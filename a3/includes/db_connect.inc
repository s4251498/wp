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
    // Keep credentials outside public_html. Prefer this account-specific file
    // when available so stale server environment values cannot override it.
    $privateConfigPath = '../../../../bookverse-db-config.php';
    $privateConfig = [];

    // Resolve the private file from this include directory. Coreteaching's
    // PHP path policy can reject an absolute path to the same home file.
    $previousWorkingDirectory = getcwd();
    if ($previousWorkingDirectory !== false && @chdir(__DIR__)) {
        try {
            if (is_readable($privateConfigPath)) {
                $loadedConfig = require $privateConfigPath;
                if (is_array($loadedConfig)) {
                    $privateConfig = $loadedConfig;
                }
            }
        } finally {
            @chdir($previousWorkingDirectory);
        }
    }

    $dbHost = $privateConfig['host'] ?? null;
    $dbUser = $privateConfig['user'] ?? null;
    $dbPass = $privateConfig['password'] ?? null;
    $dbName = $privateConfig['database'] ?? null;

    $dbHost = $dbHost ?: (getenv('BOOKVERSE_DB_HOST') ?: null);
    $dbUser = $dbUser ?: (getenv('BOOKVERSE_DB_USER') ?: null);
    $dbPass = $dbPass ?: (getenv('BOOKVERSE_DB_PASS') ?: null);
    $dbName = $dbName ?: (getenv('BOOKVERSE_DB_NAME') ?: null);

    if (!getenv('BOOKVERSE_DB_PORT') && isset($privateConfig['port'])) {
        putenv('BOOKVERSE_DB_PORT=' . (int) $privateConfig['port']);
    }
}

try {
    if (!$dbHost || !$dbUser || !$dbName) {
        throw new RuntimeException('Database environment is incomplete.');
    }

    $portValue = getenv('BOOKVERSE_DB_PORT') ?: '3306';
    $dbPort = filter_var($portValue, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 65535]]);
    if ($dbPort === false) {
        throw new RuntimeException('Database port configuration is invalid.');
    }

    $conn = mysqli_connect($dbHost, $dbUser, $dbPass ?: '', $dbName, (int) $dbPort);
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
