<?php
include "loginScript.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Modern Training">
  <meta name="author" content="Eric Zhao">
  <title>TrainerAssist</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js" type="text/javascript"></script>
  <link href="css/bootstrap-tour.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/exercise2.css" rel="stylesheet">
  <link rel="apple-touch-icon-precomposed" href="img/squarelogo.png">
  <link rel="icon" href="img/squarelogo.png">
  <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
  <link href="https://www.whimmly.com/TrainerAssist/css/simple-sidebar.css" rel="stylesheet">
</head>
<body><canvas id = "successCanvas" style = "position:absolute; z-index:0; width:0px;" height="400"></canvas> 
  <div class="loadingScreen"></div>

  <nav class="navbar navbar-inverse navbar-fixed-top" id = "sidebarToggleWrapper" style = "background-color:black;width:70px; border-bottom-right-radius:20px; ">
    <div class="navbar-header" style = "width:100%;">
      <button type="button" class="navbar-toggle" data-toggle="#menu-toggle" data-target="menu-toggle" id = "menu-toggle" onclick="toggleSidebar(this)" style = "display:block !important; float:right;">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
  </nav>    
  <div id="wrapper">
  <div id="sidebar-wrapper"  style = "z-index:1040 !important;">
    <ul class="sidebar-nav">
      <li class="sidebar-brand">
        <a href="#"  onclick="goToTrainerHome()">
          Back to Trainer Home
        </a>
      </li>

      <?php
      // If current user matches author of activity, allow for deletion and editing
      session_start();
      $link = databaseviewconnect();

      $activityID = mysqli_escape_string($link, $_GET['id']);
      $activityUser = sqlDataItemExists("activity", "user", $link, 'id', $activityID);

      if ((mysqli_escape_string($link, ($_SESSION['Username']))) == ($activityUser[0])){ 
        echo '<li><a href="#" onclick = "deleteActivity()" id = "deleteTriggerButton"><span class="glyphicon glyphicon-trash" style = "height:20px; font-size: 20px; text-align:left; z-index:501" aria-hidden="true" ></span>&nbsp;&nbsp;&nbsp;Delete Exercise</a></li><li><a href="#" id = "editTriggerButton" data-url = "';
        echo "createActivity?replaceID=" . $activityID;
        echo '" onclick = "editExercise(this)"><span class="glyphicon glyphicon-pencil" style = "height:20px; font-size: 20px; text-align:left; z-index:501" aria-hidden="true" ></span>&nbsp;&nbsp;&nbsp;Edit Exercise</a></li>  ';
      }
      ?>

    <br>
    <li>
      <a href="#" onclick = "goToBuildSet()"><span class="glyphicon glyphicon-th-list" style = "height:20px; font-size: 20px; text-align:left; z-index:501" aria-hidden="true" ></span>&nbsp;&nbsp;&nbsp;Build new plan</a>
    </li>
    <li>
      <a href="#" onclick = 'goToBuildActivity()'><span class="glyphicon glyphicon-th-large" style = "height:20px; font-size: 20px; text-align:left; z-index:501" aria-hidden="true" ></span>&nbsp;&nbsp;&nbsp;Create New Exercise</a>
    </li>              
  </ul>
</div>

<div id = "alert">
</div>
<div id="page-content-wrapper"  style = "padding-top:70px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <p class = "titlePage"><strong>

          <?php

          // Primary activity HTML

          // Retrieve from DB
          $link = databaseViewConnect();
          $activityID = mysqli_escape_string($link, $_GET['id']);
          mysqli_select_db($link, "trainerassist");
          $title = (sqldataitemexists("activity", "title", $link, "id", $activityID)[0]); 
          $author = (sqldataitemexists("activity", "user", $link, "id", $activityID)[0]);

          // Display title + author header
          echo $title . "</strong>&nbsp;&nbsp;by $author</p>";
          
          // Structural HTML
          echo '<br><div class="panel-group" id="accordion">';  
          
          // Get activity details
          $activityID = (mysqli_escape_string($link, $_GET['id']));
          $activity = sqlRowGet("activity", $link, "id", $activityID);
          $name = $activity['title'];
          $author = $activity['user'];
          $url = $activity['youtubeLink'];
          $desc = $activity['description'];
          $step1 = $activity['step1'];
          $step2 = $activity['step2'];
          $step3 = $activity['step3'];
          $step4 = $activity['step4'];
          $step5 = $activity['step5'];

          // Process muscle string
          $muscleAffJSON = $activity['muscleAffJSON'];
          $muscle = "";
          if ($muscleAffJSON != ""){
            forEach(json_decode($muscleAffJSON, true) as $value){
              $muscle .= str_replace('_', ' ', ($value . ", "));   
            }
          }
          $muscle = rtrim($muscle, ", ");

          // Generate video URL
          if (strlen($url) > 5) {
            $videoHTML = "<a data-toggle=\"modal\" style = \"text-align:center; align:center; color:#CC6633;\" data-url = \"$url\" data-target=\"#youtubeVideoPlayer\" href = \"#modal\"><span class=\"glyphicon glyphicon-facetime-video\" style = \"height:30px; font-size: 30px; text-align:center; color:#CC6633; z-index:501\" aria-hidden=\"true\" ></span></a> ";
          } else {
            $videoHTML = "";
          }             

          // Primary body 
          echo "<div class=\"panel panel-default\"> <div class=\"panel-heading accordiondiv\" data-toggle=\"collapse\" data-parent=\"#accordion\" data-target=\"#collapse1\"> <h4 class=\"panel-title\" style = \"height:100%;\"> <div class = \"row noside\"> <div class = \"col-sm-7 noside\"> <a class=\"accordion-toggle\" style=\"color:white;\" ><p class = \"actDesc\" style=\"color:white;\"><strong>$name</strong></p></a></div><div class = \"col-sm-2\"><a data-toggle=\"modal\" text-align:center; align:center; data-url = \"$url\" data-target=\"#youtubeVideoPlayer\" href = \"#modal\"><span class=\"glyphicon glyphicon-video\" style = \"height:20px; font-size: 20px; text-align:center; z-index:501\" aria-hidden=\"true\" ></span></a></div><div class = \"col-sm-3 noside\" style = \"height:100%; \"> <p class = \"actDesc repCircle\">Exercise</p></div> </div> </h4> </div> <div id=\"collapse1\" class=\"panel-collapse collapse\"> <div class=\"panel-body\"> <div class = \"row\"><br> <div class = \"col-sm-4 descriptionLeft\"> <p class = \"leftTitleDesc\"><strong>Exercise Name:</strong> &nbsp;$name</p> <p class = \"leftTitleDesc\"><strong>Description:</strong> &nbsp;$desc </p> <p class = \"leftTitleDesc\"><strong>Author:</strong> &nbsp;$author</p> <p class = \"leftTitleDesc\"><strong>Muscles Used:</strong> $muscle</p><p class = \"leftTitleDesc\"><strong>Unique ID:</strong> &nbsp;$activityID</p> $videoHTML<br><br><br><br> </div> <div class = \"col-sm-4\"> ";

          // Generate steps if applicable
          if ($step1 != "") {
            echo "<div class = \"stepDiv\"><p class = \"stepText\"><strong>1.</strong>$step1<br><br><br></p></div>";
          }
          if ($step2 != "") {
            echo "<div class = \"stepDiv\"><p class = \"stepText\"><strong>2.</strong>$step2<br><br><br></p></div>";
          }
          if ($step3 != "") {
            echo "<div class = \"stepDiv\"><p class = \"stepText\"><strong>3.</strong>$step3<br><br><br></p></div>";                                      
            echo "</div>";
          }

          // Generate new bootstrap column
          if (($step4 != "")||($step5 != "")){     
            echo "<div class = \"col-sm-4\">";
            if ($step4 != ""){
              echo "<div class = \"stepDiv\"><p class = \"stepText\"><strong>4.</strong>$step4<br><br><br></p></div>";
            }
            if ($step5 != ""){
              echo "<div class = \"stepDiv\"><p class = \"stepText\"><strong>5.</strong>$step5<br><br><br></p></div>";
            }
            echo "</div>";
          }

          // Close off tags
          echo "</div></div></div></div>";
          ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Contact Trainer</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="youtubeVideoPlayer" tabindex="-1" role="dialog" aria-labelledby="youtubeVideoPlayerLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="youtubeVideoPlayerLabel">Video Demonstration</h4>
      </div>
      <div class="modal-body">
        <div class = " embed-responsive embed-responsive-16by9" style = "height:100%; width:100%;" id = "videoContent">
          <!-- 16:9 aspect ratio -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-tour.min.js"></script>
<script src="js/script.js"></script>
<script src="js/tourGenerator.js"></script>

<script>
$(document).ready(function() {
  youtubePlayerInitiate();
  sidebarInitiate();
});
// Unknown url because dynamic cuz edit exercise id depends on activity ID
function editExercise(obj){
  var url = obj.getAttribute("data-url");
  goToPage("#0099CC", "trainerLoadingScreenColor", url);
}
// Delete activity
function deleteActivity(){
  if (confirm("Are you sure? This cannot be undone.") == true) {
    var id = getParameterByName("id");
    getRequest("api/deleteActivity.php?id="+id, function(responseText){
      greenMarkTrigger(function(){
        setTimeout(function(){
          goToPage("#0099CC","trainerLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/searchTrainer');
        }, 2000);
      });
    });
  }
}
activityDisplayTour();
</script>
</body>
</html>
