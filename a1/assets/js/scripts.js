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

        if (!file) {
            imagePreview.src = "";
            imagePreview.classList.add("d-none");
            return;
        }

        const fileName = file.name.toLowerCase();
        const allowedExtensions = [
            ".jpg",
            ".jpeg",
            ".png",
            ".gif",
            ".webp"
        ];

        const isValidImage = allowedExtensions.some(function (extension) {
            return fileName.endsWith(extension);
        });

        if (!isValidImage) {

            alert(
                "Invalid image type. Please select a JPG, JPEG, PNG, GIF or WEBP image."
            );

            imageInput.value = "";
            imagePreview.src = "";
            imagePreview.classList.add("d-none");

            return;
        }

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

        event.preventDefault();

        if (!addBookForm.checkValidity()) {
            addBookForm.reportValidity();
            return;
        }

        alert("Book details have been validated successfully.");

    });
}