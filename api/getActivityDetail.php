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
 * Returns the specific part of an activity for API use in the activity creation form, while duplicating or whatever
*/

// DB Setup
include "../loginScript.php";
$link = databaseEditConnect("PASSWORD");

// Get specific detail
$id = mysqli_escape_string($link, $_GET['id']);
$type = mysqli_escape_string($link, $_GET['type']);
echo sqlDataItemExists("activity", $type, $link, "id", $id)[0];
return sqlDataItemExists("activity", $type, $link, "id", $id)[0];   
?>
