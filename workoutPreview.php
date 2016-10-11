<?php

include "loginScript.php";
include "numConvt.php";
include "set.php";

?>
        <!--
        Copyright (c) 2015, Eric Zhao, All Rights Reserved. 
        THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
        KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
        IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
        PARTICULAR PURPOSE.
      -->
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
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap-tour.min.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/exercise2.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link rel="apple-touch-icon-precomposed" href="img/squarelogo.png">
        <link rel="icon" href="img/squarelogo.png">
        <!-- Custom Fonts -->
        <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
        <!-- Custom CSS -->

        <script type="text/javascript" src="js/bootstrap-tour-standalone.min.js"></script>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
        <link href="https://www.whimmly.com/TrainerAssist/css/simple-sidebar.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
                <![endif]-->
                <script>
                </script>
              </head>
              <body>
        <canvas id = "successCanvas" style = "position:absolute; z-index:0; width:0px;" height="400"></canvas> 
        <div class="loadingScreen" id = "toppest"></div>
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
                  <!-- Sidebar -->
                  <div id="sidebar-wrapper"  style = "z-index:1040 !important;">
                    <ul class="sidebar-nav">
                      <li class="sidebar-brand">
                        <a href="#"  onclick="goToTrainerHome()">
                          Back to Trainer Home
                        </a>
                      </li>
                      <li>
                        <a data-toggle="modal" data-target="#myModal" href = "#modal" id = "assignerTriggerButton"><span class="glyphicon glyphicon-user" style = "height:20px; font-size: 20px; text-align:left; z-index:501" aria-hidden="true" ></span>&nbsp;&nbsp;&nbsp;Share with Friends</a>
                      </li>
                      <li>
                        <a href="#" onclick = "goToCreateSetPage()"><span class="glyphicon glyphicon-th-list" style = "height:20px; font-size: 20px; text-align:left; z-index:501" aria-hidden="true" ></span>&nbsp;&nbsp;&nbsp;Build new plan</a>
                      </li>
                      <li>
                        <a href="#" onclick = 'GoToBuildActivity()'><span class="glyphicon glyphicon-pencil" style = "height:20px; font-size: 20px; text-align:left; z-index:501" aria-hidden="true" ></span>&nbsp;&nbsp;&nbsp;Build new exercise</a>
                      </li>
<?php
// Add action options
$link = databaseViewConnect();
$id = mysqli_escape_string($link, $_GET['id']);
global $globalUsername;

// Print plan available for all
echo '<li><a href = "tableDisplay?id=' . $id . '"><span class="glyphicon glyphicon-print" style = "height:20px; font-size: 20px; text-align:left; z-index:501" aria-hidden="true" ></span>&nbsp;&nbsp;&nbsp;Print Plan</a><br></li>';

// Built echo string for later

// Globals for later reference
global $activityHTML;
global $set;

$link = databaseviewconnect();
$setID = mysqli_escape_string($link, $_GET['id']);
$dayList = array();

// Get set information
$setRaw = sqlRowGet("sets", $link, "id", $setID);
$set = new Set($setID, $setRaw['activityJSON'], $setRaw['title'], $setRaw['user']);
$setData = json_decode($set->getSet(), true);

// Set up the day
$currentDay = (mysqli_escape_string($link, $_GET['day']));
if (isset($_GET['day']) == false) {
  $currentDay = 1;
} 
$activityHTML = "<br>";

// Filter out activity JSON
forEach (json_decode($setData['activityJSON'], true) as $activity) {
     
      // Assign basic information for activity
      $id        = $activity['id'];
      $rep       = $activity['rep'];
      $rawweight = $activity['weight'];
      $day       = $activity['day'];
      
      // Human-fy weight string
      if ($rawweight != 0) {
          $weight = ", $rawweight lb";
      } else {
          $weight    = "";
          $rawweight = "Not applicable";
      }

      // Setup day tabulation
      if ($id == "RestToday") {
          $dayData[$day] = "Rest";
      }
      $dayList[] = $day;
      
      // Count activities to offer accordion ID uniqueness
      $activityCounter = $activityCounter + 1;

      // Begin compiling global echo string
      if (($id == "Rest")&&($day == $currentDay)) {
      // If rest entry
         $activityHTML = $activityHTML . "<div class=\"panel panel-default\"><div class=\"panel-heading accordiondiv\"  style = \"background-color:#007aa3 !important;\"><h4 class=\"panel-title\" style = \"height:100%;\"><div class = \"row noside\"><div class = \"col-sm-9 noside\"><a class=\"accordion-toggle\"><p class = \"actDesc\"><strong>Rest</strong></p></a></div><div class = \"col-sm-3 noside\" style = \"height:100%; \"> <p class = \"actDesc repCircle\">$rep seconds</p></div></div></h4></div></div>";
      } else if (($id == "Desc")&&($day == $currentDay)) {
      // If note
         if (trim($rep) != ""){
          $activityHTML = "<div class=\"panel panel-default\">                     <div class=\"panel-heading accordiondiv\" data-toggle=\"collapse\" data-parent=\"#accordion\" data-target=\"#collapserDesc\" style = \"background-color: gray !important; !important\">                      <h4 class=\"panel-title\" style = \"height:100%;\"><div class = \"row noside\"> <div class = \"col-sm-7 noside\">  <a class=\"accordion-toggle\"><p class = \"actDesc\"><strong>Note</strong></p></a></div><div class = \"col-sm-5 noside\" style = \"height:100%; \"> <p class = \"actDesc repCircle\">Trainer</p></div></div> </h4> </div> </div><div id=\"collapserDesc\" class=\"panel-collapse collapse\"> <div class=\"panel-body\">$rep</div></div>" . $activityHTML;
        }
      } else if (($id == "RestToday")&&($day == $currentDay)) {
      // Day long rest
        $activityHTML = $activityHTML . "<div class=\"panel panel-default\">
                               <div class=\"panel-heading accordiondiv\"  style = \"background-color:#007aa3 !important;\">
                                <h4 class=\"panel-title\" style = \"height:100%;\">
                                  <div class = \"row noside\">
                                    <div class = \"col-sm-9 noside\">
                                      <a class=\"accordion-toggle\"><p class = \"actDesc\"><strong style=\"text-overflow:ellipses !important;\">Take a Break Today</strong></p></a></div><div class = \"col-sm-3 noside\" style = \"height:100%; \"> <p class = \"actDesc repCircle\">Rest</p></div>
                                    </div>
                                  </h4>
                                </div>
                              </div>";
      } else if ($day == $currentDay) {
        // Normal activity
        // Assign proper properties
        $name    = stripslashes(trim($activity['title']));
        $desc    = stripslashes(trim($activity['description']));
        $author  = stripslashes(trim($activity['user']));
        $step1   = stripslashes(trim($activity['step1']));
        $step2   = stripslashes(trim($activity['step2']));
        $step3   = stripslashes(trim($activity['step3']));
        $step4   = stripslashes(trim($activity['step4']));
        $step5   = stripslashes(trim($activity['step5']));
        $url   = stripslashes(trim($activity['video']));

        // Process muscle string
        $rawmuscle = json_decode($activity['muscleAffJSON'], true);   
        $muscle = "";
        forEach ($rawmuscle as $muscleEntry){
          $muscle .= str_replace('_', ' ', trim($muscleEntry)) . ", ";
        }
        $muscle = rtrim($muscle, ", ");
       
        // Generate video info 
        if (strlen($url) > 5) {
            $videoData = "<a data-toggle=\"modal\" style = \"text-align:center; align:center; color:#CC6633;\" data-url = \"$url\" data-target=\"#youtubeVideoPlayer\" href = \"#modal\"><span class=\"glyphicon glyphicon-facetime-video\" style = \"height:30px; font-size: 30px; text-align:center; color:#CC6633; z-index:501\" aria-hidden=\"true\" ></span></a> ";
        } else {
            $videoData = "";
        }
        
        // Primary activity main body
        $numText = ucfirst(convertNumber($activityCounter));
        $activityHTML = $activityHTML .  "<div class=\"panel panel-default\" onclick=\"starttour(this)\" id = \"" . $activityCounter . "-\"> <div class=\"panel-heading accordiondiv\" data-toggle=\"collapse\" data-parent=\"#accordion\" data-target=\"#collapse" . $numText . "\" id = \"" . $activityCounter . "-title\"> <h4 class=\"panel-title\" style = \"height:100%;\"> <div class = \"row noside\"> <div class = \"col-sm-7 noside\"> <a class=\"accordion-toggle\" style=\"color:white;\"><p class = \"actDesc\" style=\"color:white;\"><strong>$name</strong></p></a></div><div  id = \"" . $activityCounter . "-repcircle\" class = \"col-sm-5 noside\" style = \"height:100%; display: inline;\"> <p class = \"actDesc repCircle\">$rep reps$weight </p></div> </div> </h4> </div> <div id=\"collapse" . $numText . "\" class=\"panel-collapse collapse\"> <div class=\"panel-body\"> <div class = \"row\"><br> <div class = \"col-sm-4 descriptionLeft\" id = \"" . $activityCounter . "-desc\">  <p class = \"leftTitleDesc\"><strong>Exercise Name:</strong> &nbsp;$name</p> <p class = \"leftTitleDesc\"><strong>Description:</strong> &nbsp;$desc </p> <p class = \"leftTitleDesc\"><strong>Author:</strong> &nbsp;$author</p> <p class = \"leftTitleDesc\"><strong>Muscles Used:</strong> &nbsp;$muscle</p><p class = \"leftTitleDesc\"><strong>Unique ID:</strong> &nbsp;$id</p> <p class = \"leftTitleDesc\"><strong>Repititions:</strong> &nbsp;$rep</p> <p class = \"leftTitleDesc\"><strong>Weight:</strong> &nbsp;$rawweight</p> $videoData<br><br><br><br> </div> <div  id = \"" . $activityCounter . "-steps\" class = \"col-sm-4\"> ";
        
        // Add steps
        if ($step1 != "") {
            $activityHTML = $activityHTML .  "<div class = \"stepDiv\"> <p class = \"stepText\"><strong>1.</strong>$step1<br><br><br></p> </div>";
        }
        if ($step2 != "") {
            $activityHTML = $activityHTML .  "<div class = \"stepDiv\"> <p class = \"stepText\"><strong>2.</strong>$step2<br><br><br></p> </div>";
        }
        if ($step3 != "") {
            $activityHTML = $activityHTML .  "<div class = \"stepDiv\"> <p class = \"stepText\"><strong>3.</strong>$step3<br><br><br></p> </div>";
        }

        $activityHTML = $activityHTML .  "</div>";
        
        // Step4 + 5 + additioal column
        if (($step4 != "") || ($step5 != "")) {
            $activityHTML = $activityHTML .  "<div class = \"col-sm-4\">";
            if ($step4 != "") {
                $activityHTML = $activityHTML .  "<div class = \"stepDiv\"> <p class = \"stepText\"><strong>4.</strong>$step4<br><br><br></p> </div>";
            }
            if ($step5 != "") {
                $activityHTML = $activityHTML .  "<div class = \"stepDiv\"> <p class = \"stepText\"><strong>5.</strong>$step5<br><br><br></p> </div>";
            }
            $activityHTML = $activityHTML .  "</div>";
        }

        // Cap off string
        $activityHTML = $activityHTML .  "</div> </div> </div> </div>";
      }
        
    }      
        
    // Echo out day sidebar
    global $activityHTML;
    for ($dayIndex = 1; $dayIndex <= max($dayList); $dayIndex++){
     
      if ($dayIndex == $currentDay){
        if ($dayData[$dayIndex] != "Rest"){
          echo "<li><a style = \"background-color:rgba(255,255,255, 0.4); color:white;\" data-url=\"workoutPreview?id=$setID&day=$dayIndex\" href=\"#goin\" onclick = \"changeTheDay(this)\">Day $dayIndex</a></li>";
        } else {
          echo "<li><a style = \"background-color:rgba(255,255,255, 0.4); color:white;\" data-url=\"workoutPreview?id=$setID&day=$dayIndex\" href=\"#\">Day $dayIndex (Rest)</a></li>";
        }
      } else {
        if ($dayData[$dayIndex] != "Rest"){
          echo "<li><a data-url=\"workoutPreview?id=$setID&day=$dayIndex\" href=\"#goin\" onclick = \"changeTheDay(this)\">Day $dayIndex</a></li>";
        } else {
          echo "<li><a data-url=\"workoutPreview?id=$setID&day=$dayIndex\" href=\"#\" >Day $dayIndex (Rest)</a></li>";
        }
      }

    }

?>
      </ul>
    </div>
    <!-- /#sidebar-wrapper -->
    <div id = "alert">
    </div>
    <!-- Page Content -->
    <div id="page-content-wrapper" style = "padding-top:70px;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <p>
              <p class = "titlePage"><strong>
                <?php
                // Release title info
                global $set;
                $setTitle = json_decode($set->getBasicSet(), true)['title'];
                $setAuthor = json_decode($set->getBasicSet(), true)['user'];
                echo $setTitle . "</strong>&nbsp;&nbsp;by $setAuthor</p>";
                ?>
                <br>
                <div class="panel-group" id="accordion">
                <?php
                // Release main HTML
                global $activityHTML;
                echo $activityHTML;
                ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /#page-content-wrapper -->
      </div>
      <!-- /#wrapper -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Share with Friends</h4>
            </div>
            <div class="modal-body">
              <div> 
                Search by username or name: 
                <br>
                <input type="hidden" id = "userString" name="userString" value=""/>
                <input type="text" id="txt1" onkeyup="userHint(this.value)" style = "width:100%;">
              </div>
              <ul class="list-group" id="userHint" style = "margin-bottom:0px">
              </ul>
              <!--
              <br>
              <style>

                .datepicker{display:hidden; z-index:9999 !important}
              </style>

              Start date: 
              <br>
              <div class="input-group input-append date" id="datePicker" style = 'display:hidden;width:100%'>-->
                <input type="hidden" id = "dates" class="form-control disabled" onkeydown="return false;" name="date" /><!--
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>

              </div>
              <script>
                $(document).ready(function() {
                  $('#datePicker')
                  .datepicker({
                    format: 'mm/dd/yyyy',
                    todayHighlight: true
                  })

                  .on('changeDate', function(e) {
                    // Revalidate the date field
                    $('#eventForm').formValidation('revalidateField', 'date');
                    

                  });

                  var today = new Date();
                  var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!

            var yyyy = today.getFullYear();
            if(dd<10){
              dd='0'+dd
            } 
            if(mm<10){
              mm='0'+mm
            } 
            var today = dd+'/'+mm+'/'+yyyy;
            document.getElementById("dates").value = today;

          });

              </script>-->
              <br><br>
              <a style = "width:100%; border-top-left-radius:10px; border-top-right-radius:10px; border-bottom-left-radius:10px; border-bottom-right-radius:10px;" id = "addUser" onclick = "submitUserChange()" value = "Sent" name="submit"  href="#adding" class="btn btn-success">Add Users</a>
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
      <script src="js/bootstrap.min.js"></script><script src="js/bootstrap-tour.min.js"></script><script src="js/script.js"></script><script src="js/tourGenerator.js"></script>

<script>
$(document).ready(function() {
  youtubePlayerInitiate();
  sidebarInitiate();
  workoutPreviewTour();
});
// Change the day
function changeTheDay(obj){
  var url = obj.getAttribute("data-url");
  goToPage(null, "trainerLoadingScreenColor", url);
}
</script>
</body>
</html>
