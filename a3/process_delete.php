<?php
require_once __DIR__ . '/includes/book_helpers.inc';
bv_require_login();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method Not Allowed');
}

$bookId = bv_positive_id($_POST['book_id'] ?? null);
if ($bookId === null) {
    bv_set_flash('danger', 'Listing not found or you do not have permission to delete it.');
    bv_redirect('books.php');
}
if (!bv_verify_csrf(bv_post_string($_POST, 'csrf_token'))) {
    bv_set_flash('danger', 'Your session check failed. The listing was not deleted.');
    bv_redirect('details.php?id=' . $bookId);
}

require_once __DIR__ . '/includes/db_connect.inc';
$ownerId = (int) $_SESSION['user_id'];
$imagePath = null;
$found = false;
$deletedRows = 0;
try {
    $stmt = mysqli_prepare($conn, 'SELECT image_path FROM books WHERE book_id = ? AND user_id = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 'ii', $bookId, $ownerId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $imagePath);
    $found = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($found) {
        $stmt = mysqli_prepare($conn, 'DELETE FROM books WHERE book_id = ? AND user_id = ?');
        mysqli_stmt_bind_param($stmt, 'ii', $bookId, $ownerId);
        mysqli_stmt_execute($stmt);
        $deletedRows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
    }
} catch (Throwable $error) {
    error_log('BookVerse delete listing failed: ' . $error->getMessage());
    bv_set_flash('danger', 'We could not delete this listing right now. Please try again.');
    bv_redirect('books.php');
}

if (!$found || $deletedRows !== 1) {
    bv_set_flash('danger', 'Listing not found or you do not have permission to delete it.');
    bv_redirect('books.php');
}

try {
    $cleanupSucceeded = bv_delete_cover_if_unused($conn, is_string($imagePath) ? $imagePath : null);
} catch (Throwable $cleanupError) {
    error_log('BookVerse failed to remove a deleted cover: ' . $cleanupError->getMessage());
    $cleanupSucceeded = false;
}
bv_set_flash(
    $cleanupSucceeded ? 'success' : 'warning',
    $cleanupSucceeded
        ? 'Your book listing has been deleted.'
        : 'Your listing was deleted, but its cover file could not be removed.'
);
bv_redirect('books.php');
