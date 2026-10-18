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

**Task Description:**  

**Tool Used:**  

**Prompt / Input:**  

**AI Output Summary:**  

**What You Accepted:**  

**What You Changed:**  

**Validation Performed:**  

**Issues Identified:**  

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
