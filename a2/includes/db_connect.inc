<?php
/*
 * BookVerse - Database Connection
 * Automatically detects localhost or Coreteaching/Jacob 5.
 */

mysqli_report(MYSQLI_REPORT_OFF);

$server = $_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost';

if (
    $server === 'localhost' ||
    $server === '127.0.0.1' ||
    str_contains($server, 'localhost')
) {
    // Local development settings
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'bookverse';
} else {
    // Coreteaching / Jacob 5 settings
    $dbHost = 'localhost';
    $dbUser = 's4251498';
    $dbPass = 'R3dYvhNE0309171910!!!';
    $dbName = 's4251498';
}

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');
?>