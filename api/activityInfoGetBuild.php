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
 * Returns selected activity for the create set page. Activity selected from suggestions based on query. 
*/

include "../loginScript.php";
$link = databaseviewconnect();

// Fetches info
$query = mysqli_escape_string($link, $_REQUEST["q"]);
$title = sqldataitemexists("activity", "title", $link, "id", $query)[0];
$id = $query;

// Builds HTML
$addedActivity = "<a  href='#searching' class='list-group-item asdfasdfasdf searchResults'  onclick='addSuggestedActivity(this)' data-name=\"$title\" data-id=\"$id\"> \"$title\" ($id)</a>";

echo $addedActivity;
?>
