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
 * Offer a list of friends to suggest a workout plan to, used in create set (and possibly recommending workout to friends page)
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

// Cycle through matching users and adds them to response string 
$selectedUsers = sqlDataItemExists("users", "Username", $link, "", "", "Username LIKE '%" . $query . "%' OR FirstName LIKE '%" . $query . "%' OR LastName LIKE '%" . $query . "%'", true);
forEach($selectedUsers as $username) {
    $username = $username[0];
    // Verifies affiliation status
    if (in_array(strtolower($username), $affiliatedAlready)){
        $suggested .= "  <a  href='#searching' class='list-group-item searchResults dynamicActiveInactive' data-name=\"$username\" onclick='addUserSuggestion(this)'> \"$username\"</a>";
    }
}

echo $suggested === "" ? "<a  href='#searching' class='list-group-item' > Please search again. </a>" : $suggested;

// Trigger update
$suggested .= "<script>updateUserSuggestions();</script>";


?>
