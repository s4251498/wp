# COSC2446 Web Programming — Assessment 3

## BookVerse Online Bookstore Platform

## Student and deployment details

| Item | Details |
|---|---|
| Student | Oliver Heberle |
| Student ID | S4251498 |
| GitHub repository | [s4251498/wp](https://github.com/s4251498/wp) |
| Submission branch | `main` |
| Live site | [BookVerse on Saturn](https://saturn.csit.rmit.edu.au/~s4251498/wp/a3/) |
| Coreteaching host and directory | `saturn.csit.rmit.edu.au`, `~/public_html/wp/a3` |
| Jacob 5 database | `S4251498_159009` (connection verified from the live application) |

## Project overview

BookVerse is a PHP and MySQLi book-listing application. Visitors can browse recent books, search, filter the collection, view seller listings, and open cover images in a gallery modal. Registered users can add listings and edit or delete their own listings. The application uses the supplied `users` and `books` schema and runs locally or on RMIT Coreteaching.

## Features

- Responsive Bootstrap 5 layout, shared header, navigation, footer, CSS, and JavaScript.
- Homepage carousel and grid of the four newest books.
- Collection table with JavaScript status filtering (`Available`, `Reserved`, `Sold`).
- Search across title, author, and description.
- Book details, seller listings, and accessible gallery modal.
- Registration with password hashing, login, logout, session regeneration, and flash feedback.
- Authenticated book creation, editing, and owner-only deletion with confirmation.
- Image preview and upload validation; random stored filenames; cover replacement and cleanup.
- Prepared MySQLi statements, server-side validation, output escaping, CSRF protection, and server-side ownership checks.

## Project structure

```text
a3/
├── index.php, books.php, gallery.php, details.php, seller.php, search.php
├── register.php, login.php, logout.php
├── add.php, edit.php, process_delete.php
├── bookverse.sql
├── includes/
│   ├── db_connect.inc
│   ├── functions.inc
│   ├── book_helpers.inc
│   ├── catalog_helpers.inc
│   └── header.inc, nav.inc, footer.inc
├── assets/
│   ├── css/style.css
│   ├── js/scripts.js
│   └── images/ (favicon, placeholder, and supplied book covers)
├── deployment/public_html/.htaccess  # official Canvas template, personalized for deployment
├── assessment-plan.md
├── demo-notes.md
├── process-evidence.md
└── README.md
```

## Technologies and coding choices

- PHP with procedural MySQLi, MySQL, semantic HTML5, Bootstrap 5, CSS, and JavaScript.
- Shared includes provide consistent page structure, session handling, flash messages, and database access.
- SQL values use prepared statements. Displayed data is escaped with `bv_escape()`/`htmlspecialchars()`.
- Passwords are stored with `password_hash()` and checked with `password_verify()`; sessions regenerate on login and are destroyed on logout.
- State-changing forms use POST and CSRF tokens. Edit and delete operations verify the current user owns the listing in server-side queries.
- Uploads are limited by permitted extensions, detected MIME type, and size. PHP generates random filenames and keeps the existing image when an edit has no replacement.
- The database connection uses local defaults only for localhost. Production configuration is stored outside the public web directory; no production password is included in this project.

## Database setup

`bookverse.sql` is the supplied schema and sample data. It creates the `bookverse` database and drops/recreates the two tables, so use it only for a fresh disposable local database. Do not run it against the production Jacob 5 database; that would delete its tables and data. The live Jacob 5 connection has already been provisioned and verified.

For local development, import the supplied SQL into a disposable MariaDB/MySQL instance and run the application through XAMPP or another PHP server. Local connection values can be set with `BOOKVERSE_DB_HOST`, `BOOKVERSE_DB_USER`, `BOOKVERSE_DB_PASS`, `BOOKVERSE_DB_NAME`, and `BOOKVERSE_DB_PORT`. On Saturn, `includes/db_connect.inc` reads the account-specific PHP config at `~/bookverse-db-config.php`, outside `public_html`; a named ACL gives the Apache service account read access while other users have no access. Credentials are intentionally omitted here.

## Local run

1. Install PHP with MySQLi and a local MySQL/MariaDB server (the checks recorded here used XAMPP PHP 8.0.30 and MariaDB 10.4.32).
2. Create a new disposable local database and import `bookverse.sql`.
3. Place this `a3` directory under the local web root, such as XAMPP `htdocs`.
4. Start Apache and MySQL, then open `http://localhost/a3/` (adjust the path if the folder name differs).
5. Register a local test account before testing protected listing actions.

## Testing and verification

| Check | Result |
|---|---|
| PHP syntax | Pass: XAMPP PHP 8.0.30 linted all 19 PHP/include files. |
| JavaScript syntax | Pass: `node --check a3/assets/js/scripts.js`. |
| Whitespace | Pass: `git diff --check`. |
| Local database and routes | Pass for the documented isolated MariaDB sandbox: valid public routes and assets returned 200; invalid book/seller IDs returned 404; anonymous protected routes redirected to login. |
| Local interactions | Pass for exercised registration, hashing/login/logout, CRUD, uploads, ownership checks, CSRF/method checks, search, status filters, gallery modal, and missing-cover fallback. On 1 November, a disposable account also failed to edit or delete another user's sample listing in the isolated verification database; the listing remained and the test account was removed. |
| HTML validation | Pass: ten rendered states passed the W3C HTML checker with zero errors or warnings. |
| CSS validation | Inconclusive: the W3C service returned `Reader used` for POST and HTTP 520 for GET. No CSS pass is claimed. |
| Live Saturn/Jacob 5 | Pass for connection and the exercised site routes, registration/login/logout, create/edit/delete, cover upload, search, Sold filter, and anonymous edit-route protection. Listing 13 was deleted after the test and My Listings showed zero books. |
| Live cross-owner access | Not verified with two separate live accounts. Local tests covered cross-owner edit/delete rejection. |
| Phone/tablet viewport and browser console | Pending; the MyDesktop browser session did not provide a usable device viewport or DevTools console. |

Live pages and feature flows were checked in MyDesktop Chrome because the Saturn URL timed out from the external browser. This is a network-path limitation; the deployed app loaded and its database operations worked in MyDesktop. The test account `bvtest20261101` remains in Jacob 5; its temporary listing and uploaded cover were removed. No test password is included in the project.

## Deployment

The live URL is `https://saturn.csit.rmit.edu.au/~s4251498/wp/a3/`. The target is Saturn at `~/public_html/wp/a3`; the account-specific database config is kept at `~/bookverse-db-config.php`, outside the public web directory. The production PHP runtime was 7.4.33 with MySQLi. A protected diagnostic confirmed the config was readable by Apache and the Jacob 5 database connection succeeded; the temporary diagnostic endpoint was removed from Git and the server after verification.

The live application loaded its pages and assets and passed the operations listed above. Live cross-owner manipulation, mobile/tablet viewports, and a console audit remain unverified. The official Canvas `Adding .htaccess` guide and `htaccess` template were reviewed. The template is included at `deployment/public_html/.htaccess`, with the placeholder replaced by the RMIT login `s4251498@RMIT.INTERNAL`; its supplied staff-access rule is unchanged. The guide requires the file to be placed at `~/public_html/.htaccess`, not in `a3/`. This prepared file has not yet been installed or retested on Saturn.

## Git process

AT3 is on the repository `main` branch. At this report update, the repository has 81 commits; 38 commits touch `a3/`. Those commits span six actual dates in the repository history:

| Date | AT3 commits |
|---|---:|
| 27 May 2026 | 1 |
| 14 July 2026 | 1 |
| 18 October 2026 | 6 |
| 21 October 2026 | 5 |
| 28 October 2026 | 2 |
| 1 November 2026 | 23 |

For AT3-only commits, the largest date is `23 / 38 × 100 = 60.5%`, above the rubric's 50% target. Across the complete repository history, it is `23 / 81 × 100 = 28.4%`; assessment interpretation depends on whether the marker counts only AT3 commits or all project history. No dates were fabricated or rewritten. The Git history and process records should be reviewed with this limitation in mind.

## AI use and process evidence

AI assistance was used for planning, implementation review, debugging, testing, documentation, and deployment troubleshooting. Actual prompts, decisions, verification notes, and limitations are recorded in `process-evidence.md`. The student remains responsible for reviewing and understanding all submitted work. The reflection in the process evidence is a draft and must be reviewed and personalized before submission.

## Known limitations and final checklist

- The live cross-owner URL-manipulation check has not been run with two live accounts; local cross-owner authorization tests passed.
- Phone/tablet layout, live console errors, CSS validation, and exact comparison with all supplied screenshots remain unverified or inconclusive.
- The account `bvtest20261101` remains on Jacob 5, but its test listing and uploaded cover have been removed.
- The README/process reflection needs the student's personal review and personalization. The one-on-one demonstration has not taken place; see `demo-notes.md`.
- Install `deployment/public_html/.htaccess` as `~/public_html/.htaccess` following the Canvas guide, then test the live site in MyDesktop and verify the authorized RMIT login and staff access still work.
