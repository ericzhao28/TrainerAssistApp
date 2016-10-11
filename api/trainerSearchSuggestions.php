<?php
/* 
Copyright (c) 2016, Eric Zhao, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
*/


/*
 * Purpose:
 * Returns a list of activities and workout plans based on search from trainer search page (which returns even activities in contrast to the client search)
*/

include "../databaseCalls.php";
$link = databaseViewConnect();

// Get and process the query parameter from URL
$query = strtolower(mysqli_escape_string($link, $_REQUEST["q"]));
$suggested = "";

// Returns list of sets AND activities based on query 

if ($query == ""){
  // Output "no suggestion" if no hint was found or output correct values 
  echo $suggested === "" ? "<a href='#' class='list-group-item' > Please search again. </a>" : $suggested;
}

// Cycle through matching sets and adds them to response string 
$selectedSets = sqlDataItemExists("sets", "id", $link, "", "", "id LIKE '%" . $query . "%' OR title LIKE '%" . $query . "%'", true);
forEach($selectedSets as $id) {
  $id = $id[0];
  $setTitle = sqlDataItemExists("sets", "title", $link, "id", $id)[0];
  $setAuthor = sqlDataItemExists("sets", "user", $link, "id", $id)[0];
  $setID = $id;
  $suggested .= "<a href='#' class='list-group-item searchResults' onclick = \"goToWorkoutPlan(this)\" data-id=\"$setID\"> \"$setTitle\" - a plan by $setAuthor ($setID)</a>";
}

// Cycle through matching activities and adds them to response string 
$selectedActivities = sqlDataItemExists("activity", "id", $link, "", "", "id LIKE '%" . $query . "%' OR title LIKE '%" . $query . "%'", true);
forEach($selectedActivities as $id) {
  $id = $id[0];
  $actTitle = sqlDataItemExists("activity", "title", $link, "id", $id)[0];
  $actAuthor = sqlDataItemExists("activity", "user", $link, "id", $id)[0];
  $actID = $id;
  $suggested .= "<a href='#' class='list-group-item searchResults' onclick = \"goToExercise(this)\" data-id=\"$actID\"> \"$actTitle\" - a activity by $actAuthor ($actID)</a>";
}

$suggested .= "<script>update();</script>";

echo $suggested;

?>
