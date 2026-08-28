<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bookverse-navbar">
        <div class="container">

            <a class="navbar-brand bookverse-brand" href="index.php">
                <span class="material-icons align-middle">menu_book</span>
                BookVerse
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavigation"
                aria-controls="mainNavigation"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div
                class="collapse navbar-collapse"
                id="mainNavigation"
            >
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a
                            class="nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>"
                            href="index.php"
                        >
                            <span class="material-icons align-middle">home</span>
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link <?= $currentPage === 'books.php' ? 'active' : '' ?>"
                            href="books.php"
                        >
                            <span class="material-icons align-middle">menu_book</span>
                            Books
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link <?= $currentPage === 'gallery.php' ? 'active' : '' ?>"
                            href="gallery.php"
                        >
                            <span class="material-icons align-middle">photo_library</span>
                            Gallery
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link <?= $currentPage === 'add.php' ? 'active' : '' ?>"
                            href="add.php"
                        >
                            <span class="material-icons align-middle">add_circle</span>
                            Add Book
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>