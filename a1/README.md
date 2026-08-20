# COSC2446 Web Programming – Assessment 1  
# BookVerse Online Bookstore Platform

## Student Details

| Item | Details |
|---|---|
| Student name | Oliver Heberle |
| Student ID | S4251498 |
| GitHub repository URL | TODO |
| Deployed website URL | TODO |

---

## 1. Purpose of This README

This README documents the Assessment 1 project and should be completed by the student.

It is used to:

- summarise the project;
- explain the structure and technical choices;
- document testing and deployment;
- support marking of documentation and submission quality;
- help AI tools such as GitHub Copilot follow the assessment requirements.

TODO: After completing the project, update every TODO section in this file.

---

## 2. Copilot and AI Coding Instructions

This section must be completed by the student after reading the Assessment 1 brief.

Write clear instructions that would help GitHub Copilot or another AI tool produce code that follows the Assessment 1 requirements.

Your instructions should help the AI understand what it is allowed to generate, what it must not generate, and which assessment constraints must be followed.

TODO: Include instructions about:

- allowed technologies;
- technologies, frameworks, or tools that must not be used;
- required files and folders;
- CSS and JavaScript file requirements;
- whether inline CSS or inline JavaScript is allowed;
- Bootstrap layout requirements;
- form requirements;
- image validation requirements;
- gallery modal requirements;
- book status filtering requirements;
- accessibility and usability expectations;
- AI usage and process-evidence requirements.

### My Copilot / AI instructions


The following instructions were used to ensure that AI-assisted development followed the Assessment 1 requirements.

- Use HTML5, CSS3, Bootstrap 5 and JavaScript for the website.
- Do not use additional frameworks unless specifically required by the assessment.
- Keep the project as a static front-end website.
- Use the required HTML files: `index.html`, `books.html`, `gallery.html` and `add.html`.
- Keep CSS in the external `assets/css/style.css` file.
- Keep JavaScript in the external `assets/js/scripts.js` file.
- Do not use inline CSS.
- Do not use inline JavaScript.
- Use Bootstrap classes for responsive layouts and Bootstrap components where appropriate.
- Use semantic HTML elements such as `header`, `nav`, `main`, `section`, `article` and `footer`.
- Give every page a meaningful and unique title.
- Use accessible form labels associated with their corresponding form controls.
- Include appropriate alternative text for images.
- Use Bootstrap's responsive grid system for layouts that adapt to different screen sizes.
- Implement the homepage carousel using Bootstrap.
- Implement the books page as a responsive Bootstrap table.
- Implement the book status filter using JavaScript.
- Implement the gallery using a responsive Bootstrap grid.
- Use a Bootstrap modal to display selected gallery images.
- Implement the Add Book form using appropriate HTML5 input types and required fields.
- Validate uploaded image extensions using JavaScript.
- Accept JPG, JPEG, PNG, GIF and WEBP image formats.
- Display a preview of a valid selected image.
- Provide clear feedback when an invalid image file is selected.
- Maintain consistent navigation, fonts, colours, spacing and layout across all pages.
- Keep the website responsive and usable on different screen sizes.
- Avoid generating unnecessary code or functionality that is not required by the assessment.
- Review, test and understand all AI-generated code before including it in the final submission.
- Record meaningful AI usage and debugging activities in `process-evidence.md`.
- Do not fabricate testing results, debugging records, commit history or AI usage records.

---

## 3. Project Overview

Briefly describe the purpose of the BookVerse website.

BookVerse is a static online bookstore platform designed to allow users to browse and explore a collection of books. The website provides a homepage with featured books and a Bootstrap carousel, a books page containing book information and status filtering, a gallery for viewing book covers and an Add Book form. Users can interact with the gallery modal, filter books by status and preview a selected cover image when completing the form. The website was developed using HTML5, CSS3, Bootstrap 5 and JavaScript.

---

## 4. Website Structure

Complete the table below by describing the purpose of each page.

| File | Purpose |
|---|---|
| `index.html` | Homepage containing the BookVerse navigation, featured book carousel and featured book cards. |
| `books.html` | Displays the BookVerse book collection in a responsive table and allows users to filter books by status. |
| `gallery.html` | Displays book covers in a responsive Bootstrap grid and allows users to open individual covers in a Bootstrap model. |
| `add.html` | Provides a form for entering new book information, including book details, condition, price, status and cover image upload. |

---

## 5. Project Folder Structure

Show the final structure of your `a1` folder.

TODO: Update this structure if your final project contains additional required files or folders.

```text
a1/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── scripts.js
│   └── images/
│       ├── 1.png
│       ├── 2.png
│       ├── 3.png
│       ├── 4.png
│       └── covers/
│           ├── 1.png
│           ├── 2.png
│           ├── 3.png
│           ├── 4.png
│           ├── 5.png
│           ├── 6.png
│           ├── 7.png
│           ├── 8.png
│           ├── 9.png
│           ├── 10.png
│           ├── 11.png
│           └── 12.png
├── index.html
├── books.html
├── gallery.html
├── add.html
├── README.md
└── process-evidence.md
```

## 6. Technologies Used

Complete the table below. Explain how each technology was used in your project.

| Technology | How it was used in this project |
|---|---|
| HTML5 | Used to create the structure and content of all four website pages using semantic HTML elements. |
| CSS3 | Used through the external style.css file to control the BookVerse colour scheme, typography, spacing, navigation, cards, gallery and other custom styling. |
| Bootstrap 5 | Used for responsive layouts, the navigation bar, carousel, grid system, cards, table, form controls, buttons and image modal. |
| JavaScript | Used to provide interactive functionality including image extension validation, image preview, gallery modal behaviour and book status filtering. |
| Google Fonts | Elms Sans and Righteous are used for the website typography. |
| Material Icons | Used for the BookVerse menu book icon in the navigation. |
| GitHub | Used to store the project and track development using Git commits. |
| Coreteaching server | Used to deploy the completed static website for assessment submission. |
| AI tools | Used during development to assist with coding, debugging, explanations and improvements. AI-assisted code was reviewed and tested before being submitted. |

## 7. Design and Layout

BookVerse uses a consistent visual design across all four pages.

The website uses a teal and orange colour scheme defined through CSS variables in the external stylesheet. The primary colours are based around teal, with darker and lighter teal variations and orange used as a secondary accent.

The website uses Elms Sans for general body text and Righteous for display and heading elements. Google Fonts are linked externally in each HTML page.

Material Icons are used to provide the menu_book icon next to the BookVerse brand name in the navigation.

Bootstrap 5 is used throughout the website for responsive layouts and components. The Bootstrap grid allows content to change its layout depending on the screen size. Bootstrap components are also used for the homepage carousel, responsive navigation, cards, table styling, forms and gallery modal.

Custom CSS is stored in the external assets/css/style.css file rather than using inline styling.

## 8. Required Features

Complete the table below by explaining where and how each required feature should be implemented.

Feature	Page	Explanation
Carousel	index.html	A Bootstrap carousel displays four featured book collection images with captions, indicators and previous/next controls.
Responsive book layout	index.html	Featured books are displayed using Bootstrap cards and responsive grid columns that change depending on screen size.
Book table	books.html	A Bootstrap responsive table displays book title, author, genre, condition, price and status.
Status filter	books.html	A dropdown allows users to filter the displayed books by Available, Reserved, Sold or All Books. JavaScript controls which table rows are displayed.
Gallery grid	gallery.html	Twelve book covers are displayed using a responsive Bootstrap grid.
Bootstrap image modal	gallery.html	Clicking a gallery image opens a Bootstrap modal containing a larger version of the selected book cover.
Add Book form	add.html	A form allows users to enter title, author, genre, publication year, ISBN, description, condition, price, cover image and status information.
Image validation	add.html	JavaScript checks the selected image file extension and only accepts JPG, JPEG, PNG, GIF and WEBP files.
Image preview	add.html	A valid selected image is displayed in the image preview area using JavaScript and FileReader.

## 9. JavaScript Functionality

Describe the JavaScript features that should be implemented in your website.

JavaScript feature	Page	How it works
Image extension validation	add.html	JavaScript checks the selected file extension against the accepted JPG, JPEG, PNG, GIF and WEBP formats. Invalid files are rejected and the file input is cleared.
Image preview	add.html	FileReader reads a valid selected image and displays it in the image preview element.
Gallery modal	gallery.html	JavaScript reads the selected gallery button's data-image and data-title attributes and updates the Bootstrap modal with the selected image.
Book status filter	books.html	JavaScript reads each table row's data-status attribute and shows or hides rows based on the selected filter value.

## 10. Form Validation

The Add Book form uses HTML5 validation and JavaScript.

The following fields are required:

Book Title
Author Name
Genre
Publication Year
ISBN
Description
Book Condition
Price
Cover Image
Status
Agreement checkbox

Each form field has an associated <label> using the for attribute, which matches the ID of the relevant input.

Different HTML5 input types are used depending on the information being collected. Text inputs are used for titles, authors, genres and ISBNs, a number input is used for the publication year and price, a textarea is used for the description, select elements are used for condition and status, and a file input is used for the cover image.

The price field uses min="0" and step="0.01" to allow non-negative prices with two decimal places.

The image input accepts:

.jpg
.jpeg
.png
.gif
.webp

JavaScript checks the selected file extension. If an invalid extension is selected, the file input is cleared and the user receives feedback.

When a valid image is selected, JavaScript uses FileReader to create a preview of the image before the form is submitted.

The form also uses the HTML5 required attribute and JavaScript form validity checking to ensure required information has been entered.

## 11. Accessibility and Usability

The website includes several accessibility and usability features.

Each page has a meaningful and unique title.
Semantic HTML elements such as header, nav, main, section, article and footer are used.
Form controls have associated labels.
Images include alternative text using the alt attribute.
Navigation is consistent across all four pages.
The current page is identified using the Bootstrap active navigation class.
The website uses readable fonts and clear headings.
Bootstrap responsive classes allow the website to adapt to different screen sizes.
The books table includes a caption for accessibility.
Table headings use scope="col".
Carousel controls include accessible labels.
Gallery images can be selected using buttons rather than only mouse interactions.
Form feedback is provided when invalid information is entered.
Bootstrap's responsive navigation allows the menu to collapse on smaller screens.

## 12. Testing and Validation

Complete this section after testing your website.

HTML Validation
File	Result	Notes
index.html	TODO: Pass / Issues found	TODO
books.html	TODO: Pass / Issues found	TODO
gallery.html	TODO: Pass / Issues found	TODO
add.html	TODO: Pass / Issues found	TODO

CSS Validation
File	Result	Notes
assets/css/style.css	TODO: Pass / Issues found	TODO

Functionality Testing
Feature tested	Result	Notes
Navigation links	TODO	TODO
Carousel	TODO	TODO
Gallery modal	TODO	TODO
Book status filter	TODO	TODO
Add Book form validation	TODO	TODO
Image preview	TODO	TODO
Deployed site links/assets	TODO	TODO

## 13. Deployment

Provide details of your deployed website.

Item	Details
Deployed website URL	TODO
Coreteaching server	TODO
Deployment folder	TODO
.htaccess location	TODO

The deployed website will be tested by opening each page through the Coreteaching URL and checking that the navigation, images, CSS and JavaScript load correctly. Interactive features including the carousel, gallery modal, status filter and Add Book form will also be tested on the deployed version rather than only on the local version.
## 14. Git and Development Process

Git was used throughout the development of the BookVerse website to track changes and progressively develop the project.

Commits were used to record meaningful development stages such as creating the website structure, implementing Bootstrap components, adding JavaScript functionality, improving styling, fixing errors and completing documentation.

The Git history provides evidence of progressive development rather than only showing the completed website.

Git commits relating to debugging and AI-assisted development are also referenced in process-evidence.md.

Before submission, this section should be updated to accurately describe the actual Git history.

## 15. AI Use Declaration

AI tools are required for this assessment.

Confirm the following:
- [Yes ] I used AI tools meaningfully during this assessment.
- [ Yes] I recorded meaningful AI use in `process-evidence.md`.
- [ Yes] I reviewed, tested, and adapted AI-assisted output.
- [ Yes] I can explain all AI-assisted code submitted.

AI tools were used meaningfully during the development of this assessment. AI assistance was used to help with coding, debugging, explanations and reviewing the implementation against the assessment requirements.

AI-assisted code was reviewed and adapted before being included in the project, and the submitted code was tested to ensure that it worked correctly.

I have reviewed the submitted HTML, CSS and JavaScript and can explain the key technologies and functionality used in the website.

Detailed AI usage records must be included in process-evidence.md.

## 16. Process Evidence

Confirm that your process evidence file has been completed.

Requirement	Completed?
process-evidence.md file included	Yes 
At least 2 debugging records included	TODO: Yes / No
At least 2 meaningful AI usage records included	TODO: Yes / No
Relevant commit links included	TODO: Yes / No

## 17. Known Issues or Limitations

List any known issues or limitations in your submitted project.

Issue or limitation	Explanation
Limitation == Static website	Book information is currently stored directly in the HTML and is not connected to a database or backend.

Limitation == Add Book form	The Add Book form validates and previews the entered information but does not permanently add a new book to the books table because this is a static front-end website.
