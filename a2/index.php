<?php
$pageTitle = 'Home';

require_once 'includes/db_connect.inc';

$latestBooks = [];

$sql = "SELECT book_id, title, author, price, image_path, status
        FROM books
        ORDER BY created_at DESC
        LIMIT 4";

$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $latestBooks[] = $row;
    }

    mysqli_free_result($result);
}

require_once 'includes/header.inc';
require_once 'includes/nav.inc';
?>

<main>

    <!-- Hero Carousel -->
    <section class="hero-carousel">
        <div
            id="bookVerseCarousel"
            class="carousel slide"
            data-bs-ride="carousel"
        >

            <div class="carousel-indicators">

                <button
                    type="button"
                    data-bs-target="#bookVerseCarousel"
                    data-bs-slide-to="0"
                    class="active"
                    aria-current="true"
                    aria-label="Slide 1"
                ></button>

                <button
                    type="button"
                    data-bs-target="#bookVerseCarousel"
                    data-bs-slide-to="1"
                    aria-label="Slide 2"
                ></button>

                <button
                    type="button"
                    data-bs-target="#bookVerseCarousel"
                    data-bs-slide-to="2"
                    aria-label="Slide 3"
                ></button>

                <button
                    type="button"
                    data-bs-target="#bookVerseCarousel"
                    data-bs-slide-to="3"
                    aria-label="Slide 4"
                ></button>

            </div>

            <div class="carousel-inner">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <img
                        src="assets/images/covers/9.png"
                        class="d-block w-100"
                        alt="BookVerse collection of books"
                    >

                    <div class="carousel-caption d-none d-md-block">
                        <h2>Discover Your Next Great Read</h2>
                        <p>Explore the BookVerse collection.</p>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <img
                        src="assets/images/covers/10.png"
                        class="d-block w-100"
                        alt="Selection of books available at BookVerse"
                    >

                    <div class="carousel-caption d-none d-md-block">
                        <h2>Explore Our Collection</h2>
                        <p>Find books across a range of genres.</p>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <img
                        src="assets/images/covers/11.png"
                        class="d-block w-100"
                        alt="Books available for readers"
                    >

                    <div class="carousel-caption d-none d-md-block">
                        <h2>Something For Every Reader</h2>
                        <p>Browse our growing collection.</p>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="carousel-item">
                    <img
                        src="assets/images/covers/12.png"
                        class="d-block w-100"
                        alt="BookVerse online bookstore"
                    >

                    <div class="carousel-caption d-none d-md-block">
                        <h2>Welcome to BookVerse</h2>
                        <p>Your online bookstore platform.</p>
                    </div>
                </div>

            </div>

            <button
                class="carousel-control-prev"
                type="button"
                data-bs-target="#bookVerseCarousel"
                data-bs-slide="prev"
            >
                <span
                    class="carousel-control-prev-icon"
                    aria-hidden="true"
                ></span>

                <span class="visually-hidden">
                    Previous
                </span>
            </button>

            <button
                class="carousel-control-next"
                type="button"
                data-bs-target="#bookVerseCarousel"
                data-bs-slide="next"
            >
                <span
                    class="carousel-control-next-icon"
                    aria-hidden="true"
                ></span>

                <span class="visually-hidden">
                    Next
                </span>
            </button>

        </div>
    </section>


    <!-- Latest Books -->
    <section class="container pb-5">

        <div class="page-header text-center">
            <h1>Latest Books</h1>

            <p class="lead">
                Explore the newest additions to the BookVerse collection.
            </p>
        </div>

        <div class="row g-4">

            <?php if (count($latestBooks) > 0): ?>

                <?php foreach ($latestBooks as $book): ?>

                    <div class="col-12 col-sm-6 col-lg-3">

                        <article class="card book-card">

                            <img
                                src="assets/images/covers/<?= htmlspecialchars($book['image_path']) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($book['title']) ?> cover"
                            >

                            <div class="card-body d-flex flex-column">

                                <h2 class="card-title h5">
                                    <?= htmlspecialchars($book['title']) ?>
                                </h2>

                                <p class="mb-2">
                                    <strong>Author:</strong>
                                    <?= htmlspecialchars($book['author']) ?>
                                </p>

                                <p class="mb-2">
                                    <strong>Price:</strong>
                                    $<?= number_format((float) $book['price'], 2) ?>
                                </p>

                                <div class="mb-3">
                                    <span
                                        class="status-badge
                                        <?= 
                                            $book['status'] === 'Available'
                                                ? 'status-available'
                                                : (
                                                    $book['status'] === 'Reserved'
                                                        ? 'status-reserved'
                                                        : 'status-sold'
                                                )
                                        ?>"
                                    >
                                        <?= htmlspecialchars($book['status']) ?>
                                    </span>
                                </div>

                                <a
                                    href="details.php?id=<?= (int) $book['book_id'] ?>"
                                    class="btn btn-primary mt-auto"
                                >
                                    View Details
                                </a>

                            </div>

                        </article>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No books are currently available.
                    </div>
                </div>

            <?php endif; ?>

        </div>

        <div class="text-center mt-5">

            <a href="books.php" class="btn btn-outline-primary">

                <span class="material-icons align-middle">
                    menu_book
                </span>

                Browse All Books

            </a>

        </div>

    </section>

</main>

<?php
require_once 'includes/footer.inc';
?>