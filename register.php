<?php
session_start();
include "databaseCalls.php";
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
  header("location: login" );
  die();
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
  <title>TrainerAssist Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Eric Zhao">
  <meta charset="UTF-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
  
  <link href = "css/bootstrap.min.css" rel = "stylesheet" type="text/css">
  <link rel="apple-touch-icon-precomposed" href="img/squarelogo.png">
  <link rel="icon" href="img/squarelogo.png">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css"> <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'> <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'> <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
  <style type="text/css">
      .loadingScreen {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  background-color:#ffae19;
  z-index: 1102;
  border-bottom-color:white;
  border-bottom-width:0px;
  border-bottom-style:solid;
}
.bodyhide{
  background-color: #ffae19 !important;
}
.bodyhidee{
  background-color: #0099cc !important;
}
  body { 
    background-color:#ffa500;
  }
  html, body { overflow-x:hidden; }
  body { margin:0; padding:0; }
  .input-group {
    padding-bottom:5px;
  }
  </style>
</head>
<body>
  <?php
  
  $link = databaseEditConnect("LEMonadestand20Laugh");
  mysqli_select_db($link, "trainerassist");

  // Builds information
  if(!empty($_POST['username']) && !empty($_POST['password']))
  {
    $username = strtolower(mysqli_real_escape_string($link, $_POST['username']));
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $feet = mysqli_real_escape_string($link, $_POST['feet']);
    $inches = mysqli_real_escape_string($link, $_POST['inches']);
    $weight = mysqli_real_escape_string($link, $_POST['weight']);
    $desc = mysqli_real_escape_string($link, $_POST['desc']);
    $age = mysqli_real_escape_string($link, $_POST['age']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $firstName = mysqli_real_escape_string($link, $_POST['FirstName']);
    $lastName = mysqli_real_escape_string($link, $_POST['LastName']);
    
    // Check already username existing
    $checkusername = mysqli_query($link, "SELECT * FROM users WHERE Username = '".$username."'");
    
    if(mysqli_num_rows($checkusername) == 1)
    {
      echo "<div class = 'row alert alert-danger' role='alert' style = 'padding-left:10%;'><h1>Error</h1><p>Sorry, that username is taken. Please go back and try again.</p></div>";
    }
    else
    {
      // Human-ify measures
      $height = (($feet * 12) + $inches);
      $BMI = (($weight/($height*$height))*703);

      // Add to DB
      $registerquery = mysqli_query($link, ("INSERT INTO users(Username, FirstName, LastName, Password, EmailAddress, Weight, Height, Age, Description, BMI, Status) VALUES ('" . $username . "', '" . $firstName . "', '" . $lastName . "', '" . $password . "', '" . $email . "', '" . $weight . "', '" . $height . "', '" . $age . "', '" . $desc . "', '" . $BMI . "', '0')"));

      // Return error or alert
      if($registerquery)
      {
        echo "        <div class = 'row alert alert-warning' role='alert' style = 'padding-left:10%; '><h1>Success</h1><p>Your account was successfully created. Please <a href='login'>click here to login</a>.</p></div>";
      }
      else
      {
        echo "        <div class = 'row alert alert-danger' role='alert' style = 'padding-left:10%; '><h1>Something went wrong</h1><p>Please try again $registerquery</p></div>";
      }       
    }
  }
  ?>
    <div class="loadingScreen" id = "toppest"></div>
  <div class="col-md-10 col-md-offset-1"   style = 'padding-top:5%; padding-bottom:5%;'>
    <div class="modal-dialog"  style="margin-bottom:10%; width:100% !important; margin-left:0px;">
      <div class="modal-content" style = "width:100% !important;">
        <div class="panel-heading" style = "padding:0%;">
          <h3 style = "padding-left:5%; padding-right:5%; text-align:center;">Register for TrainerAssist Public Beta</h3>
        </div>
        <div class="panel-body" style = "padding-top:0%;">
          <form role="form" method="post" action="register" name="loginform" id="loginform">
            <fieldset>
              <h4 class="panel-title" style = "padding:2%; text-align:center !important;">Account Information</h4>
              <div class="input-group" style = "margin:0%; padding:0%;">
                <div class = "col-sm-4" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
                  <div class="input-group">
                    <span class = "input-group-addon" style = "min-width:100px; text-align:left;">First Name:</span>
                    <input class="form-control" required placeholder="First Name" maxlength="24" name="FirstName" id = "FirstName" type="text" value="">
                  </div>
                </div>
                <div class = "col-sm-4" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
                  <div class="input-group">
                    <span class = "input-group-addon" style = "min-width:100px; text-align:left;">Last Name: </span>
                    <input class="form-control" required placeholder="Last Name " maxlength="24" name="LastName" id = "LastName" type="text" value="">
                  </div>
                </div>             
                <div class = "col-sm-4" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
                  <div class="input-group">
                    <span class = "input-group-addon" style = "min-width:100px; text-align:left;">Age:</span>
                    <input  onkeyup="checkInputIsNumber(this, 'years')" class="form-control" required placeholder="Age" maxlength="4" name="age" id = "age" type="text" value="">
                    <span class = "input-group-addon" style = "min-width:60px; text-align:right;">years</span>
                  </div>      
                </div>
              </div>
              <div class="input-group" style = "margin:0%; padding:0%;">

                <div class = "col-sm-4" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
                  <div class="input-group">
                    <span class = "input-group-addon" style = "min-width:100px; text-align:left;">Username:</span>
                    <input class="form-control" required placeholder="Username" maxlength="20" name="username" id = "username" type="text" autofocus="">

                  </div>
                </div>

                <div class = "col-sm-4" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
                  <div class="input-group">
                    <span class = "input-group-addon" style = "min-width:100px; text-align:left;">Email:</span>
                    <input class="form-control" required placeholder="E-mail" maxlength="30" name="email" id = "email" type="email" autofocus="">

                  </div>
                </div>
                <div class = "col-sm-4" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
                  <div class="input-group">
                    <span class = "input-group-addon" style = "min-width:100px; text-align:left;">Password:</span>
                    <input class="form-control" required placeholder="Password" maxlength="30" minlength="10" name="password" id = "password" type="password" value="">
                  </div>
                </div>              
              </div>

<br>
              <h4 class="panel-title" style = "padding:2%;text-align:center !important;">Personal Information</h4>

              <div class="input-group" style = "margin:0%; padding:0%;">
                <div class = "col-sm-4" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
                  <div class="input-group">
                    <span class = "input-group-addon" style = "min-width:80px; text-align:left;">Height:</span>
                    <input class="form-control" required placeholder="Feet" maxlength="4" name="feet" onkeyup="checkInputIsNumber(this, 'ft')" id = "feet" type="text" value="">
                    <span class = "input-group-addon" style = "min-width:60px; text-align:right;">ft</span>
                  </div>
                </div>
                <div class = "col-sm-2" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
                  <div class="input-group">
                    <input class="form-control" required placeholder="Inches" maxlength="4" name="inches" onkeyup="checkInputIsNumber(this, 'in')"  id = "inches" type="text" value="">
                    <span class = "input-group-addon" style = "min-width:60px; text-align:right;">in</span>
                  </div>
                </div>
                <div class = "col-sm-6" style = "margin:0%; padding-top:0%; padding-bottom:0%;">
                  <div class="input-group">
                    <span class = "input-group-addon" style = "min-width:80px; text-align:left;">Weight:</span>
                    <input  onkeyup="checkInputIsNumber(this, 'lbs')" class="form-control" required placeholder="Weight" maxlength="4" name="weight" id = "weight" type="text" value="">
                    <span class = "input-group-addon" style = "min-width:60px; text-align:right;">lb</span>
                  </div>
                </div>

              </div><br>
              <h4 class="panel-title" style = "padding:2%; text-align:center !important;">Optional Personal Description</h4>
              <div class="form-group">
                <textarea name="desc" maxlength="400" id="desc" rows="3" wrap="soft" class="form-control input-md"></textarea>
              </div>
              
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" name="register" style = "border-bottom-left-radius:0px; border-top-left-radius:0px;float:right; border-bottom-right-radius:10px; border-top-right-radius:10px; " id="register" value="Register" class="btn btn-sm btn-success"></input>
           <a style = "float:right; border-bottom-right-radius:0px; border-top-right-radius:0px; border-bottom-left-radius:0px; border-top-left-radius:0px;float:right; " class="btn btn-sm btn-default" onclick = "goToCompHomepage()">Home</a>
              <a class="btn btn-sm btn-default" style = "float:right; border-bottom-right-radius:0px; border-top-right-radius:0px; border-bottom-left-radius:10px; border-top-left-radius:10px;float:right; " onclick = "goToLoginPage()" href= "#login">Back to Sign In</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>  
  <script src="js/script.js"></script>
</body>  
<!--
Copyright (c) 2015, Eric Zhao, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
-->
</html>
