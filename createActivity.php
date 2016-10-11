<?php
include "loginScript.php";

// Check for success alert
$link = databaseViewConnect();
if (isset($_GET['newid'])) {
  global $alert;
  $num = mysqli_escape_string($link, $_GET['newid']);
  $alert = "<div class = 'row alert alert-success' role='alert' style = 'padding-left:7%; '><h1>Exercise Added</h1><p>Your new exercise's identification number is <a href = \"https://www.whimmly.com/TrainerAssist/activityDisplay?id=$num\">" . $num . "</a>.</p></div>";
} else {
  global $alert;
  $alert = "";
}

// Check for error alerts
if (isset($_GET['error'])) {
  global $alert;
  $num = mysqli_escape_string($link, $_GET['newid']);
  $alert = "<div class = 'row alert alert-danger' role='alert' style = 'padding-left:7%; '><h1>Error.</h1><p>Missing one or more required fields.</p></div>";
} else {
  global $error;
  $error = "";
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
  <title>TrainerAssist</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Create an Exercise">
  <meta name="author" content="Eric Zhao">
  <meta charset="UTF-8">
  <link href="css/bootstrap-tour.min.css" rel="stylesheet">
  <link href = "css/bootstrap.min.css" rel = "stylesheet" type="text/css">
  <link href = "css/styless.css" rel = "stylesheet" type="text/css">
  <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" type="text/css">
  <link rel="apple-touch-icon-precomposed" href="img/squarelogo.png">
  <link rel="icon" href="img/squarelogo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
  <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
  <style>
    canvas
    {
      pointer-events: none;       /* make the canvas transparent to the mouse - needed since canvas is position infront of image */
      position: absolute;
    }
  </style>
</head>
<body style = "overflow-x:hidden;" onload = 'myInit()'>
  <canvas id='myCanvas'></canvas>   
  <div class="loadingScreen">
  </div>
  <div class = "top"  onclick="goToTrainerHome()" id = "topper">
    <a style = "width:100%; text-align:center;" href = "home"></a>
  </div>
  <?php
    // Actual error location
    global $alert;
    echo $alert;
    global $error;
    echo $error;
  ?>
  <div class = "row" >
    <div class = "col-sm-12" >
    </div>
  </div>
  <div class = "panel-body" style="color:#808080; padding-left:7%; padding-right:7%;" >

    <div class = "col-sm-9"  id = "primaryForm">
      <h1 class = "page-header nicepadding title" style = "color:#0099cc; margin-bottom:0%;  padding-left:17px; padding-right:17px;">Add Exercise</h1>
      <p></p>
      <form class="form-horizontal" id = "primaryForm" style = "padding-left:30px; padding-right:30px" method = "post" action = "api/saveActivity.php">
        <fieldset>
          <div class="form-group">
            <div class = "col-md-4">
              <p class = "formtitle">Title</p>
            </div>
            <div class="col-md-8">
              <input name="title" id="title" type="text" required maxlength="60" class="form-control input-md"/>
              <span class="help-block">Required. 60 characters max.</span>      
            </div>
          </div>

          <div class="form-group">
            <div class = "col-md-4">
              <p class = "formtitle">Short Description</p>
            </div>
            <div class="col-md-8 ">
              <div class = "form-group" style = "margin:0">
                <textarea name="description" id="description" required maxlength="400" id="desc" rows="3" wrap="soft" class="form-control input-md"></textarea>
                <span class="help-block has-errors">Required. 400 characters max.</span>  
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class = "col-md-4">
              <p class = "formtitle">Video Example</p>
            </div>
            <div class="col-md-8">
              <input name="youtubeLink" id="youtubeLink" type="text" maxlength="300" placeholder="Youtube only" class="form-control input-md"/>
              <span class="help-block">Leave blank if none. Paste link.</span>  
            </div>
          </div>      
          <div class="form-group">
            <div class = "col-md-4">
              <p class = "formtitle">Step 1</p>
            </div>
            <div class="col-md-8">
              <input name="step1" id="step1" type="text" maxlength="300" placeholder="" class="form-control input-md"/>
              <span class="help-block">Leave blank if none. Omit step number.</span>  
            </div>
          </div>
          <div class="form-group">
            <div class = "col-md-4">
              <p class = "formtitle">Step 2</p>
            </div>
            <div class="col-md-8">
              <input name="step2" id="step2" type="text" maxlength="300" placeholder="" class="form-control input-md"/>
              <span class="help-block">Leave blank if none. Omit step number.</span>  
            </div>
          </div>
          <div class="form-group">
            <div class = "col-md-4">
              <p class = "formtitle">Step 3</p>
            </div>
            <div class="col-md-8">
              <input name="step3" id="step3" type="text" maxlength="300" placeholder="" class="form-control input-md"/>
              <span class="help-block">Leave blank if none. Omit step number.</span>  
            </div>
          </div>
          <div class="form-group">
            <div class = "col-md-4">
              <p class = "formtitle">Step 4</p>
            </div>
            <div class="col-md-8">
              <input name="step4" id="step4" type="text" maxlength="300" placeholder="" class="form-control input-md"/>
              <span class="help-block">Leave blank if none. Omit step number.</span>  
            </div>
          </div>
          <div class="form-group">
            <div class = "col-md-4">
              <p class = "formtitle">Step 5</p>
            </div>
            <div class="col-md-8">
              <input name="step5" id="step5" type="text" maxlength="300" placeholder="" class="form-control input-md"/>
              <span class="help-block">Leave blank if none. Omit step number.</span>  
            </div>
          </div>
          <div style = "padding-bottom:5%;  padding-top:0% !important; border-top-color:rgb(238,238,238) !important;" class = "row" id = "muscleForm">

            <div class = "col-sm-6">
              <h2 class = "formtitle" style = "font-size:15px;  margin-bottom:8px;">Muscle Selector: </h2>
              <img src="img/muscleDiagram.jpg" width="100%" alt="Muscle Diagram"
              usemap="#muscleMap" id = "musclesMapImg">
              <map name="muscleMap" id="muscleMap-image-maps-2015-09-07-174441">
                <area shape="rect" coords="1022,1022,1024,1024" alt="Image Map" style="outline:none;" title="Image Map">
                <area alt="" title=""  shape="poly" coords="854,169,812,182,853,200,865,228,888,251,897,238,889,194,879,175"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('deltoid');">
                <area alt="" title=""  shape="poly" coords="663,169,632,188,626,239,627,275,663,243,694,188,726,187"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('deltoid')">
                <area alt="" title=""  shape="poly" coords="806,187,849,201,859,229,849,277,820,286,774,278,732,281,722,291,691,272,681,249,671,212,693,193,726,185,771,195"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('pectoralis_major')">
                <area alt="" title=""  shape="poly" coords="682,323,696,306,707,288,676,254,669,309"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('latissimus_dorsi')">
                <area alt="" title=""  shape="poly" coords="851,264,824,292,836,315,843,324,850,310"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('lattisimus_dorsi')">
                <area alt="" title=""  shape="poly" coords="863,232,846,291,857,334,880,347,896,324,894,255"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('biceps_brachil')">
                <area alt="" title=""  shape="poly" coords="662,238,624,264,613,327,639,354,661,358,668,298"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('biceps_brachil')">
                <area alt="" title=""  shape="poly" coords="715,293,681,319,686,400,688,428,717,453,732,458,727,402,717,330"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('external_oblique')">
                <area alt="" title=""  shape="poly" coords="812,301,816,360,803,443,811,463,841,430,844,368,842,321,834,295"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('external_oblique')">
                <area alt="" title=""  shape="poly" coords="772,280,729,291,721,335,721,373,731,429,748,508,775,505,791,459,806,413,814,363,814,332,813,391,811,296"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('rectus_abdominis')">
                <area alt="" title=""  shape="poly" coords="612,330,597,392,590,441,593,466,620,473,643,422,662,368,652,350,635,360"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('flexor_carpi_group')">
                <area alt="" title=""  shape="poly" coords="899,322,888,351,871,341,856,362,884,468,916,463,911,365"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('flexor_carpi_group')">
                <area alt="" title=""  shape="poly" coords="706,455.0000073939193,743,552.0000073939193,754,546.0000073939193,751,522.0000073939193,722,463.0000073939193"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('iliopsoas')">
                <area alt="" title=""  shape="poly" coords="820,448.0000073939193,773,611.0000073939193,767,655.0000073939193,771,670.0000073939193,803,563.0000073939193,813,535.0000073939193,824,470.0000073939193,830,454.0000073939193"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('sartorius')">
                <area alt="" title=""  shape="poly" coords="700,445.0000073939193,704,497.0000073939193,725,555.0000073939193,743,620.0000073939193,751,637.0000073939193,755,617.0000073939193,747,574.0000073939193,738,536.0000073939193,708,466.0000073939193"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('sartorius')">
                <area alt="" title=""  shape="poly" coords="826,476.0000026373215,855,547.0000026373215,855,594.0000026373215,847,637.0000026373215,836,684.0000026373215,830,698.0000026373215,821,695.0000026373215,820,677.0000026373215,806,677.0000026373215,800,703.0000026373215,783,710.0000026373215,774,695.0000026373215,774,641.0000026373215"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('quadriceps_fernois_group')">
                <area alt="" title=""  shape="poly" coords="698,470.00000452112255,676,521.0000045211225,661,561.0000045211225,678,650.0000045211225,692,693.0000045211225,704,712.0000045211225,710,672.0000045211225,722,670.0000045211225,732,696.0000045211225,747,700.0000045211225,748,644.0000045211225,743,596.0000045211225"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('quadriceps_fernois_group')">
                <area alt="" title=""  shape="poly" coords="697,736.0000152352412,705,823.0000152352412,728,888.0000152352412,741,886.0000152352412,747,854.0000152352412,746,838.0000152352412"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('tibialis_anterior')">
                <area alt="" title=""  shape="poly" coords="824,752.0000152352412,817,798.0000152352412,811,816.0000152352412,793,833.0000152352412,782,843.0000152352412,791,872.0000152352412,800,898.0000152352412,798,915.0000152352412,817,885.0000152352412,832,828.0000152352412,833,801.0000152352412,832,771.0000152352412"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('tibialis_anterior')">
                <area alt="" title=""  shape="poly" coords="782,760.0000152352412,776,815.0000152352412,783,838.0000152352412,795,830.0000152352412,802,801.0000152352412"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('gastrocnemius')">
                <area alt="" title=""  shape="poly" coords="741,760.0000152352412,731,796.0000152352412,734,824.0000152352412,750,835.0000152352412,751,800.0000152352412"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('gastrocnemius')">
                <area alt="" title=""  shape="poly" coords="813,454.9999972684882,781,506.9999972684882,763,526.9999972684882,773,544.9999972684882,790,540.9999972684882,802,516.9999972684882,820,463.9999972684882"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('iliopsoas')">
                <area alt="" title=""  shape="poly" coords="836,758.000017089608,834,810.000017089608,825,847.000017089608,820,894.000017089608,818,921.000017089608,830,923.000017089608,840,845.000017089608,842,786.000017089608"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('peroneus_longus')">
                <area alt="" title=""  shape="poly" coords="686,748.000017089608,681,791.000017089608,698,854.000017089608,708,911.000017089608,725,916.000017089608"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('peroneus_longus')">
                <area alt="" title=""  shape="poly" coords="791,145,778,183,828,168,838,168"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('trapezius')">
                <area alt="" title=""  shape="poly" coords="729,143,675,166,703,179,731,179,732,168"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('trapezius')">
                <area alt="" title=""  shape="poly" coords="295,122,263,145,210,166,239,193,256,276,289,334,302,349,314,333,350,261,355,193,382,170,353,158"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('trapezius')">
                <area alt="" title=""  shape="poly" coords="391,169,352,187,390,198,398,198,421,226,431,247,432,232,426,201,418,183"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('deltoid')">
                <area alt="" title=""  shape="poly" coords="203,166,166,180,158,219,157,246,174,226,198,212,207,203,231,192,238,185"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('deltoid')">
                <area alt="" title=""  shape="poly" coords="196,210,158,246,153,302,159,346,181,358,202,341,206,308,207,250"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('triceps_brachil')">
                <area alt="" title=""  shape="poly" coords="406,206,384,254,385,300,397,361,425,357,442,331,437,276,433,248,421,230"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('triceps_brachil')">
                <area alt="" title=""  shape="poly" coords="350,262,317,343,341,416,354,423,370,370,375,333,382,301,380,267"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('latissimus_dorsi')">
                <area alt="" title=""  shape="poly" coords="247,265,204,267,204,318,223,355,216,393,227,423,253,423,260,376,284,349,284,326,276,306"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('latissimus_dorsi')">
                <area alt="" title=""  shape="poly" coords="349,431,308,477,283,451,260,436,219,482,214,530,219,579,237,553,282,548,296,531,303,529,313,538,357,547,371,546,374,567,385,516,381,484,374,457"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('gluteus_maximus')">
                <area alt="" title=""  shape="poly" coords="320,535,300,574,312,641,308,673,307,714,319,743,345,703,343,715,360,699,367,722,377,655,374,586,371,544"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('hamstring_group')">
                <area alt="" title=""  shape="poly" coords="283,539,240,549,221,579,220,642,218,713,222,729,231,703,244,725,252,709,273,745,286,700,281,651,295,589,293,548"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('hamstring_group')">
                <area alt="" title=""  shape="poly" coords="241,823,227,833,215,837,235,878,243,920,250,960,260,966,258,942,261,896,263,853,268,849"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('achilles_tendon')">
                <area alt="" title=""  shape="poly" coords="346,819,309,844,316,883,316,936,312,956,323,955,333,907,338,883,355,847,358,835"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('achilles_tendon')">
                <area alt="" title=""  shape="poly" coords="356,838,336,916,327,955,333,941,341,913,352,884,365,854,366,837"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('peroneus_tongus')">
                <area alt="" title=""  shape="poly" coords="218,845,228,883,235,932,242,955,244,927,245,903,235,877"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('peroneus_tongus')">
                <area alt="" title=""  shape="poly" coords="232,723,222,740,218,800,218,822,227,839,241,837,247,816,256,836,265,842,267,845,275,822,275,798,277,772,269,745,262,721,248,730"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('gastrocnemius')">
                <area alt="" title=""  shape="poly" coords="331,707,344,726,359,701,368,719,371,753,374,786,369,829,348,830,342,805,339,825,323,840,312,838,313,791,319,742"  onmouseover='myHover(this);' onmouseout='myLeave();' style="outline:none;" target="_blank" onclick="addMuscle('gastrocnemius')">
              </map>
            </div>
            
            <div class = "col-sm-6">

              <h2 class = "formtitle" style = "font-size:15px;  margin-bottom:8px;">Linked: </h2>
              <ul class = "list-group" id = "muscleList">
                <li class = "list-group-item">
                  Click the diagram to add muscles.
                </li>
              </ul>
            </div>


          </div>
          <div class="form-group">
            <div class="col-md-12">  
              <input type="hidden" name="type" value="activity"/>
              <input type="hidden" name="muscleString" id = "muscleString" value=""/>
              <input type="hidden" name="replace" id = "replace" value=""/>
              <div class = "col-sm-2 col-sm-offset-10">
                <button value = "Sent" name="submit" class="btn btn-success">Submit</button>
              </div>
            </div>
          </div>
        </fieldset>
      </form>
      <br><br>
    </div>
    <br>
    <div class = "col-sm-3" style = "padding:0;">
      <h1 class = "page-header nicepadding title" style = "color:#0099cc; margin-bottom:0%; border-bottom-width:0px">&nbsp;</h1>




      <div style = "padding:5%;  padding-top:0% !important; border-top-color:rgb(238,238,238) !important;" id = "copyForm">
        <h2 class = "formtitle" style = "font-size:20px; margin-bottom:8px;">Duplicate an activity: </h2>
        <input placeholder=" Name of exercise to duplicate" type="text" id="searchActivitiesForDuplication" onkeyup="searchActivitiesForDuplication(this.value)"  style = "width:100%; ">
        <ul class="list-group" id="listOfActivitesForDuplication">
        </ul>
      </div>

      <div style = "padding:5%;  padding-top:0% !important; padding-bottom:1% !important; border-top-color:rgb(238,238,238) !important; border-top-width:0px;" id = "editForm">
        <h2 class = "formtitle" style = "font-size:20px;  margin-bottom:8px; border-top-width:0px;">Edit an exercise: </h2>
        <ul class="list-group" id="txtHint">
          <?php
          // Returns list of plans according to activity author
          $link = databaseViewConnect();
          $username = $_SESSION['Username'];
          $hint = "";
          // Returns each activity by user
          forEach(sqlDataItemExists("activity", "id", $link, "user", mysqli_escape_string($link, $username), null, true) as $id) {
            $id = $id[0];
            // Returns activity data, and feeds the data into the html template
            $name = sqlDataItemExists("activity", "title", $link, "id", $id)[0];
            $hint .= "<a onclick = \"replicateActivity(this)\" href=\"#\" class='list-group-item searchResults' data-id=\"$id\"> \"$name\" - an exercise by $username ($id)</a>";
          }
          echo ($hint == "") ? "<a href='#' class='list-group-item' > No plans found. </a>" : $hint;

          ?>
          
        </ul>
      </div>


    </div>
  </div>
  <footer>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/imageMapResizer.min.js"></script>
    <script src="js/bootstrap-tour.min.js"></script>
    <script src="js/muscleSelector.js"></script>
    <script src="js/script.js"></script>
    <script src="js/tourGenerator.js"></script>
    <script>
var muscles = {};
muscles.selected = new Array();
$(document).ready(function() {
  initiateMuscleImageMap();
  replicateActivity(null, true);
  createActivityTour();
  // Initalize some objects
});
  $('map').imageMapResize();
  if($('#location-map')) {
    $('#location-map area').each(function() {
      var id = $(this).attr('id');
      $(this).mouseover(function() {
        $('#overlay'+id).show();
      });
      $(this).mouseout(function() {
        var id = $(this).attr('id');
        $('#overlay'+id).hide();
      });

    });
  }


// Delete muscle from selected list
function removeThisMuscle(obj){
  obj.parentNode.parentNode.removeChild(obj.parentNode);
  muscles.splice(obj.parentNode.getAttribute("data-name"),1);
  document.getElementById("muscleString").value = JSON.stringify(muscles);
}

// Add muscle to selected list
function addMuscle(str){
  if (muscles.selected.indexOf(str) == -1){
    muscles.selected.push(str);
    document.getElementById("muscleString").value = JSON.stringify(muscles);
  }
  addMuscleToUIList();
}

// Search activities for duplication
function searchActivitiesForDuplication(str)
{
  suggestionsSearch(document.getElementById("listOfActivitesForDuplication"), str, "api/activityCopyPasteSuggestion.php?q=", function(){
  });
}

// Replicate activities for either duplicating or replacing
function replicateActivity(obj, initial, copyPaste){
  // If initial replacement called udring initialization, fetch default ID from the parameter
  if (initial == true){
    var id = getParameterByName("replaceID");
  } else {
    var id = obj.getAttribute("data-id");
  }
  // If current ID is valid, call for updates
  if (id != "") {

    var fieldsToChange=['title', 'description', 'youtubeLink', 'step1', 'step2', 'step3', 'step4', 'step5'];
    // Update all the fields
    fieldsToChange.forEach(function(currentValue){
      getRequest("api/getActivityDetail.php?id=" + id + "&type=" + currentValue, function(response){
        document.getElementById(currentValue).value = response;
      });
    });
    

    // Prep replace hidden form place
    if (copyPaste!=true){
      document.getElementById("replace").value=id;
    }

    // Clear out list of activities
    $('#listOfActivitesForDuplication').empty();
  }
}
</script>
</footer>
</body>
</html>
