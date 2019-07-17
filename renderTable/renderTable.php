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
    $ret .= $this->printTab($countTab) . '</' . ($useTh ? 'th' : 'td') . '>' . PHP_EOL;

    return $ret;
  }

  private function getInputRender(int $year, string $mount) {
    return "<input type='number' name='arr[{$this->id}-{$year}-{$mount}]' width='100px' />";
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
      $rendered .= $this->getCellRender($this->getInputRender($year, "Jan"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Feb"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Mar"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Q1"), 'colored');

      $rendered .= $this->getCellRender($this->getInputRender($year, "Apr"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "May"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Jun"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Q2"), 'colored');


      $rendered .= $this->getCellRender($this->getInputRender($year, "Jul"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Aug"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Sep"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Q3"), 'colored');

      $rendered .= $this->getCellRender($this->getInputRender($year, "Oct"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Nov"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Dec"));
      $rendered .= $this->getCellRender($this->getInputRender($year, "Q4"), 'colored');


      $rendered .= $this->getCellRender($this->getInputRender($year, "YDT"), 'colored');


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
