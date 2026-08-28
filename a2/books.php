<?php
$pageTitle = 'Books';

require_once 'includes/db_connect.inc';

$books = [];
$statusOptions = [];

$sql = "SELECT book_id, title, author, price, status
        FROM books
        ORDER BY title ASC";

$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;

        if (!in_array($row['status'], $statusOptions, true)) {
            $statusOptions[] = $row['status'];
        }
    }

    mysqli_free_result($result);
}

sort($statusOptions);

require_once 'includes/header.inc';
require_once 'includes/nav.inc';
?>

<main class="container py-5">

    <section class="page-header text-center">
        <h1>Book Collection</h1>

        <p class="lead">
            Browse and filter the complete BookVerse collection.
        </p>
    </section>

    <!-- Status Filter -->
    <section class="mb-4">

        <div class="row justify-content-center">

            <div class="col-12 col-md-6 col-lg-4">

                <label for="statusFilter" class="form-label">
                    Filter by status
                </label>

                <select
                    id="statusFilter"
                    class="form-select"
                >
                    <option value="all">
                        All Books
                    </option>

                    <?php foreach ($statusOptions as $status): ?>

                        <option value="<?= htmlspecialchars($status) ?>">
                            <?= htmlspecialchars($status) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

        </div>

    </section>


    <?php if (count($books) > 0): ?>

        <div class="book-table-wrapper">

            <div class="table-responsive">

                <table class="table table-hover mb-0 book-table">

                    <caption class="visually-hidden">
                        Complete BookVerse book collection
                    </caption>

                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>

                    <tbody id="booksTableBody">

                        <?php foreach ($books as $book): ?>

                            <tr
                                data-status="<?= htmlspecialchars($book['status']) ?>"
                            >

                                <td>
                                    <a
                                        href="details.php?id=<?= (int) $book['book_id'] ?>"
                                    >
                                        <?= htmlspecialchars($book['title']) ?>
                                    </a>
                                </td>

                                <td>
                                    <?= htmlspecialchars($book['author']) ?>
                                </td>

                                <td>
                                    $<?= number_format((float) $book['price'], 2) ?>
                                </td>

                                <td>

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

                                </td>

                                <td>

                                    <a
                                        href="details.php?id=<?= (int) $book['book_id'] ?>"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        <span class="material-icons align-middle">
                                            visibility
                                        </span>

                                        Details
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

        <div
            id="noBooksMessage"
            class="alert alert-info text-center mt-4 d-none"
        >
            No books match the selected status.
        </div>

    <?php else: ?>

        <div class="alert alert-info text-center">
            No books are currently available.
        </div>

    <?php endif; ?>

</main>

<?php
require_once 'includes/footer.inc';
?>