<?php
require_once __DIR__ . '/includes/functions.inc';
bv_start_session();

$pageTitle = 'Register';
$formError = '';

if (bv_is_authenticated()) {
    bv_redirect('index.php');
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $username = bv_post_string($_POST, 'username');
    $email = bv_post_string($_POST, 'email');
    $phone = bv_post_string($_POST, 'phone');
    $location = bv_post_string($_POST, 'location');
    $bio = bv_post_string($_POST, 'bio');
    $password = bv_post_string($_POST, 'password', false);
    $confirmPassword = bv_post_string($_POST, 'confirm_password', false);

    if (!bv_verify_csrf(bv_post_string($_POST, 'csrf_token'))) {
        $formError = 'Your session check failed. Please submit the form again.';
    } elseif ($username === '' || strlen($username) > 50) {
        $formError = 'Enter a username of no more than 50 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        $formError = 'Enter a valid email address of no more than 100 characters.';
    } elseif (strlen($phone) > 20 || strlen($location) > 100) {
        $formError = 'Phone or location is longer than the allowed limit.';
    } elseif (strlen($password) < 8 || strlen($password) > 72) {
        $formError = 'Choose a password between 8 and 72 bytes.';
    } elseif (!hash_equals($password, $confirmPassword)) {
        $formError = 'The passwords do not match.';
    } else {
        try {
            require_once __DIR__ . '/includes/db_connect.inc';
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare(
                $conn,
                'INSERT INTO users (username, email, password, phone, location, bio) VALUES (?, ?, ?, ?, ?, ?)'
            );
            mysqli_stmt_bind_param($stmt, 'ssssss', $username, $email, $passwordHash, $phone, $location, $bio);
            mysqli_stmt_execute($stmt);
            $userId = (int) mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);

            bv_login_user($userId, $username);
            bv_set_flash('success', 'Your account is ready. Welcome to BookVerse!');
            bv_redirect('index.php');
        } catch (mysqli_sql_exception $error) {
            if ((int) $error->getCode() === 1062) {
                $formError = 'That username or email is already registered.';
            } else {
                error_log('BookVerse registration failed: ' . $error->getMessage());
                $formError = 'We could not create your account right now. Please try again.';
            }
        } catch (Throwable $error) {
            error_log('BookVerse registration failed: ' . $error->getMessage());
            $formError = 'We could not create your account right now. Please try again.';
        }
    }
}

require_once __DIR__ . '/includes/header.inc';
require_once __DIR__ . '/includes/nav.inc';
?>
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
            <section class="form-card">
                <header class="page-header text-center">
                    <h1>Create your account</h1>
                    <p class="lead">Join the BookVerse reader community.</p>
                </header>
                <?php if ($formError !== ''): ?>
                    <div class="alert alert-danger" role="alert"><?= bv_escape($formError) ?></div>
                <?php endif; ?>
                <form method="post" action="register.php">
                    <input type="hidden" name="csrf_token" value="<?= bv_escape(bv_csrf_token()) ?>">
                    <div class="mb-3">
                        <label class="form-label" for="username">Username</label>
                        <input class="form-control" id="username" name="username" type="text" maxlength="50" autocomplete="username" required value="<?= bv_escape(bv_post_string($_POST, 'username')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" maxlength="100" autocomplete="email" required value="<?= bv_escape(bv_post_string($_POST, 'email')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone <span class="text-muted">(optional)</span></label>
                        <input class="form-control" id="phone" name="phone" type="tel" maxlength="20" autocomplete="tel" value="<?= bv_escape(bv_post_string($_POST, 'phone')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="location">Location <span class="text-muted">(optional)</span></label>
                        <input class="form-control" id="location" name="location" type="text" maxlength="100" autocomplete="address-level2" value="<?= bv_escape(bv_post_string($_POST, 'location')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bio">About you <span class="text-muted">(optional)</span></label>
                        <textarea class="form-control" id="bio" name="bio" rows="3"><?= bv_escape(bv_post_string($_POST, 'bio')) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password" minlength="8" maxlength="72" autocomplete="new-password" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="confirm_password">Confirm password</label>
                        <input class="form-control" id="confirm_password" name="confirm_password" type="password" minlength="8" maxlength="72" autocomplete="new-password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Create account</button>
                </form>
                <p class="text-center mt-4 mb-0">Already registered? <a href="login.php">Log in</a></p>
            </section>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/includes/footer.inc'; ?>
