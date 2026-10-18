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

The pasted rubric totals 145 marks: criteria A–K (120 marks) concern the project and its process evidence; criterion L (25 marks) is the individual demonstration. Each row remains pending until implementation and verification exist.

| Criterion / marks | Requirement and planned location | Verification plan | Status / evidence / remaining work |
|---|---|---|---|
| A. PHP structure — 20 | Required pages in `a3/`; shared files in `a3/includes/`; semantic HTML, consistent navigation and redirects. | Load each required page, inspect navigation, titles, responses, and rendered markup. | Pending. No AT3 pages exist yet. |
| B. Database structure — 15 | Use supplied schema and MySQLi; registration and book CRUD must preserve owner relationships and exact column names. | Inspect schema compatibility; exercise successful and invalid reads/writes against an available local database. | Pending. Local DB credentials/runtime not established. |
| C. JavaScript and responsive design — 10 | One `assets/js/scripts.js`; validation, gallery modal, delete confirmation, status filter, responsive Bootstrap layout. | Exercise controls and check representative phone, tablet, and desktop widths and browser console. | Pending. |
| D. Authentication and sessions — 15 | Registration, `password_hash()`/`password_verify()`, login/logout, session state and flash messages. | Test valid/invalid registration and login, duplicate account, logout, and flash lifecycle. | Pending. |
| E. Authorization — 10 | Require login for add; enforce ownership server-side for edit/delete; protect against manipulated IDs. | Attempt protected routes while logged out and cross-owner edit/delete using two accounts. | Pending. |
| F. Page compliance — 10 | Follow official filenames, field names, page behaviour, screenshot/design and content requirements. | Checklist each DOCX requirement against implementation and rendered pages. | Pending. |
| G. Deployment — 10 | Prepare Coreteaching deployment and Jacob 5 database; use student-ID database name; verify live behavior only when deployed. | Review paths/config/permissions; test deployed pages, assets, sessions and CRUD after credentials/access are available. | Pending. Student-specific deployment access is not available in this workspace. |
| H. GitHub/history — 10 | Meaningful progression and commits, with authentic work dates and below-50% concentration on one day. | Recalculate commit counts by actual calendar date and inspect commit contents before submission. | Existing repository baseline: 45 commits / 14 dates; largest date 12 (26.7%). AT3 work not started at inspection. |
| I. Debugging records — 8 | At least five genuine debugging records with symptom, reproduction, cause, fix, verification and linked commit. | Audit each entry against the actual fix, test and commit. | Pending; do not pre-fill incidents. |
| J. AI usage — 7 | At least five meaningful AI-use records showing actual prompts, evaluation, adaptations and verification. | Compare records with actual interactions and tested code. | Pending; record as work happens. |
| K. Authentic process — 5 | Dated process evidence must match real work, debugging and commits. | Cross-check dates, diffs, test notes and commit history. | Pending; maintain progressively. |
| L. Demonstration — 25 | Explain the actual implementation and relevant web, PHP, database, security, JavaScript and Git concepts. | Prepare a walkthrough and practice explanations from the completed code; do not claim demonstration marks as project checks. | Pending until implementation exists. |

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

## Risks and dependencies

- The public repository's existing AT2 database connection contains a committed live database credential. Treat it as exposed and rotate it; never copy it into AT3 or repeat it in logs.
- Local database credentials, database runtime, student's preferred display name, and live deployment access are not present here. Use placeholders until supplied; do not invent values.
- The generated HTML report contains contradictory naming and scoring hints. Follow the official DOCX and SQL where it conflicts; preserve uncertain details for review rather than silently changing schema or filenames.
- The brief requests screenshot matching. Use the screenshots embedded in the DOCX as visual references during implementation and responsive review.
