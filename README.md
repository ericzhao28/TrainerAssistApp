# Try demo
Try the demo here:
https://www.whimmly.com/TrainerAssist
Desktop             |  Mobile
:-------------------------:|:-------------------------:
![](/screenshosts/desktop.png)  |  ![](/screenshots/mobileCollage.jpg)

# TrainerAssist
A php-based web app that digitizes the job of personal trainers. The TrainerAssist online dashboard allows you to build, view, share, and monitor workout plans. The mobile compatible site supports the dynamic creation of exercises and workout plans. Workout plans can be shared with "friends" and other users, can be searched up using a muscle selection tool, or found via traditional search query. 

## Features
* Workout plans can be viewed on mobile, tablet, desktop, and also printed
* Workout app allows easy access to exercise instructions and video demonstrations
* Muscle search tool allows users to select muscles they'd like to focus on and suggests workouts
* Users can add friends and trainers, and suggest/share workouts with other users
* Quick workout plan creation tool allows cuts out the repetitive parts of writing out workout plans
* Reusable/contribute-able library of exercises
* Cross-platform and mobile-compatible because web apps are awesome

## Guide to the pages
* /login
Login page: default credentials are for testUser: username: testUser, password: testtesttest
* /register
Registration page
* /appIndex
Home page, where users can choose to create workout plans or workout themselves
* /friends
View friends, add users, accept requests and send friend requests
* /home 
Workout home dashboard
* /search
Find a workout using either traditional search query or muscle selection tool
* /assigned
View your saved workout plans, and add/remove plans
* /exercise
Try the workout plan
* /tableDisplay
Print display for workout plans
* /settings
Change/view your settings
* /trainer
Workout plan creation home dashboard
* /createSet
Create workout plans using this quick tool
* /createActivity
Create/modfiy/duplicate exercises using this tool
* /searchTrainer
Search for workout plans and exercises, or view your authored creations

## Installation

Just make sure you have mysql and PHP installed. You'll need to create the proper tables, but table schema information can be found in the api files.

# License

Copyright (c) 2016, Eric Zhao, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
