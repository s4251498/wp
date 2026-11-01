<?php
// Temporary, token-protected Coreteaching diagnostic. Remove after deployment check.
$expectedTokenHash = '47196d8c4d6ff4cf94c9ac3fc530e2a7cf93aaf397ff62605785aab79fb67187';
$providedToken = $_GET['k'] ?? '';
if (!hash_equals($expectedTokenHash, hash('sha256', $providedToken))) {
    http_response_code(404);
    exit;
}

header('Content-Type: text/plain; charset=utf-8');
header('Cache-Control: no-store, private');

echo 'PHP: ' . PHP_VERSION . ' (' . PHP_SAPI . ")\n";
echo 'mysqli extension: ' . (extension_loaded('mysqli') ? 'yes' : 'no') . "\n";
echo 'environment variables present: ';
$envNames = ['BOOKVERSE_DB_HOST', 'BOOKVERSE_DB_USER', 'BOOKVERSE_DB_PASS', 'BOOKVERSE_DB_NAME'];
foreach ($envNames as $index => $envName) {
    echo ($index ? ', ' : '') . $envName . '=' . (getenv($envName) ? 'yes' : 'no');
}
echo "\n";

$privateConfig = [];
$privateConfigReadable = false;
$privateConfigPath = '../../../../bookverse-db-config.php';
$previousWorkingDirectory = getcwd();
if ($previousWorkingDirectory !== false && @chdir(__DIR__ . '/includes')) {
    try {
        $privateConfigReadable = is_readable($privateConfigPath);
        if ($privateConfigReadable) {
            $loadedConfig = require $privateConfigPath;
            if (is_array($loadedConfig)) {
                $privateConfig = $loadedConfig;
            }
        }
    } catch (Throwable $error) {
        $privateConfigReadable = false;
    } finally {
        @chdir($previousWorkingDirectory);
    }
}

echo 'private config readable from app context: ' . ($privateConfigReadable ? 'yes' : 'no') . "\n";
$dbHost = $privateConfig['host'] ?? (getenv('BOOKVERSE_DB_HOST') ?: null);
$dbUser = $privateConfig['user'] ?? (getenv('BOOKVERSE_DB_USER') ?: null);
$dbPass = $privateConfig['password'] ?? (getenv('BOOKVERSE_DB_PASS') ?: null);
$dbName = $privateConfig['database'] ?? (getenv('BOOKVERSE_DB_NAME') ?: null);
$port = (int) ($privateConfig['port'] ?? (getenv('BOOKVERSE_DB_PORT') ?: 3306));

if (!$dbHost || !$dbUser || !$dbPass || !$dbName) {
    echo "database settings complete: no\n";
} elseif (!extension_loaded('mysqli')) {
    echo "database test: mysqli extension missing\n";
} else {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $port);
        mysqli_set_charset($connection, 'utf8mb4');
        echo "database test: connected\n";
        mysqli_close($connection);
    } catch (Throwable $error) {
        echo 'database test: failed (' . get_class($error) . ', code ' . (int) $error->getCode() . ")\n";
    }
}

echo 'deployed db_connect.inc SHA-256: ' . hash_file('sha256', __DIR__ . '/includes/db_connect.inc') . "\n";
