# AT3 Rubric Traceability and Final Status

This checklist maps the official assessment brief and supplied SQL to the implementation and evidence in this folder. It records actual results; it is not a guarantee of a mark. The individual demonstration is a separate 25-mark assessment and has not yet taken place.

## Rubric matrix

| Criterion | Evidence and actual status | Remaining work / risk |
|---|---|---|
| A. PHP structure — 20 | Required browsing, search, seller, authentication, and listing pages/includes are present. Local valid routes/assets returned 200; malformed/missing IDs returned 404. Live public routes rendered on Saturn. | Exact screenshot comparison remains; install the provided server-level access-control file and retest. |
| B. Database structure — 15 | Supplied `users`/`books` schema and columns were checked. Isolated local MariaDB tests passed; live protected diagnostic confirmed the Jacob 5 connection. Live registration, listing create/edit/delete, and cover operations worked. | Live cross-owner manipulation was not tested. The submitted SQL resets its tables and is for a fresh local database only. |
| C. JavaScript/responsive design — 10 | JS syntax passed; local and live search/filter, gallery modal, delete confirmation, and upload preview were exercised. Bootstrap responsive classes are used. | Phone/tablet viewport and live browser console checks are pending. Formal CSS validation returned service errors; no pass claimed. |
| D. Authentication/sessions — 15 | Local tests covered hashing, valid/invalid login, duplicate registration, auto-login, logout invalidation and flash lifecycle. On Saturn, registration, login, logout and re-login succeeded. | Live invalid/duplicate account cases were not separately repeated. |
| E. Authorization — 10 | Local cross-owner edit/delete and CSRF/method checks passed. On Saturn, logout followed by direct edit-route request redirected to login; own-book controls and delete workflow were verified. | Direct live access to another user's listing was not tested with two live accounts. |
| F. Page compliance — 10 | Page names, schema fields, key features and supplied statuses were compared to the DOCX/SQL; HTML validation passed ten rendered states. The official Canvas `.htaccess` template and setup guide were reviewed; the personalized file is included under `deployment/public_html/`. | Exact visual comparison remains. Install the prepared `.htaccess` at `~/public_html/.htaccess` and verify it on Saturn. |
| G. Coreteaching/Jacob 5 — 10 | Live site deployed to Saturn at the URL in README. PHP 7.4.33/MySQLi, private config access, database connection, assets, registration/login/logout, create/edit/delete, upload, search, status filtering and anonymous protected-route behavior were verified in MyDesktop Chrome. Official access-control template was prepared from Canvas. | Direct Saturn access outside MyDesktop timed out. Live cross-owner check remains. The official `.htaccess` file has not yet been installed/retested on Saturn. |
| H. GitHub/history — 10 | AT3 is published on `main`; the full repository has 79 commits, while 36 touch `a3/`, dated 27 May (1), 14 July (1), 18 October (6), 21 October (5), 28 October (2), and 1 November (21). | By AT3-only count, the largest day is `21/36 = 58.3%`, exceeding the 50% target. Across all repository history it is `21/79 = 26.6%`. Do not rewrite or fabricate dates; marker interpretation may affect this criterion. |
| I. Debugging records — 8 | `process-evidence.md` contains seven genuine debugging records with symptoms, causes/fixes, checks, and linked commits. Deployment troubleshooting is recorded separately. | Student should review evidence and ensure each record is understandable. |
| J. AI usage — 7 | `process-evidence.md` records actual AI tasks, decisions, verification, limitations, and commit links. | Student must review and be able to explain AI-assisted work. |
| K. Authentic process — 5 | Dated progress and debugging notes link to real code/docs commits; no synthetic dates were added. | Personalize the reflection draft. Ensure the submitted Git history and current write-up are reviewed together. |
| L. Demonstration — 25 | `demo-notes.md` provides an implementation-specific rehearsal guide. | The student must personally rehearse and complete the scheduled individual demonstration. |

## Verification summary

| Test group | Actual result |
|---|---|
| PHP syntax | Pass: 19 PHP/include files linted with XAMPP PHP 8.0.30. |
| JavaScript syntax | Pass: `node --check a3/assets/js/scripts.js`. |
| Whitespace | Pass: `git diff --check` at recorded checkpoints. |
| Local isolated schema and HTTP routes | Pass for exercised public/auth/CRUD routes and static assets; invalid IDs returned 404 and anonymous protected routes redirected. |
| Local database/auth/CRUD security | Pass for exercised registration, hashing, login/logout, create/edit/delete, upload validation/replacement/cleanup, ownership, CSRF and method checks. |
| Browser interactions | Pass for exercised search, status filters, gallery modal, upload preview, owner controls and confirmation modal. |
| HTML | Pass: ten rendered states returned zero errors/warnings from W3C HTML checker. |
| CSS | Inconclusive: W3C endpoint returned `Reader used`/HTTP 520. |
| Live Saturn/Jacob 5 | Pass for verified operations listed in criterion G. Test listing ID 13 and its uploaded cover were deleted; the disposable test account remains. |
| Live cross-owner, mobile/tablet, console | Not verified. |

## Submission review

- ZIP name: `COSC2446_a3_S4251498.zip`.
- Include all `a3/` application source/assets, supplied `bookverse.sql`, `README.md`, and `process-evidence.md`. `demo-notes.md` and this traceability matrix are useful supplementary documents. The zip also carries the personalized `deployment/public_html/.htaccess` template; deployment instructions specify its actual server destination.
- Do not include `.git`, `.DS_Store`, credentials, the private database config, or the sample grader HTML (`AT3_S1234567.html`).
- The supplied SQL starts by dropping/recreating tables; use only for a disposable fresh local database, never Jacob 5.
- The student must review/personalize the reflection and rehearse the 25-mark demonstration.
