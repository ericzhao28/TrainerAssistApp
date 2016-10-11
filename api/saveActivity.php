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
 * Saves newly created actvitiy to database
*/

include "../activity.php";
include "../loginScript.php";

$link = databaseviewconnect();

// Retrieve form fields
$replacedID = mysqli_escape_string($link, $_POST['replace']);
$title = mysqli_escape_string($link, $_POST['title']);
$user = mysqli_escape_string($link, $_SESSION['Username']);
$desc = mysqli_escape_string($link, $_POST['description']);
$video = mysqli_escape_string($link, $_POST['youtubeLink']);
$step1 = mysqli_escape_string($link, $_POST['step1']);
$step2 = mysqli_escape_string($link, $_POST['step2']);
$step3 = mysqli_escape_string($link, $_POST['step3']);
$step4 = mysqli_escape_string($link, $_POST['step4']);
$step5 = mysqli_escape_string($link, $_POST['step5']);
$muscleString = $_POST['muscleString'];

// Build activity object based on whether or not replacement is active
if ((mysqli_escape_string($link, ($_POST['replace'])) != "")&&((mysqli_escape_string($link, ($_SESSION['Username']))) == (sqldataitemexists("activity", "user", $link, 'id', $replacedID)[0]))){
    $activity = new Activity($replacedID, $title, $user, $desc, $video, $step1, $step2, $step3, $step4, $step5,$muscleString); 
} 
else {
    $activity = new Activity('', $title, $user, $desc, $video, $step1, $step2, $step3, $step4, $step5,$muscleString, true); 
}

mysqli_close($link);

// Save activity to DB
$saveErrors = $activity->saveActivity();

// Redirect if no errors
$id = $activity->getID();
if ($saveErrors == false){ 
  header("Location: https://www.whimmly.com/TrainerAssist/createActivity?newid=$id");
} else {
  header("Location: https://www.whimmly.com/TrainerAssist/createActivity?error=yes&errorDetails=" . $saveErrors);
}

?>
