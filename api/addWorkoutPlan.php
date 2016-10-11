<?php
/* 
Copyright (c) 2015, Eric Zhao, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
*/

/*
 * Purpose:
 * Add the workout plan to the current user, saving it to their assigned list
*/

// Connect to DB
include "../loginScript.php";
$link = databaseeditconnect("PASSWORD");

// Get form info
$id = mysqli_escape_string($link, $_GET['id']);
session_start();
$username = mysqli_escape_string($link, $_SESSION['Username']);

// Get the assigned sets
$assignmentraw = sqldataitemexists("users", "AssignedSet", $link, "username", $username)[0];

// Updated assigned set with added $id
$assignmentraw = $assignmentraw . "$id,";
$userAssignOrder = "UPDATE users SET AssignedSet=\"$assignmentraw\" WHERE username=\"$username\""; 
$result = mysqli_query($link, $userAssignOrder);  

// Check for errors and release final HTML
if ($result == false) {
    echo "  <div class = 'alert alert-danger' role='alert' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important;'><h1>Error.</h1><p>Error code:</p><br></div>";
    die();
}

echo "  <div class = 'alert alert-warning' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important;'><h1>Success</h1><p>This workout plan is now assigned to you. Refresh to update.</p><br></div>";
?>
