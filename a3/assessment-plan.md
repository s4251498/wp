# AT3 Baseline and Work Plan

This is the working traceability plan for the BookVerse Assessment 3 implementation. It records the repository baseline and planned verification; it is not evidence that unimplemented or untested requirements have passed.

## Baseline inspected

- Repository: `https://github.com/s4251498/wp`, branch `main`, inspected at `9e80a32`.
- Existing assessment folders: `a1/`, `a2/`, and `a3/`. Work for this assessment belongs in `a3/`.
- `a3/` currently contains the supplied README and process-evidence templates, a favicon, and empty CSS, JavaScript, and cover-image folders. It has no PHP pages or include files yet.
- Official sources inspected: `COSC2446 Web Programming Assessment3.docx`, `bookverse.sql`, and `AT3_S1234567.html` from the supplied ZIP. The HTML file is a generated grading report and is not a source-code starter or verified test record.
- The supplied SQL defines `users` and `books`; book states are `Available`, `Reserved`, and `Sold`, and conditions are `New`, `Gently Used`, and `Fair`. Keep these names and values unless the official brief is clarified.
- Existing repository history has 45 commits across 14 calendar dates. The largest recorded date has 12 commits: `12 / 45 × 100 = 26.7%`. This is a repository-wide baseline, not a claim about future AT3 work. Recalculate at submission.

## Rubric traceability

The pasted rubric totals 145 marks: criteria A–K (120 marks) concern the project and its process evidence; criterion L (25 marks) is the individual demonstration. Statuses below distinguish implemented work, checks actually run, and remaining work.

| Criterion / marks | Requirement and planned location | Verification plan | Status / evidence / remaining work |
|---|---|---|---|
| A. PHP structure — 20 | Required pages in `a3/`; shared files in `a3/includes/`; semantic HTML, consistent navigation and redirects. | Load each required page, inspect navigation, titles, responses, and rendered markup. | Partial: all public browsing, auth, and listing-action routes are implemented and locally rendered. Valid routes returned 200, missing details/seller returned 404, and local assets returned 200. Formal HTML validation and deployment checks remain pending. |
| B. Database structure — 15 | Use supplied schema and MySQLi; registration and book CRUD must preserve owner relationships and exact column names. | Inspect schema compatibility; exercise successful and invalid reads/writes against an available local database. | Partial: schema-column review passed and registration/add/edit/delete flows were exercised against an isolated temporary MariaDB 10.4.32 database loaded with the supplied SQL. Production connection/deployment is untested. |
| C. JavaScript and responsive design — 10 | One `assets/js/scripts.js`; validation, gallery modal, delete confirmation, status filter, responsive Bootstrap layout. | Exercise controls and check representative phone, tablet, and desktop widths and browser console. | Partial: browser checks confirmed the status filter, cover modal, and delete modal. JS syntax passes. Desktop layout was visually reviewed; phone/tablet viewport and console checks remain pending. |
| D. Authentication and sessions — 15 | Registration, `password_hash()`/`password_verify()`, login/logout, session state and flash messages. | Test valid/invalid registration and login, duplicate account, logout, and flash lifecycle. | Core flows passed against isolated MariaDB: valid registration/auto-login, duplicate and invalid-password rejection, valid login, logout invalidation, password hashing, and flash display/clear. Day 4 browser check confirmed authenticated navigation and successful logout on a disposable local account. |
| E. Authorization — 10 | Require login for add; enforce ownership server-side for edit/delete; protect against manipulated IDs. | Attempt protected routes while logged out and cross-owner edit/delete using two accounts. | Local checks passed for anonymous add/edit redirects, cross-owner edit/delete rejection, bad-CSRF delete rejection, GET-delete 405, and owner delete. Browser showed owner controls and confirmation modal for the owner account. |
| F. Page compliance — 10 | Follow official filenames, field names, page behaviour, screenshot/design and content requirements. | Checklist each DOCX requirement against implementation and rendered pages. | Partial: all required pages/features are implemented and public routes were rendered. Exact screenshot comparison, standards validation, and production/deployment requirements remain outstanding. |
| G. Deployment — 10 | Prepare Coreteaching deployment and Jacob 5 database; use student-ID database name; verify live behavior only when deployed. | Review paths/config/permissions; test deployed pages, assets, sessions and CRUD after credentials/access are available. | Pending. Student-specific deployment access is not available in this workspace. |
| H. GitHub/history — 10 | Meaningful progression and commits, with authentic work dates and below-50% concentration on one day. | Recalculate commit counts by actual calendar date and inspect commit contents before submission. | AT3 work was committed progressively across four planned dates. Recalculate date distribution from the full repository history before submission; commit counts are only a proxy for effort. |
| I. Debugging records — 8 | At least five genuine debugging records with symptom, reproduction, cause, fix, verification and linked commit. | Audit each entry against the actual fix, test and commit. | Seven debugging records include linked commits and specific verification notes; unavailable fault-injection/browser/deployment checks are identified. |
| J. AI usage — 7 | At least five meaningful AI-use records showing actual prompts, evaluation, adaptations and verification. | Compare records with actual interactions and tested code. | Six AI-use entries record the task, accepted output, adaptations, actual checks, limitations, and commit links. |
| K. Authentic process — 5 | Dated process evidence must match real work, debugging and commits. | Cross-check dates, diffs, test notes and commit history. | Process log updated on each workday and cross-linked to implementation commits; personal reflection remains for the student to complete. |
| L. Demonstration — 25 | Explain the actual implementation and relevant web, PHP, database, security, JavaScript and Git concepts. | Prepare a walkthrough and practice explanations from the completed code; do not claim demonstration marks as project checks. | `a3/demo-notes.md` contains a rehearsal outline. The individual demonstration has not occurred; student rehearsal and delivery remain pending. |

## Four-stage schedule

Target effort is distributed evenly across four actual workdays (about 25% each), keeping every day below 50%. Commit only real, coherent progress from that day. Dates and time records must be written when each session happens; this plan does not create future activity or timestamps.

| Stage | Work focus | Planned deliverables | Approx. share |
|---|---|---|---:|
| 1. Baseline and foundation | Inspect starter conventions, establish safe configuration, shared includes, database access patterns and traceability. | This baseline plan; agreed AT3 file map; initial shared layout and connection implementation after local configuration is understood. | 25% |
| 2. Authentication and protected CRUD | Registration, login/logout, sessions, flash messages, add/edit/delete flows, prepared statements, CSRF where appropriate, server-side ownership checks. | Working core flows and honest verification notes. | 25% |
| 3. Browsing and interface | Home, books, details, seller, search and gallery; filters, modals, upload preview/validation, consistent Bootstrap design and accessibility. | Complete visitor and authenticated browsing experience. | 25% |
| 4. Integration, audit and submission prep | Run the rubric test matrix; fix defects; complete README and process evidence from actual results; deployment instructions; prepare demonstration explanations. | Final audit with passed/pending results, known issues, deployment state and demo notes. | 25% |

## Test strategy

Record expected result, actual result, pass/fail, date and evidence for each executed check. At minimum cover page loading; valid and invalid/duplicate registration; valid/invalid login and logout; unauthenticated route access; CRUD; owner vs non-owner and manipulated IDs; missing IDs; search; all database status filters; image upload and invalid extensions; image cleanup on edit/delete; gallery modal and deletion confirmation; flash lifecycle; responsive layouts; missing assets/links; HTML/CSS validation; and deployment checks if access is available. Unexecuted tests remain pending.

### Checks executed so far

| Check | Expected | Actual | Result / limitation |
|---|---|---|---|
| Supplied schema vs. auth/book fields | Every referenced column exists in `users` or `books`. | All registration and book-handler column names were present in the supplied SQL. | Pass (static schema review only). |
| MySQLi bind parameter arity | Type-string length equals the bound value count. | All detected bind calls matched (11, 12, 2, and 1 parameters as applicable). | Pass (static check; not a query execution). |
| Shared JavaScript syntax | `scripts.js` parses. | `node --check a3/assets/js/scripts.js` exited successfully. | Pass (syntax only; no browser behavior check). |
| Authentication form colors | Form heading/body text has readable contrast on white. | Calculated ratios: dark teal 5.47:1 and text gray 4.83:1. | Pass (color calculation; browser appearance still pending). |
| PHP lint | All PHP and include files parse. | XAMPP PHP 8.0.30 reported no syntax errors in all 19 current `.php` and `.inc` files. | Pass (syntax only). |
| Public route responses | Valid public routes render; invalid book/seller IDs report not found. | Local PHP server returned 200 for home/books/gallery/valid details/valid seller/search; 404 for invalid details and unknown seller IDs. Anonymous add/edit returned 303 to login. | Pass locally; deployment is untested. |
| Browser status filter | Selecting a status shows only matching rows. | Selected Sold in the local browser; only the Sold listing remained visible. | Pass for the exercised filter. |
| Browser keyword search | Search for a known title returns its matching listing. | Submitted “Dune” using the search form; one matching book appeared. | Pass for the exercised query. |
| Gallery modal | Activating a cover displays the corresponding image and accessible title. | Opened the 1984 cover; modal title and image alt text updated. | Pass for one cover. |
| Owner details controls | Only the listing owner sees edit/delete controls; deletion requires confirmation. | Logged into a disposable local test account owning a seeded book; owner controls and confirmation modal appeared. Cancelled without deleting. | Pass for owner rendering; cross-owner server checks were exercised on Day 2. |
| Missing covers | Missing stored image paths display a usable fallback. | Browser initially showed a broken image; after fix it displayed the SVG placeholder. Placeholder asset returned HTTP 200. | Pass for missing-file fallback. |
| Nullable book owner | Books with NULL owner remain readable without a seller link. | Temporarily set a local test book owner to NULL; it remained visible and displayed an unavailable-seller label. Restored the original value. | Pass for exercised NULL-owner behavior. |
| Page assets | Locally referenced CSS, JS, favicon, and placeholder exist and load. | Local page assets returned HTTP 200 and filesystem checks found each referenced asset. | Pass locally. |
| Database CRUD/authentication | Operations succeed and reject invalid or unauthorized requests. | Isolated MariaDB 10.4.32 loaded the supplied SQL. Registration, password hashing, login/logout, add, edit, upload replacement/cleanup, ownership checks and delete cleanup passed HTTP/DB assertions. | Pass locally for exercised flows; not a Coreteaching/Jacob 5 deployment test. |
| Upload, CSRF, and request method checks | Invalid images/CSRF and destructive GET requests are rejected without data mutation. | Disallowed extension and MIME mismatch produced validation errors/no insert; bad-CSRF delete preserved a sample row; GET delete returned 405. | Pass locally for these checks. |
| `git diff --check` | No whitespace errors in changed files. | Passed after correcting new evidence-log formatting. | Pass. |

## Risks and dependencies

- The public repository's existing AT2 database connection contains a committed live database credential. Treat it as exposed and rotate it; never copy it into AT3 or repeat it in logs.
- Live deployment credentials, student ID, Jacob 5 database name, deployment path, and URL are not present here. Do not invent these values.
- The generated HTML report contains contradictory naming and scoring hints. Follow the official DOCX and SQL where it conflicts; preserve uncertain details for review rather than silently changing schema or filenames.
- Exact screenshot comparison, formal HTML/CSS validation, mobile/tablet viewports, and a browser console audit remain outstanding.
