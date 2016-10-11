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
 * Removes workout plan from a user's assigned list
*/

include "../loginScript.php";

// Remove from assignment
$link = databaseeditconnect("PASSWORD");
$id = mysqli_escape_string($link, $_GET['id']);
session_start();
$username = mysqli_escape_string($link, $_SESSION['Username']);

// Retrieve assignment
$assignmentraw = sqldataitemexists("users", "AssignedSet", $link, "username", $username)[0];

// Filter through assignment string
while (strpos($assignmentraw, $id) !== false){
    $assignmentraw = substr($assignmentraw, 0, strpos($assignmentraw, $id)) . substr($assignmentraw, strlen($id) + 1 + strpos($assignmentraw, $id));   
}

// Update assignment
$userAssignOrder = "UPDATE users SET AssignedSet=\"$assignmentraw\" WHERE username=\"$username\""; 
$result = mysqli_query($link, $userAssignOrder);  //order executes  

// Return results and errors
if (($result == false)) {
    echo "  <div class = 'alert alert-danger' role='alert' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important;'><h1>Error.</h1>
        <p>Error code:</p><br></div>";die();
}
echo "  <div class = 'alert alert-warning' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important;'><h1>Success</h1><p>Set removed.</p><br></div>";
?>
