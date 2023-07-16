# iCalendar Generator for TARUMT Student Timetable
Generate iCalendar (.ics) file from the student timetable of Tunku Abdul Rahman University of Management of Technology (TARUMT)

## What is this?
Experience convenience with the "TARUMT Timetable Generator" app, fully open source on GitHub. It automatically retrieves your timetable from Tunku Abdul Rahman University of Management and Technology (TARUMT)'s app, generating an iCalendar (.ics) file. Import it effortlessly into Google Calendar and other compatible apps for seamless organization of your class timetable.

## How to use?
Click the dashboard at the top of this website, and log in to the dashboard using your User ID and Password that you used to log in to TARUMT's Intranet and TARC App. After a successful login, please read the disclaimer and click the "Generate" button to generate the iCalendar (.ics) file.

## How is it working?
It will require users to log in with their TARCApp user ID and password on this website. The website will then request the following details from TARCApp:
1. Token
2. Student Name
3. Student Email
4. Student ID

Once the authorization token is granted, users will be redirected to the Dashboard, where they can generate the iCalendar (.ics) file. When the user clicks the generate button, the website will once again request the timetable details from TARCApp using the previously granted token. Please note that a random Device ID will be generated for login purposes and stored locally on your browser.

## I'm afraid of my personal data being breached
Rest assured that your personal data will not be stored on our server. The code for this website is open source and available on GitHub. We only make **DIRECT REQUESTS** to TARCApp's server **WITHOUT STORING ANY DATA ON SERVER**. If you have concerns about the potential breach of your personal data, we advise against using our website to generate the iCalendar file. Please note that this website is **NOT** affiliated with Tunku Abdul Rahman University of Management and Technology (TARUMT).

## What language has been used?
The backend of this website is built using plain **PHP**.
For the frontend, Bootstrap Studio was utilized to create an appealing user interface with the Bootstrap framework.

## How can the iCalendar (.ics) file be used?
The iCalendar (.ics) file format can be applied to various calendar applications and services. Some common uses include importing the file into:
1. Google Calendar
2. Microsoft Outlook
3. Apple Calendar (formerly iCal)
Any other calendar application or service that supports the iCalendar format (ICS). 
Users are advised to import the iCalendar (.ics) file into Google Calendar while logged in with their TARUMT Student Email (@student.tarc.edu.my). They can download the Google Calendar app or sync their phone's calendar apps with their TARUMT Student Email (@student.tarc.edu.my) for seamless integration.

## The content of the events inside iCalendar (.ics)
It contains the following :
1. Class Name (e.g. Introduction to IT)
2. Class Type (e.g. T for Tutorial)
3. Class Code (e.g. AJEL1713)
4. Class Lecturer Name
5. Class Location (e.g. K101 Block K)

## Screenshot
![image](https://github.com/samleong123/tarumt-timetable-generator/assets/58818070/fa1e4339-6448-45f5-b2a7-8795b82e22be)
