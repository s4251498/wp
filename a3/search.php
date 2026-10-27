<?php
require_once __DIR__ . '/includes/catalog_helpers.inc';
require_once __DIR__ . '/includes/db_connect.inc';
$pageTitle = 'Search books';
$query = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';
$books = [];
$loadError = false;
$queryTooLong = strlen($query) > 100;
if ($query !== '' && !$queryTooLong) {
    try {
        $pattern = '%' . $query . '%';
        $stmt = mysqli_prepare($conn, 'SELECT b.book_id, b.user_id, b.title, b.author, b.genre, b.publication_year, b.isbn, b.description, b.book_condition, b.price, b.image_path, b.status, b.created_at, u.username FROM books b INNER JOIN users u ON u.user_id = b.user_id WHERE b.title LIKE ? OR b.author LIKE ? OR b.genre LIKE ? OR b.isbn LIKE ? ORDER BY b.created_at DESC, b.book_id DESC LIMIT 50');
        mysqli_stmt_bind_param($stmt, 'ssss', $pattern, $pattern, $pattern, $pattern);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = $row;
        }
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
    } catch (Throwable $error) {
        error_log('BookVerse search query failed: ' . $error->getMessage());
        $loadError = true;
    }
}
require_once __DIR__ . '/includes/header.inc';
require_once __DIR__ . '/includes/nav.inc';
?>
<main class="container py-5">
    <header class="page-header text-center"><h1>Search the collection</h1><p class="lead">Find books by title, author, genre, or ISBN.</p></header>
    <form class="search-form mx-auto mb-5" method="get" action="search.php" role="search">
        <label class="form-label" for="bookSearch">Book keywords</label>
        <div class="input-group"><input class="form-control" id="bookSearch" name="q" type="search" maxlength="100" value="<?= bv_escape($query) ?>" placeholder="Try a title, author, genre, or ISBN"><button class="btn btn-primary" type="submit"><span class="material-icons align-middle" aria-hidden="true">search</span> Search</button></div>
    </form>
    <?php if ($queryTooLong): ?>
        <div class="alert alert-warning" role="alert">Keep your search to 100 characters or fewer.</div>
    <?php elseif ($loadError): ?>
        <div class="alert alert-warning" role="alert">Search is temporarily unavailable. Please try again.</div>
    <?php elseif ($query === ''): ?>
        <p class="text-center text-muted">Enter a keyword to search the book collection.</p>
    <?php elseif ($books): ?>
        <h2 class="h4 mb-4">Results for “<?= bv_escape($query) ?>” <span class="text-muted">(<?= count($books) ?><?= count($books) === 50 ? '+' : '' ?>)</span></h2>
        <div class="row g-4">
            <?php foreach ($books as $book): ?><div class="col-12 col-sm-6 col-lg-3"><?php bv_render_book_card($book); ?></div><?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No books matched “<?= bv_escape($query) ?>”. Try another keyword.</div>
    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.inc'; ?>
