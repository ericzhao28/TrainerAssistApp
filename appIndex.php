<?php
include "loginScript.php";
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
  <link href = "css/appIndex.css" rel = "stylesheet" type="text/css">
  <!-- Custom CSS -->
  <link rel="apple-touch-icon-precomposed" href="img/squarelogo.png">
  <link rel="icon" href="img/squarelogo.png">
  <!-- Custom Fonts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
  <script src="js/hoverintent.js"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>

  <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

</head>
<body style = "overflow-x:hidden;">

<a  href="#" onclick = "goToLogoutPage()" class = "glyph" style = "z-index:601"><span class="glyphicon glyphicon-log-out" style = "height:50px; text-align:center; z-index:501" aria-hidden="true" ></span></a>
<a  href="#" onclick = "goToFriendsPage()" class = "glyph position2" style = "z-index:601"><span class="glyphicon glyphicon-user" style = "height:50px; text-align:center; z-index:501" aria-hidden="true" ></span></a>


  <div class="loadingScreen" id = 'loadingPageIdentifier' style = "background-color:#ffae19"></div>

  <p class = "actDesc repCircle"><strong>Trainer</strong> Assist</p>

  <div  onclick = "goToClientHome()" id = "left" class = "col-xs-6 stars" style = "background-color:#ffa500" onclick = "">


    <p class = "formtitle">
      <strong id = 'change'>Workout
      </strong><br><br>
    </p>


  </div>
  <div onclick = "goToTrainerHome()" id = "right" class = "col-xs-6 stars" style= "">

    <p class = "formtitle">
      <strong id = 'change2'>Create</strong><br><br>



    </div>




    
<script src="js/bootstrap.min.js" ></script>
<script src="js/script.js" ></script>
    <script>
      $(document).ready(function() {
        // If visited from home, change the color of the loader so that it matches the orange page loader from the user home page
        if (window.location.hash == "#home"){
          document.getElementById("loadingPageIdentifier").style.backgroundColor = '#ffa500';
        }
        leftRightHoverController("#left", "#right", "#ffc04d", "#ffa500", "#4cb7db", "#0099cc");
      });
    </script>
  </body>
  </html>

