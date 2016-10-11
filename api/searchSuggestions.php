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
 * Returns a list of workout plans based on search query from client search page
*/

include "../databaseCalls.php";
$link = databaseViewConnect();

// Get and process the query parameter from URL
$query = strtolower(mysqli_escape_string($link, $_REQUEST["q"]));
$suggested = "";

// Returns list of sets based on query 
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
	$suggested .= "<a href='#' class='list-group-item searchResults' onclick = \"goToExercise(this)\" data-id=\"$setID\"> \"$setTitle\" - a plan by $setAuthor ($setID)</a>";
}

echo $suggested;
?>
