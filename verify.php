<?php
require_once 'yearToArray/yearToArray.php';

// Validate one table [year1 => array_mounts,]
function validateTable(array $table, &$startPos = [], &$endPos = []) {
  $start = FALSE;
  $break = FALSE;
  $oldYear = NULL;
  $prevYear=  NULL;
  foreach ($table as $k => $t) {
    if ($prevYear == NULL) {
      $prevYear = $k;
    }
    $oldYear = $prevYear;
    $prevYear = $k;

    // if the difference between the beginning and next year is greater 1
    // -> The gap in years. Table is invalid
    if ( (($k - $oldYear) > 1) ) {
      return FALSE;
    }

    // Check for continuity
    foreach ($t as $key => $elem) {
      // Some keys should not be checked
      if (
        ('Q1' == $key)
        || ('Q2' == $key)
        || ('Q3' == $key)
        || ('Q4' == $key)
        || ('YDT' == $key)
      ) {
        continue;
      }

      if ($elem != '') {
        if ($break) {
          return FALSE;
        }
        $start = TRUE;
        if (count($startPos) < 1) {
          $startPos = [$k, $key];
        }
        $endPos = [$k, $key];
      } else {
        if (!$start) {
          $start = FALSE;
        }
        else {
          $break = TRUE;
        }
      }

    }
  }
  return TRUE;
}

// Validate all tables. Accepts array tables [tableId => [year1 => array_mounts],]
function validateTables(array $tables) {
  // Sort array if no sorted
  foreach ($tables as &$form) {
    ksort($form);
  }
  unset($form);

  $validated = [];
  // $validated => array if validated table, start position, end position
  foreach ($tables as $arr) {
    $startPos = [];
    $endPos = [];

    $validated[] = [
      validateTable($arr, $startPos, $endPos),
      $startPos,
      $endPos,
    ];

  }

  $startPos = [];
  $endPos = [];

  $emptyPos = false;

  // Check if tables validated and start position and end position equals
  foreach ($validated as $value) {
    if (!$value[0]) {
      return FALSE;
    }
    if (count($startPos) < 1) {
      $startPos = $value[1];
      if (!isset($value[1][0], $value[1][1]))
        $emptyPos = true;
    }
    if (count($endPos) < 1) {
      $endPos = $value[2];
      if (!isset($value[2][0], $value[2][1]))
        $emptyPos = true;
    }

    if (
      (!isset(
          $startPos[0], $startPos[1],
          $endPos[0], $endPos[1]
        ) || $emptyPos) != !isset(
        $value[1][0], $value[1][1],
        $value[2][0], $value[2][1]
      ) ) {
      return FALSE;
    }

    if ($emptyPos)
      continue;

    if (
      ($startPos[0] != $value[1][0])
      || ($startPos[1] != $value[1][1])
      || ($endPos[0] != $value[2][0])
      || ($endPos[1] != $value[2][1])
    ) {
      return FALSE;
    }
  }

  return TRUE;

}

if (isset($_POST['arr'])) {

  echo validateTables($_POST['arr']) ? 'Valid' : 'Invalid';

}
