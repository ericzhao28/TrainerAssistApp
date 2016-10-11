<?php
session_start();
include "databaseCalls.php";
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
  // If logged in
}
else
{
    header("location: login" );
    die();
}

?>
