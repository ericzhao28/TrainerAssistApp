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
 * Add a user as a friend, potentially as an affiliation
*/

session_start();
include "../loginScript.php";
$link = databaseeditconnect("PASSWORD");
$rawUsersToAdd = json_decode(file_get_contents('php://input'), true);


$usersToAdd = $rawUsersToAdd['friendsAdded'];

// Get from DB
$myUsername = mysqli_escape_string($link, $_SESSION['Username']);

// Get information to form added + requested array 
$myaddedString = sqldataitemexists("users", "Added", $link, "username", $myUsername)[0];
$myrequestedString = sqldataitemexists("users", "Requested", $link, "username", $myUsername)[0];
$addedUsers = array();
$requestedUsers = array();

// Get array of added users for affiliation check
while ( 0 < (substr_count($myaddedString, ","))){
    $myAddedUsers[] = substr($myaddedString, 0, strpos($myaddedString, ","));
    $myaddedString = substr($myaddedString, strpos($myaddedString, ",") + 1);
}

// Get array of requested users for affiliation check
while ( 0 < (substr_count($myrequestedString, ","))){
    $myRequestedUsers[] = substr($myrequestedString, 0, strpos($myrequestedString, ","));
    $myrequestedString = substr($myrequestedString, strpos($myrequestedString, ",") + 1);
}

// Cycle through users in string
forEach($usersToAdd as $username){
    // Get user's added + requested
    $addedString = sqldataitemexists("users", "Added", $link, "username", $username)[0];
    $requestedString = sqldataitemexists("users", "Requested", $link, "username", $username)[0];
    while ( 0 < (substr_count($addedString, ","))){
        $addedUsers[] = substr($addedString, 0, strpos($addedString, ","));
        $addedString = substr($addedString, strpos($addedString, ",") + 1);
    }
    while ( 0 < (substr_count($requestedString, ","))){
        $requestedUsers[] = substr($requestedString, 0, strpos($requestedString, ","));
        $requestedString = substr($requestedString, strpos($requestedString, ",") + 1);
    }

    // Add self to user added list
    if (!in_array($myUsername, $requestedUsers))
    {
        $requestedString2 = sqldataitemexists("users", "Requested", $link, "username", $username)[0];
        if ($requestedString2 == false){
            $requestedString2 = "";
        }
        $requestedString2 = $requestedString2 . $myUsername . ",";
        $userRequestQuery = "UPDATE users SET Requested =\"$requestedString2\" WHERE username=\"$username\""; 
        $result = mysqli_query($link, $userRequestQuery);  //order executes  
        if ($result == false) {
            echo "  <div class = 'alert alert-danger' role='alert' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important;'><h1>Error.</h1><p>Error code:</p><br></div>";
            die();
        }   
    }

    if (!in_array($username, $myAddedUsers)){
        // Add user to self added list
        $addedString2 = sqldataitemexists("users", "Added", $link, "username", $myUsername)[0];
        if ($addedString2 == false){
            $addedString2 = "";
        }
        $addedString2 = $addedString2 . $username . ",";
        $userAddQuery = "UPDATE users SET Added =\"$addedString2\" WHERE username=\"$myUsername\""; 
        $result = mysqli_query($link, $userAddQuery);  //order executes  
        if ($result == false) {
            echo "  <div class = 'alert alert-danger' role='alert' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important;'><h1>Error.</h1><p>Error code:</p><br></div>";
            die();
        }
    }

    // Check if need to add affiliation
    if ((in_array($username, $myRequestedUsers))&&(in_array($myUsername, $addedUsers))){
        echo "yes";
        // Get existing affiliations list
        $myAffiliations = sqldataitemexists("users", "Affiliated", $link, "username", $myUsername)[0];
        $userAffiliations = sqldataitemexists("users", "Affiliated", $link, "username", $username)[0];
        if ($myAffiliations == false){
            $myAffiliations = "";
        }        
        if ($userAffiliations == false){
            $userAffiliations = "";
        }
        $myAffiliationsString = $myAffiliations;
        while ( 0 < (substr_count($myAffiliationsString, ","))){
            $myAffiliationsArr[] = substr($myAffiliationsString, 0, strpos($myAffiliationsString, ","));
            $myAffiliationsString = substr($myAffiliationsString, strpos($myAffiliationsString, ",") + 1);
        }

        if (!in_array($username, $myAffiliationsArr)){
            // Update affiliations list
            $userAffiliations = $userAffiliations . $myUsername . ",";
            $myAffiliations = $myAffiliations . $username . ",";
        }

        // Update DB
        $myAffiliationQuery = "UPDATE users SET Affiliated=\"$myAffiliations\" WHERE username=\"$myUsername\""; 
        $userAffiliationQuery = "UPDATE users SET Affiliated=\"$userAffiliations\" WHERE username=\"$username\""; 
        echo $myAffiliationQuery . "||" . $userAffiliationQuery . "//";

        // Get result
        $myResult = mysqli_query($link, $myAffiliationQuery);  //order executes  
        $result = mysqli_query($link, $userAffiliationQuery);  //order executes  

        // Check for errors
        if (($result == false)||($myResult == false)) {
            echo "  <div class = 'alert alert-danger' role='alert' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important;'><h1>Error.</h1><p>Error code:</p><br></div>";
            die();
        }

    }

}
?>
