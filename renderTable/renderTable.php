<?php

/**
 * Class RenderTable
 * for render table
 */
class RenderTable {

  protected $rendered;

  protected $years;

  static $countId = 0;
  protected $id;

  function __construct() {
    $this->rendered = '';
    $this->years = [];
    $this->id = self::$countId;
    self::$countId++;
  }

  public function addYear(int $year) {
    $this->years[] = $year;
  }

  private function printTab(int $i) {
    return str_repeat("\t", $i);
  }

  private function getCellRender(
    string $cell,
    string $addClass = NULL,
    bool $useTh = FALSE,
    int $countTab = 2) {

    $ret = '';

    $ret .= $this->printTab($countTab)
      . '<'
      . ($useTh ? 'th' : 'td')
      . (isset($addClass) ? " class='$addClass '" : '')
      . '>'
      . PHP_EOL;
    $ret .= $this->printTab($countTab + 1) . $cell . PHP_EOL;
    $ret .= $this->printTab($countTab) . '</' . ($useTh ? 'th' : 'td') .'>' . PHP_EOL;

    return $ret;
  }

  private function getTopTableRender() {
    $rendered = '';

    $rendered .= $this->printTab(1) . '<tr>' . PHP_EOL;

    $rendered .= $this->getCellRender('Year', NULL, TRUE);

    $rendered .= $this->getCellRender('Jan', NULL, TRUE);
    $rendered .= $this->getCellRender('Feb', NULL, TRUE);
    $rendered .= $this->getCellRender('Mar', NULL, TRUE);
    $rendered .= $this->getCellRender('Q1', 'colored', TRUE);

    $rendered .= $this->getCellRender('Apr', NULL, TRUE);
    $rendered .= $this->getCellRender('May', NULL, TRUE);
    $rendered .= $this->getCellRender('Jun', NULL, TRUE);
    $rendered .= $this->getCellRender('Q2', 'colored', TRUE);

    $rendered .= $this->getCellRender('Jul', NULL, TRUE);
    $rendered .= $this->getCellRender('Aug', NULL, TRUE);
    $rendered .= $this->getCellRender('Sep', NULL, TRUE);
    $rendered .= $this->getCellRender('Q3', 'colored', TRUE);

    $rendered .= $this->getCellRender('Oct', NULL, TRUE);
    $rendered .= $this->getCellRender('Nov', NULL, TRUE);
    $rendered .= $this->getCellRender('Dec', NULL, TRUE);
    $rendered .= $this->getCellRender('Q3', 'colored', TRUE);

    $rendered .= $this->getCellRender('YTD', 'colored', TRUE);

    $rendered .= $this->printTab(1) . '</tr>' . PHP_EOL;

    return $rendered;
  }

  private function getYearsRender() {
    $rendered = '';

    foreach ($this->years as $year) {
      $rendered .= $this->printTab(1) . '<tr>' . PHP_EOL;

      $rendered .= $this->getCellRender($year);
      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('', 'colored');

      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('', 'colored');


      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('', 'colored');

      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('');
      $rendered .= $this->getCellRender('', 'colored');


      $rendered .= $this->getCellRender('', 'colored');


      $rendered .= $this->printTab(1) . '</tr>' . PHP_EOL;
    }

    return $rendered;
  }

  function render() {
    $this->rendered .= '<table border="1px" width="100%">' . PHP_EOL;

    $this->rendered .= $this->getTopTableRender();
    $this->rendered .= $this->getYearsRender();

    $this->rendered .= '</table>' . PHP_EOL;

    return $this->rendered;
  }
}
