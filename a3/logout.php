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

// Rotate the identifier so the authenticated session is invalidated while a
// fresh anonymous session can carry the logout flash message.
$_SESSION = [];
session_regenerate_id(true);
bv_set_flash('info', 'You have been logged out.');
bv_redirect('index.php');
