<?php
require_once 'renderTable/renderTable.php';
//require_once 'verify.php';

$addYear = null;

foreach ($_POST as $key=>$value) {
  if ($value === 'Add year') {
    $addYear = $key;
  }
}

$tablesRender = [];
if (isset($_POST['arr'])) {
  $tables = [];

  foreach ($_POST['arr'] as $key => $table) {
    if (!isset($tables[$key])) {
      $tables[$key] = new RenderTable();
    }

    foreach ($table as $k=>$t) {
      $tables[$key]->addYear($k, $t);
    }
  }
  if (isset($addYear)) {
    $tables[$addYear]->addPrevYear();
  } elseif (isset($_POST['AddTable'])) {
    $tables[] = new RenderTable();
    $tables[count($tables) - 1]->addYear(date("Y"));
  }

  foreach ($tables as $t) {
    $tablesRender[] = $t->render();
  }

} else {
  $table = new RenderTable();
  $table->addYear(date("Y"));
  $tablesRender[] = $table->render();

}


//$table = new RenderTable();
//$table->addYear(2018);
//$table->addYear(2019);
//
//$tables[] =  $table->render();
//
//$table = new RenderTable();
//$table->addYear(2019);
//$tables[] = $table->render();

require_once 'template/table.php';

//echo '<pre>';
//var_dump($_POST);
//var_dump(yearToArray\tzParseTableYear(yearToArray\toArrayTZ($_POST['arr'])));
