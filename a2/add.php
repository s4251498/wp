<?php
$pageTitle = 'Add Book';

require_once 'includes/db_connect.inc';

$errors = [];
$successMessage = '';

$title = '';
$author = '';
$genre = '';
$publicationYear = '';
$isbn = '';
$description = '';
$bookCondition = '';
$price = '';
$status = '';
$confirmed = false;

$genres = [
    'Fiction',
    'Science Fiction',
    'Fantasy',
    'Dystopian',
    'Romance',
    'Memoir',
    'Self-Help',
    'Non-Fiction'
];

$conditions = [
    'New',
    'Gently Used',
    'Fair'
];

$statuses = [
    'Available',
    'Reserved',
    'Sold'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $publicationYear = trim($_POST['publication_year'] ?? '');
    $isbn = trim($_POST['isbn'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $bookCondition = trim($_POST['book_condition'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $confirmed = isset($_POST['confirmation']);

    /*
     * Required field validation
     */

    if ($title === '') {
        $errors[] = 'Book title is required.';
    }

    if ($author === '') {
        $errors[] = 'Author name is required.';
    }

    if (!in_array($genre, $genres, true)) {
        $errors[] = 'Please select a valid genre.';
    }

    /*
     * Publication year validation
     */

    if (
        $publicationYear === '' ||
        filter_var($publicationYear, FILTER_VALIDATE_INT) === false
    ) {
        $errors[] = 'Publication year must be a valid whole number.';
    } elseif (
        (int) $publicationYear < 1000 ||
        (int) $publicationYear > (int) date('Y')
    ) {
        $errors[] = 'Publication year must be between 1000 and the current year.';
    }

    if ($isbn === '') {
        $errors[] = 'ISBN is required.';
    } elseif (strlen($isbn) > 20) {
        $errors[] = 'ISBN must not exceed 20 characters.';
    }

    if ($description === '') {
        $errors[] = 'Description is required.';
    }

    /*
     * Condition validation
     */

    if (!in_array($bookCondition, $conditions, true)) {
        $errors[] = 'Please select a valid book condition.';
    }

    /*
     * Price validation
     */

    if (
        $price === '' ||
        !is_numeric($price) ||
        (float) $price < 0
    ) {
        $errors[] = 'Price must be a valid non-negative number.';
    }

    /*
     * Status validation
     */

    if (!in_array($status, $statuses, true)) {
        $errors[] = 'Please select a valid availability status.';
    }

    /*
     * Confirmation checkbox
     */

    if (!$confirmed) {
        $errors[] = 'Please confirm that the book information is accurate and complete.';
    }

    /*
     * Image validation
     */

    $uploadedImageName = '';
    $image = null;
    $extension = '';

    if (
        !isset($_FILES['image_path']) ||
        $_FILES['image_path']['error'] === UPLOAD_ERR_NO_FILE
    ) {

        $errors[] = 'A book cover image is required.';

    } elseif ($_FILES['image_path']['error'] !== UPLOAD_ERR_OK) {

        $errors[] = 'There was a problem uploading the image.';

    } else {

        $image = $_FILES['image_path'];

        $allowedExtensions = [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'webp'
        ];

        $extension = strtolower(
            pathinfo($image['name'], PATHINFO_EXTENSION)
        );

        if (!in_array($extension, $allowedExtensions, true)) {
            $errors[] = 'Only JPG, JPEG, PNG, GIF and WEBP images are allowed.';
        }

        if ($image['size'] > 5 * 1024 * 1024) {
            $errors[] = 'The image must be smaller than 5 MB.';
        }

        $imageInfo = @getimagesize($image['tmp_name']);

        if ($imageInfo === false) {
            $errors[] = 'The uploaded file must be a valid image.';
        }
    }

    /*
     * Process image upload and database insertion
     */

    if (empty($errors)) {

        $coversDirectory = __DIR__ . '/assets/images/covers/';

        if (!is_dir($coversDirectory)) {
            mkdir($coversDirectory, 0755, true);
        }

        /*
         * Create a unique filename so uploaded images
         * cannot overwrite existing cover images.
         */
        $uniqueFilename =
            uniqid('book_', true) . '.' . $extension;

        $destination =
            $coversDirectory . $uniqueFilename;

        if (!move_uploaded_file(
            $image['tmp_name'],
            $destination
        )) {

            $errors[] = 'The image could not be saved.';

        } else {

            /*
             * Insert the new book using the exact supplied
             * BookVerse database column names.
             */

            $sql = "INSERT INTO books
                    (
                        title,
                        author,
                        genre,
                        publication_year,
                        isbn,
                        description,
                        book_condition,
                        price,
                        image_path,
                        status
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {

                $publicationYearInt = (int) $publicationYear;
                $priceFloat = (float) $price;

                mysqli_stmt_bind_param(
                    $stmt,
                    'sssisssdss',
                    $title,
                    $author,
                    $genre,
                    $publicationYearInt,
                    $isbn,
                    $description,
                    $bookCondition,
                    $priceFloat,
                    $uniqueFilename,
                    $status
                );

                if (mysqli_stmt_execute($stmt)) {

                    $successMessage =
                        'The book was successfully added to BookVerse.';

                    /*
                     * Clear the form after successful submission.
                     */
                    $title = '';
                    $author = '';
                    $genre = '';
                    $publicationYear = '';
                    $isbn = '';
                    $description = '';
                    $bookCondition = '';
                    $price = '';
                    $status = '';
                    $confirmed = false;

                } else {

                    /*
                     * Remove the uploaded file if the
                     * database insertion failed.
                     */
                    if (file_exists($destination)) {
                        unlink($destination);
                    }

                    $errors[] =
                        'The book could not be added to the database.';
                }

                mysqli_stmt_close($stmt);

            } else {

                if (file_exists($destination)) {
                    unlink($destination);
                }

                $errors[] =
                    'The database statement could not be prepared.';
            }
        }
    }
}

require_once 'includes/header.inc';
require_once 'includes/nav.inc';
?>

<main class="container py-5">

    <section class="page-header text-center">

        <h1>
            <span class="material-icons align-middle">
                add_box
            </span>
            Add New Book
        </h1>

        <p class="lead">
            Add a new book to the BookVerse collection.
        </p>

    </section>


    <?php if (!empty($errors)): ?>

        <div
            class="alert alert-danger"
            role="alert"
        >

            <h2 class="h5">
                Please correct the following:
            </h2>

            <ul class="mb-0">

                <?php foreach ($errors as $error): ?>

                    <li>
                        <?= htmlspecialchars($error) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <?php if ($successMessage !== ''): ?>

        <div
            class="alert alert-success"
            role="alert"
        >

            <?= htmlspecialchars($successMessage) ?>

            <div class="mt-3">

                <a
                    href="books.php"
                    class="btn btn-primary"
                >
                    View Books
                </a>

            </div>

        </div>

    <?php endif; ?>


    <section class="form-card">

        <form
            method="POST"
            action="add.php"
            enctype="multipart/form-data"
        >

            <div class="row g-4">

                <!-- Book Title -->

                <div class="col-12">

                    <label
                        for="title"
                        class="form-label"
                    >
                        Book Title
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control"
                        placeholder="Enter book title"
                        value="<?= htmlspecialchars($title) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <!-- Author -->

                <div class="col-12">

                    <label
                        for="author"
                        class="form-label"
                    >
                        Author Name
                    </label>

                    <input
                        type="text"
                        id="author"
                        name="author"
                        class="form-control"
                        placeholder="Enter author name"
                        value="<?= htmlspecialchars($author) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <!-- Genre -->

                <div class="col-12">

                    <label
                        for="genre"
                        class="form-label"
                    >
                        Genre
                    </label>

                    <select
                        id="genre"
                        name="genre"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select a genre
                        </option>

                        <?php foreach ($genres as $genreOption): ?>

                            <option
                                value="<?= htmlspecialchars($genreOption) ?>"
                                <?= $genre === $genreOption ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($genreOption) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Publication Year -->

                <div class="col-12 col-md-6">

                    <label
                        for="publication_year"
                        class="form-label"
                    >
                        Publication Year
                    </label>

                    <input
                        type="number"
                        id="publication_year"
                        name="publication_year"
                        class="form-control"
                        placeholder="2024"
                        value="<?= htmlspecialchars($publicationYear) ?>"
                        min="1000"
                        max="<?= date('Y') ?>"
                        required
                    >

                </div>


                <!-- Price -->

                <div class="col-12 col-md-6">

                    <label
                        for="price"
                        class="form-label"
                    >
                        Price ($)
                    </label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="form-control"
                        placeholder="19.99"
                        value="<?= htmlspecialchars($price) ?>"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>


                <!-- ISBN -->

                <div class="col-12 col-md-6">

                    <label
                        for="isbn"
                        class="form-label"
                    >
                        ISBN
                    </label>

                    <input
                        type="text"
                        id="isbn"
                        name="isbn"
                        class="form-control"
                        placeholder="978-1-234567-89-0"
                        value="<?= htmlspecialchars($isbn) ?>"
                        maxlength="20"
                        required
                    >

                </div>


                <!-- Book Condition -->

                <div class="col-12 col-md-6">

                    <label
                        for="book_condition"
                        class="form-label"
                    >
                        Book Condition
                    </label>

                    <select
                        id="book_condition"
                        name="book_condition"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select condition
                        </option>

                        <?php foreach ($conditions as $conditionOption): ?>

                            <option
                                value="<?= htmlspecialchars($conditionOption) ?>"
                                <?= $bookCondition === $conditionOption ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($conditionOption) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Description -->

                <div class="col-12">

                    <label
                        for="description"
                        class="form-label"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="6"
                        placeholder="Describe the book..."
                        required
                    ><?= htmlspecialchars($description) ?></textarea>

                </div>


                <!-- Image Upload -->

                <div class="col-12">

                    <label
                        for="image_path"
                        class="form-label"
                    >
                        Upload Cover Image
                    </label>

                    <input
                        type="file"
                        id="image_path"
                        name="image_path"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.gif,.webp"
                        required
                    >

                    <div class="form-text">
                        Accepted formats: JPG, JPEG, PNG, GIF and WEBP.
                        Maximum file size: 5 MB.
                    </div>

                    <!-- Image preview -->

                    <div
                        id="imagePreviewContainer"
                        class="mt-3"
                    >

                        <img
                            id="imagePreview"
                            src=""
                            alt="Selected book cover preview"
                            class="img-fluid d-none"
                        >

                    </div>

                </div>


                <!-- Availability Status -->

                <div class="col-12">

                    <label
                        for="status"
                        class="form-label"
                    >
                        Availability Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select availability status
                        </option>

                        <?php foreach ($statuses as $statusOption): ?>

                            <option
                                value="<?= htmlspecialchars($statusOption) ?>"
                                <?= $status === $statusOption ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($statusOption) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Confirmation -->

                <div class="col-12">

                    <div class="form-check">

                        <input
                            type="checkbox"
                            id="confirmation"
                            name="confirmation"
                            class="form-check-input"
                            value="1"
                            <?= $confirmed ? 'checked' : '' ?>
                            required
                        >

                        <label
                            for="confirmation"
                            class="form-check-label"
                        >
                            I agree that this book information is accurate
                            and complete.
                        </label>

                    </div>

                </div>


                <!-- Submit -->

                <div class="col-12">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <span class="material-icons align-middle">
                            save
                        </span>

                        Add Book to Collection

                    </button>

                </div>

            </div>

        </form>

    </section>

</main>

<?php
require_once 'includes/footer.inc';
?>