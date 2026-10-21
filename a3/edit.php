<?php
require_once __DIR__ . '/includes/book_helpers.inc';
bv_require_login();

$pageTitle = 'Edit Book';
$isPost = (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST');
$bookId = bv_positive_id($isPost ? ($_POST['book_id'] ?? null) : ($_GET['id'] ?? null));
if ($bookId === null) {
    bv_set_flash('danger', 'Listing not found or you do not have permission to edit it.');
    bv_redirect('books.php');
}

require_once __DIR__ . '/includes/db_connect.inc';
$ownerId = (int) $_SESSION['user_id'];
$stmt = mysqli_prepare(
    $conn,
    'SELECT book_id, title, author, genre, publication_year, isbn, description, book_condition, price, image_path, status FROM books WHERE book_id = ? AND user_id = ? LIMIT 1'
);
mysqli_stmt_bind_param($stmt, 'ii', $bookId, $ownerId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $recordId, $title, $author, $genre, $publicationYear, $isbn, $description, $condition, $price, $imagePath, $status);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$found) {
    http_response_code(404);
    bv_set_flash('danger', 'Listing not found or you do not have permission to edit it.');
    bv_redirect('books.php');
}

$book = [
    'book_id' => (int) $recordId,
    'title' => (string) $title,
    'author' => (string) $author,
    'genre' => (string) $genre,
    'publication_year' => $publicationYear,
    'isbn' => $isbn,
    'description' => (string) $description,
    'book_condition' => (string) $condition,
    'price' => (string) $price,
    'image_path' => $imagePath,
    'status' => (string) $status,
];
$formError = '';
$formData = $book;

if ($isPost) {
    $validation = bv_validate_book_input($_POST);
    foreach (['title', 'author', 'genre', 'publication_year', 'isbn', 'description', 'book_condition', 'price', 'status'] as $field) {
        $formData[$field] = bv_post_string($_POST, $field);
    }

    if (!bv_verify_csrf(bv_post_string($_POST, 'csrf_token'))) {
        http_response_code(403);
        $formError = 'Your session check failed. Refresh the page and try again.';
    } elseif ($validation['errors']) {
        $formError = implode(' ', $validation['errors']);
    } else {
        $newCover = null;
        $updateSaved = false;
        try {
            $newCover = bv_store_cover_upload($_FILES['image_path'] ?? []);
            $updatedBook = $validation['data'];
            $updatedImagePath = $newCover !== null ? $newCover : $book['image_path'];
            $stmt = mysqli_prepare(
                $conn,
                'UPDATE books SET title = ?, author = ?, genre = ?, publication_year = ?, isbn = ?, description = ?, book_condition = ?, price = ?, image_path = ?, status = ? WHERE book_id = ? AND user_id = ?'
            );
            mysqli_stmt_bind_param(
                $stmt,
                'sssisssdssii',
                $updatedBook['title'],
                $updatedBook['author'],
                $updatedBook['genre'],
                $updatedBook['publication_year'],
                $updatedBook['isbn'],
                $updatedBook['description'],
                $updatedBook['book_condition'],
                $updatedBook['price'],
                $updatedImagePath,
                $updatedBook['status'],
                $bookId,
                $ownerId
            );
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $updateSaved = true;
        } catch (Throwable $error) {
            if ($newCover !== null) {
                try {
                    bv_delete_cover_if_unused($conn, $newCover);
                } catch (Throwable $cleanupError) {
                    error_log('BookVerse failed to clean up an unused cover: ' . $cleanupError->getMessage());
                }
            }
            if ($error instanceof RuntimeException) {
                $formError = $error->getMessage();
            } else {
                error_log('BookVerse edit listing failed: ' . $error->getMessage());
                $formError = 'We could not save these changes right now. Please try again.';
            }
        }

        if ($updateSaved) {
            $cleanupSucceeded = true;
            if ($newCover !== null && $book['image_path'] !== $newCover) {
                try {
                    $cleanupSucceeded = bv_delete_cover_if_unused($conn, $book['image_path']);
                } catch (Throwable $cleanupError) {
                    error_log('BookVerse failed to remove a replaced cover: ' . $cleanupError->getMessage());
                    $cleanupSucceeded = false;
                }
            }
            bv_set_flash(
                $cleanupSucceeded ? 'success' : 'warning',
                $cleanupSucceeded
                    ? 'Your book listing has been updated.'
                    : 'Your listing was updated, but its previous cover could not be removed.'
            );
            bv_redirect('details.php?id=' . $bookId);
        }
    }
}

require_once __DIR__ . '/includes/header.inc';
require_once __DIR__ . '/includes/nav.inc';
?>
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9 col-xl-8">
            <section class="form-card">
                <header class="page-header text-center">
                    <h1>Edit Book</h1>
                    <p class="lead">Update your listing details.</p>
                </header>
                <?php if ($formError !== ''): ?>
                    <div class="alert alert-danger" role="alert"><?= bv_escape($formError) ?></div>
                <?php endif; ?>
                <form action="edit.php?id=<?= $bookId ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= bv_escape(bv_csrf_token()) ?>">
                    <input type="hidden" name="book_id" value="<?= $bookId ?>">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="title">Book title</label>
                            <input class="form-control" id="title" name="title" type="text" maxlength="255" required value="<?= bv_escape((string) $formData['title']) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="author">Author</label>
                            <input class="form-control" id="author" name="author" type="text" maxlength="255" required value="<?= bv_escape((string) $formData['author']) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="genre">Genre</label>
                            <input class="form-control" id="genre" name="genre" type="text" maxlength="100" required value="<?= bv_escape((string) $formData['genre']) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="publication_year">Publication year</label>
                            <input class="form-control" id="publication_year" name="publication_year" type="number" min="0" max="9999" step="1" value="<?= bv_escape((string) $formData['publication_year']) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="isbn">ISBN <span class="text-muted">(optional)</span></label>
                            <input class="form-control" id="isbn" name="isbn" type="text" maxlength="20" value="<?= bv_escape((string) $formData['isbn']) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="book_condition">Condition</label>
                            <select class="form-select" id="book_condition" name="book_condition" required>
                                <?php foreach (['New', 'Gently Used', 'Fair'] as $conditionOption): ?>
                                    <option value="<?= bv_escape($conditionOption) ?>"<?= $formData['book_condition'] === $conditionOption ? ' selected' : '' ?>><?= bv_escape($conditionOption) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="price">Price</label>
                            <input class="form-control" id="price" name="price" type="number" min="0" max="999999.99" step="0.01" required value="<?= bv_escape((string) $formData['price']) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <?php foreach (['Available', 'Reserved', 'Sold'] as $statusOption): ?>
                                    <option value="<?= bv_escape($statusOption) ?>"<?= $formData['status'] === $statusOption ? ' selected' : '' ?>><?= bv_escape($statusOption) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required><?= bv_escape((string) $formData['description']) ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="image_path">Replace cover <span class="text-muted">(optional)</span></label>
                            <input class="form-control" id="image_path" name="image_path" type="file" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
                            <div class="form-text">Leave blank to keep the current cover. JPG, PNG, GIF, or WEBP; maximum 5 MB.</div>
                            <?php if (is_string($book['image_path']) && $book['image_path'] !== ''): ?>
                                <div class="image-preview-container">
                                    <img id="imagePreview" class="img-fluid" src="<?= bv_escape(bv_cover_src($book['image_path'])) ?>" alt="Current cover for <?= bv_escape($book['title']) ?>">
                                </div>
                            <?php else: ?>
                                <div class="image-preview-container">
                                    <img id="imagePreview" class="img-fluid d-none" src="" alt="Preview of selected book cover">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-12 d-flex flex-wrap gap-2 mt-4">
                            <button class="btn btn-primary" type="submit">Save changes</button>
                            <a class="btn btn-outline-secondary" href="details.php?id=<?= $bookId ?>">Cancel</a>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/includes/footer.inc'; ?>
