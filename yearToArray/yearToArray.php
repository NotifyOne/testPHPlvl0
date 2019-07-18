<?php
namespace yearToArray;


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
