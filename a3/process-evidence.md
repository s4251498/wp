# Process Evidence Log

This file combines:
1. Debugging records
2. AI (e.g., Copilot/ChatGPT) usage logs

You must maintain this file throughout development.

---

## General Instructions
- Record entries as you work (not at the end)
- Be honest and specific
- Link to commits. Each debugging record must include at least one related GitHub commit
(using commit hash and URL).
- Superficial or fabricated entries will not receive marks

---

# 🔧 Section 1: Debugging Records

## Bug 1

**Date Identified:**
21/10/2026

**Date Fixed:**
21/10/2026

**File:**
`includes/functions.inc`, `register.php`, `login.php`

**Related Commit:**
`29458c7` — https://github.com/s4251498/wp/commit/29458c7

**Symptom:**
A generic POST-string helper trimmed password values, so leading and trailing spaces were silently removed before hashing and verification.

**Steps to Reproduce:**
Register with a password that intentionally begins or ends with a space, then inspect the registration and login code paths. The same generic helper changed the submitted secret on both paths.

**Root Cause:**
The helper treated passwords like ordinary text fields and normalized them with `trim()`.

**Fix:**
Added an optional trim flag to `bv_post_string()` and read password/confirmation fields without trimming.

**Verification:**
Registered an account with a leading/trailing-space password against the isolated test database; login with the exact password succeeded and the trimmed variant failed. Confirmed the stored value is a 60-character password hash, not plaintext.

---

## Bug 2

**Date Identified:**
21/10/2026

**Date Fixed:**
21/10/2026

**File:**
`edit.php`

**Related Commit:**
`f2bc85a` — https://github.com/s4251498/wp/commit/f2bc85a

**Symptom:**
The initial edit-handler error boundary could report that saving failed when the database update had already succeeded but cleanup of the replaced image then failed.

**Steps to Reproduce:**
Submit a valid edit with a new cover and make removal of the old cover fail after the update. The earlier control flow would enter the general save-error handler after the record was already updated.

**Root Cause:**
Database persistence and post-update file cleanup were handled inside the same `try`/`catch` block.

**Fix:**
Track whether the update succeeded and handle old-cover cleanup afterward, reporting cleanup failure as a warning while preserving the successful update result.

**Verification:**
Reviewed the two control-flow paths: update errors remain form errors; cleanup errors after a successful update are logged and produce a warning flash. Runtime database/filesystem fault injection remains pending.

---

## Bug 3

**Date Identified:**
21/10/2026

**Date Fixed:**
21/10/2026

**File:**
`assets/css/style.css`

**Related Commit:**
`52197db` — https://github.com/s4251498/wp/commit/52197db

**Symptom:**
The authentication form sits on a white panel, while the shared page heading rules used a light teal heading and white lead text, making the heading low-contrast and the lead text unreadable on that panel.

**Steps to Reproduce:**
Inspect the shared `.page-header` rules together with the white `.form-card` background on `register.php` and `login.php`.

**Root Cause:**
The shared dark-background page heading colors were inherited inside a light form card without a local color override.

**Fix:**
Added form-card heading and lead color overrides using the existing dark-teal and text-gray palette.

**Verification:**
Reviewed the CSS cascade and calculated contrast on white: `#0f766e` is 5.47:1 and `#6b7280` is 4.83:1. Browser rendering review remains pending.

---

## Bug 4

**Date Identified:**
28/10/2026

**Date Fixed:**
28/10/2026

**File:**
`gallery.php`, `assets/js/scripts.js`

**Related Commit:**
`dbc877d` — https://github.com/s4251498/wp/commit/dbc877d

**Symptom:**
The gallery's accessible button held the modal's image/title data, but the JavaScript selected the nested image element and read data attributes from the wrong element.

**Steps to Reproduce:**
Open the gallery and activate a cover. The modal handler would run on the image, whose `data-image` and `data-title` attributes were absent.

**Root Cause:**
The gallery markup was changed from a directly activated image to a native button without updating the JavaScript selector to match the new trigger.

**Fix:**
Updated the script to bind to `.gallery-image-button`, where the modal data is stored. Native button keyboard activation now supplies keyboard access without a duplicate custom key handler.

**Verification:**
Compared the trigger selector and data attributes, then opened a gallery cover in the local browser and confirmed the modal title and image alt text updated to the selected book.

---

## Bug 5

**Date Identified:**
01/11/2026

**Date Fixed:**
01/11/2026

**File:**
`includes/book_helpers.inc`

**Related Commit:**
`b869224` — https://github.com/s4251498/wp/commit/b869224

**Symptom:**
Existing database rows referenced cover filenames such as `1.png` that were not included in the supplied project assets, so the browser displayed broken-image icons.

**Steps to Reproduce:**
Open a seeded listing detail page or homepage while its stored cover file is absent from `assets/images/covers/`.

**Root Cause:**
The cover helper validated the filename but assumed that a file with that name existed on disk.

**Fix:**
Require a regular, non-symlink file to exist before returning its URL; otherwise return `cover-placeholder.svg`.

**Verification:**
Observed the broken cover in the browser before the change, reloaded after the change, and confirmed the placeholder rendered. Confirmed the placeholder asset returned HTTP 200.

---

## Bug 6

**Date Identified:**
01/11/2026

**Date Fixed:**
01/11/2026

**File:**
`details.php`, `seller.php`, `index.php`, `books.php`, `gallery.php`, `search.php`

**Related Commit:**
`b869224` — https://github.com/s4251498/wp/commit/b869224

**Symptom:**
Invalid or missing detail/seller identifiers displayed a not-found message but returned HTTP 200, which misreported the result to browsers and clients.

**Steps to Reproduce:**
Request `details.php?id=abc`, a non-existent book ID, or an unknown seller ID and inspect the response status.

**Root Cause:**
The pages rendered an error message without setting an appropriate HTTP response status.

**Fix:**
Return HTTP 404 for invalid/missing book and seller records, and HTTP 503 when a page's database read fails.

**Verification:**
Local HTTP checks returned 404 for invalid/missing book IDs and unknown sellers; public valid pages continued returning 200. Database-outage 503 behavior was reviewed in code but not fault-injected.

---

## Bug 7

**Date Identified:**
01/11/2026

**Date Fixed:**
01/11/2026

**File:**
`includes/catalog_helpers.inc`, `books.php`, `details.php`, `search.php`

**Related Commit:**
`b869224` — https://github.com/s4251498/wp/commit/b869224

**Symptom:**
An inner join to `users` would hide a `books` row whose nullable `user_id` has no matching seller.

**Steps to Reproduce:**
Temporarily set a test book's `user_id` to NULL and request the collection and that book's detail page.

**Root Cause:**
The book query required every listing to match a user, although the supplied schema permits a null owner.

**Fix:**
Use a left join for public book reads and show an unavailable-seller label when no seller record exists.

**Verification:**
Temporarily set a local test row's owner to NULL; it remained visible on the collection and details page showed the fallback label. Restored the original owner immediately afterward.

---

# 🤖 Section 2: AI Usage Log

## AI Task 1

**Date:**
18/10/2026

**Task Description:**
Inspect the supplied AT3 assessment materials and the existing `wp` repository, then prepare a rubric traceability matrix and a four-stage work plan before implementation.

**Tool Used:**
ChatGPT / Codex

**Prompt / Input:**
I supplied the AT3 project brief and asked Codex to inspect the starter materials before changes. I then identified `https://github.com/s4251498/wp` as the actual repository, explained that AT1 and AT2 live in their respective directories, clarified that the remaining 25 marks are for the later demonstration, and asked for four stages over four days with no more than half the total work on one day.

**AI Output Summary:**
Codex inspected the assessment DOCX and SQL, cloned and inspected the repository, found that AT3 currently has only its documentation templates and asset placeholders, calculated the existing repository commit-date distribution, and wrote `a3/assessment-plan.md` with a requirement matrix, test plan, risks, and four approximately equal work stages.

**What You Accepted:**
Use the existing repository and keep all AT3 work in `a3/`; treat the official DOCX and SQL as requirements sources; keep untested work marked pending; divide future effort across four actual workdays; preserve authentic dates and commits.

**What You Changed:**
No application code was generated in this planning session. The plan records the baseline and distinguishes project/process criteria (120 marks) from the later demonstration (25 marks). It also flags the exposed AT2 database credential without copying it into AT3.

**Validation Performed:**
Compared the repository tree and commit log with the checked-out repository, read the official assessment DOCX and `bookverse.sql`, checked the new plan for whitespace errors, and confirmed that all implementation/test statuses remain pending. This validates the planning artifact only; no application behavior has been tested.

**Issues Identified:**
The supplied HTML grading report has conflicting naming and scoring descriptions and is not a trustworthy implementation/test record. The repository's existing AT2 database connection contains a committed live credential; the account owner should rotate it. No credential value is reproduced here.

**Related Commit:**
`846baaa` — https://github.com/s4251498/wp/commit/846baaa

---

## AI Task 2

**Date:**
18/10/2026

**Task Description:**
Create the initial AT3 shared PHP infrastructure and carry forward the established design and JavaScript patterns without copying the AT2 database credential.

**Tool Used:**
ChatGPT / Codex

**Prompt / Input:**
The assessment brief requires MySQLi, secure sessions and flash messages, reusable header/navigation/footer includes, a single CSS and JavaScript file, prepared statements for later queries, and protection of production credentials. The user asked to start work in the existing `a3/` directory and keep the four-day work plan balanced.

**AI Output Summary:**
Codex added environment-based database configuration, reusable session/escaping/flash/CSRF/access helpers, shared page includes, an AT2-derived stylesheet and JavaScript foundation, and a four-stage project plan. It kept the Jacob 5 credential out of the new files.

**What You Accepted:**
Keep the required procedural MySQLi connection; default local settings only on localhost; require server environment variables for non-local database credentials; escape shared output; use session-backed flash messages; make the logout control a CSRF-token POST form; reuse the existing BookVerse visual foundation.

**What You Changed:**
The helper initially used PHP's `never` return type. After reviewing the AT2 history's older-server compatibility fix, it was removed to avoid requiring PHP 8.1. The live database settings remain environment variables because no deployment credentials were provided.

**Validation Performed:**
`node --check a3/assets/js/scripts.js` passed and the connection file reads environment configuration without an embedded password. At the time, PHP was not found on PATH; later that day I located the XAMPP PHP 8.0.30 runtime and ran the checks recorded below.

**Issues Identified:**
PHP was initially not found on PATH, but the XAMPP runtime was later located. The copied JavaScript features still need browser testing when their pages are implemented. No live deployment credential or local database setup was invented.

**Related Commit:**
`e2dc298` — https://github.com/s4251498/wp/commit/e2dc298

---

## AI Task 3

**Date:**
21/10/2026

**Task Description:**
Implement registration, login, logout, session handling, and session-backed feedback for AT3.

**Tool Used:**
ChatGPT / Codex

**Prompt / Input:**
The user asked Codex to continue with Day 2 of the agreed project plan. The AT3 brief requires password hashing and verification, immediate login after registration, session cleanup, flash messages, protected requests, and prepared MySQLi statements.

**AI Output Summary:**
Codex added the registration, login, and logout routes plus helpers for POST values and authenticated session setup. Registration stores a `password_hash()` value and logs in the new user; login checks username or email with a prepared statement and `password_verify()`; logout is POST-only and checks a CSRF token.

**What You Accepted:**
Use generic login failures, regenerate the session ID after login, destroy the authenticated session on logout, require CSRF tokens on state-changing forms, and use a prepared insert for registration.

**What You Changed:**
During review, password values were changed to bypass the text helper's normal trimming behavior. The form uses native HTML validation, while server-side checks remain authoritative.

**Validation Performed:**
Reviewed SQL fields and security control flow. Using PHP 8.0.30 and an isolated MariaDB 10.4.32 loaded from the supplied SQL, verified registration/auto-login, duplicate and invalid-password rejection, login/logout, session invalidation, password hashing, and one-time flash lifecycle over HTTP.

**Issues Identified:**
The local HTTP checks do not replace browser/device, production database, or deployment testing; those remain for later stages.

**Related Commit:**
`29458c7` — https://github.com/s4251498/wp/commit/29458c7; logout session cleanup refinement: `3cd5fb8` — https://github.com/s4251498/wp/commit/3cd5fb8

---

## AI Task 4

**Date:**
21/10/2026

**Task Description:**
Implement protected book creation, owner-only editing/deletion, input validation, and safe cover upload/cleanup handling.

**Tool Used:**
ChatGPT / Codex

**Prompt / Input:**
Continue the Day 2 scope from the AT3 brief: use the provided `books` schema, keep add protected by login, enforce ownership on edit/delete, use prepared statements, validate uploads, generate unique filenames, retain the old cover when no replacement is selected, and avoid destructive GET requests.

**AI Output Summary:**
Codex added shared book-validation/upload helpers, `add.php`, `edit.php`, a POST-only `process_delete.php`, and a placeholder cover. The handlers validate schema enum values, use prepared statements, check owner IDs in both fetch and mutation queries, use CSRF tokens, validate image extension/MIME/size, generate random filenames, and clean up unreferenced image files.

**What You Accepted:**
Keep the supplied `Available`/`Reserved`/`Sold` statuses and `New`/`Gently Used`/`Fair` conditions; use generated upload names; keep the existing image when editing without an upload; perform delete through POST; and avoid removing an image still referenced by another book.

**What You Changed:**
The edit flow was adjusted so a post-update image cleanup error cannot be reported as if the database update failed. Cover display and deletion also reject path-like filenames. Price validation was tightened to match the supplied `DECIMAL(8,2)` schema.

**Validation Performed:**
Compared handler field names and bind parameter arity with the supplied SQL; all referenced columns were present and all bind counts matched. PHP 8.0.30 lint passed for all current PHP/INC files. HTTP checks against the isolated database verified add/edit/delete, upload replacement and cleanup, owner rejection, invalid extension/MIME rejection, bad-CSRF rejection, and GET-delete 405.

**Issues Identified:**
The XAMPP runtime and temporary database were available for isolated tests. Public browsing pages such as `details.php` and `books.php` are still scheduled for Day 3, so successful CRUD handlers redirect to routes not yet implemented.

**Related Commit:**
`f2bc85a` — https://github.com/s4251498/wp/commit/f2bc85a

---

## AI Task 5

**Date:**
28/10/2026

**Task Description:**
Implement the public BookVerse browsing experience scheduled for Day 3.

**Tool Used:**
ChatGPT / Codex

**Prompt / Input:**
The user asked to continue Day 3 of the agreed four-day AT3 plan. The planned scope is the home, books, details, gallery, seller, and search pages, with the status filter, image modal, owner controls, responsive layout, and database-backed content.

**AI Output Summary:**
Added six public pages and a catalog helper for prepared database reads, safe cover paths, status classes, and reusable book cards. The homepage queries only the four latest listings; details and seller queries validate IDs; search uses a prepared statement; owner-only edit/delete controls are shown on details; gallery and status-filter markup use the existing shared JavaScript.

**What You Accepted:**
Keep all project work within `a3/`, continue using the supplied schema and shared includes, use procedural MySQLi, and leave integration/browser checks for Day 4 rather than claiming unrun tests.

**What You Changed:**
Adjusted the gallery JavaScript trigger to use the data-bearing native button, bounded the search query length, and added responsive/keyboard focus styling for the gallery and empty homepage state.

**Validation Performed:**
Reviewed page queries against the schema fields and inspected the gallery markup/script selector relationship. No PHP lint, browser, database, device-width, or rendered HTML checks have yet been run for this Day 3 implementation; those remain for Day 4.

**Issues Identified:**
The public pages depend on the local/deployment database being configured. Screenshots, browser behavior, responsive widths, and invalid/missing-ID response behavior still need integration review.

**Related Commit:**
`dbc877d` — https://github.com/s4251498/wp/commit/dbc877d

---

## AI Task 6

**Date:**
01/11/2026

**Task Description:**
Integrate the six browsing pages, correct issues found during local checks, complete rubric/process documentation, and prepare a demonstration walkthrough.

**Tool Used:**
ChatGPT / Codex

**Prompt / Input:**
The user asked Codex to complete Day 4 of the four-day plan. The plan calls for integration checks, bug fixes, README/process-evidence completion, deployment-state reporting, and demonstration preparation.

**AI Output Summary:**
Linted current PHP files, checked JavaScript syntax, exercised all public routes against the isolated supplied schema, and used a local browser to check status filtering, keyword search, gallery modal behavior, login navigation, and owner controls. Integration review found missing cover files, incorrect error response codes, and the nullable owner join case; the code was updated and rechecked. The README and demo rehearsal outline were completed with unavailable deployment/student information clearly identified.

**What You Accepted:**
Keep deployment and personal/student-only details marked unavailable when they were not provided; document the actual local checks and leave unrun device-width/standards/deployment checks pending.

**What You Changed:**
The missing-cover fallback now checks disk before returning a cover URL, invalid book/seller IDs return 404, database read errors return 503, and public catalog reads preserve nullable-owner books with an unavailable-seller label. Added short comments at security and cleanup boundaries to explain the reason for the checks without narrating obvious code.

**Validation Performed:**
All current PHP/INC files passed PHP 8.0.30 lint; `node --check` and `git diff --check` passed. Local HTTP checks returned 200 for valid public routes, 404 for invalid/missing details and seller IDs, and 303 for anonymous add/edit requests. Browser checks confirmed one visible Sold row after filtering, a Dune search result, the selected gallery image/title in the modal, owner-only controls and delete-confirmation modal, login/logout navigation, and placeholder display for absent cover files. A temporary test account was removed and the book owner value restored. Formal HTML/CSS validation, phone/tablet viewport checks, console audit, and live deployment checks remain pending.

**Issues Identified:**
No deployment credentials, database name, deployment folder, or live URL are available. The student must supply their ID, complete their own reflection, personally review/explain the code, verify the deployed site, and rehearse the individual demonstration.

**Related Commit:**
`b869224` — https://github.com/s4251498/wp/commit/b869224; `2d09a21` — https://github.com/s4251498/wp/commit/2d09a21.

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**

**Where AI was incorrect or misleading:**

**What you learned about debugging:**

**How your approach changed over time:**
