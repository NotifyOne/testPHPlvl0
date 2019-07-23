<?php
require_once 'yearToArray/yearToArray.php';

function getQuartalsCorrected(float $mount1 = 0.0, float $mount2 = 0.0, float $mount3 = 0.0) {
  $mountSum = ($mount1 + $mount2 + $mount3 + 1);
//  echo $mountSum;
  return $mountSum != 1 ? round( ( $mountSum / 3 ), 2 ) : 0;
}

function getYearCorrected(array $quartals) {
  $sum = 0.0;
  foreach ($quartals as $quartal) {
    $sum += $quartal;
  }
  $sum += 1;
  return $sum != 1 ? ($sum / 4) : 0;
}

function validateValues(array $table) {
  $Q[] = getQuartalsCorrected(
    floatval($table['Jan'] ?? 0),
    floatval($table['Feb'] ?? 0),
    floatval($table['Mar'] ?? 0));
  $Q[] = getQuartalsCorrected(
    floatval($table['Apr'] ?? 0),
    floatval($table['May'] ?? 0),
    floatval($table['Jun'] ?? 0));
  $Q[] = getQuartalsCorrected(
    floatval($table['Jul'] ?? 0),
    floatval($table['Aug'] ?? 0),
    floatval($table['Sep'] ?? 0));
  $Q[] = getQuartalsCorrected(
    floatval($table['Oct'] ?? 0),
    floatval($table['Nov'] ?? 0),
    floatval($table['Dec'] ?? 0));

  foreach ($Q as $k => $item) {
    if ( abs($item - floatval($table['Q' . ($k + 1)] ?? 0)) > 0.05 ) {
      return false;
    }
  }

  $yearDT = getYearCorrected($Q);

  if ( abs($yearDT - floatval($table['YDT'] ?? 0)) > 0.05 ) {
    return false;
  }

  return true;
}

// Validate one table [year1 => array_mounts,]
function validateTable(array $table, &$startPos = [], &$endPos = []) {
  $start = FALSE;
  $break = FALSE;
  $oldYear = NULL;
  $prevYear = NULL;
  foreach ($table as $k => $t) {
    if ($prevYear == NULL) {
      $prevYear = $k;
    }
    $oldYear = $prevYear;
    $prevYear = $k;

    // if the difference between the beginning and next year is greater 1
    // -> The gap in years. Table is invalid
    if ((($k - $oldYear) > 1)) {
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
    // End Check for continuity
    if (!validateValues($t)) {
      return false;
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

  $emptyPos = FALSE;

  // Check if tables validated and start position and end position equals
  foreach ($validated as $value) {
    if (!$value[0]) {
      return FALSE;
    }
    if (count($startPos) < 1) {
      $startPos = $value[1];
      if (!isset($value[1][0], $value[1][1])) {
        $emptyPos = TRUE;
      }
    }
    if (count($endPos) < 1) {
      $endPos = $value[2];
      if (!isset($value[2][0], $value[2][1])) {
        $emptyPos = TRUE;
      }
    }

    if (
      (!isset(
          $startPos[0], $startPos[1],
          $endPos[0], $endPos[1]
        ) || $emptyPos) != !isset(
        $value[1][0], $value[1][1],
        $value[2][0], $value[2][1]
      )) {
      return FALSE;
    }

    if ($emptyPos) {
      continue;
    }

    if (
        ($startPos[0] != $value[1][0])
        || ($startPos[1] != $value[1][1])
        || ($endPos[0] != $value[2][0])
        || ($endPos[1] != $value[2][1])
      ) {
      return FALSE;
    }
  }

  foreach ($tables as $table) {
    validateValues($table);
  }

  return TRUE;

}

if (isset($_POST['arr'])) {

  echo validateTables($_POST['arr']) ? 'Valid' : 'Invalid';

}
