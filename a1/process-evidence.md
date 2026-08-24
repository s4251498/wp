# Process Evidence Log

This file combines:

1. Debugging records
2. AI (e.g., Copilot/ChatGPT) usage logs

This document records the development, debugging and AI-assisted work completed during Assessment 1.

---

## General Instructions

* Record entries as development work is completed.
* Entries describe genuine development and debugging activities.
* AI-assisted suggestions were reviewed and tested before being incorporated.
* Git commits are used to provide evidence of changes made during development.

---

# 🔧 Section 1: Debugging Records

## Bug 1 — Gallery Page Layout and Functionality

**Date Identified:**
21/08/2026

**Date Fixed:**
21/08/2026

**File:**
`gallery.html` and `assets/css/style.css`

**Related Commit:**
`b8ca74e922973dd7ce0f68ec3cb0478d7b89edeb`
https://github.com/s4251498/wp/commit/b8ca74e922973dd7ce0f68ec3cb0478d7b89edeb

**Symptom:**
The Gallery page did not match the required assessment layout correctly. The page required adjustments to the gallery structure and styling so that the book images displayed correctly and the page matched the intended responsive design.

**Steps to Reproduce:**

1. Open `gallery.html` in the browser.
2. View the Gallery page at normal browser zoom.
3. Compare the layout and image sizing against the provided assessment reference.
4. The gallery layout and image presentation do not match the required design closely enough.

**Root Cause:**
The original gallery HTML and CSS did not provide the correct layout and sizing required for the assessment reference design. The gallery page required changes to both its HTML structure and associated styling.

**Fix:**
The Gallery page was updated to improve its structure and presentation.

The gallery HTML was modified and the CSS was adjusted to control the image dimensions, spacing and responsive behaviour.

The changes were committed with the message:

`Fix gallery page`

**Verification:**
The updated `gallery.html` was opened in the browser and checked against the assessment reference screenshot.

The gallery images displayed correctly and the responsive layout was checked at different browser zoom levels.

The Gallery modal functionality was also tested to ensure that selecting an image continued to open the correct image in the modal.

---

## Bug 2 — Add Book Page Menu Sizing

**Date Identified:**
21/08/2026

**Date Fixed:**
21/08/2026

**File:**
`add.html` and `assets/css/style.css`

**Related Commit:**
`41944cfb5be714580ffada9a49e53da63b762ade`
https://github.com/s4251498/wp/commit/41944cfb5be714580ffada9a49e53da63b762ade

**Symptom:**
The Add Book page menu/form layout was not displaying at the correct size compared with the required assessment design.

**Steps to Reproduce:**

1. Open `add.html` in the browser.
2. View the Add Book form.
3. Compare the form and menu sizing with the provided assessment reference screenshot.
4. The menu/form sizing does not match the intended layout.

**Root Cause:**
The CSS sizing applied to the Add Book page did not match the required assessment layout, resulting in the menu and form dimensions appearing incorrectly compared with the reference design.

**Fix:**
The CSS styling for the Add Book page was adjusted to improve the menu and form sizing.

The changes were tested visually and then committed with the message:

`Fix add book menu size`

**Verification:**
The Add Book page was reloaded after the CSS changes.

The form and menu sizing were compared against the reference screenshot at different browser zoom levels.

The page displayed correctly and the Add Book form remained functional after the styling changes.

---

# 🤖 Section 2: AI Usage Log

## AI Task 1 — Review and Update Assessment Website Styling

**Date:**
21/08/2026

**Task Description:**
Review and improve the BookVerse website styling so that the pages better matched the assessment reference screenshots while maintaining the required Bootstrap and CSS structure.

**Tool Used:**
ChatGPT

**Prompt / Input:**
Provided the current `style.css` file and asked ChatGPT to update the CSS to improve the layout and make the website better match the provided assessment screenshots.

**AI Output Summary:**
ChatGPT reviewed the existing CSS and suggested changes to the colour variables, dark navy theme, navigation, carousel sizing, cards, buttons, tables, forms, gallery styling and responsive layouts.

**What You Accepted:**
I accepted CSS suggestions that improved the appearance, sizing and consistency of the BookVerse pages while still meeting the assessment requirements.

**What You Changed:**
The AI-generated CSS was reviewed rather than being accepted without testing.

Carousel heights, book image sizes and responsive media queries were manually adjusted after viewing the website in the browser.

The gallery and Add Book page styling was also refined to better match the reference screenshots.

**Validation Performed:**
The website was opened in the browser and compared against the provided assessment reference screenshots.

The pages were reloaded after CSS changes to check the resulting layout at different browser zoom levels.

**Issues Identified:**
Some initial AI-suggested sizing did not match the reference screenshots closely enough. The image and carousel dimensions therefore required manual adjustment.

---

## AI Task 2 — CoreTeaching Deployment Troubleshooting

**Date:**
21/08/2026

**Task Description:**
Set up and troubleshoot deployment of the Assessment 1 website to the RMIT CoreTeaching Titan server.

**Tool Used:**
ChatGPT

**Prompt / Input:**
Asked for step-by-step assistance deploying the existing GitHub `wp` repository to CoreTeaching from the beginning, including SSH setup, GitHub authentication, repository cloning and web server configuration.

**AI Output Summary:**
ChatGPT provided step-by-step instructions for:

* Connecting to Titan using SSH.
* Generating an ED25519 SSH key.
* Adding the public key to GitHub.
* Testing GitHub SSH authentication.
* Cloning the repository.
* Checking the project structure.
* Setting up the web-accessible directory.
* Configuring the `.htaccess` authentication file.
* Testing the deployed website.

**What You Accepted:**
The step-by-step troubleshooting approach and the commands used to diagnose and configure the CoreTeaching deployment.

**What You Changed:**
Commands were executed one at a time and the results were checked before continuing.

When the initial deployment produced a `403 Forbidden` error, the suggested directory permissions and deployment structure were investigated and corrected.

The `.htaccess` configuration was also updated with the actual RMIT student ID before being uploaded to the server.

**Validation Performed:**
The GitHub SSH connection was tested successfully using:

```bash
ssh -T git@github.com
```

The repository was successfully cloned onto Titan.

The CoreTeaching website was then tested through the browser.

After the `.htaccess` configuration was added, the website correctly requested RMIT authentication and successfully loaded after entering the RMIT credentials.

**Issues Identified:**
The initial CoreTeaching deployment returned `403 Forbidden` because of directory permissions.

After correcting the permissions, the server returned `404 Not Found`, which identified a second deployment directory issue.

These issues were resolved through iterative testing and verification.

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**

AI was most useful for troubleshooting problems, explaining unfamiliar deployment commands and helping identify possible causes of HTML, CSS, JavaScript and server configuration issues.

It was also useful for reviewing the website against the assessment requirements and suggesting improvements to the CSS and responsive layout.

**Where AI was incorrect or misleading:**

Some AI-generated CSS sizing suggestions did not match the reference screenshots closely enough and required manual adjustment after testing the website.

During deployment, the initial assumptions about the CoreTeaching directory structure required verification against the actual server behaviour. The commands were therefore tested one at a time rather than being blindly executed.

**What you learned about debugging:**

Debugging is more effective when problems are isolated and tested individually.

For the CoreTeaching deployment, the change from `403 Forbidden` to `404 Not Found` was useful evidence because it showed that the permission problem had been fixed and that the remaining problem was the location of the website files.

Testing after each change made it possible to identify the actual cause of each problem rather than changing multiple things at once.

**How your approach changed over time:**

The development process became more iterative. Instead of making large changes without testing, changes were made, tested in the browser or on the server, and then adjusted based on the result.

AI suggestions were treated as starting points rather than final solutions. The code and configuration were reviewed, modified and tested before being accepted.

