<?php
require_once 'renderTable/renderTable.php';

$table = new RenderTable();
$table->addYear(2018);
$table->addYear(2019);



$tables =  $table->render();

require_once 'template/table.php';
