<?php

/* 
Copyright (c) 2016, Eric Zhao, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
*/

class Activity
{
  // Already established
  private $id, $title, $user, $description, $youtubeLink, $step1, $step2, $step3, $step4, $step5, $muscleAffJSON;

  // Creating the activity
  public function Activity($id, $title, $user, $description, $youtubeLink, $step1, $step2, $step3, $step4, $step5, $muscleString, $new=null) 
  {
    $link = databaseViewConnect();
    mysqli_select_db($link, "trainerassist");
    $this->id = ($id == '') ? $this->idGen($link) : $id;
    $this->title = $title;
    $this->user = $user;
    $this->description = $description;
    $this->youtubeLink = $youtubeLink;
    $this->step1 = $step1;
    $this->step2 = $step2;
    $this->step3 = $step3;
    $this->step4 = $step4;
    $this->step5 = $step5;
    $this->muscleAffJSON = $this->parseMuscleJSON($muscleString); 
    $this->new = $new;
  }
 
  // Save activity / update activity
  public function saveActivity()
  {
    $link = databaseEditConnect("LEMonadestand20Laugh");
    if (!$this->new){
      $error = updateToDatabase("LEMonadestand20Laugh", "trainerassist", "activity", "id", $this->id, array(
        'id'=>$this->id,
        'title'=>$this->title,
        'user'=>$this->user,
        'description'=>$this->description,
        'step1'=>$this->step1,
        'step2'=>$this->step2,
        'step3'=>$this->step3,
        'step4'=>$this->step4,
        'step5'=>$this->step5,
        'youtubeLink'=>$this->youtubeLink,
        'muscleAffJSON'=>$this->muscleAffJSON
      )); 
    }
    else 
    {
      $error = saveToDatabase("LEMonadestand20Laugh", "trainerassist", "activity", "id", $this->id, array(
        'id'=>$this->id,
        'title'=>$this->title,
        'user'=>$this->user,
        'description'=>$this->description,
        'step1'=>$this->step1,
        'step2'=>$this->step2,
        'step3'=>$this->step3,
        'step4'=>$this->step4,
        'step5'=>$this->step5,
        'youtubeLink'=>$this->youtubeLink,
        'muscleAffJSON'=>$this->muscleAffJSON
      ), true); 
  }
  $this->new = false;  
   return $error; 
}

// Return activity information in the form of JSON
public function getActivity(){
  return json_encode(array(
    'id'=>$this->id,
    'title'=>$this->title,
    'user'=>$this->user,
    'description'=>$this->description,
    'step1'=>$this->step1,
    'step2'=>$this->step2,
    'step3'=>$this->step3,
    'step4'=>$this->step4,
    'step5'=>$this->step5,
    'youtubeLink'=>$this->youtubeLink,
    'muscleAffJSON'=>$this->muscleAffJSON
  ));
}

// Return ID
public function getID(){
  return $this->id;
}

// Parse muscle JSON
private function parseMuscleJSON($muscleString){
  $muscleJSONObj = json_decode($muscleString, true);
  return json_encode($muscleJSONObj['selected']); 
}

// Randomly generates activity ID 
function idGen($link){
  mysqli_select_db($link, "trainerassist");
  $activityID = mt_rand(0, 999999);
  $variableexists = sqlDataItemExists("activity", "id", $link, "id", $activityID);
  while ($variableexists){
    $activityID = mt_rand(0, 999999);
    $variableexists = sqlDataItemExists("activity", "id", $link, "id", $activityID);
  }
  return $activityID;
}


} // End of class

?>
