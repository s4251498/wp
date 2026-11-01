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

## AI Task 7

**Date:**
01/11/2026

**Task Description:**
Move the completed AT3 work onto the repository's default branch, review deployment and final-check status, and prepare a reflection draft from the recorded project evidence.

**Tool Used:**
ChatGPT / Codex

**Prompt / Input:**
The user asked why AT3 was not on `main`, directed Codex to fix that immediately, and requested live deployment, the remaining checks, and a reflection. The user also emphasized retaining four real work dates in Git history.

**AI Output Summary:**
Codex verified that `origin/main` was an ancestor of the completed `codex/at3-foundation` branch, fast-forwarded local `main` to the AT3 branch, pushed `main`, fetched from GitHub, and confirmed the remote and local `main` resolve to `c6f329a`. It checked the project files and environment for Coreteaching/Jacob 5 deployment details; no live URL, deployment path, or credentials were available. A W3C CSS validator request returned HTTP 500, so formal validation was not claimed. Codex prepared a reflection draft grounded in recorded work and marked it for the student's review.

**What You Accepted:**
Keep the authentic four-date commit history, publish the finished implementation on `main`, report unavailable deployment access honestly, and treat the reflection as a draft requiring personal review.

**What You Changed:**
The assessment plan now records `main` as the published branch, the exact commit-date count and distribution, and remaining deployment/validation limitations. The final reflection section now has an evidence-based draft. These changes do not add fabricated work dates or test results.

**Validation Performed:**
`git fetch origin` confirmed `main` and `origin/main` both resolve to `c6f329a` after the push; the working tree was clean at that checkpoint. The history contains four real AT3 work dates. Deployment was not possible without the required hosting access. The CSS validator returned HTTP 500 and is recorded as inconclusive, not a pass.

**Issues Identified:**
The live site, small-screen browser viewports, browser console, formal HTML/CSS validation, and exact screenshot comparison still require access or a usable validator/browser setup. The student must review and personalize the reflection before submission and complete the individual demonstration.

**Related Commit:**
`f6c502e` — https://github.com/s4251498/wp/commit/f6c502e (published branch update and reflection draft). The brief follow-up evidence-link edit records this hash.

---

## AI Task 8

**Date:**
01/11/2026

**Task Description:**
Continue the live Coreteaching deployment attempt using the official current-access instructions, verify the correct server, and run available local checks while deployment is in progress.

**Tool Used:**
ChatGPT / Codex

**Prompt / Input:**
The user asked to continue deployment without stopping at the first error, check course announcements for the worldwide PHP server issue, verify the correct connection details, and keep progressing through remaining assessment checks if a genuine access blocker remained.

**AI Output Summary:**
The Canvas announcement dated 26 October states that developer access from outside RMIT was disabled while a worldwide PHP vulnerability was being resolved; students must connect through RMIT MyDesktop using PuTTY or Tera Term. The official downloaded Coreteaching handout identifies Saturn as `saturn.csit.rmit.edu.au` and confirms the student-number login. The earlier error screenshot showed a mistyped hostname. After correcting the field, PuTTY connected to Saturn's internal host and reached its password prompt. The SSH host key was offered only for a one-time connection. The PuTTY window is currently awaiting the user-entered RMIT password; no password has been submitted by Codex and no remote deployment changes have been made.

**What You Accepted:**
Follow the official MyDesktop route, use the verified Saturn host and Jacob 5 instructions, do not publish or expose credentials, and do not report deployment as successful until live verification is complete.

**What You Changed:**
The W3C HTML checker found invalid gallery modal semantics and empty image `src` values, plus missing placeholder options in required selects on Add/Edit. Added the gallery dialog role, provided valid placeholder image URLs, added empty-value select placeholders, and stopped JavaScript from clearing preview image sources to empty strings. Updated the README deployment/testing status and this evidence log. No production database was changed.

**Validation Performed:**
All 12 `.php` files and 7 `.inc` files passed XAMPP PHP 8.0.30 syntax lint; `node --check a3/assets/js/scripts.js` passed. The existing local `bookverse` database was left intact after inspection found no `users` table; a new isolated `bookverse_at3_verify_20261101` database was created from the supplied SQL after removing `CREATE DATABASE`, `USE`, and `DROP TABLE` statements. It contains 3 sample users and 12 sample books. On that sandbox, public routes returned HTTP 200, invalid IDs returned 404, static assets returned 200, and search, status filters, gallery modal, sample login/logout, owner-only controls, logged-out access, and GET-delete rejection worked in the local browser. Ten rendered states (home, books, gallery, details, seller, search, login, register, authenticated add, and authenticated edit) passed the W3C HTML checker with zero errors or warnings. Gallery modal behavior still worked after the markup change. The CSS validator returned `Reader used` for POST and HTTP 520 for GET, so CSS validation remains inconclusive. PuTTY visibly connected to Saturn and reached a password prompt; the remote session then closed before authentication completed. These checks do not establish authenticated server access or deployment.

**Issues Identified:**
The remote PuTTY window is waiting at the password prompt. Per the computer-use restrictions, Codex cannot automate entry into an authentication dialog. The user must enter the RMIT password privately in PuTTY, then tell Codex when a shell prompt is visible. Remaining checks include inspecting server Git state, deploying the correct `main` checkout, safely migrating the existing Jacob 5 schema, configuring private PHP connection settings, setting required paths/permissions, and testing all live features and assets. W3C HTML validation passed for ten rendered states; CSS validation is inconclusive after service errors. Small-screen checks and the browser console audit also remain outstanding.

**Related Commit:**
`da08e49` — https://github.com/s4251498/wp/commit/da08e49 (deployment-progress documentation). This entry was completed in the follow-up evidence-link commit.

---

# 📌 Final Reflection (End of Assessment)

> **AI-assisted draft for student review:** This is based on the recorded project work and checks. Edit it so it accurately reflects your own learning and experience before submitting.

**What AI was most useful for:**

AI was most useful for helping me trace the assessment requirements to specific pages and plan the implementation in stages. It also helped me review the PHP, SQL, and browser behavior together. The integration checks caught issues that were not obvious from reading the code alone, including missing cover files, incorrect not-found responses, and books with no matching seller. I treated generated code and explanations as suggestions and checked them against the supplied schema and local results.

**Where AI was incorrect or misleading:**

AI-generated implementation was not automatically correct or complete. Some work initially had only code-level review and needed later database and browser checks. The Day 3 notes also correctly left those checks pending instead of implying the pages were fully verified. The Git work was initially pushed to `codex/at3-foundation` while the repository's `main` branch still lacked AT3; after I pointed this out, the branch was fast-forwarded to `main` and the remote was checked. I should verify the target branch and test evidence rather than relying on an assistant's summary.

**What you learned about debugging:**

I learned to reproduce a symptom, identify the layer causing it, make a focused change, and verify the result with a relevant check. For example, a broken cover was traced to a database filename whose image did not exist on disk; the fix was to use the placeholder when the file is absent, then reload the page and check the placeholder response. Testing invalid IDs and a nullable book owner also showed why response codes and database relationships matter, not just whether a page appears.

**How your approach changed over time:**

I started by mapping the rubric and existing schema, then built the shared application foundation and authentication/protected listing actions before adding the public browsing pages. I used an isolated local database for integration checks and recorded limitations instead of claiming deployment was tested. The live Coreteaching/Jacob 5 setup has been exercised for the core application flows. Small-screen browser checks, formal style validation, direct live cross-owner access, and the individual demonstration still need attention. I need to review this draft, understand the code well enough to explain it, and personally rehearse the demonstration.

## Deployment Follow-up — 1 November 2026

The user completed the PuTTY permission checks on Saturn. Apache workers run as `apache:apache`; `setfacl` and `getfacl` are installed. The database config was mode `600`, which kept PHP from reading it. With the user's approval, a named ACL granted only the `apache` user read access to `~/bookverse-db-config.php`; the owner remains `s4251498`, and the `dg-adm-teaching-linux-allusers` group and other users have no access. `getfacl` confirmed the resulting permissions without exposing config contents.

After this fix, the protected diagnostic reported the config readable from the PHP application context and `database test: connected` on PHP 7.4.33 with mysqli. In MyDesktop Chrome, the live Saturn URL loaded the homepage, Books list, a book details page, Gallery, gallery modal, Register, and Log in. CSS and navigation rendered; missing uploaded covers displayed the intended fallback. One detail page showed an unavailable seller, consistent with a record that has no matching seller. No account or database records were created or modified during these checks. Search submission was not verified because MyDesktop input omitted characters while entering the query. Live authenticated CRUD, registration/login/logout submissions, uploads, upload permissions, mobile widths, and console audit remain outstanding.

The temporary token-protected diagnostic endpoint was removed from the Git project after confirming the database connection and its removal from the Saturn checkout was confirmed. The endpoint token is not recorded here.

### Live application verification — 1 November 2026

In the authenticated Saturn application, registered the disposable account `bvtest20261101`, verified its welcome state, logged out, logged back in, and confirmed authenticated navigation. Created a temporary listing (ID 13) with an uploaded cover, opened it in My Listings, and edited its title and status to Sold. The updated details page displayed the new title; searching the edited title returned one result with the uploaded cover. The Books status selector set to Sold showed this listing and another Sold listing, while other statuses were filtered from view. These live operations also further confirm the Jacob 5 application connection and that the cover directory was writable.

The disposable account remains in the live database. After the user approved removing only temporary listing ID 13, submitted the site's delete confirmation. Saturn returned “Your book listing has been deleted,” and the test seller page then showed zero books. The test cover was removed with the listing. This verifies the live delete path and its cleanup. After logging out, requested the protected `edit.php?id=12` route directly; the application redirected to login and displayed “Please log in to access that page.” The test also confirmed that owner edit/delete controls appear on the owner's own detail page, but did not verify direct cross-owner URL access. The remaining production checks are cross-owner authorization denial, mobile/tablet viewport behavior, and a browser console review. The application remains reachable and functioning inside MyDesktop Chrome; the external browser path previously timed out and was not used to judge application behavior.

## AI Task 9 — Prepare the Canvas submission package — 1 November 2026

**User request:** Prepare the project files on the user's actual Windows Desktop for upload and check them against every rubric criterion.

**What was reviewed:** The official assessment DOCX, supplied `bookverse.sql`, the current `main` branch, A3 source and documentation, the supplied cover assets in A1, and the official Canvas `Adding .htaccess` guide and `htaccess` template in the COSC2446 course Modules.

**Changes made:** Corrected stale README deployment/branch/student details; updated the rubric matrix, test status, Git distribution, and demo notes; added the supplied SQL to `a3/`; prepared the official Kerberos `.htaccess` template with the account placeholder replaced by `s4251498@RMIT.INTERNAL`; and created a clean desktop folder and ZIP containing the A3 source, documents, schema, and 12 supplied cover images. The `.htaccess` file is under `deployment/public_html/` so it is not mistaken for an A3 child file. The project commit is `37d5b74` on `main`; no work dates were changed.

**Verification:** Rechecked the archive file list (45 entries at initial packaging), including all 12 sample covers, schema, required README/process evidence, source pages/includes/assets, and personalized `.htaccess`. The packaging excludes `.git`, the supplied sample grader HTML, and `codexCredentials.txt`. The package includes only the non-secret assessment source/config template; the private database config remains outside the submission.

**Limitations retained:** The `.htaccess` template is prepared but has not been installed/retested on Saturn. Live cross-owner manipulation, phone/tablet viewports, and the remote browser console remain unverified. The AT3-only commit distribution exceeds the stated 50% target on 1 November, and the student must review the reflection and complete the individual demonstration. Do not describe the project as meeting every criterion until these items are addressed.

## AI Task 10 — Offline rubric audit and `.htaccess` follow-up — 1 November 2026

**User request:** Complete the remaining assessment work that can be done locally, then clarified that the official `.htaccess` should be installed while the user will handle the live demonstration.

**Local verification:** Started the existing XAMPP MariaDB instance and PHP 8.0.30 built-in server against the isolated `bookverse_at3_verify_20261101` database. The home, books, gallery, search, register, login, CSS, JavaScript, and favicon routes returned HTTP 200; invalid book and seller IDs returned HTTP 404. Created a temporary account in the isolated database, attempted to edit and delete sample book ID 1 while logged in as that different user, and verified both attempts were denied and the sample listing remained. Removed the temporary account afterward. The local database `bookverse` was not used for this security check.

**Documentation correction:** Recounted the repository history directly. It contains 79 total commits and 36 commits touching `a3/`, across six dates: 27 May (1), 14 July (1), 18 October (6), 21 October (5), 28 October (2), and 1 November (21). The largest date is `21/36 = 58.3%` of AT3 commits, above the 50% target. Corrected the README and assessment matrix; no commit dates were rewritten.

**`.htaccess` status:** The Canvas template personalized for `s4251498@RMIT.INTERNAL` remains in the submission package at `deployment/public_html/.htaccess`. The live placement at `~/public_html/.htaccess` could not be performed from this host: direct SSH to Coreteaching timed out, and the available MyDesktop session provides a PuTTY terminal without a file-transfer control. Do not claim the server file was installed. The user's live demonstration remains for the user to perform.

**Related evidence:** The Desktop source folder and ZIP were refreshed from the current `a3/` tree and checked for matching file sizes and content; all 12 cover PNGs and the personalized template are included, with no private DB config or credentials. The user must still install and verify `.htaccess` on Saturn, personally review the reflection, and complete the live demonstration.
