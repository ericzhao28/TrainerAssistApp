<?php

include "loginScript.php";
$link = databaseviewconnect();

// Global username data
global $globalusername;
$globalusername = mysqli_escape_string($link, $_SESSION['Username']);

// Generate alerts if needed
global $pagetype;
$pagetype = "Activity";
if (isset($_GET['newid'])) {
  global $alert;
  $num = mysqli_escape_string($link, $_GET['newid']);
  $alert = "<div class = 'row alert alert-warning' role='alert' style = 'padding-left:7%; '><h1>Activity Added</h1><p>Your new workout plan's identification number is " . $num . ".</p></div>";
} else {
  global $alert;
  $alert = "";
}

// Generate errors if needed
if (isset($_GET['error'])) {
  global $alert;
  $num = mysqli_escape_string($link, $_GET['newid']);
  $alert = "<div class = 'row alert alert-danger' role='alert' style = 'padding-left:7%; '><h1>Error.</h1><p>Something went wrong. Try again.</p></div>";
} else {
  global $error;
  $error = "";
}

// Determine edit status
if (isset($_GET['delete'])){
  global $status;
  $status = "Save edits";
} else {
  global $status;
  $status = "Edit Plans";
}
mysqli_close($link);
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
  <link href="css/bootstrap-tour.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/animate.css" type="text/css">
  <link href = "css/styles.css" rel = "stylesheet" type="text/css">
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
  <script>
  var chosen = [];
  var idchosen = [];
  var totaladded = [];
  function showHint(str)
  {
    if (str.length==0) { 
      document.getElementById("txtHint").innerHTML="";
      document.getElementById("searchtext").innerHTML="";
      return;
    } else {
      var xmlhttp=new XMLHttpRequest();
      xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
      }
    }
    xmlhttp.open("GET","api/searchSuggestions.php?q="+str,true);
    xmlhttp.send();
    }
  }
  </script>
</head>
<body style = "overflow-x:hidden;"><div class="loadingScreen"></div>
  <div class = "top" onclick="goToClientHome()" id = "topper"><a style = "width:100%; text-align:center;" href = "home"> </a></div>
  <div id = "alert">
  </div>
  <div class = "panel-body" style="color:#808080; padding-left:3%; padding-right:3%;" >
    <div class = "row">
      <div class = "col-sm-12" style=" padding-left:32px; padding-right:32px;">
        <div class = "row">
          <div class = "col-sm-10">
            <h1 class = "page-header nicepadding title" style = "color:#ffa500; margin-bottom:0px;"> My Plans </h1>
          </div>
          <div class = "col-sm-2">
            <a href="#" class = "btn btn-warning" onclick = "editSaveButtonHandler()" style = "text-align:right; align:right; margin-top:40px;" id = "editButtons"><span class="glyphicon glyphicon-pencil" style = "height:20px; font-size: 20px; text-align:left; z-index:501" aria-hidden="true" ></span>&nbsp;&nbsp;&nbsp;<?php global $status; echo $status; ?></a>
          </div>
          <p></p>
        </div>
        <p></p>
        <div class = "row">
          <br>
          <ul class="list-group" id="txtHint">
            <?php

            // Retrieve assigned sets from DB
            $link = databaseviewconnect();
            $assignedSetsHTML = "";
            $assignedSets = sqldataitemexists("users", "AssignedSet", $link, "username", mysqli_escape_string($link, $_SESSION['Username']))[0];
            $delete = mysqli_escape_string($link, $_GET['delete']);

            while (0 < (substr_count($assignedSets, ","))){

              // Build information needs
              $setID = substr($assignedSets, 0, strpos($assignedSets, ","));
              $title = sqldataitemexists("sets", "title", $link, "id", $setID)[0];
              $author = sqldataitemexists("sets", "user", $link, "id", $setID)[0];
              $assignedSets = substr($assignedSets, strpos($assignedSets, ",") + 1);
              // Build HTML + Check for deletion
              if ($delete == "yes"){
                $assignedSetsHTML .= "  <a href=\"#\" class='list-group-item asdfasdfasdf largesearchResults' style = \"background-color:#ffe5e5\" onclick=\"removeAddedPlan(this)\" data-id=\"$setID\"> \"$title\" by $author ($setID) </a></a> ";
              } else {
                $assignedSetsHTML .= "  <a href=\"#\" class='list-group-item largesearchResults' onclick=\"goToWorkoutPlan(this)\" style = \"border-style:solid; border-width:1px; border-color:#ffa500;\" data-id=\"$setID\"> \"$title\" by $author ($setID) </a></a> ";
              } 

            }
          
            // Output "no suggestion" if no assigned set was found or output correct values 
            echo ($assignedSetsHTML == "") ? "<a href='#' class='list-group-item'  style = \"background-color:#fff !important; color: rgb(128, 128, 128) !important; border-style:solid; border-width:1px; border-color:#ffa500;\"> No plans found. </a>" : $assignedSetsHTML;
            ?>
    </ul>
  </p> 
  <div id = "edit">
  </div>
</div>
</div>
</div>
</div>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-tour.min.js"></script>
<script src="js/script.js"></script>
<script src="js/tourGenerator.js"></script>
<script>    

// If width is smaller than 767px, combine the edit buttons
$(document).ready(function() {
  adjustEditButtons();
  assignedTour();
});


// Adjusts edit button depending on screen width, called during initialization
function adjustEditButtons(){
  var width = (document.width !== undefined) ? document.width : document.body.offsetWidth;
  if (width < 767){
    $("#editButtons").detach().appendTo('#edit')
  }
}

// Remove plan
function removeAddedPlan(obj){
  if (confirm("Are you sure?") == true) {
    var id = obj.getAttribute("data-id");
    (obj.parentNode).removeChild(obj);
    getRequest("api/removeWorkoutPlan.php?id=" + id, function(responseText){
      document.getElementById("alert").innerHTML= responseText;
    });
  }
}

function editSaveButtonHandler(){
  if (getParameterByName("delete") == "yes"){
    goToPage(null, "clientLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/assigned');
  } else {
    goToPage(null, "clientLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/assigned?delete=yes');
  }
}


function goToWorkoutPlan(obj){
  var id = obj.getAttribute("data-id");
  goToPage(null, "clientLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/exercise?id=" + id);
}
</script>
</body>
</html>
