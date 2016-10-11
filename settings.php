<?php
include "loginScript.php";

global $firstName, $lastName, $age, $weight, $height, $email, $feet, $inches, $description;

// Setup DB
$link = databaseeditconnect("LEMonadestand20Laugh");
mysqli_select_db($link, "trainerassist");

// Get form info
$username = mysqli_real_escape_string($link, $_SESSION['Username']);
$feet = mysqli_real_escape_string($link, $_POST['feet']);
$inches = mysqli_real_escape_string($link, $_POST['inches']);
$weight = mysqli_real_escape_string($link, $_POST['weight']);
$description = mysqli_real_escape_string($link, $_POST['desc']);
$age = mysqli_real_escape_string($link, $_POST['age']);
$email = mysqli_real_escape_string($link, $_POST['email']);
$firstName = mysqli_real_escape_string($link, $_POST['FirstName']);
$lastName = mysqli_real_escape_string($link, $_POST['LastName']);

// Validate fields
if ($email != ""){
  // Check username
  $checkusername = mysqli_query($link, "SELECT * FROM users WHERE Username = '".$username."'");
  if(mysqli_num_rows($checkusername) == 1)
  {
    // Human-ify some properties
    $height = (($feet * 12) + $inches);
    $BMI = (($weight/($height*$height))*703);

    // File changes to DB and recieve errors if applicable
    $result = mysqli_query($link, ("UPDATE users SET FirstName='" . $firstName . "', LastName='" . $lastName . "', EmailAddress='" . $email . "', Weight='" . $weight . "', Height='" . $height . "', Age='" . $age . "', Description='" . $description . "', BMI='" . $BMI . "' WHERE Username='" . $username . "'"));
    if($result)
    {
      global $javascriptSetter;
      $javascriptSetter =  "<script>runCheckWithoutRefresh();</script>";
    }
    else
    {
      echo "<div class = 'row alert alert-danger' id = 'alerter' role='alert' style = 'padding-left:10%; '><h1>Something went wrong</h1><p>Please try again</p></div>"; 
    }       
  }

} else {


  // If no post data, fetch from DB
  $myUsername = mysqli_escape_string($link, $_SESSION['Username']);
  $firstName = sqldataitemexists("users", "FirstName", $link, "Username", $myUsername)[0];
  $lastName = sqldataitemexists("users", "LastName", $link, "Username", $myUsername)[0];
  $age = sqldataitemexists("users", "Age", $link, "Username", $myUsername)[0];
  $weight = sqldataitemexists("users", "Weight", $link, "Username", $myUsername)[0];
  $height = sqldataitemexists("users", "Height", $link, "Username", $myUsername)[0];
  $email = sqldataitemexists("users", "EmailAddress", $link, "Username", $myUsername)[0];
  $description = sqldataitemexists("users", "Description", $link, "Username", $myUsername)[0];
  $feet = (int) ($height/12);
  $inches = ($height % 12);

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
  <link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
 // 
 var xmlhttp=new XMLHttpRequest();
 xmlhttp.onreadystatechange=function() {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
  }
}
xmlhttp.open("GET","api/trainerSearchSuggestions.php?q="+str,true);
xmlhttp.send();
}
//}    if $('#txtHint .searchResults').length > 2 {
}
</script>
<style>
  .bodyhide{
    background-color:#ffa500 !important;
  }
</style>
</head>
<body style = "overflow-x:hidden;"><canvas id = "successCanvas" style = "position:absolute; z-index:0; width:0px;" height="400"></canvas> <div class="loadingScreen" style = "background-color:#ffa500 !important;"></div>
  <div class = "top" onclick="goToClientHome()" id = "topper" style = "background-color:#ffa500 !important;"><a style = "width:100%; text-align:center;" href = "home"> </a></div>

  <div class = 'alert alert-warning' style = 'width:100% !important; margin:0% !important; margin-bottom10%% !important; padding-left:10%; padding-right:none !important; padding-top:15px !important; display:none;' id = "alert">
    <h1>Success</h1>
    <p>Database updated. </p>
    <br>
  </div>


  <div class = "panel-body" style="color:#808080; padding-left:3%; padding-right:3%;" >
    <div class = "container-fluid">
      <h1 class = "page-header nicepadding title" style = "color:#ffa500; padding-left:32px; padding-right:32px; text-align:center; border-bottom-width:0px;"> Settings</h1>
         <div class = "row">
      <h1 class = "page-header nicepadding largeSearch" style = "color:rgb(128, 128, 128); padding-left:12px; padding-right:12px; text-align:center; margin-bottom:0px;">Update Your Information</h1>
      <form role="form" method="post" action="settings#alerter">
       <fieldset>
        <h4 class="panel-title" style = "padding:2%; text-align:center !important;">Account Information</h4>
        <div class="input-group" style = "margin:0%; padding:0%; width:100%;">
          <div class = "col-sm-3" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
            <div class="input-group">
              <span class = "input-group-addon" style = "min-width:100px; text-align:left;">First Name:</span>
              <input class="form-control" required placeholder="First Name" maxlength="24" name="FirstName" id = "FirstName" type="text" value=<?php global $firstName; echo '"'. $firstName . '"'; ?>>
            </div>
          </div>
          <div class = "col-sm-3" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
            <div class="input-group">
              <span class = "input-group-addon" style = "min-width:100px; text-align:left;">Email:</span>
              <input class="form-control" required placeholder="E-mail" maxlength="30" name="email" id = "email" type="email" autofocus="" value = <?php global $email; echo '"'. $email . '"'; ?>>
            </div>
          </div>  

          <div class = "col-sm-3" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
            <div class="input-group">
              <span class = "input-group-addon" style = "min-width:100px; text-align:left;">Age:</span>
              <input  onkeyup="checkInp(this, 'years')" class="form-control" required placeholder="Age" maxlength="4" name="age" id = "age" type="text" value=<?php global $age; echo '"'. $age . '"'; ?>>
              <span class = "input-group-addon" style = "min-width:60px; text-align:right;">years</span>
            </div>      
          </div>
          <div class = "col-sm-3" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
            <div class="input-group">
              <span class = "input-group-addon" style = "min-width:100px; text-align:left;">Last Name: </span>
              <input class="form-control" required placeholder="Last Name " maxlength="24" name="LastName" id = "LastName" type="text" value=<?php global $lastName; echo '"'. $lastName . '"'; ?>>
            </div>
          </div>  
        </div>
        <br>
        <h4 class="panel-title" style = "padding:2%;text-align:center !important;">Personal Information</h4>
        <div class="input-group" style = "margin:0%; padding:0%; width:100%;">
          <div class = "col-sm-4" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
            <div class="input-group">
              <span class = "input-group-addon" style = "min-width:80px; text-align:left;">Height:</span>
              <input class="form-control" required placeholder="Feet" maxlength="4" name="feet" onkeyup="checkInp(this, 'ft')" id = "feet" type="text" value=<?php global $feet; echo '"'. $feet . '"'; ?>>
              <span class = "input-group-addon" style = "min-width:60px; text-align:right;">ft</span>
            </div>
          </div>
          <div class = "col-sm-2" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
            <div class="input-group" style = "width:100%;">
              <input class="form-control" required placeholder="Inches" maxlength="4" name="inches" onkeyup="checkInp(this, 'in')"  id = "inches" type="text" value=<?php global $inches; echo '"'. $inches . '"'; ?>>
              <span class = "input-group-addon" style = "min-width:60px; text-align:right;">in</span>
            </div>
          </div>
          <div class = "col-sm-6" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
            <div class="input-group">
              <span class = "input-group-addon" style = "min-width:80px; text-align:left;">Weight:</span>
              <input  onkeyup="checkInp(this, 'lbs')" class="form-control" required placeholder="Weight" maxlength="4" name="weight" id = "weight" type="text" value=<?php global $weight; echo '"'. $weight . '"'; ?>>
              <span class = "input-group-addon" style = "min-width:60px; text-align:right;">lb</span>
            </div>
          </div>
        </div><br>
        <h4 class="panel-title" style = "padding:2%; text-align:center !important;">Optional Personal Description</h4>
        <div class="form-group">
          <textarea name="desc" maxlength="400" id="desc" rows="3" wrap="soft" class="form-control input-md"><?php global $description; echo $description; ?></textarea>
        </div>
        <!-- Change this to a button or input when using this as a form -->
        <input type="submit" name="register" style = "border-bottom-left-radius:0px; border-top-left-radius:0px;float:right; border-bottom-right-radius:10px; border-top-right-radius:10px; " id="register" value="Update" class="btn btn-sm btn-success"></input>
        <a class="btn btn-sm btn-default" style = "float:right; border-bottom-right-radius:0px; border-top-right-radius:0px; border-bottom-left-radius:10px; border-top-left-radius:10px;float:right; " href= "#refresh" onclick="goToSettings()">Reset</a>
      </fieldset>
    </form>
  </div>


</div>
</div>

  <script src = "js/script.js"></script><script src = "js/tourGenerator.js"></script>
<script>
 
  function runCheckWithoutRefresh(){
    greenMarkTrigger(function(){
      setTimeout(function(){
        $('#successCanvas').fadeOut();
        $('#affirmationCheckModal').fadeOut();
      }, 2000);
    });
  }

</script>
<?php
global $javascriptSetter;
echo $javascriptSetter;
?>
</body>
</html>
