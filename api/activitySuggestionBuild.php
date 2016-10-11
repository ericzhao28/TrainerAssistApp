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
 * Return a list of activities matching the query from the create set form, to be added to the pool of activities for use in creating a new workout plan
*/

include "../loginScript.php";
$link = databaseViewConnect();

// Get and process the query parameter from URL
$query = strtolower(mysqli_escape_string($link, $_REQUEST["q"]));
$suggested = "";

// Returns list of activities to add to create set based on query 

if ($query == ""){
  	// Output "no suggestion" if no hint was found or output correct values 
	echo $suggested === "" ? "<a href='#' class='list-group-item' > Please search again. </a>" : $suggested;
}

// Cycle through matching activities and adds them to response string 
$selectedActivities = sqlDataItemExists("activity", "id", $link, "", "", "id LIKE '%" . $query . "%' OR title LIKE '%" . $query . "%'", true);
forEach($selectedActivities as $id) {
	$id = $id[0];
	$activityTitle = sqlDataItemExists("activity", "title", $link, "id", $id)[0];
	$activityAuthor = sqlDataItemExists("activity", "user", $link, "id", $id)[0];
	$activityID = $id;
	$suggested .= "<a href=\"#searching\" class='list-group-item searchResults dynamicActiveInactive' data-name=\"$activityTitle\" onclick='addSuggestedActivity(this)' data-id=\"$activityID\"> \"$activityTitle\" by $activityAuthor ($activityID)</a>";
}

$suggested .= "<script>update();</script>";

echo $suggested;

?>
