<?php
require_once 'yearToArray/yearToArray.php';

function validate($arrayToValidate) {
  foreach ($arrayToValidate as $table) {
    $start = false;
    $break = false;
    foreach ($table as $t) {
      foreach ($t as $key=>$elem) {
        if (
          ('Q1' == $key)
          || ('Q2' == $key)
          || ('Q3' == $key)
          || ('Q4' == $key)
          || ('YDT' == $key)
        ) continue;
        if ($elem != '') {
          if ($break)
            return 'Invalid';
          $start = true;
        } else {
          if (!$start) {
            $start = false;
          } else {
            $break = true;
          }
        }
      }

    }
  }
  return 'Valid';
}

if (isset($_POST['arr'])) {
//  $tables = yearToArray\tzParseTableYear(yearToArray\toArrayTZ($_POST['arr']));

  echo validate($_POST['arr']);
}
