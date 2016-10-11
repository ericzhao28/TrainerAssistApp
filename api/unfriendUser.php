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
 * Unfriend a user
*/

include "../databaseCalls.php";
$link = databaseeditconnect("PASSWORD");

$otherUser = mysqli_escape_string($link, $_GET['id']);
session_start();
$username = mysqli_escape_string($link, $_SESSION['Username']);

$otherUserAffiliations = sqldataitemexists("users", "Affiliated", $link, "Username", $otherUser)[0];
$otherUserRequested = sqldataitemexists("users", "Requested", $link, "Username", $otherUser)[0];
$myUserAffiliations = sqldataitemexists("users", "Affiliated", $link, "Username", $username)[0];
$myUserAdded = sqldataitemexists("users", "Added", $link, "Username", $username)[0];

// Remove yourself from their friends list
if (strpos($otherUserAffiliations, $username) !== false){
		$otherUserAffiliations = ltrim(str_replace(','.$username.',', ',', ','.$otherUserAffiliations),",");
}

// Remove yourself from their requested list
if (strpos($otherUserRequested, $username) !== false){
		$otherUserRequested = ltrim(str_replace(','.$username.',', ',', ','.$otherUserRequested),",");
}

// Remove them from your friends list
if (strpos($myUserAffiliations, $otherUser) !== false){
		$myUserAffiliations = ltrim(str_replace(','.$otherUser.',', ',', ','.$myUserAffiliations),",");
}

// Remove them from your added list
if (strpos($myUserAdded, $otherUser) !== false){
		$myUserAdded = ltrim(str_replace(','.$otherUser.',', ',', ','.$myUserAdded),",");
}

// Issue requests
$updateTheirAff = "UPDATE users SET Affiliated=\"$otherUserAffiliations\" WHERE Username=\"$otherUser\""; 
$updateTheirRequests = "UPDATE users SET Requested=\"$otherUserRequested\" WHERE Username=\"$otherUser\""; 
$updateMyAff = "UPDATE users SET Affiliated=\"$myUserAffiliations\" WHERE Username=\"$username\""; 
$updateMyAdd = "UPDATE users SET Added=\"$myUserAdded\" WHERE Username=\"$username\""; 

echo $updateTheirAff . "|" . $updateTheirRequests . "|" . $updateMyAff . "|" . $updateMyAdd;
$result = mysqli_query($link, $updateTheirAff);    
$result1 = mysqli_query($link, $updateMyAff);    
$result2 = mysqli_query($link, $updateMyAdd);   
$result3 = mysqli_query($link, $updateTheirRequests);      

// Check for errors
if (($result == false)) {
    echo "  <div class = 'alert alert-danger' role='alert' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important;'><h1>Error.</h1><p>Error code:</p><br></div>";
    die();
}
?>
