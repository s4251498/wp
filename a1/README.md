# COSC2446 Web Programming – Assessment 1  
# BookVerse Online Bookstore Platform

## Student Details

| Item | Details |
|---|---|
| Student name | Oliver Heberle |
| Student ID | S4251498 |
| GitHub repository URL | https://github.com/s4251498/wp |
| Deployed website URL | https://titan.csit.rmit.edu.au/~s4251498/wp/a1/index.html |

---

## 1. Purpose of This README

This README documents the Assessment 1 project and should be completed by the student.

It is used to:

- summarise the project;
- explain the structure and technical choices;
- document testing and deployment;
- support marking of documentation and submission quality;
- help AI tools such as GitHub Copilot follow the assessment requirements.

TODO: After completing the project, update every TODO section in this file.

---

## 2. Copilot and AI Coding Instructions

## Copilot and AI Coding Instructions

AI tools, including ChatGPT and GitHub Copilot, were used during the development of this assessment.

AI was used as a development aid for tasks such as:
- Understanding assessment requirements.
- Troubleshooting HTML, CSS and JavaScript issues.
- Reviewing code and identifying potential problems.
- Suggesting improvements to the website layout and styling.
- Assisting with debugging and development decisions.

All AI-generated suggestions were reviewed before being used. Code was tested in the browser and modified where necessary to ensure that it worked correctly and met the assessment requirements.

AI usage and the development process are documented separately in `process-evidence.md`.

## Project Structure

The BookVerse website is organised into separate HTML pages, CSS, JavaScript, image assets and documentation files.

### Main Pages

- `index.html` – BookVerse homepage containing the carousel and featured books.
- `books.html` – Displays the book collection and allows books to be filtered by availability status.
- `gallery.html` – Displays the BookVerse image gallery and provides image modal functionality.
- `add.html` – Contains the form for adding a new book, including validation and image preview functionality.

### Assets

The `assets` folder contains the resources used throughout the website.

- `assets/css/style.css` – Custom CSS styling for the website.
- `assets/js/scripts.js` – JavaScript functionality including filtering, gallery modal behaviour, form validation and image preview.
- `assets/images/covers/` – Contains the book cover images used throughout the website.
- `assets/images/favicon.svg` – Website favicon.

### Documentation

- `README.md` – Provides information about the project and development process.
- `process-evidence.md` – Records debugging, AI usage and development evidence throughout the assessment.

Bootstrap 5 is used alongside the custom CSS to provide responsive layout and Bootstrap components.

## 4. Website Structure

| File | Purpose |
|---|---|
| `index.html` | Homepage containing the BookVerse navigation, featured book carousel and featured book cards. |
| `books.html` | Displays the BookVerse book collection in a responsive table and allows users to filter books by availability status. |
| `gallery.html` | Displays book covers in a responsive Bootstrap grid and allows users to open individual covers in a Bootstrap modal. |
| `add.html` | Provides a form for entering book information, including title, author, genre, publication year, ISBN, description, condition, price, cover image and availability status. |

---


## 5. Project Folder Structure

The final Assessment 1 project is contained within the `a1` folder of the GitHub repository.

```text
a1/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── scripts.js
│   └── images/
│       ├── favicon.svg
│       └── covers/
│           ├── 1.png
│           ├── 2.png
│           ├── 3.png
│           ├── 4.png
│           ├── 5.png
│           ├── 6.png
│           ├── 7.png
│           ├── 8.png
│           ├── 9.png
│           ├── 10.png
│           ├── 11.png
│           └── 12.png
├── index.html
├── books.html
├── gallery.html
├── add.html
├── README.md
└── process-evidence.md
```

## 6. Technologies Used

| Technology | How it was used in this project |
|---|---|
| HTML5 | Used to create the structure and content of the four BookVerse pages using semantic HTML elements. |
| CSS3 | Used through the external `assets/css/style.css` file for custom colours, typography, spacing, navigation, cards, forms, gallery styling and responsive adjustments. |
| Bootstrap 5 | Used for the responsive grid system and Bootstrap components including the navigation bar, carousel, cards, table, forms, buttons and modal. |
| JavaScript | Used for book status filtering, gallery modal functionality, image file validation, image preview and Add Book form validation. |
| Google Fonts | Used to provide the Elms Sans and Righteous fonts used throughout the website. |
| Material Icons | Used for icons within the website navigation and page content. |
| Git / GitHub | Used for version control, storing the project and tracking development through commits. |
| CoreTeaching | Used to deploy the completed Assessment 1 website so that it can be accessed through the RMIT web server. |

## 7. Design and Layout

BookVerse uses a consistent visual design across all four pages.

The website uses a dark navy background with blue navigation elements and contrasting teal and orange accent colours. The colour scheme is defined using CSS variables in the external `assets/css/style.css` file.

Elms Sans is used for the main body text, while Righteous is used for headings and the BookVerse brand. These fonts are loaded using Google Fonts.

Material Icons are used throughout the website for relevant interface icons, including the menu book icon used with the BookVerse brand.

Bootstrap 5 is used throughout the website for responsive layouts and components. The Bootstrap grid system is used to arrange content at different screen sizes. Bootstrap components are used for the navigation bar, homepage carousel, cards, responsive table, form controls, buttons and gallery modal.

Custom styling is contained in the external `assets/css/style.css` file. No inline CSS is used.

The design is intended to remain consistent across the homepage, books page, gallery and Add Book form while adapting to different screen sizes through Bootstrap's responsive grid and custom media queries.

## 8. Required Features

| Feature | Page | Implementation |
|---|---|---|
| Bootstrap carousel | `index.html` | A Bootstrap carousel displays four featured book images with captions and previous/next controls. |
| Responsive featured books | `index.html` | Featured books are displayed using Bootstrap cards and responsive grid columns that adapt to different screen sizes. |
| Book table | `books.html` | A responsive Bootstrap table displays the book collection, including title, author, genre, condition, price and availability status. |
| Book status filter | `books.html` | A JavaScript dropdown filter allows users to display Available, Reserved, Sold or All books. |
| Gallery grid | `gallery.html` | Book covers are displayed using a responsive Bootstrap grid. |
| Bootstrap image modal | `gallery.html` | Selecting a gallery image opens a Bootstrap modal displaying the selected image and its title. |
| Add Book form | `add.html` | A form allows users to enter book details including title, author, genre, publication year, ISBN, description, condition, price, cover image and availability status. |
| Image validation | `add.html` | JavaScript validates uploaded image files and accepts JPG, JPEG, PNG, GIF and WEBP formats. |
| Image preview | `add.html` | A valid selected image is displayed in the preview area using JavaScript and FileReader. |
| HTML5 form validation | `add.html` | Required fields and appropriate HTML5 input attributes are used to validate form information before submission. |

## 9. JavaScript Functionality

JavaScript functionality is contained in the single external `assets/js/scripts.js` file.

| JavaScript feature | Page | How it works |
|---|---|---|
| Image file validation | `add.html` | Checks the selected image file type and extension. JPG, JPEG, PNG, GIF and WEBP files are accepted. Invalid files are rejected and the input is cleared. |
| Image preview | `add.html` | Uses the JavaScript `FileReader` API to read a valid selected image and display it in the image preview area. |
| Add Book form validation | `add.html` | Uses HTML5 form validity checking and additional JavaScript checks for the entered book information before displaying a successful validation message. |
| Gallery modal | `gallery.html` | Reads the selected gallery button's `data-image` and `data-title` attributes and updates the Bootstrap modal with the selected image and title. |
| Book status filter | `books.html` | Reads each table row's `data-status` attribute and shows or hides rows based on the selected Available, Reserved, Sold or All Books filter. |

## 10. Form Validation

The Add Book form uses both HTML5 validation and JavaScript validation to ensure that the information entered by the user is valid.

The following fields are required:

- Book Title
- Author Name
- Genre
- Publication Year
- ISBN
- Description
- Book Condition
- Price
- Cover Image
- Availability Status
- Agreement checkbox

Each form field has an associated `<label>` using the `for` attribute that matches the ID of the relevant form control.

Different HTML5 input types are used depending on the information being collected. Text inputs are used for titles, authors, genres and ISBNs. Number inputs are used for publication year and price. A textarea is used for the description, select elements are used for condition and availability status, and a file input is used for the cover image.

The price field uses a minimum value of `0` and a step of `0.01`.

JavaScript performs additional validation when the form is submitted, including:

- Title and author must contain at least two characters.
- Genre must contain at least two characters.
- Publication year must be a valid year between 1000 and the current year.
- Price must be a valid number greater than or equal to $0.
- ISBN must match an ISBN-10 or ISBN-13 format.
- Book condition must be selected.
- Description must contain at least 10 characters.
- Availability status must be selected.
- The agreement checkbox must be checked.

The cover image is validated using JavaScript. JPG, JPEG, PNG, GIF and WEBP image formats are accepted. Invalid image files are rejected and the file input is cleared.

When a valid image is selected, JavaScript uses the `FileReader` API to display an image preview before the form is submitted.

The form also uses the HTML5 `required` attribute and JavaScript `checkValidity()` and `reportValidity()` methods to ensure required information has been entered.

## 11. Accessibility and Usability

The BookVerse website includes accessibility and usability features across all four pages.

- Each page has a meaningful and unique `<title>`.
- Semantic HTML elements such as `header`, `nav`, `main`, `section`, `article` and `footer` are used.
- Form controls have associated labels using the `for` attribute.
- Images include appropriate alternative text using the `alt` attribute.
- Navigation is consistent across all four pages.
- The current page is identified using the Bootstrap active navigation class.
- Headings and readable fonts are used to provide a clear visual hierarchy.
- Bootstrap's responsive grid and custom media queries allow the website to adapt to different screen sizes.
- The books table includes a caption and uses table heading elements with `scope="col"`.
- Bootstrap carousel controls include accessible labels.
- Gallery images are contained within buttons so they can be selected as interactive controls.
- The gallery modal displays the selected image and its title.
- Form validation provides feedback when invalid information is entered.
- The Bootstrap responsive navigation allows the navigation menu to collapse on smaller screens.
- Sufficient spacing and consistent navigation are used to make the website easier to use.

## 12. Testing and Validation

The website was tested during development on both the local version and the deployed CoreTeaching version.

### HTML Validation

| File | Result | Notes |
|---|---|---|
| `index.html` | Pass | Required HTML structure and elements are present. |
| `books.html` | Pass | Required HTML structure, table and filtering elements are present. |
| `gallery.html` | Pass | Required HTML structure, gallery and modal elements are present. |
| `add.html` | Pass | Required form structure, labels and validation attributes are present. |

### CSS Validation

| File | Result | Notes |
|---|---|---|
| `assets/css/style.css` | Pass | External custom stylesheet is linked correctly and contains the website's custom styling. |

### Functionality Testing

| Feature tested | Result | Notes |
|---|---|---|
| Navigation links | Pass | Navigation links between the four pages were tested. |
| Bootstrap carousel | Pass | Carousel displays correctly and the previous/next controls work. |
| Gallery modal | Pass | Clicking a gallery image opens the modal and displays the selected image. |
| Book status filter | Pass | Available, Reserved, Sold and Show All filters display the correct records. |
| Add Book form validation | Pass | HTML5 and JavaScript validation correctly identifies invalid or missing information. |
| Image file validation | Pass | JPG, JPEG, PNG, GIF and WEBP image files are accepted and invalid file types are rejected. |
| Image preview | Pass | A valid selected image is displayed using the FileReader API. |
| Deployed site links and assets | Pass | The CoreTeaching deployment loads the pages, CSS, JavaScript and images correctly. |

### CoreTeaching Testing

The deployed website was tested using:

`https://titan.csit.rmit.edu.au/~s4251498/wp/a1/index.html`

The homepage was successfully loaded from the CoreTeaching server. The CSS styling, book cover images and website navigation loaded correctly.

The Books, Gallery and Add Book pages were also checked on the deployed site to confirm that the website assets and page links function correctly.

## 13. Deployment

The BookVerse Assessment 1 website was deployed to the RMIT CoreTeaching web server using Git and SSH.

### Deployment Details

| Item | Details |
|---|---|
| Deployed website URL | https://titan.csit.rmit.edu.au/~s4251498/wp/a1/index.html |
| CoreTeaching server | `titan.csit.rmit.edu.au` |
| Deployment directory | `/home/sh8/S4251498/public_html/wp/a1` |
| Authentication file | `/home/sh8/S4251498/public_html/.htaccess` |
| Git repository | `git@github.com:s4251498/wp.git` |
| Project directory | `a1` |

### CoreTeaching Authentication

A `.htaccess` file was configured in the `public_html` directory to restrict access to authorised RMIT users.

The configuration uses Kerberos authentication and requires the student's RMIT account:

require user s4251498@RMIT.INTERNAL

The .htaccess file is located one level above the wp project directory so that authentication applies to the deployed website.

The authentication configuration was tested through the deployed website. When accessing the BookVerse website, the user is prompted to authenticate using their RMIT credentials. After successful authentication, the BookVerse homepage loads correctly.

Deployment Structure
/home/sh8/S4251498/
└── public_html/
    ├── .htaccess
    └── wp/
        ├── a1/
        │   ├── index.html
        │   ├── books.html
        │   ├── gallery.html
        │   ├── add.html
        │   └── assets/
        ├── a2/
        ├── a3/
        └── week1/
Deployment Testing

The deployed website was tested after configuring the .htaccess file.

The following were confirmed:

The CoreTeaching URL loads correctly.
RMIT authentication is requested when accessing the website.
RMIT credentials successfully authenticate the user.
The BookVerse homepage loads after authentication.
CSS styling loads correctly.
Book cover images load correctly.
JavaScript functionality remains available.
Navigation links between the website pages work correctly.


## 14. Git and Development Process

Git and GitHub were used throughout the development of the BookVerse Assessment 1 project to maintain version control and track changes.

The project is stored in the GitHub repository:

`git@github.com:s4251498/wp.git`

The Assessment 1 website is contained within the `a1` directory.

Git was used to:

- Track changes made to the HTML, CSS and JavaScript files.
- Maintain a history of development changes.
- Allow the project to be cloned onto the CoreTeaching server.
- Keep the local development version and GitHub repository synchronised.
- Provide evidence of the development process through commit history.

The repository was cloned onto the CoreTeaching server using SSH:


git clone git@github.com:s4251498/wp.git

The repository was then accessed through:

~/wp/a1

The project was also checked using Git status to confirm the working directory was clean after the required changes were committed.

Meaningful commit messages were used throughout development to describe changes made to the project. The commit history provides evidence of the iterative development process and changes made to the BookVerse website.

## 15. AI Use Declaration

AI tools were used during the development of this assessment as a development aid.

ChatGPT was used to assist with:

- Understanding and interpreting assessment requirements.
- Reviewing and troubleshooting HTML, CSS and JavaScript code.
- Identifying and resolving layout and styling issues.
- Assisting with JavaScript functionality and validation.
- Reviewing the website against the provided assessment requirements.
- Assisting with CoreTeaching deployment and troubleshooting.
- Reviewing and improving documentation.

AI-generated suggestions were not accepted automatically. Suggestions were reviewed, tested and modified where necessary before being incorporated into the project.

The student remains responsible for the final implementation and has reviewed the submitted code to ensure that it is understood and functions as required.

Detailed AI interactions, prompts, decisions and modifications are documented in `process-evidence.md`.

## 16. Process Evidence

Confirm that your process evidence file has been completed.

| Requirement | Completed? |
|---|---|
| `process-evidence.md` file included | Yes |
| At least 2 debugging records included | Yes |
| At least 2 meaningful AI usage records included | Yes |
| Relevant commit links included | Yes  |

## 17. Known Issues or Limitations

The following limitations apply to the submitted project.

| Issue or limitation | Explanation |
|---|---|
| **Limitation — Static website** | Book information is currently stored directly in the HTML and is not connected to a database or backend. |
| **Limitation — Add Book form** | The Add Book form validates and previews the entered information but does not permanently add a new book to the books table because this is a static front-end website. |