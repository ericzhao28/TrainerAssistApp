<?php

include "loginScript.php";
global $pagetype;
$link = databaseviewconnect();

// Get alerts
if (isset($_GET['newid'])) {
  global $alert;
  $num = mysqli_escape_string($link, $_GET['newid']);
  $alert = "        <div class = 'row alert alert-warning' role='alert' style = 'padding-left:7%; '>
  <h1>Activity Added</h1>
  <p>Your new set's identification number is " . $num . ".</p>
  
</div>";
} else {
  global $alert;
  $alert = "";
}

// Get errors
if (isset($_GET['error'])) {
  global $alert;
  $num = mysqli_escape_string($link, $_GET['newid']);
  $alert = "        <div class = 'row alert alert-danger' role='alert' style = 'padding-left:7%; '>
  <h1>Error.</h1>
  <p>Something went wrong. Try again.</p>
  
</div>";
} else {
  global $error;
  $error = "";
}


?>
<!--
Copyright (c) 2015, Eric Zhao, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>TrainerAssist</title>
  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/animate.css" type="text/css">
  <link href = "css/styless.css" rel = "stylesheet" type="text/css">
  <!-- Custom CSS -->
  <link rel="apple-touch-icon-precomposed" href="../img/squarelogo.png">
  <link rel="icon" href="../img/squarelogo.png">
  <!-- Custom Fonts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
  <script src="https://www.whimmly.com/TrainerAssist/js/hoverintent.js"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
  <link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
  <style>
    .bodyhide{
      background-color:#ffa500 !important;
    }
  </style>
</head>
<body style = "overflow-x:hidden;"><canvas id = "successCanvas" style = "position:absolute; z-index:0; width:0px;" height="400"></canvas> <div class="loadingScreen" style = "background-color:#ffae19 !important;"></div>
  <div class = "top" onclick="goToAppHome()" id = "topper" style = "background-color:#ffa500 !important;"><a style = "width:100%; text-align:center;" href = "home"> </a></div>

  <div class = 'alert alert-warning' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important; display:none;' id = "alert">
    <h1>Success</h1>
    <p>Database updated. </p>
    <br>
  </div>


  <div class = "panel-body" style="color:#808080; padding-left:3%; padding-right:3%;" >
    <div class = "container-fluid">
      <h1 class = "page-header nicepadding title" style = "color:#ffa500; padding-left:32px; padding-right:32px; text-align:center; border-bottom-width:0px;"> Friends</h1>
   

   
        <div class = "col-sm-3">
          <h1 class = "page-header nicepadding largeSearch" style = "color:rgb(128, 128, 128); padding-left:32px; padding-right:32px; text-align:center; margin-bottom:0px;"> Add a Friend</h1>
          <br><p class = "stepText" style = "text-align:center !important;">
         Both you and your friends must add each other.
          <br>
        </p>
      </div>

      <div class = "col-sm-3">
        <ul class="list-group">
          <h1 class = "page-header nicepadding largeSearch" style = "color:rgb(128, 128, 128); padding-left:32px; padding-right:32px; text-align:center; margin-bottom:20px;">Pending Requests</h1>

<?php

$link = databaseViewConnect();
$suggested = "";

// Get username
session_start();
$myUsername = $_SESSION['Username'];

// Builds up array of adds
$peopleWhoRequestedString = sqldataitemexists("users", "Requested", $link, "Username", $myUsername)[0];
$peopleWhoRequested = array();
while ( 0 < (substr_count($peopleWhoRequestedString, ","))){
  $peopleWhoRequested[] = substr($peopleWhoRequestedString, 0, strpos($peopleWhoRequestedString, ","));
  $peopleWhoRequestedString = substr($peopleWhoRequestedString, strpos($peopleWhoRequestedString, ",") + 1);
}

// Builds up array of affiliated friends
$myAffiliatedFriendsString = sqldataitemexists("users", "Affiliated", $link, "Username", $myUsername)[0];

$myAffiliatedFriends = array();
while ( 0 < (substr_count($myAffiliatedFriendsString, ","))){
  $myAffiliatedFriends[] = substr($myAffiliatedFriendsString, 0, strpos($myAffiliatedFriendsString, ","));
  $myAffiliatedFriendsString = substr($myAffiliatedFriendsString, strpos($myAffiliatedFriendsString, ",") + 1);
}

// If both requested and not affiliated, echoes HTML
forEach($peopleWhoRequested as $name) {
  if (!in_array(strtolower($name), $myAffiliatedFriends)){
    $suggested .= "  <a  href='#top' onclick='addFriendFromRequested(this)' class='list-group-item searchResults ' data-name=\"$name\" > \"$name\"</a>";
  }
}

// Output "no suggestion" if no users found
if ($suggested == ""){
  echo $suggested === "" ? "<a href='#' class='list-group-item' > None. </a>" : $suggested;
} else {
  echo $suggested;
}

?>
        </ul>
      </div>
      <div class = "col-sm-3">
        <h1 class = "page-header nicepadding largeSearch" style = "color:rgb(128, 128, 128); padding-left:32px; padding-right:32px; text-align:center; margin-bottom:20px;"> Search Users</h1>
        <input type="hidden" id = "userString" name="userString" value=""/>
        <input type="text" id="txt1" onkeyup="searchForNonFriends(this.value)" style = "width:100%; margin-bottom:0px;">
        <ul class="list-group" id="searchForNonFriends" style = "margin-bottom:0px;">
        </ul>
        <a style = "width:100%; border-top-left-radius:0px; border-top-right-radius:0px; border-bottom-left-radius:10px; border-bottom-right-radius:10px; display:none;" onclick = "submitUserChange()" value = "Sent" name="submit"  href="#top" id = "addUser" class="btn btn-info">Add Users</a>
      </div>
      <div class = "col-sm-3">
        <h1 class = "page-header nicepadding largeSearch" style = "color:rgb(128, 128, 128); padding-left:32px; padding-right:32px; text-align:center; margin-bottom:20px;"> Added Friends</h1>

<?php

$link = databaseViewConnect();

$suggested = "";

// Get array of affiliated users
$myAffiliatedFriendsString = sqldataitemexists("users", "Affiliated", $link, "Username", $myUsername)[0];
$myAffiliatedFriends = array();
while ( 0 < (substr_count($myAffiliatedFriendsString, ","))){
  $myAffiliatedFriends[] = substr($myAffiliatedFriendsString, 0, strpos($myAffiliatedFriendsString, ","));
  $myAffiliatedFriendsString = substr($myAffiliatedFriendsString, strpos($myAffiliatedFriendsString, ",") + 1);
}

// Echo out html if master username file overlaps with affiliated users
forEach($myAffiliatedFriends as $name) {
  $suggested .= "  <a href=\"#\" class='list-group-item asdfasdfasdf largesearchResults' onclick=\"unfriendUser(this)\" data-id=\"$name\"> $name </a></a> ";
  
}

// Output "no suggestion" if no users found
if ($suggested == ""){
  echo $suggested === "" ? "<a href='#' class='list-group-item' > None. </a>" : $suggested;
} else {
  echo $suggested;
}

?>
      
      </div>

    
 
</div>
</div>
<script src="js/script.js"></script><script src="js/tourGenerator.js"></script>

<script type="text/javascript">
// Begin friend tracking object
var friendTracker = {friendsAdded: []};

// In the list of suggested users, make sure to highlight any users that are already added
function updateSuggestedUsersHighlighting(){
  var friendArr = friendTracker['friendsAdded'];
  friendArr.forEach(function(currentValue){
    $('.dynamicActiveInactive[data-name="' + currentValue + '"]').addClass("active");
  });
}

// When user is searching for a non-friend user to add
function searchForNonFriends(userSearchQuery) {
  // Show add user button if there is a query entered
  document.getElementById("addUser").style.display = (userSearchQuery != "") ? "block" : "none";
  suggestionsSearch(document.getElementById("searchForNonFriends"), userSearchQuery, "api/nonFriendSuggestions.php?q=", function(){
    updateSuggestedUsersHighlighting();
  });
}

// Add a friend from nonfriendsuggestions.php
function addFriendFromSuggested(nonFriendSuggestionSelected){
  if (friendTracker.friendsAdded.indexOf(nonFriendSuggestionSelected.getAttribute("data-name")) == -1){

    $(nonFriendSuggestionSelected).addClass("active");
    friendTracker.friendsAdded.push(nonFriendSuggestionSelected.getAttribute("data-name"));

  } else {

    $(nonFriendSuggestionSelected).removeClass("active");
    friendTracker.friendsAdded.splice(friendTracker.friendsAdded.indexOf(nonFriendSuggestionSelected.getAttribute("data-name")),1);

  }
}

// Submit friend adding request to the server
function submitUserChange() {
  if (friendTracker.friendsAdded.length > 0){
    // Post the array object
    postRequest("api/friendUser.php", JSON.stringify(friendTracker), function(responsetext){
      
    });
    // Reset the array
    refresh();
  }

  
}

// Add a friend from the list of people who requested you but you didn't add back
function addFriendFromRequested(selectedUserEntry){
  if (friendTracker.friendsAdded.indexOf(selectedUserEntry.getAttribute("data-name")) == -1)
  {
    // Remove node because selected, and add to array
    selectedUserEntry.parentNode.removeChild(selectedUserEntry);
    friendTracker.friendsAdded.push(selectedUserEntry.getAttribute("data-name"));
  } 
  submitUserChange();
}

// Unfriend a user
function unfriendUser(obj){
  // Are you sure
  if (confirm("Are you sure?") == true) {
    // Get the id of deleted user
    var id = obj.getAttribute("data-id");
    // Remove the deleted user from the list of affiliations
    (obj.parentNode).removeChild(obj);
    // Send server request to update delete post
    getRequest("api/unfriendUser.php?id=" + id, function(responseText){
      document.getElementById("alert").innerHTML = responseText;
    });
  }
  
  setTimeout(refresh, 500);
}

</script>
</body>
</html>
