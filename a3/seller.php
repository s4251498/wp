<?php
require_once __DIR__ . '/includes/catalog_helpers.inc';
$pageTitle = 'Seller listings';
$sellerId = bv_positive_id($_GET['id'] ?? null);
$seller = null;
$books = [];
$loadError = false;
if ($sellerId !== null) {
    try {
        require_once __DIR__ . '/includes/db_connect.inc';
        $stmt = mysqli_prepare($conn, 'SELECT user_id, username, location, bio FROM users WHERE user_id = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 'i', $sellerId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $seller = mysqli_fetch_assoc($result) ?: null;
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        if ($seller !== null) {
            $stmt = mysqli_prepare($conn, 'SELECT book_id, user_id, title, author, genre, publication_year, isbn, description, book_condition, price, image_path, status, created_at FROM books WHERE user_id = ? ORDER BY created_at DESC, book_id DESC');
            mysqli_stmt_bind_param($stmt, 'i', $sellerId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($row = mysqli_fetch_assoc($result)) {
                $books[] = $row;
            }
            mysqli_free_result($result);
            mysqli_stmt_close($stmt);
        }
    } catch (Throwable $error) {
        error_log('BookVerse seller page query failed: ' . $error->getMessage());
        $loadError = true;
    }
}
require_once __DIR__ . '/includes/header.inc';
require_once __DIR__ . '/includes/nav.inc';
?>
<main class="container py-5">
    <?php if ($loadError): ?>
        <div class="alert alert-warning" role="alert">Seller listings are temporarily unavailable.</div>
    <?php elseif ($seller): ?>
        <header class="page-header text-center">
            <span class="material-icons display-4 text-primary" aria-hidden="true">account_circle</span>
            <h1><?= bv_escape($seller['username']) ?>’s listings</h1>
            <?php if (!empty($seller['location'])): ?><p class="mb-2"><span class="material-icons align-middle" aria-hidden="true">place</span> <?= bv_escape($seller['location']) ?></p><?php endif; ?>
            <?php if (!empty($seller['bio'])): ?><p class="lead"><?= nl2br(bv_escape($seller['bio'])) ?></p><?php endif; ?>
            <p class="text-muted"><?= count($books) ?> <?= count($books) === 1 ? 'book' : 'books' ?> listed</p>
        </header>
        <?php if ($books): ?><div class="row g-4"><?php foreach ($books as $book): ?><div class="col-12 col-sm-6 col-lg-3"><?php bv_render_book_card($book); ?></div><?php endforeach; ?></div>
        <?php else: ?><div class="alert alert-info text-center">This seller has no listings yet.</div><?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info text-center"><h1 class="h4">Seller not found</h1><p>This seller profile is unavailable or the link is invalid.</p><a href="books.php" class="btn btn-primary">Browse books</a></div>
    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.inc'; ?>
