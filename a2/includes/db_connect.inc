<?php
/*
 * BookVerse - Database Connection
 * Automatically detects localhost or RMIT Jupiter server.
 */

mysqli_report(MYSQLI_REPORT_OFF);

$server = isset($_SERVER['SERVER_NAME'])
    ? $_SERVER['SERVER_NAME']
    : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost');

/*
 * Check whether the site is running locally.
 * strpos() is used instead of str_contains() for compatibility
 * with older PHP versions on the RMIT server.
 */
if (
    $server === 'localhost' ||
    $server === '127.0.0.1' ||
    strpos($server, 'localhost') !== false
) {
    // Local development settings
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'bookverse';

} else {
    // RMIT Jupiter / Coreteaching settings
    $dbHost = 'localhost';
    $dbUser = 's4251498';
    $dbPass = 'R3dYvhNE0309171910!!!';
    $dbName = 's4251498';
}

$conn = mysqli_connect(
    $dbHost,
    $dbUser,
    $dbPass,
    $dbName
);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');
?>