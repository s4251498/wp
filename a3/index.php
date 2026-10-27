<?php
require_once __DIR__ . '/includes/catalog_helpers.inc';
require_once __DIR__ . '/includes/db_connect.inc';

$pageTitle = 'Discover books';
$books = [];
$loadError = false;
try {
    $books = bv_fetch_latest_books($conn, 4);
} catch (Throwable $error) {
    error_log('BookVerse home page query failed: ' . $error->getMessage());
    $loadError = true;
}
$latestBooks = $books;
$slides = $books;

require_once __DIR__ . '/includes/header.inc';
require_once __DIR__ . '/includes/nav.inc';
?>
<main>
    <section class="hero-carousel" aria-label="Featured books">
        <?php if ($slides): ?>
            <div id="bookVerseCarousel" class="carousel slide" data-bs-ride="carousel">
                <?php if (count($slides) > 1): ?>
                    <div class="carousel-indicators">
                        <?php foreach ($slides as $index => $slide): ?>
                            <button type="button" data-bs-target="#bookVerseCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"<?= $index === 0 ? ' aria-current="true"' : '' ?> aria-label="Slide <?= $index + 1 ?>"></button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="carousel-inner">
                    <?php foreach ($slides as $index => $slide): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <a href="details.php?id=<?= (int) $slide['book_id'] ?>">
                                <img src="<?= bv_escape(bv_cover_src($slide['image_path'])) ?>" class="d-block w-100" alt="<?= bv_escape($slide['title']) ?> book cover">
                            </a>
                            <div class="carousel-caption d-none d-md-block">
                                <h2><?= bv_escape($slide['title']) ?></h2>
                                <p>By <?= bv_escape($slide['author']) ?> · <?= bv_escape($slide['genre']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($slides) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#bookVerseCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
                    <button class="carousel-control-next" type="button" data-bs-target="#bookVerseCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="container py-5"><div class="hero-empty text-center rounded-4 p-5"><span class="material-icons display-3" aria-hidden="true">menu_book</span><h1 class="mt-3">Discover your next great read</h1><p class="lead mb-0">Browse a community collection of books on BookVerse.</p></div></div>
        <?php endif; ?>
    </section>

    <section class="container py-4 py-lg-5">
        <header class="page-header text-center">
            <h1>Latest books</h1>
            <p class="lead">Fresh additions from the BookVerse community.</p>
        </header>
        <?php if ($loadError): ?>
            <div class="alert alert-warning" role="alert">We could not load the book collection right now.</div>
        <?php elseif ($latestBooks): ?>
            <div class="row g-4">
                <?php foreach ($latestBooks as $book): ?>
                    <div class="col-12 col-sm-6 col-lg-3"><?php bv_render_book_card($book); ?></div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">No books have been listed yet. Check back soon.</div>
        <?php endif; ?>
        <div class="text-center mt-4"><a class="btn btn-primary" href="books.php"><span class="material-icons align-middle" aria-hidden="true">menu_book</span> Browse all books</a></div>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.inc'; ?>
