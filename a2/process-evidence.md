**# Process Evidence Log

Repository: https://github.com/s4251498/wp
Project: BookVerse — COSC2446 Assessment 2**

This file records debugging activities and AI usage during development of the BookVerse COSC2446 Assessment 2 project.

---

# 🔧 Section 1: Debugging Records

## Bug 1 - Hero Images Not Loading

**Date Identified:**  

30/09/2026

**Date Fixed:**  

30/09/2026

**File:**  

index.php

**Related Commit:**  

Commit: 311c1e9
Repository: https://github.com/s4251498/wp

**Symptom:**  

The BookVerse homepage loaded correctly, but the large hero/carousel images at the top of the page were not displaying. Other book cover images were loading correctly.

**Steps to Reproduce:**  

1. Start the project using XAMPP.

2. Open the BookVerse homepage.

3. Observe the large carousel at the top of the page.

4. The carousel structure appeared, but some of the large images were missing.

**Root Cause:**  

The image paths used by the carousel did not match the actual location and filenames of the supplied image assets in the project.

**Fix:**  

Checked the supplied image files and corrected the image locations and paths used by the homepage carousel. The book cover images were also placed in the required `assets/images/covers` directory.

**Verification:**  

Reloaded the homepage through XAMPP and confirmed that the carousel images displayed correctly.

---

## Bug 2 - Navigation Bar Not Displaying

**Date Identified:**  

30/09/2026

**Date Fixed:**  

30/09/2026

**File:**  

includes/nav.inc

**Related Commit:**  

Commit: 22e91b9
Repository: https://github.com/s4251498/wp

**Symptom:**  

The main website content was displaying, but the navigation bar was missing from the rendered website.

**Steps to Reproduce:**  

1. Start the project through XAMPP.

2. Open the homepage.

3. The page content displays but the navigation bar does not appear.

**Root Cause:**  

The working project being served by XAMPP was not using the same copy of the navigation file that had been edited in the development project folder.

**Fix:**  

Checked the project folder being served by XAMPP and ensured that the updated `nav.inc` file was present in the correct `includes` directory.

**Verification:**  

Reloaded the website through XAMPP and confirmed that the navigation bar appeared correctly on the page.

---

## Bug 3 - Site Colours Did Not Match the Supplied Design

**Date Identified:**  

30/09/2026

**Date Fixed:**  

30/09/2026

**File:**  

assets/css/style.css

**Related Commit:**  

Commit: d08fd1a
Repository: https://github.com/s4251498/wp

**Symptom:**  

The website was functional, but the colours did not match the supplied BookVerse reference design. In particular, the navigation/header appeared green when the supplied design used a dark blue/navy appearance.

**Steps to Reproduce:**  

1. Open any BookVerse page.

2. Compare the site's colours with the supplied reference screenshots and colour specifications.

3. The navigation and page background did not visually match the supplied design.

**Root Cause:**  

The original CSS used the supplied teal brand colours too broadly instead of using the darker navy/background and blue navigation colours shown in the supplied reference design.

**Fix:**  

Updated the stylesheet to retain the supplied BookVerse brand colours while adding the dark navy page background and dark blue navigation styling required to match the supplied reference design.

**Verification:**  

Reloaded all pages through XAMPP and checked the homepage, books page, details page, gallery and add-book page. Confirmed that the common navigation, background, cards, buttons and footer styling were consistent.

---

## Bug 4 - Image Upload/Preview Functionality Required Client-Side Validation

**Date Identified:**  

30/09/2026

**Date Fixed:**  

30/09/2026

**File:**  

assets/js/scripts.js

**Related Commit:**  

Commit: 4d9ea55
Repository: https://github.com/s4251498/wp

**Symptom:**  

The Add Book page required client-side image validation and an image preview before the form was submitted.

**Steps to Reproduce:**  

1. Open the Add Book page.

2. Select an image using the image upload field.

3. Test an unsupported file extension.

4. Test a supported image file.

**Root Cause:**  

The Add Book page relied on JavaScript functionality to provide client-side validation and preview behaviour, so the external JavaScript needed to correctly connect to the `image_path` input and `imagePreview` element.

**Fix:**  

Implemented/checked the external JavaScript so that JPG, JPEG, PNG, GIF and WEBP files are accepted, unsupported extensions are rejected, files over 5 MB are rejected, and valid images are previewed using `FileReader`.

**Verification:**  

Tested the image input with supported and unsupported extensions and confirmed that valid images produced a preview while invalid files were cleared and an error message was displayed.

---

# 🤖 Section 2: AI Usage Log

## AI Task 1 - Checking Project Requirements Against the Rubric

**Date:**  

30/09/2026

**Task Description:**  

Check the BookVerse implementation against the Assessment 2 requirements and identify missing or incorrect functionality.

**Tool Used:**  

ChatGPT

**Prompt / Input:**  

Asked ChatGPT to reassess the existing implementation against the supplied COSC2446 Assessment 2 rubric and identify anything that needed to be changed.

**AI Output Summary:**  

ChatGPT reviewed the project requirements and identified areas requiring attention, including image paths, shared navigation, styling, JavaScript functionality, documentation and testing.

**What You Accepted:**  

Used the identified rubric requirements to guide the implementation and testing of the project.

**What You Changed:**  

The project was checked and modified where required rather than accepting all AI suggestions automatically.

**Validation Performed:**  

Compared suggested changes against the supplied assessment requirements and tested the resulting website through XAMPP.

**Issues Identified:**  

Some initial AI suggestions did not immediately match the actual project structure or supplied reference design. These were checked against the project before being implemented.

---

## AI Task 2 - Fixing Image Paths and Homepage Display

**Date:**  

30/09/2026

**Task Description:**  

Resolve missing images on the BookVerse homepage and ensure the project used the required image directories.

**Tool Used:**  

ChatGPT

**Prompt / Input:**  

Provided the current `index.php`, project folder structure and screenshots showing missing images and asked for the file to be corrected.

**AI Output Summary:**  

ChatGPT identified that the homepage carousel and book-cover image paths needed to correspond to the actual project image locations.

**What You Accepted:**  

Used the corrected image-path structure and checked the resulting page.

**What You Changed:**  

Copied the supplied book images into the required covers directory and corrected the relevant paths.

**Validation Performed:**  

Opened the website through XAMPP and checked that the carousel and book cover images loaded.

**Issues Identified:**  

Some supplied images had different locations/names from the paths initially assumed, so the actual project folders had to be checked before the final paths were used.

---

## AI Task 3 - Correcting Site Styling

**Date:**  

30/09/2026

**Task Description:**  

Make the website colours match the supplied BookVerse reference design and colour requirements.

**Tool Used:**  

ChatGPT

**Prompt / Input:**  

Provided the current `style.css`, supplied colour specifications and screenshots and asked for the CSS to be checked and corrected.

**AI Output Summary:**  

ChatGPT reviewed the CSS and identified that the teal brand colours were being used where the supplied reference design showed dark navy/dark blue areas.

**What You Accepted:**  

Used the updated CSS structure for the common site styling.

**What You Changed:**  

Adjusted the page background, navigation, footer, buttons, cards and other common components while retaining the supplied brand colour variables.

**Validation Performed:**  

Reloaded the website through XAMPP and checked multiple pages to ensure the common styling was consistent.

**Issues Identified:**  

An initial CSS change did not appear to affect the website because the version being served by XAMPP was not the same project copy being edited. The correct project location was then identified and updated.

---

## AI Task 4 - Checking Add Book and JavaScript Requirements

**Date:**  

30/09/2026

**Task Description:**  

Check whether the Add Book PHP page and common JavaScript satisfied the assessment requirements.

**Tool Used:**  

ChatGPT

**Prompt / Input:**  

Provided the complete `add.php` and `scripts.js` files and asked for them to be checked against the assessment rubric.

**AI Output Summary:**  

ChatGPT reviewed the Add Book form, server-side validation, prepared database statement, image upload handling, client-side image validation, image preview, gallery modal and book status filtering.

**What You Accepted:**  

Kept the existing Add Book PHP implementation because it already satisfied the relevant requirements and retained the JavaScript functionality after checking it against the required behaviour.

**What You Changed:**  

Only changes that were required by the rubric were considered rather than rewriting working code unnecessarily.

**Validation Performed:**  

Reviewed the code against the assessment requirements and tested the project through XAMPP.

**Issues Identified:**  

The first file provided during the review was `style.css` rather than `scripts.js`, so the correct JavaScript file had to be provided before the JavaScript requirements could be checked.

---

# 📌 Final Reflection

**What AI was most useful for:**  

AI was most useful for reviewing the implementation against the assessment requirements, identifying missing functionality, debugging file paths and helping check that different pages used consistent styling and JavaScript functionality.

**Where AI was incorrect or misleading:**  

Some initial suggestions were based on assumptions about the project structure or image filenames. The suggestions had to be checked against the actual project files and supplied assessment materials before being implemented. AI also initially suggested changes that were unnecessary when the existing code already satisfied the requirement.

**What you learned about debugging:**  

I learned that a website can appear to have a code problem when the actual problem is the environment or file being served. Checking the exact XAMPP project directory, file paths and browser result was important when debugging missing images and navigation. I also learned to test changes against the assessment requirements rather than only checking whether the page loads.

**How your approach changed over time:**  

I became more focused on checking each implementation against the rubric before making changes. I also learned to test common files across multiple pages because changes to shared CSS, navigation and JavaScript can affect the entire website.  