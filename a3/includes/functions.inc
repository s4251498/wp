<?php
/** Shared request, output, flash, and access-control helpers for BookVerse. */

function bv_start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'httponly' => true,
        'secure' => $isHttps,
        'samesite' => 'Lax',
        'path' => '/',
    ]);
    session_start();
}

function bv_escape(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function bv_set_flash(string $type, string $message): void
{
    bv_start_session();
    $allowedTypes = ['success', 'danger', 'warning', 'info'];
    $_SESSION['flash'][] = [
        'type' => in_array($type, $allowedTypes, true) ? $type : 'info',
        'message' => $message,
    ];
}

function bv_take_flashes(): array
{
    bv_start_session();
    $flashes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return is_array($flashes) ? $flashes : [];
}

function bv_redirect(string $location)
{
    header('Location: ' . $location, true, 303);
    exit;
}

function bv_is_authenticated(): bool
{
    bv_start_session();
    return isset($_SESSION['user_id']) && filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT) !== false;
}

function bv_require_login(): void
{
    if (!bv_is_authenticated()) {
        bv_set_flash('warning', 'Please log in to access that page.');
        bv_redirect('login.php');
    }
}

function bv_csrf_token(): string
{
    bv_start_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function bv_verify_csrf(?string $submittedToken): bool
{
    bv_start_session();
    return is_string($submittedToken)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $submittedToken);
}
