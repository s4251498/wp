<?php
require_once __DIR__ . '/functions.inc';

function bv_positive_id($value): ?int
{
    if (!is_scalar($value)) {
        return null;
    }
    $id = filter_var((string) $value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? null : (int) $id;
}

function bv_cover_src($filename): string
{
    if (!is_string($filename) || $filename === '' || basename($filename) !== $filename
        || !preg_match('/\A[a-zA-Z0-9_-]+\.(jpg|jpeg|png|gif|webp)\z/i', $filename)) {
        return 'assets/images/cover-placeholder.svg';
    }
    return 'assets/images/covers/' . rawurlencode($filename);
}

function bv_validate_book_input(array $source): array
{
    $title = bv_post_string($source, 'title');
    $author = bv_post_string($source, 'author');
    $genre = bv_post_string($source, 'genre');
    $yearText = bv_post_string($source, 'publication_year');
    $isbnText = bv_post_string($source, 'isbn');
    $description = bv_post_string($source, 'description');
    $condition = bv_post_string($source, 'book_condition');
    $priceText = bv_post_string($source, 'price');
    $status = bv_post_string($source, 'status');
    $errors = [];

    if ($title === '' || strlen($title) > 255) {
        $errors[] = 'Enter a title of no more than 255 characters.';
    }
    if ($author === '' || strlen($author) > 255) {
        $errors[] = 'Enter an author of no more than 255 characters.';
    }
    if ($genre === '' || strlen($genre) > 100) {
        $errors[] = 'Enter a genre of no more than 100 characters.';
    }
    if ($yearText !== '' && filter_var($yearText, FILTER_VALIDATE_INT) === false) {
        $errors[] = 'Publication year must be a whole number.';
    } elseif ($yearText !== '' && ((int) $yearText < 0 || (int) $yearText > 9999)) {
        $errors[] = 'Publication year must be between 0 and 9999.';
    }
    if (strlen($isbnText) > 20) {
        $errors[] = 'ISBN must be no more than 20 characters.';
    }
    if ($description === '') {
        $errors[] = 'Enter a description.';
    }
    if (!in_array($condition, ['New', 'Gently Used', 'Fair'], true)) {
        $errors[] = 'Choose a valid book condition.';
    }
    if (!preg_match('/\A\d{1,6}(?:\.\d{1,2})?\z/', $priceText)
        || (float) $priceText < 0 || (float) $priceText > 999999.99) {
        $errors[] = 'Enter a price between 0 and 999999.99.';
    }
    if (!in_array($status, ['Available', 'Reserved', 'Sold'], true)) {
        $errors[] = 'Choose a valid listing status.';
    }

    return [
        'errors' => $errors,
        'data' => [
            'title' => $title,
            'author' => $author,
            'genre' => $genre,
            'publication_year' => $yearText === '' ? null : (int) $yearText,
            'isbn' => $isbnText === '' ? null : $isbnText,
            'description' => $description,
            'book_condition' => $condition,
            'price' => (float) $priceText,
            'status' => $status,
        ],
    ];
}

function bv_store_cover_upload(array $file): ?string
{
    $errorCode = isset($file['error']) && is_int($file['error']) ? $file['error'] : UPLOAD_ERR_NO_FILE;
    if ($errorCode === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($errorCode !== UPLOAD_ERR_OK) {
        throw new RuntimeException('The cover upload did not complete. Please choose the image again.');
    }

    $tmpName = isset($file['tmp_name']) && is_string($file['tmp_name']) ? $file['tmp_name'] : '';
    $originalName = isset($file['name']) && is_string($file['name']) ? $file['name'] : '';
    $size = isset($file['size']) && is_numeric($file['size']) ? (int) $file['size'] : 0;
    if ($tmpName === '' || !is_uploaded_file($tmpName) || $size < 1 || $size > 5 * 1024 * 1024) {
        throw new RuntimeException('Choose an image smaller than 5 MB.');
    }

    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
    ];
    if (!isset($allowedTypes[$extension])) {
        throw new RuntimeException('Use a JPG, JPEG, PNG, GIF, or WEBP image.');
    }

    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = $fileInfo ? finfo_file($fileInfo, $tmpName) : false;
    if ($fileInfo) {
        finfo_close($fileInfo);
    }
    if ($mimeType !== $allowedTypes[$extension]) {
        throw new RuntimeException('The selected file does not match an accepted image type.');
    }

    $directory = __DIR__ . '/../assets/images/covers';
    if (!is_dir($directory) || !is_writable($directory)) {
        throw new RuntimeException('Cover uploads are not available right now.');
    }
    $generatedName = bin2hex(random_bytes(16)) . '.' . $extension;
    if (!move_uploaded_file($tmpName, $directory . DIRECTORY_SEPARATOR . $generatedName)) {
        throw new RuntimeException('The cover could not be saved. Please try again.');
    }
    return $generatedName;
}

function bv_delete_cover_if_unused(mysqli $conn, ?string $filename): bool
{
    if ($filename === null || $filename === '') {
        return true;
    }
    if (basename($filename) !== $filename
        || !preg_match('/\A[a-zA-Z0-9_-]+\.(jpg|jpeg|png|gif|webp)\z/i', $filename)) {
        return false;
    }

    $stmt = mysqli_prepare($conn, 'SELECT COUNT(*) FROM books WHERE image_path = ?');
    mysqli_stmt_bind_param($stmt, 's', $filename);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $referenceCount);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    if ((int) $referenceCount > 0) {
        return true;
    }

    $directory = realpath(__DIR__ . '/../assets/images/covers');
    if ($directory === false) {
        return false;
    }
    $candidate = $directory . DIRECTORY_SEPARATOR . $filename;
    if (is_link($candidate)) {
        return false;
    }
    $realCandidate = realpath($candidate);
    if ($realCandidate === false) {
        return true;
    }
    if (strpos($realCandidate, $directory . DIRECTORY_SEPARATOR) !== 0 || !is_file($realCandidate)) {
        return false;
    }
    return unlink($realCandidate);
}
