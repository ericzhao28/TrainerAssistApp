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
 * Returns a list of non friends based on search query for finding and adding new people on the friends page
*/


// Connect to DB
include "../loginScript.php";
$link = databaseViewConnect();

// Get username
session_start();
$myUsername = mysqli_escape_string($link, $_SESSION['Username']);

// Get and process the query parameter from URL
$query = strtolower(mysqli_escape_string($link, $_REQUEST["q"]));
$suggested = "";

// Output "no suggestion" if no hint was found or output correct values 
if ($query == ""){
    echo $suggested === "" ? "<a href='#' class='list-group-item' > Please search again. </a>" : $suggested;
}

// Get already affiliated users
$affiliatedAlreadyString = sqldataitemexists("users", "Affiliated", $link, "username", $myUsername)[0];
$affiliatedAlready = array();
while ( 0 < (substr_count($affiliatedAlreadyString, ","))){
    $affiliatedAlready[] = substr($affiliatedAlreadyString, 0, strpos($affiliatedAlreadyString, ","));
    $affiliatedAlreadyString = substr($affiliatedAlreadyString, strpos($affiliatedAlreadyString, ",") + 1);
}

// Get already added users
$addedAlreadyString = sqldataitemexists("users", "Added", $link, "username", $myUsername)[0];
$addedAlready = array();
while ( 0 < (substr_count($addedAlreadyString, ","))){
    $addedAlready[] = substr($addedAlreadyString, 0, strpos($addedAlreadyString, ","));
    $addedAlreadyString = substr($addedAlreadyString, strpos($addedAlreadyString, ",") + 1);
}

// Cycle through matching users and adds them to response string 
$selectedUsers = sqlDataItemExists("users", "Username", $link, "", "", "Username LIKE '%" . $query . "%' OR FirstName LIKE '%" . $query . "%' OR LastName LIKE '%" . $query . "%'", true);
forEach($selectedUsers as $username) {
    $username = $username[0];
    // Verifies non affiliated status
    if ((!in_array(strtolower($username), $affiliatedAlready))&&(!in_array(strtolower($username), $addedAlready))&&(strtolower($username)!=$myUsername)){
        $suggested .= "  <a  href='#searching' class='list-group-item searchResults dynamicActiveInactive' data-name=\"$username\" onclick='addFriendFromSuggested(this)'> \"$username\"</a>";
    }
}

echo $suggested === "" ? "<a  href='#searching' class='list-group-item' > Please search again. </a>" : $suggested . "<script>updateSuggestedUsersHighlighting()</script>";

?>
