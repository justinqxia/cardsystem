# cardsystem
Digital card sign-in/sign-out system for the Indiana Academy

Description:
As a boarding school for high schoolers, the Indiana Academy has basic legal requirements for ensuring the safety of its students
Thus, the Academy currently uses a sign-in/sign-out system involving physical cards, about the same size as those "Do Not Disturb" signs at hotels
**********************NOTE: Add in picture of card***********************************
When leaving the building, students have to filling out these cards, indicating the date, destination, companion, signout time, and expected return time.
These cards are then given to the front desk worker, who puts these cards into slots behind the front desk.
When signing back into the building, the front desk worker gets the student's card, and fills out the actual sign in time and initials the card.
We are designing a digital version of that system, so that the students can fill out the information on a website.
The goals are the increase simplicity and reduce time spent at the front desk.

Types of files:
Almost all of the .csv files are created for each student. These files contain a record of every time this student has signed out.
The cards.csv file is used to keep track of who is currently signed out, and holds the signout information for each student
The .php files are used for managing the website, where students can fill out their cards, and it gets stored in a database
The .py files are run on the computer connected to the magnetic stripe reader, which pulls information from the database and stores it in the .csv files

Usage Procedure:
-Student fills out information through a website, such as destination and expected return time
-Student then comes to the front desk and swipes their Ball State ID at the magnetic stripe reader in order to sign out
-Upon signing back into the building, student then swipes their card again at the front desk

<img width="1177" alt="Screen Shot 2022-07-21 at 8 51 20 PM" src="https://user-images.githubusercontent.com/73600482/180338663-96f81550-1ca3-467e-80bd-4630c15b6b83.png">


Requirements:
-Create system for inputing destination, companion, and estimated return time.
-Could possibly have the app/webstie automatically fill out the date and sign-out time
-Can propose changes remotely which can be approved by the front desk worker

Beta Testing change notes:
-Make website more mobile friendly/possibly develop an app
-Add some sort of indicator for successful swipes

Hardware:
We began developing a physical housing for an Arduino, which would set off a light to indicate if the student had signed in/out correctly or not. The housing has two green lights and a red light, along with an LED display. The two green lights would indicate whether the student was leaving or returning, and the LED display would show what kind of error if the red light turned on.

Indexes for cards
0- ID number
1- First Name
2- Last Name
3- Email
4- Floor
5- Card
6- Destination
7- Date
8- Sign-out Time
9- Expected Return Time
10- Actual Return Time
11- Companion
12- Special Permission
13- Status
