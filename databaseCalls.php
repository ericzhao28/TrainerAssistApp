<?php

/* 
Copyright (c) 2016, Eric Zhao, All Rights Reserved. 
THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
PARTICULAR PURPOSE.
*/

// Connect to database using edit permissions
function databaseEditConnect($password){
	$link = mysqli_connect('localhost', 'root', $password); 
	if (!$link) { 
		mysqli_close($link);
		return false;
	} 
	if (!mysqli_set_charset($link, 'utf8')) { 
		mysqli_close($link);
		return false;
	} 
	return $link;
}

// Connect to database using view permissions
function databaseViewConnect(){
	$link = mysqli_connect('localhost', 'read', 'Ericrox28'); 
	if (!$link){ 
		mysqli_close($link);
		return false;
	} 
	if (!mysqli_set_charset($link, 'utf8')) { 
		mysqli_close($link);
		return false;
	} 
	return $link;
}

// Save to database call
function saveToDatabase($pass, $db, $table, $conditionalVar, $conditionalVarMatch, $updatedData, $checkConflict=null){
  
  // Connect
  $link = databaseEditConnect($pass);
  mysqli_select_db($link, $db);

  // Check for identifier conflicts 
  if ($checkConflict && (sqlDataItemExists($table, $conditionalVar, $link, $conditionalVar, $conditionalVarMatch))){
   return "Entry with identifier " . $conditionalVar . " of " . $conditionalVarMatch . " already exists.";
  }

  // Build query
  $query = "INSERT INTO " . $table . " (";
  forEach ($updatedData as $title => $value){
    $title = mysqli_escape_string($link, $title);
    $query .= ($title . ", ");
  }
  $query = rtrim($query, ", ");
  $query .= ") VALUES (";
  forEach ($updatedData as $title => $value){
    $value = mysqli_escape_string($link, $value);
    $query .= ("'" . $value . "', ");
  } 
  $query = rtrim($query, ", ");
  $query .= ")";
  // Check for errors and finish
  $result = mysqli_query($link, $query);
  if (!$result){
    mysqli_close($link);
    return "Query failed: " . $query;
  }
  mysqli_close($link);
  return false;
}

// Update database call
function updateToDatabase($pass, $db, $table, $conditionalVar, $conditionalVarMatch, $updatedData){
  // Set up connections
  $link = databaseEditConnect($pass);
  mysqli_select_db($link, $db);
  
  // Ensure there is entity to update 
  if (!sqlDataItemExists($table, $conditionalVar, $link, $conditionalVar, $conditionalVarMatch)){
   return "No entry to update with identifier " . $conditionalVar . " matching " . $conditionalVarMatch;
  }

  // Build query request
  $query = "UPDATE " . $table . " SET ";
  forEach ($updatedData as $title => $value){
    $title = mysqli_escape_string($link, $title);
    $value = mysqli_escape_string($link, $value);
    $query .= ($title . "='" . $value . "', ");
  }
  $query = rtrim($query, ", ");
  $query .= " WHERE " . $conditionalVar . "='" . $conditionalVarMatch . "'";

  // Check result + test for errors
  $result = mysqli_query($link, $query);
  if (!$result){
    mysqli_close($link);
    return "Query failed: " . $query;
  }
  mysqli_close($link);
  return false;
}

// Check if SQL item exists
function sqlDataItemExists($table, $row, $link, $conditionalVar, $conditionalVarMatch, $specialCondition = null, $multi =null, $debug=null){
  mysqli_select_db($link, "trainerassist");
  // Build query
	$condition = ($specialCondition == null) ? ("WHERE " . $conditionalVar . "='" . $conditionalVarMatch . "'") : ("WHERE " . $specialCondition); 
  $query = ("SELECT " . $row . " FROM " . $table . ' ' . $condition);
 
  // Debug
  if ($debug){
    return $query;  
  }

  // Check result + test for errors
  $result = mysqli_query($link, $query);
  if (!$result){
    return false;
  }

  // Begin filtering results if obtained
  if (!$multi){
    $filteredResult = mysqli_fetch_array($result, MYSQLI_NUM);  
  } else {
    $filteredResult = array();
      for ($i = 0;$i<$result->num_rows;$i++){
      $filteredResult[] = mysqli_fetch_array($result, MYSQLI_NUM);  
    }
  }
	if (!isset($filteredResult)){
		return False;
		exit();
  }

  // Return filtered result if existant
  return (count($filteredResult) == 0) ? false : $filteredResult;
}

// Retreieve entire row
function sqlRowGet($table, $link, $conditionalVar, $conditionalVarMatch, $specialCondition = null){
 mysqli_select_db($link, "trainerassist"); 
  // Build query
	$condition = ($specialCondition == null) ? ("WHERE " . $conditionalVar . "='" . $conditionalVarMatch . "'") : ("WHERE " . $specialCondition); 
  $query = ("SELECT * FROM " . $table . ' ' . $condition);
  
  // Check result + test for errors
  $result = mysqli_query($link, $query);
  if (!$result){
    return false;
  }

  // Begin filtering results if obtained
  $filteredResult = mysqli_fetch_array($result, MYSQLI_ASSOC);  
	if (!isset($filteredResult)){
		return False;
		exit();
  }

  // Return filtered result if existant
  return (count($filteredResult) == 0) ? false : $filteredResult;
  

}

?>
