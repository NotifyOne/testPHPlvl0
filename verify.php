<?php
require_once 'yearToArray/yearToArray.php';

function validateTable($table, &$startPos = [], &$endPos = []) {
  $start = FALSE;
  $break = FALSE;
  foreach ($table as $k=>$t) {
    foreach ($t as $key => $elem) {
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
          return false;
        }
        $start = TRUE;
          if (count($startPos) < 1)
            $startPos = [$k , $key];
        $endPos = [$k , $key];
      }
      else {
        if (!$start) {
          $start = FALSE;
        }
        else {
          $break = TRUE;
        }
      }
    }

  }
  return true;
}

function validateTables($tables) {
  $validated = [];
  foreach ($tables as $arr) {
    $startPos = [];
    $endPos = [];

    $validated[] = [
      validateTable($arr, $startPos, $endPos),
      $startPos,
      $endPos
    ];

  }

  $startPos = [];
  $endPos = [];
  foreach ($validated as $value) {
    if (!$value[0]) {
      return false;
    }
    if (count($startPos) < 1)
      $startPos = $value[1];
    if (count($endPos) < 1)
      $endPos = $value[2];

    if (
         ($startPos[0] != $value[1][0])
      || ($startPos[1] != $value[1][1])
      || ($endPos[0] != $value[2][0])
      || ($endPos[1] != $value[2][1])
    ) {
      return FALSE;
    }
  }
  return true;

}



if (isset($_POST['arr'])) {

  echo validateTables($_POST['arr']) ? 'true' : 'false';

}
