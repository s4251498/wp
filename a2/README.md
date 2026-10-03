# COSC2446 Web Programming – Assessment 2  
# BookVerse Online Bookstore Platform

## Student Details

| Item | Details |
|---|---|
| Student name | Oliver Heberle |
| Student ID | s4251498 |
| GitHub repository URL | https://github.com/s4251498/wp |
| Deployed website URL | https://titan.csit.rmit.edu.au/~s4251498/wp/a2/index.php |

---

## 1. Purpose of This README

This README documents the BookVerse Assessment 2 dynamic website project.

It provides information about:

- the purpose and structure of the project;
- the technologies used;
- the database and PHP implementation;
- the required dynamic website features;
- the design and layout decisions;
- validation and security practices;
- testing;
- deployment;
- Git development practices;
- AI-assisted development and process evidence.
---

## 2. Copilot and AI Coding Instructions

The following instructions were used when developing the project with AI assistance.

### My Copilot / AI instructions

- Use the technologies and structure required by the COSC2446 Assessment 2 brief.
- Use HTML5, CSS3, Bootstrap 5, JavaScript, PHP and MySQL.
- Use the supplied database structure and do not change the required table or column names.
- Use MySQLi procedural database access and prepared statements.
- Keep database connection code inside `includes/db_connect.inc`.
- Use shared include files for the header, navigation and footer.
- Keep the main PHP pages inside the `a2` directory.
- Use the supplied BookVerse visual design as the basis for the dynamic website.
- Use Bootstrap for responsive layout and components where appropriate.
- Keep custom styling in `assets/css/style.css`.
- Keep JavaScript functionality in `assets/js/scripts.js`.
- Implement the homepage carousel and dynamic book content.
- Implement the books table and status filtering.
- Implement links from books to the individual details page.
- Implement the gallery grid and Bootstrap image modal.
- Implement the Add Book form with appropriate validation.
- Validate uploaded image file extensions on the client side.
- Provide an image preview before submission.
- Validate uploaded files on the server side.
- Generate unique filenames for uploaded images rather than relying on the original filename.
- Use prepared statements for database insertion and retrieval.
- Escape database output using `htmlspecialchars()` where appropriate.
- Validate query-string values before using them in database queries.
- Do not expose raw database errors to normal users on the deployed site.
- Keep uploaded/generated cover images out of Git using `.gitignore`.
- Maintain responsive layouts for desktop and mobile screen sizes.
- Use meaningful labels, alternative text and consistent navigation.
- Do not introduce unnecessary frameworks or technologies outside the assessment requirements.
- AI-assisted code must be reviewed, tested and adapted before submission.
- AI use and debugging activities must be documented in `process-evidence.md`.

---

## 3. Project Overview

BookVerse is a dynamic online bookstore website that allows users to browse a collection of books and view detailed information about individual books.

Assessment 2 extends the static BookVerse website developed for Assessment 1 by connecting the website to a MySQL database and using PHP to generate dynamic content.

Users can browse books, filter books according to their availability status, view individual book details, browse the book cover gallery and add new books through the Add Book form.

The project uses PHP, MySQL, MySQLi procedural prepared statements, JavaScript, Bootstrap, HTML5 and CSS3.

---

## 4. Website Structure

| File | Purpose |
|---|---|
| `index.php` | Homepage containing the navigation, Bootstrap carousel and featured/latest books retrieved from the database. |
| `books.php` | Displays the books stored in the database in a table and provides filtering by book status. |
| `gallery.php` | Displays book covers in a responsive gallery and provides a Bootstrap modal for viewing individual covers. |
| `add.php` | Provides the Add Book form, client-side validation, image preview, image upload handling and database insertion. |
| `details.php` | Displays detailed information about one selected book using its database ID. |
| `process_add.php` | Not used. Add Book processing is handled directly through `add.php`. |

---

## 5. Project Folder Structure

The final Assessment 2 project is structured as follows:

```text
a2/

├── assets/
│   ├── css/
│   │   ├── .gitkeep
│   │   └── style.css
│   ├── js/
│   │   ├── .gitkeep
│   │   └── scripts.js
│   └── images/
│       ├── covers/
│       │   └── .gitkeep
│       └── favicon.svg
│
├── includes/
│   ├── db_connect.inc
│   ├── header.inc
│   ├── nav.inc
│   └── footer.inc
│
├── index.php
├── books.php
├── gallery.php
├── add.php
├── details.php
├── README.md
└── process-evidence.md
---

## 6. Technologies Used

Complete the table below. Explain how each technology was used in your project.

| Technology | How it was used in this project |
|---|---|
| HTML5 | Used to provide the structure and semantic content of the website and forms. |
| CSS3 | Used for custom BookVerse styling, colours, spacing, typography and responsive presentation. |
| Bootstrap 5 | Used for responsive layout and components including the carousel and modal. |
| JavaScript | Used for client-side image validation, image preview, gallery interaction and book status filtering. |
| PHP | Used to generate dynamic pages, process form submissions and communicate with the database. |
| MySQL | Stores the BookVerse book records. |
| MySQLi procedural prepared statements | Used for database queries and insertion while reducing SQL injection risk. |
| Google Fonts | Used for the website typography. |
| Material Icons | Used for interface icons throughout the website. |
| GitHub | Used for source-code version control and development history. |
| Coreteaching server | Used for the final deployed website. |
| Jacob 5 database server | Used for the deployed MySQL database. |
| AI tools | Used as a development aid for understanding requirements, generating and reviewing code, debugging and improving the implementation. All AI-assisted output was reviewed and tested. |

---

## 7. Design and Layout

The Assessment 2 website continues the visual design established in Assessment 1.

The BookVerse design uses a dark navy background with teal/turquoise interface elements and yellow accent elements. The navigation bar provides consistent access to the Home, Browse Books, Gallery and Add Book pages.

The website uses the required fonts and Material Icons to maintain a consistent visual identity.

Bootstrap is used for responsive layout and interface components. Custom CSS in assets/css/style.css provides the BookVerse-specific appearance rather than relying entirely on Bootstrap defaults.

The shared header.inc, nav.inc and footer.inc files ensure that the main pages use a consistent structure and navigation.

The website was tested at both desktop and mobile screen sizes to ensure that content remains usable on smaller screens.

---

## 8. Required Features

Complete the table below by explaining where and how each required feature should be implemented.

| Feature | Page/File | Explanation |
|---|---|---|
| Carousel | `index.php` | Displays featured book content using a Bootstrap carousel. |
| Latest 4 books from database | `index.php` | Retrieves book records from the database and displays the featured/latest books on the homepage. |
| Book table | `books.php` | Displays database book records in a structured table. |
| Status filter | `books.php` | Allows users to filter books according to their availability status. |
| Book detail link | `books.php` / `details.php` | Provides a link from a book record to its individual details page. |
| Details page | `details.php` | Retrieves and displays information about one selected book. |
| Gallery grid | `gallery.php` | Displays book cover images in a responsive grid. |
| Bootstrap image modal | `gallery.php` | Allows users to select a cover and view it in a larger Bootstrap modal. |
| Add Book form | `add.php` | Allows users to enter information for a new book. |
| Record insertion | `add.php` or `process_add.php` | Processes the submitted form and inserts the new book into the database using a prepared statement. |
| Image upload | `add.php` or `process_add.php` | Allows a book cover to be uploaded and associated with the new database record. |

---

## 9. Database Design and Use

The project uses MySQL for storing BookVerse book information.

For local development, the supplied BookVerse database schema is used to create the local database.

For deployment, the database is hosted on the Jacob 5 database server using the required student-specific database.

The project uses the supplied books table and its required fields.

Book records are retrieved from the database and displayed dynamically on the homepage, books page, gallery and details page.

New book records are inserted through the Add Book form.

The details page uses the selected book ID from the query string to retrieve one specific book record.

Database queries use MySQLi procedural prepared statements.

Database tables and important fields
Table	Important fields	Purpose
books	book_id, title, author, genre, publication_year, isbn, description, book_condition, price, image_path, status, created_at	Stores all BookVerse book information used by the dynamic website.
---

## 10. PHP Includes and Reusable Structure

Describe how the include files are used.

| Include file | Purpose |
|---|---|
| `includes/db_connect.inc` | Establishes the MySQL database connection and provides the database connection used by the PHP pages. |
| `includes/header.inc` | Provides common HTML head content, Bootstrap resources, custom CSS, fonts, icons and favicon references. |
| `includes/nav.inc` | Provides the common BookVerse navigation menu. |
| `includes/footer.inc` | Provides the common footer and closing page structure. |
| Other optional include files | No additional optional include files are required. |

These shared files reduce repeated code and ensure that the main pages have consistent navigation, styling and database access.
---

## 11. JavaScript Functionality

Describe the JavaScript features that should be implemented in your website.

| JavaScript feature | Page | How it works |
|---|---|---|
| Image extension validation | `add.php` | Checks the selected cover image before the form is submitted and provides feedback when an unsupported file type is selected. |
| Image preview | `add.php` | Displays a preview of the selected cover image before the form is submitted. |
| Gallery modal | `gallery.php` | Allows users to select a gallery image and view the selected cover in a larger modal interface. |
| Book status filter | `books.php` | Allows the displayed book records to be filtered according to their status. |

---

## 12. Form Handling and Validation

The Add Book form collects the information required to create a new BookVerse record.

Required information includes the book title, author, genre, publication year, price, ISBN, book condition, description, cover image and availability status.

Form labels are associated with their corresponding inputs to improve usability and accessibility.

Appropriate HTML input types are used for different types of information, including text, number, select and file inputs.

Client-side JavaScript validates the selected image extension and provides an image preview before submission.

Server-side processing validates the uploaded file before accepting it.

Uploaded images are given unique filenames rather than relying directly on the original filename.

After validation, the new book information is inserted into the books database table using a MySQLi procedural prepared statement.

The user receives feedback depending on whether the operation succeeds or fails.

---

## 13. Security and Best Practices

The project uses several security and development best practices.

MySQLi procedural prepared statements are used for database queries.
Prepared statements reduce the risk of SQL injection.
Database output is escaped using htmlspecialchars() where appropriate.
Query-string values are validated before being used to retrieve records.
Uploaded image files are validated before being stored.
Uploaded files use generated unique filenames rather than relying on the original filename.
Uploaded cover images are excluded from Git using .gitignore.
Database errors are not intended to be exposed as raw errors to normal users on the deployed website.
The database connection is kept inside includes/db_connect.inc rather than duplicated throughout the application.
The website uses a common include structure to reduce duplicated code.

---

## 14. Accessibility and Usability

The website includes several accessibility and usability considerations.

Pages have meaningful titles.
Semantic HTML elements are used where appropriate.
Form controls have associated labels.
Book cover images use alternative text where appropriate.
Navigation remains consistent across pages.
Text is presented with consideration for readability.
Colours and contrast are used consistently.
The layout responds to smaller screen sizes.
Buttons and links provide clear actions.
Form feedback is provided when validation or submission issues occur.
---

## 15. Testing and Validation

Complete this section after testing your website.

### Rendered HTML Validation

| Page | Result | Notes |
|---|---|---|
| `index.php` | Testedd | Homepage, navigation, carousel and book content checked. |
| `books.php` |Tested | Book table and status filtering checked.|
| `gallery.php` | Tested | Gallery layout and modal behaviour checked. |
| `add.php` | Tested | Form layout, validation and image preview checked. |
| `details.php` |Tested | Individual book information and navigation checked. |

### CSS Validation

| File | Result | Notes |
|---|---|---|
| `assets/css/style.css` | Tested | Custom BookVerse styling and responsive layout checked. |

### Functionality Testing

Feature tested	Result	Notes
Navigation links	Tested	Navigation between the main BookVerse pages checked.
Database connection	Tested locally	PHP pages successfully use the database connection.
Latest books display	Tested	Book records are displayed dynamically.
Books table	Tested	Database records are displayed in the books table.
Book status filter	Tested	Status filtering was checked using different book statuses.
Details page query string	Tested	Individual book records can be opened from the books page.
Gallery modal	Tested	Book cover modal interaction checked.
Add Book form validation	Tested	Required fields and validation behaviour checked.
Image upload	Tested	Book cover upload was tested.
Image preview	Tested	Selected cover image preview was tested.
Deployed site links/assets	TODO	Complete final deployment testing before submission.
Deployed database content	TODO	Complete final deployment testing before submission.

---

## 16. Deployment

Item	Details
Deployed website URL	TODO – complete after deployment
Coreteaching server	TODO – complete after deployment
Jacob 5 database name	TODO – complete after deployment
Deployment folder	TODO – complete after deployment
.htaccess location	TODO – complete after deployment
Upload folder permissions	TODO – complete after deployment

The deployed website will be tested after upload to confirm that all PHP pages, navigation links, CSS, JavaScript, images and database functionality operate correctly on the Coreteaching environment.

The deployed database connection will also be checked to ensure that book records can be retrieved and new records can be inserted successfully.
---

## 17. Git and Development Process

GitHub was used to maintain the project source code and development history.

Development was organised into meaningful stages such as creating the project structure, implementing the database connection, developing the main PHP pages, adding JavaScript functionality, refining the CSS and completing documentation and testing.

Commits are intended to represent meaningful development stages rather than unrelated changes.

The Git history and process-evidence.md provide supporting information about the development process and debugging activities.

---

## 18. AI Use Declaration

AI tools were used meaningfully during this assessment.

 I used AI tools meaningfully during this assessment.
 I recorded meaningful AI use in process-evidence.md.
 I reviewed, tested, and adapted AI-assisted output.
 I can explain all AI-assisted code submitted.

AI tools were used to assist with understanding the assessment requirements, planning the project structure, generating and reviewing code, identifying implementation issues and helping with debugging. AI-generated code was reviewed and adapted to the requirements of the BookVerse project, and the resulting functionality was tested during development.

Detailed AI usage records are maintained in process-evidence.md.

---

## 19. Process Evidence

The process evidence file is included with the project submission.

Requirement	Completed?
process-evidence.md file included	Yes
At least 4 debugging records included	TODO – final review
At least 4 meaningful AI usage records included	TODO – final review
Relevant commit links included	TODO – complete with final Git history

The process evidence documents debugging activities and meaningful AI assistance used during development.

---

## 20. Known Issues or Limitations

Issue or limitation	Explanation
Deployment details	Final Coreteaching and Jacob 5 details must be completed after deployment.
Final validation	Final deployed-site validation must be completed before submission.

