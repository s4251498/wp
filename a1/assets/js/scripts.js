/* =========================================
   BookVerse - Assessment 1
   JavaScript Functionality
   ========================================= */


/* ---------- Image Preview and Validation ---------- */

const imageInput = document.getElementById("image_path");
const imagePreview = document.getElementById("imagePreview");

if (imageInput && imagePreview) {

    imageInput.addEventListener("change", function () {

        const file = imageInput.files[0];

        // Clear preview when no file is selected
        if (!file) {
            imagePreview.src = "";
            imagePreview.classList.add("d-none");
            return;
        }

        // Allowed image file types
        const allowedTypes = [
            "image/jpeg",
            "image/png",
            "image/gif",
            "image/webp"
        ];

        // Check the actual file type
        if (!allowedTypes.includes(file.type)) {

            alert(
                "Invalid image type. Please select a JPG, JPEG, PNG, GIF or WEBP image."
            );

            imageInput.value = "";
            imagePreview.src = "";
            imagePreview.classList.add("d-none");

            return;
        }

        // Check the file extension as an additional validation
        const fileName = file.name.toLowerCase();

        const allowedExtensions = [
            ".jpg",
            ".jpeg",
            ".png",
            ".gif",
            ".webp"
        ];

        const hasValidExtension = allowedExtensions.some(function (extension) {
            return fileName.endsWith(extension);
        });

        if (!hasValidExtension) {

            alert(
                "Invalid image file extension. Please select a JPG, JPEG, PNG, GIF or WEBP image."
            );

            imageInput.value = "";
            imagePreview.src = "";
            imagePreview.classList.add("d-none");

            return;
        }

        // Create image preview
        const reader = new FileReader();

        reader.addEventListener("load", function () {

            imagePreview.src = reader.result;
            imagePreview.classList.remove("d-none");

        });

        reader.readAsDataURL(file);
    });
}


/* ---------- Gallery Modal ---------- */

const galleryButtons = document.querySelectorAll(".gallery-image-button");
const modalImage = document.getElementById("modalImage");
const imageModalLabel = document.getElementById("imageModalLabel");

galleryButtons.forEach(function (button) {

    button.addEventListener("click", function () {

        const imagePath = button.dataset.image;
        const imageTitle = button.dataset.title;

        if (modalImage) {
            modalImage.src = imagePath;
            modalImage.alt = imageTitle;
        }

        if (imageModalLabel) {
            imageModalLabel.textContent = imageTitle;
        }
    });
});


/* ---------- Book Status Filter ---------- */

const statusFilter = document.getElementById("statusFilter");

if (statusFilter) {

    statusFilter.addEventListener("change", function () {

        const selectedStatus = statusFilter.value;
        const bookRows = document.querySelectorAll("tbody tr");

        bookRows.forEach(function (row) {

            const bookStatus = row.dataset.status;

            if (
                selectedStatus === "all" ||
                bookStatus === selectedStatus
            ) {
                row.classList.remove("d-none");
            } else {
                row.classList.add("d-none");
            }

        });
    });
}


/* ---------- Add Book Form ---------- */

const addBookForm = document.getElementById("addBookForm");

if (addBookForm) {

    addBookForm.addEventListener("submit", function (event) {

        // Prevent the form from submitting before validation
        event.preventDefault();


        /* ---------- Get Form Values ---------- */

        const title = document.getElementById("title");
        const author = document.getElementById("author");
        const genre = document.getElementById("genre");
        const publicationYear = document.getElementById("publication_year");
        const price = document.getElementById("price");
        const isbn = document.getElementById("isbn");
        const bookCondition = document.getElementById("book_condition");
        const description = document.getElementById("description");
        const status = document.getElementById("status");
        const agree = document.getElementById("agree");


        /* ---------- Check Required Fields ---------- */

        if (!addBookForm.checkValidity()) {

            addBookForm.reportValidity();

            return;
        }


        /* ---------- Validate Book Title ---------- */

        if (title.value.trim().length < 2) {

            alert("Book title must contain at least 2 characters.");

            title.focus();

            return;
        }


        /* ---------- Validate Author ---------- */

        if (author.value.trim().length < 2) {

            alert("Author name must contain at least 2 characters.");

            author.focus();

            return;
        }


        /* ---------- Validate Genre ---------- */

        if (genre.value.trim().length < 2) {

            alert("Please enter a valid book genre.");

            genre.focus();

            return;
        }


        /* ---------- Validate Publication Year ---------- */

        const currentYear = new Date().getFullYear();
        const yearValue = Number(publicationYear.value);

        if (
            !Number.isInteger(yearValue) ||
            yearValue < 1000 ||
            yearValue > currentYear
        ) {

            alert(
                "Please enter a valid publication year between 1000 and " +
                currentYear +
                "."
            );

            publicationYear.focus();

            return;
        }


        /* ---------- Validate Price ---------- */

        const priceValue = Number(price.value);

        if (
            Number.isNaN(priceValue) ||
            priceValue < 0
        ) {

            alert("Please enter a valid price greater than or equal to $0.");

            price.focus();

            return;
        }


        /* ---------- Validate ISBN ---------- */

        // Remove spaces and hyphens before checking the ISBN
        const cleanedISBN = isbn.value.replace(/[\s-]/g, "");

        // ISBN-10 or ISBN-13 format
        const isbnPattern = /^(?:\d{9}[\dXx]|\d{13})$/;

        if (!isbnPattern.test(cleanedISBN)) {

            alert(
                "Please enter a valid ISBN-10 or ISBN-13 number."
            );

            isbn.focus();

            return;
        }


        /* ---------- Validate Book Condition ---------- */

        if (bookCondition.value === "") {

            alert("Please select the condition of the book.");

            bookCondition.focus();

            return;
        }


        /* ---------- Validate Description ---------- */

        if (description.value.trim().length < 10) {

            alert(
                "Book description must contain at least 10 characters."
            );

            description.focus();

            return;
        }


        /* ---------- Validate Availability Status ---------- */

        if (status.value === "") {

            alert("Please select an availability status.");

            status.focus();

            return;
        }


        /* ---------- Validate Agreement Checkbox ---------- */

        if (!agree.checked) {

            alert(
                "You must agree that the book information is accurate and complete."
            );

            agree.focus();

            return;
        }


        /* ---------- Final Validation ---------- */

        alert(
            "Book details have been validated successfully."
        );

    });
}