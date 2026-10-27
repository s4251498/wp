<?php
require_once __DIR__ . '/book_helpers.inc';

function bv_status_class(string $status): string
{
    return match ($status) {
        'Available' => 'status-available',
        'Reserved' => 'status-reserved',
        'Sold' => 'status-sold',
        default => '',
    };
}

function bv_fetch_all_books(mysqli $conn, string $orderBy = 'title'): array
{
    $allowedOrder = [
        'title' => 'b.title ASC, b.book_id DESC',
        'newest' => 'b.created_at DESC, b.book_id DESC',
    ];
    $order = $allowedOrder[$orderBy] ?? $allowedOrder['title'];
    $sql = 'SELECT b.book_id, b.user_id, b.title, b.author, b.genre, b.publication_year, b.isbn, b.description, b.book_condition, b.price, b.image_path, b.status, b.created_at, u.username FROM books b INNER JOIN users u ON u.user_id = b.user_id ORDER BY ' . $order;
    $result = mysqli_query($conn, $sql);
    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
    mysqli_free_result($result);
    return $books;
}

function bv_fetch_latest_books(mysqli $conn, int $limit = 4): array
{
    $limit = max(1, min($limit, 12));
    $stmt = mysqli_prepare($conn, 'SELECT b.book_id, b.user_id, b.title, b.author, b.genre, b.price, b.image_path, b.status, u.username FROM books b INNER JOIN users u ON u.user_id = b.user_id ORDER BY b.created_at DESC, b.book_id DESC LIMIT ?');
    mysqli_stmt_bind_param($stmt, 'i', $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
    return $books;
}

function bv_render_book_card(array $book): void
{
    $cover = bv_cover_src($book['image_path'] ?? null);
    $title = (string) ($book['title'] ?? 'Untitled');
    ?>
    <article class="card book-card h-100">
        <a href="details.php?id=<?= (int) $book['book_id'] ?>" aria-label="View details for <?= bv_escape($title) ?>">
            <img class="card-img-top" src="<?= bv_escape($cover) ?>" alt="<?= bv_escape($title) ?> cover" loading="lazy">
        </a>
        <div class="card-body d-flex flex-column">
            <h2 class="card-title h5"><a class="text-decoration-none" href="details.php?id=<?= (int) $book['book_id'] ?>"><?= bv_escape($title) ?></a></h2>
            <p class="mb-2"><strong>Author:</strong> <?= bv_escape((string) ($book['author'] ?? '')) ?></p>
            <p class="mb-2"><strong>Price:</strong> $<?= number_format((float) ($book['price'] ?? 0), 2) ?></p>
            <p class="mb-3"><span class="status-badge <?= bv_escape(bv_status_class((string) ($book['status'] ?? ''))) ?>"><?= bv_escape((string) ($book['status'] ?? '')) ?></span></p>
            <a class="btn btn-outline-primary mt-auto" href="details.php?id=<?= (int) $book['book_id'] ?>">View details</a>
        </div>
    </article>
    <?php
}
