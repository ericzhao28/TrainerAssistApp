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
    <link href="css/bootstrap.min.css" rel="stylesheet"> <link href="css/bootstrap-tour.min.css" rel="stylesheet"> <link href="css/userHomepage.css" rel="stylesheet"> <link rel="stylesheet" href="css/animate.css" type="text/css"> <link rel="apple-touch-icon-precomposed" href="img/squarelogo.png"> <link rel="icon" href="img/squarelogo.png"> <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script> <script src="https://www.whimmly.com/TrainerAssist/js/hoverintent.js"></script> <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script> <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"> <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css"> <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'> <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'> <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
</head>
<body style="padding-bottom:0%; overflow-x: hidden; background-color:#ffa500;" id="trainer" onresize="go()"> <div class="loadingScreen" id="hidey"></div><a href="#" onclick="goToAssigned()"><p id="titleLeft">Saved Plans</p></a><p id="title">TrainerAssist</p><a href="#" onclick="goToSearch()"><p id="titleRight">Find a Plan</p></a><div id="triangle-topright" onclick="goToSearch()" ></div><div class="invis" id="invis1" onclick="goToSearch()" ></div><div class="invis" id="invis2" onclick="goToAssigned()" ></div><div id="squareLeft" onclick="goToSearch()" class="tour-step tour-step-one"></div><div id="squareRight" onclick="goToAssigned()" class="tour-step tour-step-two" ></div><div id="triangle-up" onclick="goToLogoutPage()"></div><div id="triangle-topleft" onclick="goToAssigned()" ></div>

<div id="logout">

<br>
<br>


<a href="#" onclick="goToAppHome()" style="z-index:500" id="logoutbutt" class="glyph"><span class="glyphicon glyphicon-home" style="height:50px; font-size: 60px; text-align:center; z-index:501" aria-hidden="true" ></span></a>

<a href="#" onclick="goToSettings()" id="trainerbutt" class="glyph" style="z-index:500"><span class="glyphicon glyphicon-cog" style="height:50px; font-size: 60px; text-align:center; z-index:501" aria-hidden="true" ></span></a>

</div>

<script src="js/bootstrap.min.js"></script><script src="js/bootstrap-tour.min.js"></script>
<script src = "js/script.js"></script><script src = "js/tourGenerator.js"></script>
<script>
$(document).ready(function() {

    // Generate triangle
    triangleGen();
    clientHomeTour();

    // Setup color highlighting
    $("#invis1").hoverIntent(function(){
        $("#squareLeft").animate({
            backgroundColor: "#ffe4b2"
        }, 341), $("#triangle-topright").animate({
            borderTopColor: "#ffe4b2"
        }, 341), $("#titleRight").animate({
            color: "#4D4D4D"
        }, 341)
    }, function(){
        $("#squareLeft").animate({
            backgroundColor: "#ededed"
        }, 341), $("#triangle-topright").animate({
            borderTopColor: "#ededed"
        }, 341), $("#titleRight").animate({
            color: "#000000"
        }, 341)
    }), $("#invis2").hoverIntent(function(){
        $("#squareRight").animate({
            backgroundColor: "#ffe4b2"
        }, 341), $("#triangle-topleft").animate({
            borderTopColor: "#ffe4b2"
        }, 341), $("#titleLeft").animate({
            color: "#4D4D4D"
        }, 341)
    }, function(){
        $("#squareRight").animate({
            backgroundColor: "#dbdbdb"
        }, 341), $("#triangle-topleft").animate({
            borderTopColor: "#dbdbdb"
        }, 341), $("#titleLeft").animate({
            color: "#000000"
        }, 341)
    });
});
</script>
</body>  
<!--
Copyright (c) 2015, Eric Zhao, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
-->
</html>