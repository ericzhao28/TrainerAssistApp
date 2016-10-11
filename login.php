<?php 

// DB Connection
include "databaseCalls.php"; 
session_start();
$link = databaseViewConnect();
mysqli_select_db($link, "trainerassist");

// Check for earlier session credentials
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && ($_SESSION['Status'] == 0))
{
  header("location: appIndex" );
  die();
}

// Check for fresh login form submission via POST
elseif(!empty($_POST['username']) && !empty($_POST['password']))
{

  // Verify POST credentials
  $username = strtolower(mysqli_real_escape_string($link, $_POST['username']));
  $password = mysqli_real_escape_string($link, $_POST['password']);
  $checklogin = mysqli_query($link, "SELECT * FROM users WHERE Username = '".$username."' AND Password = '".$password."'");
  if(mysqli_num_rows($checklogin) == 1)
  {
    $row = mysqli_fetch_array($checklogin);
    $email = $row['EmailAddress'];

    $_SESSION['Username'] = $username;
    $_SESSION['EmailAddress'] = $email;
    $_SESSION['Status'] = 0;
    $_SESSION['LoggedIn'] = 1;
    header("location: appIndex" );
    die();
  }
  else
  {
    global $error;
    $error = "<div class = 'row alert alert-danger' role='alert' style = 'padding-left:10%; '><h7>Incorrect username or password.</h1></div>";
  }
}
else
{
// Not logged in
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
  "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>TrainerAssist Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Eric Zhao">
  <meta charset="UTF-8">    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

  <link href = "css/bootstrap.min.css" rel = "stylesheet" type="text/css">
  <link rel="apple-touch-icon-precomposed" href="img/squarelogo.png">
  <link rel="icon" href="img/squarelogo.png">
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
    .bodyhidee{
      background-color: #ffae19 !important;
    }
    .bodyhide{
      background-color: #ffa500 !important;
    }
    body { 
      background-color:#ffa500;
    }
    html, body {  height: 100%; overflow-x:hidden; }
    body { margin:0; padding:0; }
  </style>
</head>
<body>
  <?php 
  global $error;
  echo $error;
  ?>
  <div class="loadingScreen" id = "toppest"></div>
  <div class="col-md-6 col-md-offset-3"  style = 'top:20%;'>
    <div class="modal-dialog" style="margin-bottom:20%; width:100% !important; margin-left:0px;">
      <div class="modal-content" style = "width:100% !important;">
        <div class="panel-heading">
          <h3 class="panel-title">Sign In to TrainerAssist Demo</h3>
        </div>
        <div class="panel-body">
          <form role="form" method="post" action="login">
            <fieldset>
              <div class="form-group">
                <input required class="form-control" maxlength="20" placeholder="Username" name="username" id = "username" type="text" autofocus="" value="testUser">
              </div>
              <div class="form-group">
                <input required class="form-control" maxlength="30" minlength="10" placeholder="Password" name="password" id = "password" type="password" value="testtesttest">
              </div>
              <!-- Change this to a button or input when using this as a form -->             
              <input type="submit" name="Login" style = "border-bottom-left-radius:0px; border-top-left-radius:0px;float:right; border-bottom-right-radius:10px; border-top-right-radius:10px; " id="register" id="Login" value="Sign in" class="btn btn-sm btn-success"></input>
              <a style = "float:right; border-bottom-right-radius:0px; border-top-right-radius:0px; border-bottom-left-radius:0px; border-top-left-radius:0px;float:right; " class="btn btn-sm btn-default" onclick = "goToCompHomepage()" href= "#goToCompHomepage">Home</a>
              <a style = "float:right; border-bottom-right-radius:0px; border-top-right-radius:0px; border-bottom-left-radius:10px; border-top-left-radius:10px;float:right; " class="btn btn-sm btn-default" onclick = "goToRegisterPage()" href= "#register">Register</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="js/bootstrap.min.js"></script>  <script src="js/script.js"></script>
  <script>
    
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
