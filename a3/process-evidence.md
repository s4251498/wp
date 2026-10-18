# Process Evidence Log

This file combines:
1. Debugging records
2. AI (e.g., Copilot/ChatGPT) usage logs

You must maintain this file throughout development.

---

## General Instructions
- Record entries as you work (not at the end)
- Be honest and specific
- Link to commits.Each debugging record must include at least one related GitHub commit 
(using commit hash and URL).
- Superficial or fabricated entries will not receive marks

---

# 🔧 Section 1: Debugging Records

## Bug 1

**Date Identified:**  
(e.g., 15/03/2026)

**Date Fixed:**  
(e.g., 15/03/2026)

**File:**  
(e.g., about.html)

**Related Commit:**
(e.g., abc1234)

**Symptom:**  
What went wrong?

**Steps to Reproduce:**  
How can the issue be triggered?

**Root Cause:**  
Why did the issue occur?

**Fix:**  
What did you change?

**Verification:**  
How did you confirm the fix?

---

## Bug 2

**Date Identified:**  

**Date Fixed:**  

**File:**  

**Related Commit:**  

**Symptom:**  

**Steps to Reproduce:**  

**Root Cause:**  

**Fix:**  

**Verification:**  

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
`node --check a3/assets/js/scripts.js` passed, `git diff --check` passed after a whitespace correction, and the new connection file was inspected to confirm it reads configuration from environment variables instead of containing a password. PHP syntax and database behavior remain unverified because PHP/MySQL are not installed or configured in this workspace.

**Issues Identified:**  
The local environment has no PHP runtime, so the PHP includes cannot yet be linted or exercised here. The copied JavaScript features still need browser testing when their pages are implemented. No live deployment credential or local database setup was invented.

**Related Commit:**
`e2dc298` — https://github.com/s4251498/wp/commit/e2dc298

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
