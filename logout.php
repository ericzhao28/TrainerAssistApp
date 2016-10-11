<?php 
/* 
Copyright (c) 2015, Eric Zhao, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
*/
// Log out by destroying session
session_start();
$_SESSION = array(); 
session_destroy(); 
?>
<meta http-equiv="refresh" content="0;appIndex">