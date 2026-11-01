# BookVerse — Individual Demo Rehearsal

The individual demonstration is worth 25 marks. This is a rehearsal guide; the student should explain the submitted code in their own words and be ready to answer follow-up questions.

## Suggested walkthrough (6–8 minutes)

1. **Public browsing:** open the deployed home page, explain the four newest listings, open a detail page, and follow the seller link.
2. **Find a book:** show the books table and JavaScript filter (`Available`, `Reserved`, `Sold`), then submit a title/author/description search.
3. **Gallery:** open a cover in the Bootstrap modal and explain the event handler in `assets/js/scripts.js`.
4. **Authentication:** log in to an account you control; point out the session-aware navigation and open your seller listings.
5. **CRUD:** add a disposable listing with a cover, view it, edit it, then show the delete confirmation and delete only that disposable record if the assessor asks. Do not delete a real listing.
6. **Security:** explain password hashing, prepared statements, CSRF tokens, escaping, server-side validation, and owner checks in `includes/functions.inc`, `includes/book_helpers.inc`, `edit.php`, and `process_delete.php`.
7. **Deployment and process:** explain the private database config outside `public_html`, how Jacob 5 is reached, and show the real commit progression on `main` plus the relevant records in `process-evidence.md`.

## Topics to explain from this code

- HTTP request/response and client/server flow: a form submits to PHP; PHP validates, queries MySQLi, sets a flash message, then redirects.
- Includes: `header.inc`, `nav.inc`, and `footer.inc` keep the page shell consistent; `db_connect.inc` opens one configured MySQLi connection.
- SQL safety: prepared statements bind values separately from SQL syntax; output uses `bv_escape()`/`htmlspecialchars()`.
- Authentication vs authorization: a session identifies the logged-in user; edit/delete queries also require the listing's `user_id` to match that user.
- Passwords and sessions: `password_hash()` stores a one-way hash; `password_verify()` checks it; login regenerates the session ID; logout destroys the session.
- CSRF: state-changing POST forms include a session token, checked on the server.
- Uploads: PHP checks upload status, size, extension, and MIME; it generates a random filename and safely retains/replaces/removes cover files.
- JavaScript: `scripts.js` previews uploads, validates client-side feedback, filters rows, handles gallery modal content, and confirms deletion. PHP remains authoritative.
- Database structure: `users.user_id` and `books.user_id` link owners to listings; `book_id` identifies a book.
- Git and evidence: work is on `main`; explain one genuine bug and its commit/test record.

## Before the demonstration

- Rehearse logging in with an account you control and confirm it owns the disposable listing used in the walkthrough.
- Check the live URL and database-backed routes in MyDesktop; the external Saturn route previously timed out.
- Be prepared to state honestly that live cross-owner manipulation, phone/tablet viewports, the live browser console, formal CSS validation, and exact screenshot comparison remain unverified or inconclusive.
- Review and personalize the reflection draft in `process-evidence.md`; do not claim experiences that are not yours.
- Do not expose passwords or production configuration on screen.
