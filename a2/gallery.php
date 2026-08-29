<?php
$pageTitle = 'Gallery';

require_once 'includes/db_connect.inc';

$books = [];

$sql = "SELECT book_id, title, author, image_path
        FROM books
        ORDER BY title ASC";

$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }

    mysqli_free_result($result);
}

require_once 'includes/header.inc';
require_once 'includes/nav.inc';
?>

<main class="container py-5">

    <section class="page-header text-center">
        <h1>Book Gallery</h1>

        <p class="lead">
            Explore the BookVerse collection through its covers.
        </p>
    </section>


    <?php if (count($books) > 0): ?>

        <section aria-label="Book cover gallery">

            <div class="row g-4">

                <?php foreach ($books as $book): ?>

                    <div class="col-12 col-sm-6 col-lg-3">

                        <article class="gallery-card">

                            <img
                                src="assets/images/covers/<?= htmlspecialchars($book['image_path']) ?>"
                                alt="<?= htmlspecialchars($book['title']) ?> cover"
                                class="gallery-image"
                                data-bs-toggle="modal"
                                data-bs-target="#bookImageModal"
                                data-image="assets/images/covers/<?= htmlspecialchars($book['image_path']) ?>"
                                data-title="<?= htmlspecialchars($book['title']) ?>"
                                role="button"
                                tabindex="0"
                            >

                            <h2 class="gallery-title h5">
                                <?= htmlspecialchars($book['title']) ?>
                            </h2>

                        </article>

                    </div>

                <?php endforeach; ?>

            </div>

        </section>


        <!-- Bootstrap Image Modal -->

        <div
            class="modal fade"
            id="bookImageModal"
            tabindex="-1"
            aria-labelledby="bookImageModalLabel"
            aria-hidden="true"
        >

            <div class="modal-dialog modal-dialog-centered modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <h2
                            class="modal-title fs-5"
                            id="bookImageModalLabel"
                        >
                            Book Cover
                        </h2>

                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>

                    <div class="modal-body text-center">

                        <img
                            id="galleryModalImage"
                            src=""
                            alt=""
                            class="gallery-modal-image"
                        >

                    </div>

                </div>

            </div>

        </div>

    <?php else: ?>

        <div class="alert alert-info text-center">
            No book covers are currently available.
        </div>

    <?php endif; ?>

</main>

<?php
require_once 'includes/footer.inc';
?>