<?php
/** MySQLi connection: local defaults for localhost; environment variables on Coreteaching. */

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$httpHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
$serverName = strtolower((string) (parse_url('http://' . $httpHost, PHP_URL_HOST) ?: 'localhost'));
$isLocalServer = in_array($serverName, ['localhost', '127.0.0.1', '::1'], true);

if ($isLocalServer) {
    $dbHost = getenv('BOOKVERSE_DB_HOST') ?: 'localhost';
    $dbUser = getenv('BOOKVERSE_DB_USER') ?: 'root';
    $dbPass = getenv('BOOKVERSE_DB_PASS') ?: '';
    $dbName = getenv('BOOKVERSE_DB_NAME') ?: 'bookverse';
} else {
    // Configure these values in the server environment; never commit credentials.
    $dbHost = getenv('BOOKVERSE_DB_HOST');
    $dbUser = getenv('BOOKVERSE_DB_USER');
    $dbPass = getenv('BOOKVERSE_DB_PASS');
    $dbName = getenv('BOOKVERSE_DB_NAME');
}

try {
    if (!$dbHost || !$dbUser || !$dbName) {
        throw new RuntimeException('Database environment is incomplete.');
    }

    $conn = mysqli_connect($dbHost, $dbUser, $dbPass ?: '', $dbName, 3306);
    mysqli_set_charset($conn, 'utf8mb4');
} catch (Throwable $error) {
    error_log('BookVerse database connection failed: ' . $error->getMessage());
    http_response_code(503);
    $showDevelopmentDetails = $isLocalServer && getenv('BOOKVERSE_APP_ENV') === 'development';
    $publicMessage = 'BookVerse is temporarily unavailable. Please try again later.';
    if ($showDevelopmentDetails) {
        $publicMessage .= ' Development detail: ' . htmlspecialchars($error->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
    exit($publicMessage);
}
