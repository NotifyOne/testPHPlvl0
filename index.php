<?php
require_once 'renderTable/renderTable.php';

// table id for add new line
$addYear = null;

// Search id with value 'Add year' (button)
foreach ($_POST as $key=>$value) {
  if ($value === 'Add year') {
    $addYear = $key;
  }
}

// Array tables for rendering
$tablesRender = [];
if (isset($_POST['arr'])) {
  $tables = [];

  // Create tables with prev array
  foreach ($_POST['arr'] as $key => $table) {
    if (!isset($tables[$key])) {
      $tables[$key] = new RenderTable();
    }

    foreach ($table as $k=>$t) {
      $tables[$key]->addYear($k, $t);
    }
  }

  if (isset($addYear)) {
    // Add empty line for table with prev year
    $tables[$addYear]->addPrevYear();
  } elseif (isset($_POST['AddTable'])) {
    // Add table with empty line and year = current year
    $tables[] = new RenderTable();
    $tables[count($tables) - 1]->addYear(date("Y"));
  }

  // Render tables
  foreach ($tables as $t) {
    $tablesRender[] = $t->render();
  }

} else {
  // If $_POST['arr'] not set - page load once
  // -> render empty table with year = current year
  $table = new RenderTable();
  $table->addYear(date("Y"));
  $tablesRender[] = $table->render();

}

// Require template file: Branch html from logic
require_once 'template/table.php';
