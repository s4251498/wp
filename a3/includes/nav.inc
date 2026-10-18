<?php
$currentPage = basename($_SERVER['PHP_SELF'] ?? '');
$loggedIn = bv_is_authenticated();
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bookverse-navbar" aria-label="Main navigation">
        <div class="container">
            <a class="navbar-brand bookverse-brand" href="index.php"><span class="material-icons align-middle" aria-hidden="true">menu_book</span> BookVerse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavigation">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <?php foreach ([
                        'index.php' => ['Home', 'home'],
                        'books.php' => ['Books', 'menu_book'],
                        'gallery.php' => ['Gallery', 'photo_library'],
                    ] as $href => [$label, $icon]): ?>
                        <li class="nav-item"><a class="nav-link<?= $currentPage === $href ? ' active' : '' ?>" href="<?= bv_escape($href) ?>"<?= $currentPage === $href ? ' aria-current="page"' : '' ?>><span class="material-icons align-middle" aria-hidden="true"><?= bv_escape($icon) ?></span> <?= bv_escape($label) ?></a></li>
                    <?php endforeach; ?>
                    <li class="nav-item"><a class="nav-link<?= $currentPage === 'search.php' ? ' active' : '' ?>" href="search.php" aria-label="Search books"><span class="material-icons align-middle" aria-hidden="true">search</span> Search</a></li>
                    <?php if ($loggedIn): ?>
                        <li class="nav-item"><a class="nav-link<?= $currentPage === 'add.php' ? ' active' : '' ?>" href="add.php"><span class="material-icons align-middle" aria-hidden="true">add_circle</span> Add Book</a></li>
                        <li class="nav-item"><a class="nav-link<?= $currentPage === 'seller.php' ? ' active' : '' ?>" href="seller.php?id=<?= (int) $_SESSION['user_id'] ?>"><span class="material-icons align-middle" aria-hidden="true">person</span> My Listings</a></li>
                        <li class="nav-item"><span class="navbar-text px-lg-2">Hi, <?= bv_escape((string) ($_SESSION['username'] ?? 'Reader')) ?></span></li>
                        <li class="nav-item">
                            <form action="logout.php" method="post" class="d-lg-inline">
                                <input type="hidden" name="csrf_token" value="<?= bv_escape(bv_csrf_token()) ?>">
                                <button class="nav-link btn btn-link" type="submit">Log out</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link<?= $currentPage === 'register.php' ? ' active' : '' ?>" href="register.php">Register</a></li>
                        <li class="nav-item"><a class="nav-link<?= $currentPage === 'login.php' ? ' active' : '' ?>" href="login.php">Log in</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
<?php foreach (bv_take_flashes() as $flash): ?>
    <div class="container mt-3" role="status" aria-live="polite">
        <div class="alert alert-<?= bv_escape($flash['type']) ?> alert-dismissible fade show mb-0">
            <?= bv_escape($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Dismiss message"></button>
        </div>
    </div>
<?php endforeach; ?>
