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
 * In the create activity page, returns all activities matching search query for duplicating the activity
*/

include "../loginScript.php";
$link = databaseViewConnect();

// Get and process the query parameter from URL
$query = strtolower(mysqli_escape_string($link, $_REQUEST["q"]));
$suggested = "";

// Output "no suggestion" if no hint was found or output correct values 
if ($query == ""){
	echo $suggested === "" ? "<a href='#' class='list-group-item' > Please search again. </a>" : $suggested;
}

// Cycle through matching activities and adds them to response string 
$selectedActivities = sqlDataItemExists("activity", "id", $link, "", "", "id LIKE '%" . $query . "%' OR title LIKE '%" . $query . "%'", true);
forEach($selectedActivities as $id) {
	$id = $id[0];
	$activityTitle = sqlDataItemExists("activity", "title", $link, "id", $id)[0];
	$activityAuthor = sqlDataItemExists("activity", "user", $link, "id", $id)[0];
	$activityID = $id;

	$suggested .= "<a href=\"#\" class='list-group-item searchResults' onclick='replicateActivity(this, false, true)' data-id=\"$activityID\"> \"$activityTitle\" - an exercise by $activityAuthor ($activityID)</a>";
}

$suggested .= "<script>update();</script>";

echo $suggested;

?>
