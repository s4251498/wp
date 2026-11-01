# BookVerse Assessment 3 Demonstration Notes

Use this as a rehearsal outline for the individual demonstration. Explain the code in your own words and use a demo account with listings already prepared. Do not use production credentials during the demonstration.

## Suggested walkthrough (about 6–8 minutes)

1. **Anonymous browsing:** show the home carousel and latest four database listings in `index.php`; open one detail page and follow its seller link.
2. **Collection and discovery:** show the `books.php` table, filter by Available/Reserved/Sold, search by title or author, then show a keyword result in `search.php`.
3. **Gallery:** open a cover in the Bootstrap modal and explain how the native button supports keyboard activation.
4. **Account and ownership:** log in with the demo account, point out the authenticated navigation, open one owned listing, and show the edit and delete controls. Open the delete confirmation and cancel it.
5. **Listing lifecycle:** add a listing with an image, edit a field without replacing its image, then (if time and a prepared disposable listing allow) replace the image and delete the disposable listing after confirming it is safe to remove.
6. **Implementation explanation:** show `includes/db_connect.inc`, `functions.inc`, and `book_helpers.inc`; explain environment-based configuration, password hashing/verification, sessions and flash messages, prepared statements, CSRF tokens, server-side ownership checks, upload MIME/size validation, random filenames, and escaping output.
7. **Process evidence:** point to `assessment-plan.md` and `process-evidence.md`, explain one real bug and its verification, and show the progressive Git commits on `codex/at3-foundation`.

## Rehearse these explanations

- How an SQL placeholder and `mysqli_stmt_bind_param()` keep submitted values separate from SQL syntax.
- Why password hashes are stored and how `password_verify()` checks a login.
- How the session `user_id` is used for access checks and how owner IDs are included in edit/delete database queries.
- Why delete uses POST plus a CSRF token and confirmation modal.
- How PHP checks both the filename extension and actual MIME type, limits upload size, and generates an unpredictable stored name.
- How `htmlspecialchars()` and the shared header/navigation/footer helpers improve safety and consistency.
- What the isolated tests cover and what remains untested: live deployment, exact assessment screenshot comparison, and small-screen browser review.

## Before presenting

- Verify the deployed URL, database connection, uploads directory permissions, and sample records on the day of the demonstration.
- Make sure the demo account can log in and owns the listing used for edit/delete controls.
- Keep a second browser session logged out to show the anonymous experience if useful.
- Do not delete a real listing during the demonstration; use a disposable demo listing.
- Be ready to explain and adapt the code independently. The assessment demonstration is an individual explanation of the submitted project.
