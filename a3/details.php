<?php
require_once __DIR__ . '/includes/catalog_helpers.inc';
$pageTitle = 'Book details';
$bookId = bv_positive_id($_GET['id'] ?? null);
$book = null;
$loadError = false;

if ($bookId !== null) {
    try {
        require_once __DIR__ . '/includes/db_connect.inc';
        $stmt = mysqli_prepare($conn, 'SELECT b.book_id, b.user_id, b.title, b.author, b.genre, b.publication_year, b.isbn, b.description, b.book_condition, b.price, b.image_path, b.status, b.created_at, u.username FROM books b INNER JOIN users u ON u.user_id = b.user_id WHERE b.book_id = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 'i', $bookId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $book = mysqli_fetch_assoc($result) ?: null;
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
    } catch (Throwable $error) {
        error_log('BookVerse details query failed: ' . $error->getMessage());
        $loadError = true;
    }
}
$isOwner = $book !== null && bv_is_authenticated() && (int) $_SESSION['user_id'] === (int) $book['user_id'];

require_once __DIR__ . '/includes/header.inc';
require_once __DIR__ . '/includes/nav.inc';
?>
<main class="container py-5">
    <?php if ($book): ?>
        <header class="page-header text-center"><h1>Book details</h1><p class="lead">Listing shared by <a href="seller.php?id=<?= (int) $book['user_id'] ?>"><?= bv_escape($book['username']) ?></a>.</p></header>
        <section class="details-card">
            <div class="row g-4 align-items-start">
                <div class="col-12 col-md-5 text-center"><img class="details-image" src="<?= bv_escape(bv_cover_src($book['image_path'])) ?>" alt="<?= bv_escape($book['title']) ?> cover"></div>
                <div class="col-12 col-md-7">
                    <h2><?= bv_escape($book['title']) ?></h2>
                    <dl class="row mt-4">
                        <dt class="col-sm-4 detail-label">Author</dt><dd class="col-sm-8 detail-value"><?= bv_escape($book['author']) ?></dd>
                        <dt class="col-sm-4 detail-label">Genre</dt><dd class="col-sm-8 detail-value"><?= bv_escape($book['genre']) ?></dd>
                        <dt class="col-sm-4 detail-label">Publication year</dt><dd class="col-sm-8 detail-value"><?= $book['publication_year'] === null ? 'Not provided' : (int) $book['publication_year'] ?></dd>
                        <dt class="col-sm-4 detail-label">ISBN</dt><dd class="col-sm-8 detail-value"><?= bv_escape((string) ($book['isbn'] ?? 'Not provided')) ?></dd>
                        <dt class="col-sm-4 detail-label">Condition</dt><dd class="col-sm-8 detail-value"><?= bv_escape($book['book_condition']) ?></dd>
                        <dt class="col-sm-4 detail-label">Price</dt><dd class="col-sm-8 detail-value">$<?= number_format((float) $book['price'], 2) ?></dd>
                        <dt class="col-sm-4 detail-label">Status</dt><dd class="col-sm-8 detail-value"><span class="status-badge <?= bv_escape(bv_status_class($book['status'])) ?>"><?= bv_escape($book['status']) ?></span></dd>
                        <dt class="col-sm-4 detail-label">Seller</dt><dd class="col-sm-8 detail-value"><a href="seller.php?id=<?= (int) $book['user_id'] ?>"><?= bv_escape($book['username']) ?></a></dd>
                    </dl>
                    <hr><h3 class="h5">Description</h3><p><?= nl2br(bv_escape($book['description'])) ?></p>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <a class="btn btn-outline-primary" href="books.php">Back to books</a>
                        <?php if ($isOwner): ?>
                            <a class="btn btn-primary" href="edit.php?id=<?= (int) $book['book_id'] ?>">Edit listing</a>
                            <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteBookModal">Delete listing</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php if ($isOwner): ?>
            <div class="modal fade" id="deleteBookModal" tabindex="-1" aria-labelledby="deleteBookModalLabel" aria-describedby="deleteBookModalDescription" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
                    <div class="modal-header"><h2 class="modal-title fs-5" id="deleteBookModalLabel">Delete this listing?</h2><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cancel"></button></div>
                    <div class="modal-body"><p id="deleteBookModalDescription">This removes “<?= bv_escape($book['title']) ?>” from the collection. This action cannot be undone.</p></div>
                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Keep listing</button><form method="post" action="process_delete.php"><input type="hidden" name="csrf_token" value="<?= bv_escape(bv_csrf_token()) ?>"><input type="hidden" name="book_id" value="<?= (int) $book['book_id'] ?>"><button class="btn btn-danger" type="submit">Delete listing</button></form></div>
                </div></div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="page-header text-center"><div class="alert <?= $loadError ? 'alert-warning' : 'alert-info' ?>" role="alert"><h1 class="h3"><?= $loadError ? 'Details unavailable' : 'Book not found' ?></h1><p><?= $loadError ? 'We could not load this listing right now.' : 'The listing may have been removed, or the link may be invalid.' ?></p><a class="btn btn-primary" href="books.php">Browse books</a></div></div>
    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.inc'; ?>
