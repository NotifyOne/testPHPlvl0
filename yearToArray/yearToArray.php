<?php
namespace yearToArray;

// Parse variables to array in technical task
function toArrayTZ(array $years) {
  $parsed = [];

  foreach ($years as $key=>$year) {
    $parsed[] = [explode('-', $key), $year];
  }

  $arr = [];
  foreach ($parsed as $parse) {
    $arr[$parse[0][0]][$parse[0][1]][$parse[0][2]] = $parse[1];
  }
  unset($parsed);

//  var_dump($arr);
  $return = [];

  foreach ($arr as $key=>$aa) {
    foreach ($aa as $key1=>$a) {
      $return[] = array_merge([
        'Year' => $key1,
        'Form' => $key,
      ], $a);
    }
  }

  return $return;
}

// Parse variavles from technical task to array[formID][year]
function tzParseTableYear(array $array) {
  $tables = [];
  foreach ($array as $arr) {
    foreach ($arr as $k=>$a) {
      if ($k == 'Year' || $k == 'Form' )
        continue;
      $tables[$arr['Form']][$arr['Year']][$k] = $a;
    }
  }
  return $tables;
}
