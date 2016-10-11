<?php

/* 
Copyright (c) 2016, Eric Zhao, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
*/
error_reporting(E_ERROR);
class Set
{
  // Some props
  private $id, $activityJSON, $title, $user, $date, $usersAssigned;
  
  // Constructor method
  public function Set($id, $activityJSON, $title, $user){
    $link = databaseViewConnect(); 
    mysqli_select_db($link, "trainerassist");
    $this->id = ($id == '') ? $this->idGen($link) : $id;
    $this->activityJSON = $activityJSON;
    $this->title = $title;
    $this->user = $user;
    $this->date = $date;
    $this->usersAssigned = $usersAssigned;
    $this->muscleJSON = $this->calculateMuscleDist($activityJSON);
  }

  // Save the set
  public function saveSet()
  {
    $error = saveToDatabase("LEMonadestand20Laugh", "trainerassist", "sets", "id", $this->id, array(
      'id'=>$this->id,
      'activityJSON'=>$this->activityJSON,
      'title'=>$this->title,
      'muscleJSON'=>$this->muscleJSON,
      'user'=>$this->user
    ));
    return $error;
  }

  // Share the set
  public function shareSet()
  {

    while ( 0 < (substr_count($usersAssigned, ","))){

      $username = substr($usersAssigned, 0, strpos($usersAssigned, ",")); 
      
      $usersAssigned = substr($usersAssigned, strpos($usersAssigned, ",") + 1);
      $assignmentraw = sqldataitemexists("users", "AssignedSet", $link, "username LIKE " . '"' . $username . '"')[0];
      
      $assignment = $assignmentraw;
      if ($assignment == false){
        $assignment = "";
      }

      $assignment = $assignment . $ID . "~" . $date . ",";
      $userAssignOrder = "UPDATE users SET AssignedSet=\"$assignment\" WHERE username=\"$username\"";	
      $result = mysqli_query($link, $userAssignOrder);  //order executes	

    }

  }

  // Get the set's basic info in JSON
  public function getBasicSet(){
    return json_encode(array(
      'id'=>$this->id,
      'title'=>$this->title,
      'user'=>$this->user,
      'date'=>$this->date,
      'muscleJSON'=>$this->muscleJSON,
      'usersAssigned'=>$this->usersAssigned
    ));
  }

  // Get the set JSON
  public function getSet(){
    return json_encode(array(
      'id'=>$this->id,
      'activityJSON'=>$this->populateActivities(),
      'title'=>$this->title,
      'user'=>$this->user,
      'date'=>$this->date,
      'muscleJSON'=>$this->muscleJSON,
      'usersAssigned'=>$this->usersAssigned
    ));
  }

  // Get ID
  public function getID(){
    return $this->id;
  }

  // Calculate muscle distribution for muscle search algorithim
  private function calculateMuscleDist($activityJSON){
    $link = databaseViewConnect();
    $activityJSON = $this->activityJSON;
    $activityArray = (json_decode($activityJSON, true));
    $muscleArr = array();
    // Begin processing activities
    forEach ($activityArray as $activityKey => $activityEntry){
      $activityID = $activityEntry['id']; 
      if ($activityID != "Rest"){
        $muscleJSONString = sqlDataItemExists("activity", "muscleAffJSON", $link, "id", $activityID)[0];
        $muscleList = json_decode(($muscleJSONString), true);
        if ($muscleJSONString != ""){
          forEach ($muscleList as $muscle){

            $muscleArr[$muscle] = (in_array($muscle, $muscleArr)) ? ($muscleArr[$muscle] + 1) : 0;
          }
        }
      }
    }
    mysqli_close($link);
    return json_encode($muscleArr);
  }

  // Populate activity array for use
  private function populateActivities(){
    $link = databaseViewConnect();
    mysqli_select_db($link, "trainerassist"); 
    $activityJSON = $this->activityJSON;
    $activityArray = (json_decode($activityJSON, true));
    // Begin processing activities
    forEach ($activityArray as $activityKey => $activityEntry){
      $activityID = $activityEntry['id']; 
      // For normal activity cases
      if ($activityID != "Rest"){
        $activityWeight = $activityEntry['weight'];
        $activityRep = $activityEntry['rep'];
        $activityDay = $activityEntry['day'];
        // Get activity details from DB
        $activityTitle = sqlDataItemExists("activity", "title", $link, "id", $activityID)[0];
        $activityAuthor = sqlDataItemExists("activity", "user", $link, "id", $activityID)[0];
        $activityDesc = sqlDataItemExists("activity", "description", $link, "id", $activityID)[0]; 
        $activityYoutube = sqlDataItemExists("activity", "youtubeLink", $link, "id", $activityID)[0];
        $step1 = sqlDataItemExists("activity", "step1", $link, "id", $activityID)[0];
        $step2 = sqlDataItemExists("activity", "step2", $link, "id", $activityID)[0];
        $step3 = sqlDataItemExists("activity", "step3", $link, "id", $activityID)[0];
        $step4 = sqlDataItemExists("activity", "step4", $link, "id", $activityID)[0];
        $step5 = sqlDataItemExists("activity", "step5", $link, "id", $activityID)[0];
        $muscleAffJSON = sqlDataItemExists("activity", "muscleAffJSON", $link, "id", $activityID)[0];
        
        // Compile results in array
        $activityArray[$activityKey] = array_merge($activityArray[$activityKey], array(
          'user'=>$activityAuthor,
          'title'=>$activityTitle,
          'description'=>$activityDesc,
          'step1'=>$step1,
          'step2'=>$step2,
          'step3'=>$step3,
          'step4'=>$step4,
          'step5'=>$step5,
          'youtubeLink'=>$activityYoutube,
          'muscleAffJSON'=>$muscleAffJSON
        ));

      // For rest cases
      } else {
        $activityID = $activityEntry['id']; 
        $activityWeight = ""; 
        $activityRep = $activityEntry['rep'];
        $activityDay = $activityEntry['day'];
        $activityTitle =""; 
        $activityAuthor =""; 
        $activityDesc =""; 
        $activityYoutube =""; 
        $step1 =""; 
        $step2 =""; 
        $step3 =""; 
        $step4 =""; 
        $step5 =""; 
        $muscleAffJSON = "";
        
        // Compile results in array
        array_push($activityArray[$activityKey], array(
          'user'=>$activityAuthor,
          'title'=>$activityTitle,
          'description'=>$activityDesc,
          'step1'=>$step1,
          'step2'=>$step2,
          'step3'=>$step3,
          'step4'=>$step4,
          'step5'=>$step5,
          'youtubeLink'=>$activityYoutube,
          'muscleAffJSON'=>$muscleAffJSON
        ));
      }
    }
    return json_encode($activityArray);
  }

  // Randomly generates set ID 
  private function idGen($link){
    mysqli_select_db($link, "trainerassist");
    $setID = mt_rand(0, 999999);
    $variableexists = sqlDataItemExists("set", "id", $link, "id", $setID);
    while ($variableexists){
      $setID = mt_rand(0, 999999);
      $variableexists = sqlDataItemExists("set", "id", $link, "id", $setID);
    }
    return $setID;
  }
}

?>
