<?php

require('loginScript.php');

// Get alerts
$link = databaseViewConnect();
if (isset($_GET['newid'])) {
  global $alert;
  $num = mysqli_escape_string($link, $_GET['newid']);
  $alert = "<div class = 'row alert alert-warning' role='alert' style = 'padding-left:7%; '><h1>Exercise Added</h1><p>Your new workout plan's identification number is " . $num . ".</p></div>";
} else {
  global $alert;
  $alert = "";
}

// Get errors
if (isset($_GET['error'])) {
  global $alert;
  $num = mysqli_escape_string($link, $_GET['newid']);
  $alert = "<div class = 'row alert alert-danger' role='alert' style = 'padding-left:7%; '><h1>Error.</h1><p>Something went wrong. Try again.</p></div>";
} else {
  global $error;
  $error = "";
}

mysqli_close($link);

?>

<!--
Copyright (c) 2016, Eric Zhao, All Rights Reserved. 
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
  <link href="css/bootstrap-tour.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/animate.css" type="text/css">
  <link href = "css/styless.css" rel = "stylesheet" type="text/css">
  <!-- Custom CSS -->
  <link rel="apple-touch-icon-precomposed" href="img/squarelogo.png">
  <link rel="icon" href="img/squarelogo.png">
  <!-- Custom Fonts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
  <script src="https://www.whimmly.com/TrainerAssist/js/hoverintent.js"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
  <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
</head>
<body style = "overflow-x:hidden;"><div class="loadingScreen"></div>
  <div class = "top" onclick="goToTrainerHome()" id = "topper"><a style = "width:100%; text-align:center;" href = "home"> </a></div>
  <div class = "panel-body" style="color:#808080; padding-left:3%; padding-right:3%;" >
    <div class = "row">
      <h1 class = "page-header nicepadding title" style = "color:#0099cc; padding-left:32px; padding-right:32px;"> Search Database</h1>
      <div class = "col-sm-8" style=" padding-left:32px; padding-right:32px;">
        
        <div class = "row" style = "padding-top:0px; padding-bottom:0px;">
          <div> 
            <h2 class = "formtitle" style = "font-size:25px;">Search by name or ID: </h2><input type="text" id="txt1" class = "largeSearch" onkeyup="searchForActSets(this.value)" style = "width:100%; ">
          </div>
          <ul class="list-group" id="listOfActSetSuggestions">
          </ul>
        </div>
      </div>
      <div class = "col-sm-4" style = "padding-left:32px; padding-right:32px;">
        <h2 class = "formtitle" style = "font-size:25px;">Your Exercises: </h2>
        <ul class="list-group" id="listOfActSetSuggestions">
          <?php
          
          // Get all activities matching user
          $link = databaseviewconnect();
          $rawActivities = sqlDataItemExists("activity", "id", $link, "user", mysqli_escape_string($link, $_SESSION['Username']), null, true);
          $suggestion = "";
          forEach ($rawActivities as $id){
            $id = $id[0];
            $title = sqlDataItemExists("activity", "title", $link, "id", $id)[0];
            $author = sqlDataItemExists("activity", "user", $link, "id", $id)[0];
            $suggestion .= "  <a onclick = \"goToExercise(this)\" href=\"#\" class='list-group-item searchResults' data-id=\"$id\"> \"$title\" - an exercise by $author ($id)</a>";
          }

          // If no results
          echo $suggestion === "" ? "<a href='#' class='list-group-item' > No activities found. </a>" : $suggestion;
          
          ?>
        </ul>
        <br>
        <h2 class = "formtitle" style = "font-size:25px;">Your Plans: </h2>
        <ul class="list-group" id="listOfActSetSuggestions">
          <?php

          // Get all sets matching user
          $link = databaseviewconnect();
          $rawSets = sqlDataItemExists("sets", "id", $link, "user", mysqli_escape_string($link, $_SESSION['Username']), null, true);
          $suggestion = "";
          forEach ($rawSets as $id){
            $id = $id[0];
            $title = sqlDataItemExists("sets", "title", $link, "id", $id)[0];
            $author = sqlDataItemExists("sets", "user", $link, "id", $id)[0];
            $suggestion .= "  <a onclick=\"goToWorkoutPlan(this)\" href=\"#\" class='list-group-item searchResults' data-id=\"$id\"> \"$title\" - a plan by $author ($id)</a>"; 
          }
          
          // If no results
          echo $suggestion === "" ? "<a href='#' class='list-group-item' > No plans found. </a>" : $suggestion;
          ?>
        </ul>
      </div>
    </div>
  </div>
  <script src = "js/script.js"></script><script src = "js/tourGenerator.js"></script>
  <script>
  // Search for sets and activities, returns suggestions or wipes search and suggestion box
  function searchForActSets(query){
    suggestionsSearch(document.getElementById("listOfActSetSuggestions"), query, "api/trainerSearchSuggestions.php?q=", function(){

    });
  }

  function goToExercise(obj){
    var id = obj.getAttribute("data-id");
    goToPage("#0099CC", "trainerLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/activityDisplay?id=' + id);
  }

  function goToWorkoutPlan(obj){
    var id = obj.getAttribute("data-id");
    goToPage("#0099CC", "trainerLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/workoutPreview?id=' + id);
  }

    
  </script>
</body>
</html>
