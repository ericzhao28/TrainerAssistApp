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
 * Saves newly created set to database
*/

include "../loginScript.php";
include "../set.php";

// Database setup 	
$link = databaseEditConnect("PASSWORD");
mysqli_select_db($link, "trainerassist");

// Retrieve form fileds
$masterJSONObject = json_decode($_POST['dataString'], true); 

$activityComp = $masterJSONObject['dataArrayForJSON'];
$title = mysqli_escape_string($link, $_POST['title']);
$user = mysqli_escape_string($link, $_SESSION['Username']);
$usersAssigned = $masterJSONObject['selectedUsers'];
$date = mysqli_escape_string($link, $_POST['date']);

// Generate set and save
$createdSet = new Set('', json_encode($activityComp), $title, $user, $date, $usersAssigned);
$id = $createdSet->getID();
$error = $createdSet->saveSet();


// Process users assigned
forEach($usersAssigned as $userAssigned){
  $userAssigned = mysqli_escape_string($link, $userAssigned);
  $assignedSet = sqldataitemexists("users", "AssignedSet", $link, "username", $userAssigned, null)[0];
  if ($assignedSet == false){
      $assignedSet = "";
  }
  // Update assignments
  $assignedSet = $assignedSet . $id . ",";
  $userAssignOrder = "UPDATE users SET AssignedSet=\"$assignedSet\" WHERE username=\"$userAssigned\""; 
  $result = mysqli_query($link, $userAssignOrder);  //order executes  
}

// Redirect plus error tests
if ($error == false){
  header("Location: https://www.whimmly.com/TrainerAssist/createSet?newid=$id");
} else {
  header("Location: https://www.whimmly.com/TrainerAssist/createSet?error=yes&errordetails=" . $error);
}

	
?>
