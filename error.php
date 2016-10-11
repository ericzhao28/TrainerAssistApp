<!--
Copyright (c) 2015, Eric Zhao and Youth Competitive Programming Circle, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
    <title><?php global $title; echo $title; ?></title>
    <meta http-equiv = "content-type" content = "text/html" content = "charset=utf8" name="viewport" content = "width=device-width, initial-scale=1.0"> 
    <meta name="author" content="Eric Zhao and Youth Competitive Programming Circle contributors.">
    <!--Link to local style sheets-->
    <link href = "https://www.ycpc.us/css/bootstrap.min.css" rel = "stylesheet">
    <link href = "https://www.ycpc.us/css/courseStyles.css" rel = "stylesheet">
    <link href = "https://www.ycpc.us/css/perfect-scrollbar-0.4.10.min.css" rel = "stylesheet">
    <link rel="apple-touch-icon-precomposed" href="https://www.ycpc.us/img/squarelogo.png">
    <link rel="icon" href="https://www.ycpc.us/img/squarelogo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
</head>
<body>
    <?php include "includecode/load.html"; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>
                        Oops.
                    </h1>
                    <br><br>
                    <h2>
                        We were <?php
                        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        $pageid = $_GET['id'];  
                        echo $pageid . " ";
                        echo (isset($error)) ? $error : "unable to get link";} 
                        ?> 
                        </h2>
                        <br><br>
                        <div class="error-actions">
                            <a href="https://www.ycpc.us" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                                Take Me Home </a><a href="https://www.ycpc.us/about#contact" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(window).load(function () {
                    $("#loader").fadeOut("fast");
                })
            </script>
            <script>
                $(document).ready(function() { 
                    $("#loader").fadeOut("fast");
                })
            </script>
        </body>
        </html>