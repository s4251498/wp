# COSC2446 Web Programming — Assessment 3
# BookVerse Online Bookstore Platform

## Student Details

| Item | Details |
|---|---|
| Student name | Oliver Heberle |
| Student ID | Not supplied in the project files |
| GitHub repository | https://github.com/s4251498/wp |
| Published branch | `main` (`c6f329a`) |
| Development branch | `codex/at3-foundation` |
| Deployed website | Not deployed / URL not supplied |

## 1. Project Overview

BookVerse is a database-backed community book listing site. Visitors can browse the newest four listings, search, filter the collection, view book and seller pages, and open covers in a gallery. Registered users can add listings and edit or delete their own books. Assessment 3 extends the earlier BookVerse work with persistent accounts, authentication, protected CRUD, server-side validation, image upload handling, and owner checks, using HTML, CSS, Bootstrap 5, JavaScript, PHP, and MySQL/MariaDB.

## 2. AI Coding Instructions

When extending this project:

- Keep all Assessment 3 work inside `a3/` and follow the supplied `users` and `books` schema and its exact enum values.
- Use PHP, semantic HTML, the existing Bootstrap 5 CDN include, one stylesheet (`assets/css/style.css`), one script (`assets/js/scripts.js`), and the existing shared includes. Do not add a framework or package dependency without an assessment requirement.
- Use procedural MySQLi prepared statements for values in SQL. Escape displayed user/database strings with `bv_escape()`; validate IDs and enums server-side.
- Use `db_connect.inc` and environment variables for non-local database settings; never commit credentials or display raw database errors to visitors.
- Keep passwords untrimmed, hash them with `password_hash()`, verify with `password_verify()`, regenerate the session ID on login, and destroy the session on logout.
- Use session flash messages and CSRF tokens for state-changing forms. Keep add/edit/delete access checks on the server and include the current user ID in edit/delete predicates.
- Validate image extension, MIME type, and size on the server; generate stored filenames; never trust original filenames or a client-side check alone. Preserve an existing cover when edit has no replacement and remove files only when no book references them.
- Keep browsing pages public. Keep listing mutations owner-only. Keep delete POST-only and show a confirmation before submitting.
- Preserve responsive Bootstrap layouts, accessible labels/alt text, keyboard-operable gallery controls, status filtering, search, and seller links.
- Update `assessment-plan.md` and `process-evidence.md` only with checks and work that actually happened. Do not invent deployment details, test results, dates, or personal reflections.

## 3. Website Structure

| File | Purpose |
|---|---|
| `index.php` | Displays a carousel and the four newest books. |
| `books.php` | Lists books and filters by status; links to details and sellers. |
| `gallery.php` | Shows covers and opens the selected cover in a Bootstrap modal. |
| `details.php` | Shows one validated listing; displays edit/delete controls to its owner. |
| `seller.php` | Shows one seller profile and their books. |
| `search.php` | Searches title, author, genre, and ISBN using a prepared statement. |
| `register.php`, `login.php`, `logout.php` | Account registration, authentication, and session logout. |
| `add.php`, `edit.php` | Protected listing creation and owner-only editing. |
| `process_delete.php` | POST-only owner-authorized deletion and cover cleanup. |
| `includes/*.inc` | Database, session/security helpers, catalog helpers, header, navigation, and footer. |
| `assets/css/style.css`, `assets/js/scripts.js` | Shared responsive styles and browser interactions. |
| `assets/images/cover-placeholder.svg` | Fallback displayed when a stored cover is absent or invalid. |

## 4. Project Folder Structure

```text
a3/
├── assets/
│   ├── css/style.css
│   ├── js/scripts.js
│   └── images/
│       ├── favicon.svg
│       ├── cover-placeholder.svg
│       └── covers/.gitignore, .gitkeep
├── includes/
│   ├── book_helpers.inc
│   ├── catalog_helpers.inc
│   ├── db_connect.inc
│   ├── footer.inc
│   ├── functions.inc
│   ├── header.inc
│   └── nav.inc
├── add.php
├── books.php
├── details.php
├── edit.php
├── gallery.php
├── index.php
├── login.php
├── logout.php
├── process_delete.php
├── register.php
├── search.php
├── seller.php
├── assessment-plan.md
├── demo-notes.md
├── process-evidence.md
└── README.md
```

## 5. Technologies

| Technology | Use |
|---|---|
| HTML5/CSS3 | Semantic pages, forms, shared design, and responsive styling. |
| Bootstrap 5 | Responsive grid, navigation, carousel, modal, form controls, and alerts. |
| JavaScript | Status filter, cover preview/extension-size checks, gallery modal updates, and existing UI interactions. |
| PHP 8 | Server-side pages, sessions, validation, uploads, redirects, and page rendering. |
| MySQL/MariaDB | Supplied `users` and `books` schema for persistent accounts and listings. |
| Procedural MySQLi | Prepared statements for registration, authentication, listing changes, details, search, and seller queries. |
| Google Fonts / Material Icons | Shared visual typography and interface icons loaded by `header.inc`. |
| Git/GitHub | Incremental commits on `codex/at3-foundation`; evidence records link work to commits. |
| XAMPP | Local PHP 8.0.30 and isolated MariaDB 10.4.32 checks. |
| Coreteaching / Jacob 5 | Deployment targets required by the assessment; no deployment configuration or access was supplied, so live use is pending. |
| AI tools | ChatGPT/Codex assisted implementation and review; detailed prompts and adaptations are in `process-evidence.md`. |

## 6. Design and Required Features

The interface carries forward the BookVerse palette and typography from the earlier assessment, with a shared header/navigation/footer and Bootstrap responsive layout. Navigation changes for authenticated users and includes Add Book, My Listings, account name, and POST logout controls.

| Feature | Implementation |
|---|---|
| Latest images and four latest books | Homepage carousel and card grid use the newest four database records. Missing covers use the SVG fallback. |
| Collection and status filter | `books.php` renders a semantic table with `data-status`; JavaScript filters Available, Reserved, and Sold rows. |
| Details and seller links | Listing links use validated numeric IDs; details and seller pages query their selected database records. |
| Seller page | Shows username, optional public location/bio, and that seller's listings. |
| Gallery | Responsive cover grid with native buttons and an accessible Bootstrap modal. |
| Search | Prepared search across title, author, genre, and ISBN; input is bounded to 100 characters. |
| Registration/login/logout | Password hashing/verification, generic login errors, regenerated sessions, POST+CSRF logout, and one-time flash messages. |
| Add/edit/delete | Protected CRUD, validation, prepared statements, and server-side owner checks. Delete uses POST, CSRF, and a confirmation modal. |
| Uploads | JPG/JPEG/PNG/GIF/WEBP, 5 MB limit, extension/MIME checks, random filenames, replacement retention/cleanup. |

## 7. Database Design

Local checks used the supplied SQL in a temporary MariaDB 10.4.32 database. The live Jacob 5 database name and credentials are not available, so production connection and deployment remain unverified. `db_connect.inc` uses local defaults only for localhost and environment variables for deployment.

| Table | Important fields | Purpose |
|---|---|---|
| `users` | `user_id`, `username`, `email`, `password`, `phone`, `location`, `bio`, `joined_at` | Account identity and a password hash; optional seller profile fields. |
| `books` | `book_id`, `user_id`, `title`, `author`, `genre`, `publication_year`, `isbn`, `description`, `book_condition`, `price`, `image_path`, `status`, `created_at` | Book listing content, owner relationship, and stored cover filename. |

Book reads use prepared statements where input is supplied and shared catalog helpers for the home/collection. Registration inserts a user; add inserts a book for the current session user; edit/delete queries include both book and owner IDs. Search binds its keyword parameters. Details and seller pages validate positive integer IDs before querying. The collection reads with a left join so a book with a nullable seller ID remains visible.

## 8. Shared PHP Includes

| Include | Purpose |
|---|---|
| `db_connect.inc` | Opens procedural MySQLi, applies `utf8mb4`, validates port configuration, and avoids embedded deployment secrets. |
| `functions.inc` | Session cookie settings, escaping, flash messages, redirect, login/access, and CSRF helpers. |
| `book_helpers.inc` | Positive-ID/input validation, cover path fallback, upload checks, and safe cover cleanup. |
| `catalog_helpers.inc` | Shared catalog queries, status classes, and reusable book cards. |
| `header.inc`, `nav.inc`, `footer.inc` | Shared document head/resources, session-aware navigation, flash rendering, and page footer/scripts. |

## 9. Authentication and Access Control

Registration validates fields, hashes passwords, inserts with a prepared statement, and logs the new user in. Login accepts username or email and verifies the stored hash. Session IDs are regenerated on login; logout is POST-only, checks CSRF, destroys the authenticated session, and starts a fresh anonymous session for its flash message. Add/edit/delete require authentication; edit/delete and the details-page controls are limited to the listing owner. Public browsing pages do not require login.

| Route/action | Access | Check |
|---|---|---|
| `add.php` | Authenticated users | `bv_require_login()` |
| `edit.php` | Owner only | Session login plus `book_id` and `user_id` in fetch/update queries |
| `process_delete.php` | Owner only | POST, CSRF, session login, and owner-scoped select/delete queries |
| Edit/delete controls | Listing owner | Compare session user ID with the book owner ID |
| Browse/search/details/gallery/seller | Public | Validated query inputs and escaped output |

## 10. CRUD, Search, and JavaScript

Create is handled by `add.php`; read-all by `books.php`; read-one by `details.php`; update by `edit.php`; delete by `process_delete.php`. Server-side owner predicates prevent changing the URL or submitted ID to edit another person's record. Status filtering uses the row's `data-status` attribute. Search uses a prepared statement. Seller links use the related `user_id`.

The shared JavaScript validates image extensions and size for user feedback, previews a selected cover, updates the gallery modal, and filters status rows. Server-side checks remain authoritative. The delete confirmation modal submits a CSRF-protected POST form.

## 11. Form Handling and Validation

Registration requires username, valid email, password, and confirmation; phone, location, and bio are optional. Login accepts username or email and password. Book forms require title, author, genre, description, condition, price, and status; publication year and ISBN are optional. Add requires a cover, while edit permits no replacement and retains the current file. Search accepts a keyword of up to 100 characters. Labels are associated with controls, HTML constraints improve feedback, and server-side validation remains authoritative. State-changing forms carry a CSRF token.

## 12. Uploads and Security

Uploads are stored under `assets/images/covers/` with a random 32-character hexadecimal filename and accepted image extension. The original name is used only to read the extension. PHP verifies upload status, size, extension, and MIME type. Editing without a new file retains the current cover. Replaced/deleted files are removed only after checking that no book still references them. Missing or unsafe paths display the placeholder. The directory `.gitignore` keeps generated uploads out of Git while retaining its placeholder file; production write permissions must be set on the hosting server.

Queries use prepared statements, output is escaped, inputs are validated server-side, sessions use HttpOnly/SameSite cookies, state-changing forms use CSRF tokens, and mutation queries check ownership. Detailed database errors go to the server log rather than the visitor. Deployment upload-directory permissions and HTTPS settings still need verification on Coreteaching.

## 13. Accessibility and Usability

Pages use meaningful titles, headings, semantic tables, associated form labels, image alt text, readable status labels, keyboard-operable gallery buttons, visible focus styles, responsive Bootstrap classes, consistent navigation, and session feedback. Browser visual review was done at the available desktop viewport; separate phone/tablet viewport checks and formal HTML/CSS validator runs are still pending.

## 14. Testing and Validation (1 November 2026)

Checks below used an isolated local database and the XAMPP PHP 8.0.30 built-in server; they do not constitute deployment verification.

| Check | Result | Notes |
|---|---|---|
| PHP syntax | Pass | All 19 current `.php`/`.inc` files passed `php -l`. |
| JavaScript syntax | Pass | `node --check a3/assets/js/scripts.js`. |
| Whitespace | Pass | `git diff --check`. |
| Public pages | Pass | Home, books, gallery, valid details, valid seller, and matching search returned HTTP 200. |
| Invalid page IDs | Pass | Invalid/missing book ID and unknown seller returned HTTP 404 after the fix. |
| Anonymous access | Pass | Anonymous add/edit requests redirected with HTTP 303. |
| Status filter | Pass | Browser selection of Sold left only Sold rows visible. |
| Search | Pass | Browser search for “Dune” displayed the matching book. |
| Gallery modal | Pass | Browser activation displayed the selected cover/title in the modal. |
| Owner controls | Pass | A disposable local account showed its edit/delete controls and delete modal; no destructive delete was submitted. Account and temporary owner change were removed/restored afterward. |
| Missing cover fallback | Pass | Desktop browser initially showed a broken image for seeded `1.png`; after the fix it displayed the SVG placeholder. |
| Nullable seller handling | Pass | Temporarily setting a test listing owner to NULL left the book visible with an unavailable-seller label; the database row was restored. |
| Local assets | Pass | CSS, JavaScript, favicon, and cover placeholder paths existed and loaded locally. |
| Full CRUD/auth/upload suite | Pass in earlier isolated run | Registration, hash/login/logout, add/edit/delete, upload replacement/cleanup, invalid upload, owner checks, CSRF, and method checks were exercised on Day 2. |
| Responsive phone/tablet widths | Pending | The current browser session did not expose a viewport override. Responsive CSS is present but needs manual device-width review. |
| HTML/CSS standards validators | Pending | Not run. |
| Browser console audit | Pending | Not completed. |
| Live deployment | Pending | No deployment URL/access/configuration was provided. |

## 15. Deployment

| Item | Details |
|---|---|
| Website URL | Not deployed / not supplied |
| Jacob 5 database name | Not supplied |
| Deployment folder | Not supplied |
| `.htaccess` | No custom AT3 file currently present |
| Upload permissions | Must be checked on the deployment host |

Live authentication, database, paths, sessions, and upload permissions must be checked after the actual hosting details are available. Configure `BOOKVERSE_DB_HOST`, `BOOKVERSE_DB_USER`, `BOOKVERSE_DB_PASS`, `BOOKVERSE_DB_NAME`, and optionally `BOOKVERSE_DB_PORT` in the hosting environment. No production credentials are stored in this project.

## 16. Git and Development Process

Work is organized into four planned stages, with dated implementation days on 18 October, 21 October, 28 October, and 1 November 2026. Commits show the foundation, protected CRUD/authentication, browsing features, and integration fixes/docs as separate increments. `process-evidence.md` links AI tasks and debugging records to their implementation commits. Recalculate the final date/commit distribution before submission; commit count is only a rough proxy for effort.

## 17. AI Use and Process Evidence

AI helped inspect requirements, build and review shared PHP/auth/CRUD/browsing code, and identify integration issues. The process log contains six AI task records and seven debugging records with verification limits recorded. The student must personally review this code, complete the final reflection, and ensure they can explain each part before attesting to the assessment declaration.

`demo-notes.md` contains a rehearsal walkthrough for the later individual demonstration. The 25-mark demonstration has not yet occurred and is not represented as completed work.

## 18. Known Limitations

- The project has not been deployed; Coreteaching/Jacob 5 credentials, database name, URL, path, and permissions are not available.
- The supplied ZIP has no cover images. Existing database filenames that are missing locally use the placeholder; suitable real covers can be added through the upload form.
- Exact comparison with the assessment screenshots, mobile/tablet browser checks, formal HTML/CSS validation, and a browser console audit remain outstanding.
- The student ID, personal reflection, and live demonstration must be completed by the student.
