<?php
require_once __DIR__ . '/includes/book_helpers.inc';
bv_require_login();

$pageTitle = 'Add a Book';
$formError = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!bv_verify_csrf(bv_post_string($_POST, 'csrf_token'))) {
        http_response_code(403);
        $formError = 'Your session check failed. Refresh the page and try again.';
    } else {
        $validation = bv_validate_book_input($_POST);
        $coverUpload = $_FILES['image_path'] ?? null;
        if ($validation['errors']) {
            $formError = implode(' ', $validation['errors']);
        } elseif (!is_array($coverUpload) || (int) ($coverUpload['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            $formError = 'Choose a cover image for this listing.';
        } else {
            $newCover = null;
            try {
                require_once __DIR__ . '/includes/db_connect.inc';
                $newCover = bv_store_cover_upload($coverUpload);
                if ($newCover === null) {
                    throw new RuntimeException('Choose a cover image for this listing.');
                }

                $book = $validation['data'];
                $ownerId = (int) $_SESSION['user_id'];
                $title = $book['title'];
                $author = $book['author'];
                $genre = $book['genre'];
                $publicationYear = $book['publication_year'];
                $isbn = $book['isbn'];
                $description = $book['description'];
                $condition = $book['book_condition'];
                $price = $book['price'];
                $imagePath = $newCover;
                $status = $book['status'];

                $stmt = mysqli_prepare(
                    $conn,
                    'INSERT INTO books (user_id, title, author, genre, publication_year, isbn, description, book_condition, price, image_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );
                mysqli_stmt_bind_param(
                    $stmt,
                    'isssisssdss',
                    $ownerId,
                    $title,
                    $author,
                    $genre,
                    $publicationYear,
                    $isbn,
                    $description,
                    $condition,
                    $price,
                    $imagePath,
                    $status
                );
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                bv_set_flash('success', 'Your book listing has been added.');
                bv_redirect('books.php');
            } catch (Throwable $error) {
                if ($newCover !== null && isset($conn)) {
                    try {
                        bv_delete_cover_if_unused($conn, $newCover);
                    } catch (Throwable $cleanupError) {
                        error_log('BookVerse failed to clean up an unused cover: ' . $cleanupError->getMessage());
                    }
                }
                if ($error instanceof RuntimeException) {
                    $formError = $error->getMessage();
                } else {
                    error_log('BookVerse add listing failed: ' . $error->getMessage());
                    $formError = 'We could not save this listing right now. Please try again.';
                }
            }
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
                    <h1>Add a Book</h1>
                    <p class="lead">Share a book with the BookVerse community.</p>
                </header>
                <?php if ($formError !== ''): ?>
                    <div class="alert alert-danger" role="alert"><?= bv_escape($formError) ?></div>
                <?php endif; ?>
                <form action="add.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= bv_escape(bv_csrf_token()) ?>">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="title">Book title</label>
                            <input class="form-control" id="title" name="title" type="text" maxlength="255" required value="<?= bv_escape(bv_post_string($_POST, 'title')) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="author">Author</label>
                            <input class="form-control" id="author" name="author" type="text" maxlength="255" required value="<?= bv_escape(bv_post_string($_POST, 'author')) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="genre">Genre</label>
                            <input class="form-control" id="genre" name="genre" type="text" maxlength="100" required value="<?= bv_escape(bv_post_string($_POST, 'genre')) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="publication_year">Publication year</label>
                            <input class="form-control" id="publication_year" name="publication_year" type="number" min="0" max="9999" step="1" value="<?= bv_escape(bv_post_string($_POST, 'publication_year')) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="isbn">ISBN <span class="text-muted">(optional)</span></label>
                            <input class="form-control" id="isbn" name="isbn" type="text" maxlength="20" value="<?= bv_escape(bv_post_string($_POST, 'isbn')) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="book_condition">Condition</label>
                            <?php $selectedCondition = bv_post_string($_POST, 'book_condition'); ?>
                            <select class="form-select" id="book_condition" name="book_condition" required>
                                <option value="">Choose a condition</option>
                                <?php foreach (['New', 'Gently Used', 'Fair'] as $conditionOption): ?>
                                    <option value="<?= bv_escape($conditionOption) ?>"<?= $selectedCondition === $conditionOption ? ' selected' : '' ?>><?= bv_escape($conditionOption) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="price">Price</label>
                            <input class="form-control" id="price" name="price" type="number" min="0" max="999999.99" step="0.01" required value="<?= bv_escape(bv_post_string($_POST, 'price')) ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <?php $selectedStatus = bv_post_string($_POST, 'status') ?: 'Available'; ?>
                            <select class="form-select" id="status" name="status" required>
                                <?php foreach (['Available', 'Reserved', 'Sold'] as $statusOption): ?>
                                    <option value="<?= bv_escape($statusOption) ?>"<?= $selectedStatus === $statusOption ? ' selected' : '' ?>><?= bv_escape($statusOption) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required><?= bv_escape(bv_post_string($_POST, 'description')) ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="image_path">Cover image</label>
                            <input class="form-control" id="image_path" name="image_path" type="file" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp" required>
                            <div class="form-text">JPG, PNG, GIF, or WEBP; maximum 5 MB.</div>
                            <div class="image-preview-container">
                                <img id="imagePreview" class="img-fluid d-none" src="" alt="Preview of selected book cover">
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-wrap gap-2 mt-4">
                            <button class="btn btn-primary" type="submit">Add listing</button>
                            <a class="btn btn-outline-secondary" href="books.php">Cancel</a>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/includes/footer.inc'; ?>
