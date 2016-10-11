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
 * Assign a workout plan to a user
*/

include "../loginScript.php";
$link = databaseeditconnect("PASSWORD");

$ID = mysqli_escape_string($link, $_GET['id']);

$usersAssigned = mysqli_escape_string($link, $_GET['user']);
$usersAssigned = $usersAssigned . ",";

while ( 0 < (substr_count($usersAssigned, ","))){
    // Get info
    $username = substr($usersAssigned, 0, strpos($usersAssigned, ","));
    $usersAssigned = substr($usersAssigned, strpos($usersAssigned, ",") + 1);

    // Retrieve user's current assignments
    $assignedSet = sqldataitemexists("users", "AssignedSet", $link, "username", $username)[0];
    
    if ($assignedSet == false){
        $assignedSet = "";
    }

    // Update assignments
    $assignedSet = $assignedSet . $ID . ",";
    $userAssignOrder = "UPDATE users SET AssignedSet=\"$assignedSet\" WHERE username=\"$username\""; 
    $result = mysqli_query($link, $userAssignOrder);  //order executes  
    if ($result == false) {
        echo "  <div class = 'alert alert-danger' role='alert' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important;'><h1>Error.</h1><p>Error code: $userAssignOrder + $ID</p><br></div>";
    die();
    }
}

echo "<div class = 'alert alert-success' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important;'><h1>Success</h1><p>Plan assigned.</p><br></div>";
?>
