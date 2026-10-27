<?php
require_once __DIR__ . '/includes/catalog_helpers.inc';
require_once __DIR__ . '/includes/db_connect.inc';

$pageTitle = 'Book collection';
$books = [];
$loadError = false;
try {
    $books = bv_fetch_all_books($conn);
} catch (Throwable $error) {
    error_log('BookVerse books page query failed: ' . $error->getMessage());
    $loadError = true;
}
$statuses = ['Available', 'Reserved', 'Sold'];

require_once __DIR__ . '/includes/header.inc';
require_once __DIR__ . '/includes/nav.inc';
?>
<main class="container py-5">
    <header class="page-header text-center">
        <h1>Book collection</h1>
        <p class="lead">Browse every listing and filter by availability.</p>
    </header>
    <?php if ($loadError): ?>
        <div class="alert alert-warning" role="alert">We could not load the book collection right now.</div>
    <?php elseif ($books): ?>
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-6 col-lg-4">
                <label for="statusFilter" class="form-label">Filter by listing status</label>
                <select id="statusFilter" class="form-select">
                    <option value="all">All books</option>
                    <?php foreach ($statuses as $status): ?><option value="<?= bv_escape($status) ?>"><?= bv_escape($status) ?></option><?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="book-table-wrapper">
            <div class="table-responsive">
                <table class="table table-hover book-table mb-0">
                    <caption class="visually-hidden">BookVerse listings with title, author, seller, price, status, and details.</caption>
                    <thead><tr><th scope="col">Title</th><th scope="col">Author</th><th scope="col">Seller</th><th scope="col">Price</th><th scope="col">Status</th><th scope="col">Details</th></tr></thead>
                    <tbody id="booksTableBody">
                        <?php foreach ($books as $book): ?>
                            <tr data-status="<?= bv_escape($book['status']) ?>">
                                <td><a href="details.php?id=<?= (int) $book['book_id'] ?>"><?= bv_escape($book['title']) ?></a></td>
                                <td><?= bv_escape($book['author']) ?></td>
                                <td><a href="seller.php?id=<?= (int) $book['user_id'] ?>"><?= bv_escape($book['username']) ?></a></td>
                                <td>$<?= number_format((float) $book['price'], 2) ?></td>
                                <td><span class="status-badge <?= bv_escape(bv_status_class($book['status'])) ?>"><?= bv_escape($book['status']) ?></span></td>
                                <td><a class="btn btn-sm btn-outline-primary" href="details.php?id=<?= (int) $book['book_id'] ?>">View details</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="noBooksMessage" class="alert alert-info text-center mt-4 d-none" role="status">No books match the selected status.</div>
    <?php else: ?>
        <div class="alert alert-info text-center">No books are currently listed. <a href="search.php">Try a search</a> or check back later.</div>
    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.inc'; ?>
