<?php
require_once __DIR__ . '/includes/catalog_helpers.inc';
require_once __DIR__ . '/includes/db_connect.inc';
$pageTitle = 'Book gallery';
$books = [];
$loadError = false;
try {
    $books = bv_fetch_all_books($conn);
} catch (Throwable $error) {
    error_log('BookVerse gallery query failed: ' . $error->getMessage());
    $loadError = true;
}
require_once __DIR__ . '/includes/header.inc';
require_once __DIR__ . '/includes/nav.inc';
?>
<main class="container py-5">
    <header class="page-header text-center"><h1>Book gallery</h1><p class="lead">Explore the collection cover by cover.</p></header>
    <?php if ($loadError): ?>
        <div class="alert alert-warning" role="alert">We could not load the gallery right now.</div>
    <?php elseif ($books): ?>
        <section aria-label="Book cover gallery"><div class="row g-4">
            <?php foreach ($books as $book): $cover = bv_cover_src($book['image_path']); ?>
                <div class="col-12 col-sm-6 col-lg-3"><article class="gallery-card h-100">
                    <button class="gallery-image-button" type="button" data-bs-toggle="modal" data-bs-target="#bookImageModal" data-image="<?= bv_escape($cover) ?>" data-title="<?= bv_escape($book['title']) ?>" aria-label="Enlarge cover of <?= bv_escape($book['title']) ?>">
                        <img class="gallery-image" src="<?= bv_escape($cover) ?>" alt="<?= bv_escape($book['title']) ?> cover" loading="lazy">
                    </button>
                    <h2 class="gallery-title h5"><a href="details.php?id=<?= (int) $book['book_id'] ?>"><?= bv_escape($book['title']) ?></a></h2>
                </article></div>
            <?php endforeach; ?>
        </div></section>
        <div class="modal fade" id="bookImageModal" tabindex="-1" aria-labelledby="bookImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content">
                <div class="modal-header"><h2 class="modal-title fs-5" id="bookImageModalLabel">Book cover</h2><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body text-center"><img id="galleryModalImage" src="" alt="" class="gallery-modal-image"></div>
            </div></div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No book covers are available yet.</div>
    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.inc'; ?>
