<?php
require_once __DIR__ . '/includes/functions.inc';
bv_start_session();

$pageTitle = 'Log in';
$formError = '';

if (bv_is_authenticated()) {
    bv_redirect('index.php');
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $identifier = bv_post_string($_POST, 'identifier');
    $password = bv_post_string($_POST, 'password', false);

    if (!bv_verify_csrf(bv_post_string($_POST, 'csrf_token'))) {
        $formError = 'Your session check failed. Please submit the form again.';
    } elseif ($identifier === '' || $password === '') {
        $formError = 'Enter your username or email and password.';
    } else {
        try {
            require_once __DIR__ . '/includes/db_connect.inc';
            $stmt = mysqli_prepare(
                $conn,
                'SELECT user_id, username, password FROM users WHERE username = ? OR email = ? LIMIT 1'
            );
            mysqli_stmt_bind_param($stmt, 'ss', $identifier, $identifier);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $userId, $username, $passwordHash);
            $foundUser = mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if ($foundUser && password_verify($password, $passwordHash)) {
                bv_login_user((int) $userId, (string) $username);
                bv_set_flash('success', 'You are now logged in.');
                bv_redirect('index.php');
            }

            $formError = 'The username/email or password was not recognized.';
        } catch (Throwable $error) {
            error_log('BookVerse login failed: ' . $error->getMessage());
            $formError = 'We could not log you in right now. Please try again.';
        }
    }
}

require_once __DIR__ . '/includes/header.inc';
require_once __DIR__ . '/includes/nav.inc';
?>
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <section class="form-card">
                <header class="page-header text-center">
                    <h1>Welcome back</h1>
                    <p class="lead">Log in to manage your book listings.</p>
                </header>
                <?php if ($formError !== ''): ?>
                    <div class="alert alert-danger" role="alert"><?= bv_escape($formError) ?></div>
                <?php endif; ?>
                <form method="post" action="login.php">
                    <input type="hidden" name="csrf_token" value="<?= bv_escape(bv_csrf_token()) ?>">
                    <div class="mb-3">
                        <label class="form-label" for="identifier">Username or email</label>
                        <input class="form-control" id="identifier" name="identifier" type="text" autocomplete="username" required value="<?= bv_escape(bv_post_string($_POST, 'identifier')) ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password" autocomplete="current-password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Log in</button>
                </form>
                <p class="text-center mt-4 mb-0">New to BookVerse? <a href="register.php">Create an account</a></p>
            </section>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/includes/footer.inc'; ?>
