<?php
if (!isset($pageTitle)) {
    $pageTitle = 'BookVerse';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?> | BookVerse</title>

    <meta
        name="description"
        content="BookVerse online bookstore platform"
    >

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Elms+Sans:wght@400;500;600;700&family=Righteous&display=swap"
        rel="stylesheet"
    >

    <!-- Material Icons -->
    <link
        href="https://fonts.googleapis.com/icon?family=Material+Icons"
        rel="stylesheet"
    >

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >

    <!-- BookVerse custom CSS -->
    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

    <link
        rel="icon"
        type="image/svg+xml"
        href="assets/images/favicon.svg"
    >
</head>

<body>