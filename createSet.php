<?php
include "loginScript.php";

$link = databaseViewConnect();

// Generate alerts
if (isset($_GET['newid'])) {
  global $alert;
  $num = mysqli_escape_string($link, $_GET['newid']);
  $alert = "<div class = 'row alert alert-success' role='alert' style = 'padding-left:7%; '><h1>Plan Added</h1><p>Your new workout plan's identification number is <a href = \"https://www.whimmly.com/TrainerAssist/workoutPreview?id=$num\">" . $num . "</a>.</p></div>";
} else {
  global $alert;
  $alert = "";
}

// Generate errors
if (isset($_GET['error'])) {
  global $alert;
  $num = mysqli_escape_string($link, $_GET['newid']);
  $alert = "<div class = 'row alert alert-danger' role='alert' style = 'padding-left:7%; '><h1>Error.</h1><p>Something went wrong. Try again.</p></div>";
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
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Create a Plan">
  <meta name="author" content="Eric Zhao">
  <title>TrainerAssist</title>
  <link href="css/bootstrap-tour.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/animate.css" type="text/css">
  <link href = "css/styless.css" rel = "stylesheet" type="text/css">
  <link rel="apple-touch-icon-precomposed" href="img/squarelogo.png">
  <link rel="icon" href="img/squarelogo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
  <script src="https://www.whimmly.com/TrainerAssist/js/hoverintent.js"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
  <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
  <script type="text/javascript" src="js/bootstrap-tour-standalone.min.js"></script>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

</head>
<body style = "overflow-x:hidden;">

  <div class="loadingScreen"></div>
  <div class = "top" onclick="goToTrainerHome()" id = "topper">
    <a style = "width:100%; text-align:center;" href = "home"></a>
  </div>

  <?php
  global $alert;
  echo $alert;
  global $error;
  echo $error;
  ?>
  
  <div class = "panel-body" style="color:#808080; padding-left:3%; padding-right:3%;" >
    <h1 class = "page-header nicepadding title" style = "color:#0099cc;border-bottom-color:#d6d6d6; padding-left:17px; padding-right:17px;">Create a plan</h1>
    <p></p>
    <div class = "row" id = "row-eq-heighter">
      <div class = "col-md-7 col-sm-12" id = "chooseExercise" style = " padding-left:32px; padding-right:32px;  border-bottom-style: solid; border-bottom-width:1px; border-bottom-color:#d6d6d6;">
        <br>
        <h2 class = "formtitle" style = "font-size:25px;">Choose your exercises:</h2>
        <br>
        <div> 
          Search by name or ID: 
          <br>
          <br>
          <input type="text" id="searchForActivities" onkeyup="searchForActivity(this.value)" style = "width:100%;">
        </div>
        <ul class="list-group" id="suggestedExercises">
        </ul>
        <br>
        <br>
        <br>
      </div>
      <div class = "col-md-5 col-sm-12" id = "selectedExercise" style = " padding-left:32px; padding-right:32px;  border-bottom-style: solid; border-bottom-width:1px; border-bottom-color:#d6d6d6;">
        <br>
        <h2 class = "formtitle" style = "font-size:25px;">Selected exercises:</h2>
        <br>
        Click to remove: 
        <br>
        <br>
        <ul class="list-group" id="selectedExercises">
        </ul>
        <br>
        <br>
        <br>
      </div>

    </div>
    <div class = "row">
      <div class = "col-sm-12" style = "padding-left:32px; padding-right:32px; border-bottom-style: solid; border-bottom-width:1px; border-bottom-color:#d6d6d6;">
        <br>
        <br>
        <br>

        
        <div class = "row-eq-height row"> 
          <div class = "col-md-4 col-sm-12"  id = "buildSet" style = " padding-left:26px; padding-right:26px; border-bottom-style: solid; border-bottom-width:1px; border-bottom-color:#d6d6d6;">
            <h2 class = "formtitle" style = "font-size:25px;">Build your plan:</h2>
            <br>
            <div>
              Add and customize exercises: 
              <br>
              <br>
              <select id = "listOfSelectedExerciseOptions" style = "height:22px; line-height:18px; font-size:14px; width:100%;">
                <option data-id= "defaultActivitySelectionValue">Select exercise...</option>
                <option data-id = "Rest">Rest</option>
              </select>
              <br>
              <br>
              <div>
                <div class = "col-sm-5 noside" style = "padding-right:2px; padding-left:2px;">
                  <div class="input-group" style = "width:100%;">
                   <input type="text" id="selectedActivityReps" style = "width:100%;border-top-right-radius:0px; border-bottom-right-radius:0px; " maxlength = "10"  placeholder=" Reps/rest time">
                   <span class = "input-group-addon" style = "min-width:30px; text-align:right; font-size:12px; border-bottom-left-radius:0px; border-top-left-radius:0px;">reps</span>
                 </div>


               </div>
               <div class = "col-sm-5 noside"  style = "padding-right:2px; padding-left:2px;">
                <div class="input-group" style = "width:100%;">
                  <input type="text" id="selectedActivityWeight" style = "width:100%;border-top-right-radius:0px; border-bottom-right-radius:0px; " maxlength = "10"  placeholder=" Weight (optional)">
                  <span class = "input-group-addon" style = "min-width:30px; text-align:right; font-size:12px; border-bottom-left-radius:0px; border-top-left-radius:0px;">lb</span>
                </div>
              </div>
              <div class = "col-sm-2 noside" style = "text-align:center;">
                <a href="#searching" onclick="addExerciseToDay()" style ="width: 16px;
                height: 20px; top: 3px; text-align:center;
                position: relative;
                ">
                <span class="glyphicon glyphicon-ok" style = "height:20px; font-size: 20px; text-align:center; z-index:501" aria-hidden="true" ></span>
              </a>
            </div>
          </div>
        </div>
        <br>
        <br>
        <br>
      </div>
      <div class = "col-md-5 col-sm-12" id = "defaultDay" style = " padding-left:32px; padding-right:32px;"> 

        <h2 class = "formtitle" style = "font-size:25px;">Set Your Plan's Days:</h2>
        <br>
        <br>
        <li  class="list-group-item" style = "background-color:#0099cc; color:white; min-height:40px;"><div class = "col-sm-9" style = "height:auto !important;">Default Day</div><div class = "col-sm-3">           <select id = "dayChooser" style = "font-size:14px; width:100%; text-align:center;text-indent:5px;color:black;">
          <option data-id= "newDay" style = "text-align:center;">New day</option>
        </select></div> </li>
        <ul class="list-group" id="dayActivityAddedList">
          <li  class="list-group-item" id = "ignore">Set default days above </li>
        </ul>
        <div class =  "col-sm-6" style = "padding:0 !important;">
          <a style = "width:100%; border-top-right-radius:0px; border-bottom-right-radius:0px; border-bottom-left-radius:0px;" onclick = "addRestDay()" href="#searching" class="btn btn-info">Add Rest Day</a>
        </div>
        <div class =  "col-sm-6" style = "padding:0 !important;">
          <a style = "width:100%; border-top-left-radius:0px; border-bottom-left-radius:0px; border-top-right-radius:0px" onclick = "addExerciseDay()" href="#searching" class="btn btn-success">Add Default Day</a>
        </div>

        <br>
        <br>
        <br>



      </div>

      <div class = "col-md-3 col-sm-12" id = "addInfomation" style = " padding-left:32px; padding-right:32px;"> 

        <h2 class = "formtitle" style = "font-size:25px;">Add a note:</h2>
        <br>
        <br>
        <li  class="list-group-item" style = "background-color:#0099cc; color:white"> Attach a note or description for the day:</li>
        
           <textarea id = "dayDesc" placeholder = "Add a description for today." style = "width:100%; height:30; padding-top:10px; padding-bottom:10px; padding-left:15px; padding-right:15px;" rows="5"></textarea>
        <br>
        <br>
        <br>



      </div>
    </div>
    <div class = "row">
      <div class = "col-sm-12" style = "padding-left:32px; padding-right:32px; border-bottom-style: solid; border-bottom-width:1px; border-bottom-color:#d6d6d6;">

        <div class = "row-eq-height row"> 

          <div class = "col-md-12  col-sm-12 sortable grid" id = "listOfDaysDiv" style = "padding-top:4%; background-color: #D8D8D8; padding-bottom:1%; min-height:200px;"> 

          </div>
        </div>
        <br>
        <br>
        <br>
      </div>
    </div>
    <div class = "row row-eq-height">
      <div class = "col-sm-7" id = "assignUsers" style = "padding-left:32px; padding-right:32px; border-bottom-style: solid; border-bottom-width:1px; border-bottom-color:#d6d6d6;">
        <br>
        <br>
        <br>
        <h2 class = "formtitle" style = "font-size:25px;">Share with Friends:</h2>
        <br>
        <div> 
          Search by username or name: 
          <br>
          <input type="text" id="searchForUsers" onkeyup="searchForUser(this.value)" style = "width:100%;">
        </div>
        <ul class="list-group" id="suggestedUsers">
        </ul>
        <br>
        <br>
        <br>
        <br>
      </div>

      <div class = "col-sm-5" id = "finalSet" style = " padding-left:32px; padding-right:32px;  border-bottom-style: solid; border-bottom-width:1px; border-bottom-color:#d6d6d6;">
        <br>
        <br>
        <br>
        <h2 class = "formtitle" style = "font-size:25px;">Title your plan:</h2><br>
        <form method = "post" action = "api/saveSet.php" enctype="multipart/form-data" onsubmit="return updateDataStringValue();">
          <fieldset>
            <div class="form-group">
              <div class = "col-md-2">
                <p class = "formtitle">Title</p>
              </div>
              <div class="col-md-10">
                <input name="title" type="text" required maxlength="60" placeholder="Name of exercise" class="form-control input-md"/>
                <br>
                <div class="input-group input-append date" id="datePicker" style = 'display:none;width:100%'>
                  <input type="text" placeholder = "Starting Date" class="form-control disabled" onkeydown="return false;" name="date" />
                  <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>

                </div>
                <script>
                  $(document).ready(function() {
          //          $('#datePicker')
          //          .datepicker({
          //            format: 'mm/dd/yyyy'
          //          })
         //           .on('changeDate', function(e) {
            // Revalidate the date field
        //    $('#eventForm').formValidation('revalidateField', 'date');

      //    });


                  });

                </script>
                <br><br>
              </div>
            </div>


            <!-- Button (Double) -->
            <div class="form-group">
              <div class="col-md-12">  
                <input type="hidden" name="type" value="set"/>
                <input type="hidden" id = "dataString" name="dataString" value=""/>
                <button value = "Sent" name="submit" class="btn btn-success pull-right">Submit</button>
              </div>
            </div>
          </fieldset>
        </form>

        <br>
        <br>
        <br>
        <br>
      </div>
    </div>
  </div>
  <script src="js/jquery.sortable.js"></script>
  <script src="js/bootstrap.min.js"></script><script src="js/bootstrap-tour.min.js"></script>
  <script src="js/script.js"></script><script src="js/tourGenerator.js"></script>
<script>
$(document).ready(function() {
  createSetTour();
  sortablesInitalization();
  if ($(window).width() > 1000) {
    $(document.getElementById("row-eq-heighter")).addClass("row-eq-height");
  }
});
// Initialize some objects
var masterJSONObject = {activitiesSelected: [], selectedUsers: [],dataArrayForJSON: []};


/*
 * Misc.
*/ 
function sortablesInitalization(){
  $(".sortable").sortable().bind("sortupdate", function() {});
  $('.sortable').sortable({
    items: ':not(.disableds)'
  });
}

/*
 * User recommendation handlers
*/

// Handles search for friend to suggest set to
function searchForUser(query) {
  suggestionsSearch(document.getElementById("suggestedUsers"), query, "api/friendSuggestions.php?q=", function(){
    updateUserSuggestions();
  });
}

// Add active class to user suggestions if username found in selected users global array
function updateUserSuggestions() {
  masterJSONObject.selectedUsers.forEach(function(currentValue, index){
    $('.dynamicActiveInactive[data-name="' + currentValue + '"]').addClass("active");
  });
}

function addUserSuggestion(userSuggestion) {
  if (masterJSONObject.selectedUsers.indexOf(userSuggestion.getAttribute("data-name")) == -1){
    // If user is not in suggested users list
    $(userSuggestion).addClass("active"); 
    document.getElementById("searchForUsers").value = ""; 
    // Update selected users list
    masterJSONObject.selectedUsers.push(userSuggestion.getAttribute("data-name")); 
  } else {
    // If user is in suggested users list already
    $(userSuggestion).removeClass("active");
    // Remove submission from selected users list
    var userIndex = masterJSONObject.selectedUsers.indexOf(userSuggestion.getAttribute("data-name"));
    masterJSONObject.selectedUsers.splice(userIndex, 1);
  }
}       

/*
 * Activity suggestion selection handlers
*/

// Array of all the names of selected activities


// Update to handle active classes while searching
function activitySearchUpdate() {
  masterJSONObject.activitiesSelected.forEach(function(currentValue){
    $('.dynamicActiveInactive[data-id="' + currentValue + '"]').addClass("active");
  });  
}

// Handles search for workout exercises to add to set
function searchForActivity(query) {
  suggestionsSearch(document.getElementById("suggestedExercises"), query, "api/activitySuggestionBuild.php?q=", function(){
    activitySearchUpdate();
  });
}

// Click on trigger for suggested activities
function addSuggestedActivity(selectedActivity) {
  // Clear search box
  document.getElementById("searchForActivities").value = "";
  
  // Check whether selected activity is already in the list of selected activities
  if (masterJSONObject.activitiesSelected.indexOf(selectedActivity.getAttribute("data-id")) == -1) {

    // Make suggested results active
    $(selectedActivity).addClass("active");

    // Add HTML of the activity to the chosen array
    masterJSONObject.activitiesSelected.push(selectedActivity.getAttribute("data-id"));

    // Add the exercise to the exercise options in day generation
    var listOfExerciseOptions = document.getElementById("listOfSelectedExerciseOptions");
    var optionExercise = document.createElement("option");
    optionExercise.appendChild(document.createTextNode(selectedActivity.innerHTML));
    optionExercise.value = selectedActivity.getAttribute("data-id");
    listOfExerciseOptions.appendChild(optionExercise);
    optionExercise.setAttribute("data-id", selectedActivity.getAttribute("data-id"));
    optionExercise.setAttribute("data-name", selectedActivity.getAttribute("data-name"));

    // Add selected activity to selected activities list 
    getRequest("api/activityInfoGetBuild.php?q=" + selectedActivity.getAttribute("data-id"), function(responseText){
      document.getElementById("selectedExercises").innerHTML += responseText;
    });

  } else {

    $(selectedActivity).removeClass("active");

    // Remove option from activities selected array      
    masterJSONObject.activitiesSelected.splice(masterJSONObject.activitiesSelected.indexOf(selectedActivity.getAttribute("data-id")), 1);

    /* Should be extraneous with next 3 filters
    // Remove all other options with the optionID
    $("[data-id=" + selectedActivity.getAttribute("data-id") + "]").parentNode.removeChild($("[data-id=" + selectedActivity.getAttribute("data-id") + "]"));
    */

    // Remove from list of selected exercise options
    $("#listOfSelectedExerciseOptions > option").each(function(){
      if (this.value == selectedActivity.getAttribute("data-id")){
        this.parentNode.removeChild(this);
      }
    });

  
    // Remove from selected exercises
    $("#selectedExercises").children().each(function(){
      if (this.getAttribute("data-id") == selectedActivity.getAttribute("data-id")){
        this.parentNode.removeChild(this);
      }
    });
      
    // Make inactive from suggested exercises (under search) 
    $("#suggestedExercises").children().each(function(){
      if (this.getAttribute("data-id") == selectedActivity.getAttribute("data-id")){
        $(this).removeClass("active");
      }
    });
  }
}

/*
 * Add activity to day plan handlers
*/

// Delete my parents :D
function deleteMyParents(me){
  me.parentNode.parentNode.parentNode.removeChild(me.parentNode.parentNode);
}

// Add an activity selection to the default/selected day
function addExerciseToDay() {

  // Grab values of activity selector
  var listOfSelectedExerciseOptions = document.getElementById("listOfSelectedExerciseOptions");
  var dayActivityAddedList = document.getElementById("dayActivityAddedList");
  var selectedID = listOfSelectedExerciseOptions[listOfSelectedExerciseOptions.selectedIndex].getAttribute("data-id");
  var selectedName = listOfSelectedExerciseOptions[listOfSelectedExerciseOptions.selectedIndex].getAttribute("data-name");
  var selectedReps = document.getElementById("selectedActivityReps").value;
  var selectedWeight = document.getElementById("selectedActivityWeight").value;

  // Ensure weight and reps are integers, that rep is extant, and that the the default selection value is not the selected option

  if ((isInt(selectedWeight) || (selectedWeight == "")) && isInt(selectedReps) && ("" != selectedReps)) {


    // Transfer id to name if exercise is a default rest entry
    if (selectedID == "Rest"){
      selectedName = selectedID;
    }

    var dayActivityAddedList = document.getElementById("dayActivityAddedList");
    
    // Build new day activity list entry and assign proper values to it
    var newDayActivityEntry = document.createElement("li");
    newDayActivityEntry.setAttribute("data-id", selectedID);
    newDayActivityEntry.setAttribute("data-name", selectedName);

    // Add delete button
    var deleteButton = $("<button />").addClass("deleteButton btn btn-danger").text("x");
    $(deleteButton).attr("style", "text-align:right;  margin-right:10px; padding-left:3px; padding-top:0px; padding-bottom:2px; padding-right:3px; font-size:8px; margin-top:-3px;");
    $(deleteButton).attr("onclick", "deleteMyParents(this)");

    // Add repetition text box
    var repetitionInputBox = $("<input>").text(selectedReps);
    $(repetitionInputBox).attr("style", "text-align:right; right:0; padding-left:3px; height:100%; margin-left:3%; padding-bottom:2px; padding-right:3px; right:0; width:25%; display:inline-block;"); 
    $(repetitionInputBox).attr("value", selectedReps);
    $(repetitionInputBox).attr("placeholder", "Repetitions"); 
    $(repetitionInputBox).attr("data-value", "rep");

    // Add weight text box
    var weightInputBox = $("<input>").text(selectedWeight);
    $(weightInputBox).attr("style", "text-align:right;  right:0; padding-left:3px; height:100%; margin-left:2%; padding-bottom:2px; padding-right:3px; right:0; width:25%; display:inline-block;"); 
    $(weightInputBox).attr("value", selectedWeight); 
    $(weightInputBox).attr("placeholder", "Weight (lb)");
    $(weightInputBox).attr("data-value", "weight");

    // If rest is the exercise
    if ("Rest" == selectedID) {
      // Add rest time to repetition textbox
      var restTimeAddition = $("<label>").text(selectedName);
      $(restTimeAddition).attr("style", "margin-top: 3px; margin-left:0px; margin-right:0px; margin-right:27% !important; width:45%; text-overflow: ellipsis; display:inline-block; clear: both; float:left; font-weight:normal;"); 
      $(repetitionInputBox).attr("placeholder", "Rest Time"); 
      deleteButton.prependTo(restTimeAddition); 
      restTimeAddition.appendTo(newDayActivityEntry); 
      // Weight is not added
      repetitionInputBox.appendTo(newDayActivityEntry)
    } else {
      // Blank label instead of rest time appendment
      var blankLabel = $("<label>").text(selectedName);
      $(blankLabel).attr("style", "margin-top: 3px; margin-left:0px; margin-right:0px; margin-right:0px !important; width:45%; text-overflow: ellipsis; display:inline-block; clear: both; float:left; font-weight:normal;");
      deleteButton.prependTo(blankLabel);
      blankLabel.appendTo(newDayActivityEntry); 
      weightInputBox.appendTo(newDayActivityEntry);
      repetitionInputBox.appendTo(newDayActivityEntry);
    }

    // Add exercise to list
    $(newDayActivityEntry).addClass("list-group-item");
    $(newDayActivityEntry).attr("style", "overflow:hidden;  position: relative;display: block;");
    dayActivityAddedList.appendChild(newDayActivityEntry);
  } 
}

/*
 * Add day plan to workout plan handlers
*/ 

// If selected to add an exercise day, distinguish between whether a new day is called for
function addExerciseDay(){
  var dayChooser = document.getElementById("dayChooser")
  dayChosen = dayChooser[dayChooser.selectedIndex].getAttribute("data-id");
  if (dayChosen == "newDay"){
    addDayToPlan();
  } else {
    addDayToPlan(dayChosen);
  }
}

// If selected to add a rest day, distinguish between whether a new day is called for
function addRestDay(){
  var dayChooser = document.getElementById("dayChooser")
  dayChosen = dayChooser[dayChooser.selectedIndex].getAttribute("data-id");
  if (dayChosen == "newDay"){
    addRestDayToPlan();
  } else {
    addRestDayToPlan(dayChosen);
  }

}

function addDayToPlan(dayNum) {
  var dayActivityAddedObject = document.getElementById("dayActivityAddedList");
  var dayActivityAddedList = dayActivityAddedObject.children;

  // Parent day div
  var dayParentDiv = document.createElement("div");
  $(dayParentDiv).addClass("col-sm-4"); 
  $(dayParentDiv).attr("draggable", "false");

  // Day ul
  var dayParentUL = document.createElement("ul");      
  $(dayParentUL).addClass("list-group list");

  // Initial header info in a first li for the day ul
  var dayHeaderInfoLI = document.createElement("li");
  $(dayHeaderInfoLI).attr("style", "background-color:#0099cc; color:white");

  if (dayNum == null){
    $(dayHeaderInfoLI).addClass("list-group-item").text("Day " + (document.getElementById("listOfDaysDiv").children.length + 1));
  } else {
    $(dayHeaderInfoLI).addClass("list-group-item").text("Day " + dayNum);    
  }


  // Delete the day :'(
  var deleteThisDayButton = $("<button />").addClass("deleteButton btn btn-danger").text("x");
  $(deleteThisDayButton).attr("style", "text-align:right; margin-right:10px; padding-left:3px; padding-top:0px; padding-bottom:2px; padding-right:3px; font-size:8px; margin-top:-3px; float:right;");
  $(deleteThisDayButton).attr("onclick", "deleteThisDay(this)");
  deleteThisDayButton.appendTo(dayHeaderInfoLI);

  // For each exercise in the day template/reset
  $(dayActivityAddedObject).children().each(function(index, exerciseValue){
    if (exerciseValue.id == "ignore"){
      return true;
    }
    // Get the varaible rep and weight
    var rep, weight;
    $(exerciseValue).children().each(function(index, currentValue){
      try{
        if (currentValue.getAttribute("data-value")=="rep"){
          rep = currentValue.value;
        } else if (currentValue.getAttribute("data-value")=="weight"){
          weight = currentValue.value;
        }
      } 
      catch (err){
        alert(err.message);
        console.log(currentValue);
      }

    });

    // Get static exercise data
    var id = exerciseValue.getAttribute("data-id");
    var name = exerciseValue.getAttribute("data-name");

    // Generate exercise LI 
    var generatedExerciseLI = document.createElement("li");
    generatedExerciseLI.setAttribute("data-id", id), generatedExerciseLI.setAttribute("data-weight", weight), generatedExerciseLI.setAttribute("data-rep", rep), generatedExerciseLI.setAttribute("data-name", name);

    // Generate repetitions input for LI
    var repetitionsInputBox = $("<input>").text(rep);
    $(repetitionsInputBox).attr("style", "text-align:right; right:0; padding-left:3px; height:100%; margin-left:3%; padding-bottom:2px; padding-right:3px; right:0; width:25%; display:inline-block;"); 
    $(repetitionsInputBox).attr("placeholder", "Repetitions");
    $(repetitionsInputBox).attr("value", rep);
    $(repetitionsInputBox).attr("data-value", "rep");

    // Generate weight input for LI
    var weightInputBox = $("<input>").text(weight);
    $(weightInputBox).attr("style", "text-align:right;  right:0; padding-left:3px; height:100%; margin-left:2%; padding-bottom:2px; padding-right:3px; right:0; width:25%; display:inline-block;");
    $(weightInputBox).attr("placeholder", "Weight (lb)");
    $(weightInputBox).attr("value", weight);
    $(weightInputBox).attr("data-value", "weight");

    // If rest
    if ("Rest" == id) {
      // Create a rest label and change the repetition placeholder to say rest time
      var restLabel = $("<label>").text(name);
      $(restLabel).attr("style", "margin-top: 3px; margin-left:0px; margin-right:27%; margin-right:0px !important; width:45%; text-overflow: ellipsis; display:inline-block; clear: both; float:left; font-weight:normal;");
      $(repetitionsInputBox).attr("placeholder", "Rest Time");
      restLabel.appendTo(generatedExerciseLI);
      repetitionsInputBox.appendTo(generatedExerciseLI);
    } else {
      // Generate blank label for structure and append all other parts
      var blankLabel = $("<label>").text(name);
      $(blankLabel).attr("style", "margin-top: 3px; margin-left:0px; margin-right:0px; margin-right:0px !important; width:45%; text-overflow: ellipsis; display:inline-block; clear: both; float:left; font-weight:normal;");
      blankLabel.appendTo(generatedExerciseLI);
      repetitionsInputBox.appendTo(generatedExerciseLI);
      weightInputBox.appendTo(generatedExerciseLI);
    }

    // Finish off LI
    $(generatedExerciseLI).addClass("list-group-item");
    $(generatedExerciseLI).attr("style", "overflow:hidden;  position: relative;display: block;");
    dayParentUL.appendChild(generatedExerciseLI);
  });

  // If description necessary, add it
  if (document.getElementById("dayDesc").value != ""){
    // Some regex processing?
    var descriptionDayText = document.getElementById("dayDesc").value.replace(/-/g, ''); 
    descriptionDayText = (descriptionDayText).replace(/~/g, ''); 
    descriptionDayText = (descriptionDayText).replace(/\+/g, ''); 

    // Create new li yay
    var descriptionLI = document.createElement("li");

    // Set blank attributes
    descriptionLI.setAttribute("data-id", "Desc");
    descriptionLI.setAttribute("data-rep", "");
    descriptionLI.setAttribute("data-weight", "");
    descriptionLI.setAttribute("data-name", "");

    // Set up child elements and set proper attributions
    var descLabel = $("<label>").text("Desc");
    var descRep = $("<textarea>").text(descriptionDayText.trim());
    var descWeight = $("<input>").text("");
    $(descRep).attr("data-value", "rep");
    $(descRep).attr("value", descriptionDayText);
    $(descWeight).attr("data-value", "weight");
    $(descLabel).attr("style", "display:none");
    $(descWeight).attr("style", "display:none");
    $(descRep).attr("style", "width:100%; background-color:#0099cc; color:white; padding-left:20px; padding-right:20px; padding-top:10px; padding-bottom:10px;");
    $(descRep).attr("rows", "\"5\"");

    // Append children
    descLabel.appendTo(descriptionLI);
    descRep.appendTo(descriptionLI);
    descWeight.appendTo(descriptionLI);

    // Add final LI
    dayParentUL.appendChild(descriptionLI);
    document.getElementById("dayDesc").value = "";
  }

  // Deviation depending on whether day num is set
  if (dayNum == null){
    // Assuming the creation of a new day
    // Set the day of the attri. Since this is a new day, we can assume day number is set by length of day div + 1
    $(dayParentDiv).attr("id", "Day" + (document.getElementById("listOfDaysDiv").children.length + 1));

    // Add option to day override
    var dayChooser = document.getElementById("dayChooser");
    dayOption = document.createElement("option");
    dayOption.setAttribute("data-id", (document.getElementById("listOfDaysDiv").children.length + 1));
    dayOption.appendChild(document.createTextNode("Day " + (document.getElementById("listOfDaysDiv").children.length + 1)));
    dayChooser.appendChild(dayOption);

    dayParentDiv.appendChild(dayHeaderInfoLI);
    dayParentDiv.appendChild(dayParentUL);
    document.getElementById("listOfDaysDiv").appendChild(dayParentDiv)

  } else {
    // Assuming overriding an old one
    $(dayParentDiv).attr("id", "Day" + (dayNum));

    // Append
    dayParentDiv.appendChild(dayHeaderInfoLI);
    dayParentDiv.appendChild(dayParentUL);    
    document.getElementById("listOfDaysDiv").replaceChild(dayParentDiv, document.getElementById("Day" + dayNum));
    // Remove from option
  }

}

function addRestDayToPlan(dayNum) {
  // Generate new parent div
  var newParentDiv = document.createElement("div");
  $(newParentDiv).addClass("col-sm-4");
  $(newParentDiv).attr("draggable", "true");

  // Generate new body UL
  var newPrimeUL = document.createElement("ul");
  $(newPrimeUL).addClass("list-group list");

  // Generate new header LI
  var newHeaderLI = document.createElement("li");
  $(newHeaderLI).attr("style", "background-color:#0099cc; color:white");
  if (dayNum == null){
    $(newHeaderLI).addClass("list-group-item").text("Day " + (document.getElementById("listOfDaysDiv").children.length + 1));
  } else {
    $(newHeaderLI).addClass("list-group-item").text("Day " + dayNum);
  }

  // Delete button
  var deleteButton = $("<button />").addClass("deleteButton btn btn-danger").text("x");
  $(deleteButton).attr("style", "text-align:right; margin-right:10px; padding-left:3px; padding-top:0px; padding-bottom:2px; padding-right:3px; font-size:8px; margin-top:-3px; float:right;");
  $(deleteButton).attr("onclick", "deleteThisDay(this)");
  deleteButton.appendTo(newHeaderLI);

  // Generate static LI and static P for appending onto the LI and then on the prime ul
  var restStaticLI = document.createElement("li");
  restStaticLI.setAttribute("data-id", "restDaySoSkip");
  restStaticLI.setAttribute("style", "height:50px");
  var restStaticP = $("<p>").text("Rest Day");
  $(restStaticP).attr("style", "margin-top: 3px; margin-left:0px; margin-right:0px; margin-right:0px !important; width:100%; text-overflow: ellipsis; float:left; font-weight:normal;");
  restStaticP.appendTo(restStaticLI);
  $(restStaticLI).addClass("list-group-item");
  newPrimeUL.appendChild(restStaticLI);
       

  if (dayNum == null){
    // Assuming a new day

    // Differentiate for days
    $(newParentDiv).attr("id", "Day" + (document.getElementById("listOfDaysDiv").children.length + 1));

    // Update for day chooser 
    var dayChooser = document.getElementById("dayChooser");
    dayOption = document.createElement("option");
    dayOption.setAttribute("data-id", (document.getElementById("listOfDaysDiv").children.length + 1));
    dayOption.appendChild(document.createTextNode("Day " + (document.getElementById("listOfDaysDiv").children.length + 1)));
    dayChooser.appendChild(dayOption);

    // Append everything
    newParentDiv.appendChild(newHeaderLI), newParentDiv.appendChild(newPrimeUL), document.getElementById("listOfDaysDiv").appendChild(newParentDiv);        
  } else {
    // Assuming overriding an old one
    $(newParentDiv).attr("id", "Day" + (dayNum));

    // Append
    newParentDiv.appendChild(newHeaderLI);
    newParentDiv.appendChild(newPrimeUL);    
    document.getElementById("listOfDaysDiv").replaceChild(newParentDiv, document.getElementById("Day" + dayNum));
    // Remove from option
  }
}


// Deleting a house, triggered by button, on the header LI, in the day div, in the days list
function deleteThisDay(deleteButton) {
  // Fuck hiearchy man
  deleteButton.parentNode.parentNode.parentNode.removeChild(deleteButton.parentNode.parentNode);
  // Change every day div in the days list's header day count to match the index + 1 to account for missing day div in the list
  $("#listOfDaysDiv").children().each(function(index, value){
    value.children[0].childNodes[0].nodeValue = "Day " + (index + 1);
    value.setAttribute("id", "Day" + (index + 1));
  });

  // Update day chooser
  document.getElementById("dayChooser").removeChild(document.getElementById("dayChooser").lastChild);
}

/*
 * Miscellanious
*/

// Update data string of activity/day information before submission time
function updateDataStringValue() {

  // Prep data
  document.getElementById("dataString").value = "";
  // For every day
  $("#listOfDaysDiv").children().each(function(index, currentValue){
    // For every exercise, get the children of the day's activity UL that is 2nd (1 in array indexes)
    $(currentValue.children[1]).children().each(function(innerIndex, currentValue){
      var id = currentValue.getAttribute("data-id");
      var rep;
      var weight;

      // Assuming it's not a rest day
      if (id != "restDaySoSkip") {
        $(currentValue).children().each(function(innerMostIndex, currentValue){
          // Fetch rep and weight info
          if (currentValue.getAttribute("data-value") == "rep"){
            rep = currentValue.value;
          } else if (currentValue.getAttribute("data-value") == "weight") {
            weight = currentValue.value;  
          }       
        });

        if (weight == undefined){
          weight = "";
        }

        // Push the new data to the data array
        masterJSONObject.dataArrayForJSON.push({
          "rep":rep, 
          "weight":weight,
          "id":id,
          "day": (index+1)
        });

      } else {

        // If it is a rest day
        masterJSONObject.dataArrayForJSON.push({
          "id":"RestToday", 
          "weight":"0",
          "reps": "1",
          "day": (index+1)
        });

      }
    });
  });
  
  document.getElementById("dataString").value = JSON.stringify(masterJSONObject);

}


</script>
</body>
</html>
