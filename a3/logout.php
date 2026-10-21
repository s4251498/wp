<?php
require_once __DIR__ . '/includes/functions.inc';
bv_start_session();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method Not Allowed');
}

if (!bv_verify_csrf(bv_post_string($_POST, 'csrf_token'))) {
    bv_set_flash('danger', 'Your session check failed. You are still logged in.');
    bv_redirect('index.php');
}

// Destroy the authenticated session and start a new anonymous session for the
// flash message that confirms logout.
$sessionName = session_name();
$cookieParameters = session_get_cookie_params();
if (ini_get('session.use_cookies')) {
    setcookie(
        $sessionName,
        '',
        time() - 42000,
        $cookieParameters['path'],
        $cookieParameters['domain'],
        $cookieParameters['secure'],
        $cookieParameters['httponly']
    );
    unset($_COOKIE[$sessionName]);
}
$_SESSION = [];
session_destroy();
session_id('');
bv_start_session();
bv_set_flash('info', 'You have been logged out.');
bv_redirect('index.php');
