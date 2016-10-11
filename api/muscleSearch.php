<?php

/*
 * Purpose:
 * Returns a list of suggested workouts based on muscle selections
*/

// CHANGE 
$hint = "";

include "../loginScript.php";
$link = databaseviewconnect();
$setList = sqldataitemexists("sets", "id", $link, "", "", "1", true);

// Process muscle string
$muscleRawJSON = json_decode(file_get_contents('php://input'), true);

// Generate muscle array
$muscleList = $muscleRawJSON['selected'];

$selectedSets = array();

forEach($setList as $setID){

  // Get scores, generate initial tallies
  $setID = $setID[0];
  $muscleJSON = sqldataitemexists("sets", "muscleJSON", $link, "id", $setID)[0];  
  $totalCount = 0;
  $score = 0;
  if (($muscleJSON == null)||(!(count($muscleJSON)>0))){

    continue;
  }
  // Get total muscle count for balancing across concentrations
  forEach(json_decode($muscleJSON, true) as $muscle => $tally){
    $totalCount += $tally;
  }

  // Generate score 
  forEach(json_decode($muscleJSON, true) as $muscle => $tally){
    if (in_array($muscle, $muscleList)){
      $score += 100*$tally/$totalCount;
    }
  }

  if ($score>0){
    // Compare across different sets
    for ($i=0; $i<5; $i++){
      if (isset($selectedSets[$i])){
        if ($selectedSets[$i][0] < $score){
          array_splice($selectedSets, $i, 0, array(array($score, $setID)));
  
          if(isset($selectedSets[5])){
            array_pop($selectedSets);
          }
          break;

        }
      } else { 

          $selectedSets[$i] = array($score, $setID);
          break;
      }
    }
  }
}

// Release results
$suggestions = "";
forEach($selectedSets as $setScore){
  // Get set info
  $setID = $setScore[1];
  $title = sqldataitemexists("sets", "title", $link, "id", $setID)[0];  
  $author = sqldataitemexists("sets", "user", $link, "id", $setID)[0];
  $suggestions .= "  <a href='#' class='list-group-item searchResults' onclick = \"goToExercise(this)\" data-id=\"$setID\"> \"$title\" - a plan by $author ($setID)</a>";
}

echo $suggestions;


mysqli_close($link);

?>
