<?php

// Get scripts
include "loginScript.php";
include "set.php";

global $tableHTML;

// Get DB
$link = databaseviewconnect();

// Setup set info
$setID = mysqli_escape_string($link, $_GET['id']);
$setRaw = sqlRowGet("sets", $link, "id", $setID);
$set = new Set($setID, $setRaw['activityJSON'], $setRaw['title'], $setRaw['user']);
$setData = json_decode($set->getSet(), true);

// Set up the days
$dayList = array();
$currentDay = (mysqli_escape_string($link, $_GET['day']));
if (isset($_GET['day']) == false) {
  $currentDay = 1;
} 
            
$activityHTML = "<br>";

// Cycle through activities
forEach (json_decode($setData['activityJSON'], true) as $activity) {

	// Fetch info
  $id        = $activity['id'];
  $rep       = $activity['rep'];
  $rawweight = $activity['weight'];
  $day       = $activity['day'];
  $name    = stripslashes(trim($activity['title']));

   // Human-fy weight string
  if ($rawweight != 0) {
      $weight = ", $rawweight lb";
  } else {
      $weight    = "";
      $rawweight = "Not applicable";
  }
	
  // Build HTML
	if (($id != "RestToday")&&($id != "")){
		// New day
		if (!(in_array($day, $dayList))){
			$dayList[] = $day;
			
			$tableHTML = $tableHTML . "      <tr style = 'border-bottom-width:0px; border-top-width:1px; border-top-style:solid; border-top-color:#ffa500;'>
			<th  style = 'border-bottom-width:0px; border-top-width:0px; color:#ffa500' scope=\"row\" class = \"thFirst\">Day $day</th>";
			if ($id == "Rest"){
				$tableHTML = $tableHTML . "<td style = 'border-bottom-width:0px; border-top-width:0px;'>$id Rest ($rep seconds)</td>";

			} else if ($id == "Desc"){
				$tableHTML = $tableHTML . "<td style = 'border-bottom-width:0px; border-top-width:0px;'>Note: $rep</td>";
			} else if ($id != ""){
				$tableHTML = $tableHTML . "<td style = 'border-bottom-width:0px; border-top-width:0px;'>$name ($rep reps, $weight)</td>";
			} 

		} else {
		// Addition to existing day
			$entryCounter = $entryCounter + 1;
			
			if ($entryCounter > 3){
				$tableHTML = $tableHTML . "</tr><tr style = 'border-bottom-width:0px; border-top-width:0px;'>";
				$entryCounter = 0;
			}
			if ($id == "Rest"){
				$tableHTML = $tableHTML . "<td style = 'border-bottom-width:0px; border-top-width:0px;'>Rest ($rep seconds)</td>";
			} else if ($id == "Desc"){
				$tableHTML = $tableHTML . "<td style = 'border-bottom-width:0px; border-top-width:0px;'>Note: $rep</td>";
			} else if ($id != ""){
				$tableHTML = $tableHTML . "<td style = 'border-bottom-width:0px; border-top-width:0px;'>$name ($rep reps, $weight)</td>";
			}
			
			// Cap off this day
			$incrementAverage = $entryJSON[$index + 1];
			if  (!(in_array(($incrementAverage["im:day"]["label"]), $dayList))){
				$tableHTML = $tableHTML . "</tr><tr style = 'border-bottom-width:0px; border-top-width:0px;'><td style = 'border-bottom-width:0px; border-top-width:0px;height:10px !important;'>&nbsp;</td></tr>";
				$entryCounter = 0;
			}
		}
	}
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
	<style>



	</style>

</head>
<body>


	<div class = "row flipper" id = "flipper" style = "padding:0%; margin:0%; height:100%; top:0;">
		<table class="table"  style = "padding:0%; margin:0%; width:100%; top:0;">
			<tbody>
				<?php
				global $tableHTML;
				echo $tableHTML;
				?>
			</tbody>
		</table>
	</div>
	<script src="js/bootstrap.min.js"></script><script src="js/bootstrap-tour.min.js"></script>
	<script>
		document.body.style.height = document.getElementById("flipper").offsetWidth + "px";
	</script>

</body>
</html>