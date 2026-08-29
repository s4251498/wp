<?php
$pageTitle = 'Book Details';

require_once 'includes/db_connect.inc';

$book = null;
$errorMessage = '';

/*
 * Get the book ID from the query string.
 * The value is validated before being used in the prepared statement.
 */
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {

    $bookId = (int) $_GET['id'];

    $sql = "SELECT book_id, title, author, price, status, description, image_path
            FROM books
            WHERE book_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, 'i', $bookId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $book = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
        } else {
            $errorMessage = 'The requested book could not be found.';
        }

        mysqli_stmt_close($stmt);

    } else {
        $errorMessage = 'Unable to retrieve the book details.';
    }

} else {
    $errorMessage = 'A valid book ID is required.';
}

require_once 'includes/header.inc';
require_once 'includes/nav.inc';
?>

<main class="container py-5">

    <?php if ($book !== null): ?>

        <section class="page-header text-center">
            <h1>Book Details</h1>

            <p class="lead">
                View information about this BookVerse title.
            </p>
        </section>

        <section class="details-card">

            <div class="row g-4 align-items-start">

                <!-- Book Cover -->
                <div class="col-12 col-md-5 text-center">

                    <img
                        src="assets/images/covers/<?= htmlspecialchars($book['image_path']) ?>"
                        alt="<?= htmlspecialchars($book['title']) ?> cover"
                        class="details-image"
                    >

                </div>


                <!-- Book Information -->
                <div class="col-12 col-md-7">

                    <h2 class="mb-4">
                        <?= htmlspecialchars($book['title']) ?>
                    </h2>

                    <dl class="row">

                        <dt class="col-sm-4 detail-label">
                            Author
                        </dt>

                        <dd class="col-sm-8 detail-value">
                            <?= htmlspecialchars($book['author']) ?>
                        </dd>


                        <dt class="col-sm-4 detail-label">
                            Price
                        </dt>

                        <dd class="col-sm-8 detail-value">
                            $<?= number_format((float) $book['price'], 2) ?>
                        </dd>


                        <dt class="col-sm-4 detail-label">
                            Status
                        </dt>

                        <dd class="col-sm-8 detail-value">

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

                        </dd>

                    </dl>


                    <hr class="my-4">


                    <h3>Description</h3>

                    <p>
                        <?= nl2br(htmlspecialchars($book['description'])) ?>
                    </p>


                    <div class="mt-4">

                        <a
                            href="books.php"
                            class="btn btn-outline-primary"
                        >
                            <span class="material-icons align-middle">
                                arrow_back
                            </span>

                            Back to Books
                        </a>

                    </div>

                </div>

            </div>

        </section>

    <?php else: ?>

        <section class="page-header text-center">

            <div class="alert alert-danger">

                <h1 class="h3">
                    Book Not Found
                </h1>

                <p class="mb-3">
                    <?= htmlspecialchars($errorMessage) ?>
                </p>

                <a
                    href="books.php"
                    class="btn btn-primary"
                >
                    Return to Books
                </a>

            </div>

        </section>

    <?php endif; ?>

</main>

<?php
require_once 'includes/footer.inc';
?>