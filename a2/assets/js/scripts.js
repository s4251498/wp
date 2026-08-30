/*
 * BookVerse - Common JavaScript
 * COSC2446 Assessment 2
 */

document.addEventListener('DOMContentLoaded', function () {

    /*
     * ==========================================
     * Books Page - Status Filter
     * ==========================================
     */

    const statusFilter = document.getElementById('statusFilter');
    const bookRows = document.querySelectorAll('#booksTableBody tr');
    const noBooksMessage = document.getElementById('noBooksMessage');

    if (statusFilter) {

        statusFilter.addEventListener('change', function () {

            const selectedStatus = this.value;
            let visibleRows = 0;

            bookRows.forEach(function (row) {

                const rowStatus = row.dataset.status;

                if (
                    selectedStatus === 'all' ||
                    rowStatus === selectedStatus
                ) {
                    row.classList.remove('d-none');
                    visibleRows++;
                } else {
                    row.classList.add('d-none');
                }

            });

            if (noBooksMessage) {
                if (visibleRows === 0) {
                    noBooksMessage.classList.remove('d-none');
                } else {
                    noBooksMessage.classList.add('d-none');
                }
            }

        });

    }


    /*
     * ==========================================
     * Add Book - Image Preview
     * ==========================================
     */

    const imageInput = document.getElementById('image_path');
    const imagePreview = document.getElementById('imagePreview');

    if (imageInput && imagePreview) {

        imageInput.addEventListener('change', function () {

            const file = this.files[0];

            if (!file) {
                imagePreview.src = '';
                imagePreview.classList.add('d-none');
                return;
            }

            const allowedExtensions = [
                'jpg',
                'jpeg',
                'png',
                'gif',
                'webp'
            ];

            const fileName = file.name.toLowerCase();
            const fileExtension = fileName
                .split('.')
                .pop();

            if (!allowedExtensions.includes(fileExtension)) {

                alert(
                    'Please select a JPG, JPEG, PNG, GIF or WEBP image.'
                );

                this.value = '';
                imagePreview.src = '';
                imagePreview.classList.add('d-none');

                return;
            }

            /*
             * Maximum file size: 5 MB
             */
            const maximumSize = 5 * 1024 * 1024;

            if (file.size > maximumSize) {

                alert(
                    'The selected image must be smaller than 5 MB.'
                );

                this.value = '';
                imagePreview.src = '';
                imagePreview.classList.add('d-none');

                return;
            }

            const reader = new FileReader();

            reader.addEventListener('load', function (event) {

                imagePreview.src = event.target.result;
                imagePreview.classList.remove('d-none');

            });

            reader.readAsDataURL(file);

        });

    }


    /*
     * ==========================================
     * Gallery - Bootstrap Image Modal
     * ==========================================
     */

    const galleryImages = document.querySelectorAll(
        '.gallery-image'
    );

    const galleryModalImage = document.getElementById(
        'galleryModalImage'
    );

    const galleryModalLabel = document.getElementById(
        'bookImageModalLabel'
    );

    if (
        galleryImages.length > 0 &&
        galleryModalImage
    ) {

        galleryImages.forEach(function (image) {

            image.addEventListener('click', function () {

                const imageSource = this.dataset.image;
                const imageTitle = this.dataset.title;

                galleryModalImage.src = imageSource;
                galleryModalImage.alt =
                    imageTitle + ' cover';

                if (galleryModalLabel) {
                    galleryModalLabel.textContent =
                        imageTitle;
                }

            });

            /*
             * Allow keyboard users to open the image.
             */
            image.addEventListener('keydown', function (event) {

                if (
                    event.key === 'Enter' ||
                    event.key === ' '
                ) {

                    event.preventDefault();
                    this.click();

                }

            });

        });

    }

});