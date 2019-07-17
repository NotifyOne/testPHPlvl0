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

  public function addYear(int $year, array $values = [NULL]) {
    $this->years[] = [$year, $values];
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

  private function getInputRender(int $year, string $mount, string $value = '') {
    return "<input type='number' name='arr[{$this->id}-{$year}-{$mount}]' width='100px' value='{$value}' />";
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

      $rendered .= $this->getCellRender($year[0]);
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Jan", ($year[1]['Jan'] ?? '') ));
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Feb"), ($year[1]['Feb'] ?? '') );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Mar"), ($year[1]['Mar'] ?? '') );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Q1", ($year[1]['Q1'] ?? '')), 'colored' );

      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Apr", ($year[1]['Apr'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "May", ($year[1]['May'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Jun", ($year[1]['Jun'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Q2", ($year[1]['Q2'] ?? '')), 'colored' );


      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Jul", ($year[1]['Jul'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Aug", ($year[1]['Aug'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Sep", ($year[1]['Sep'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Q3", ($year[1]['Q3'] ?? '')), 'colored' );

      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Oct", ($year[1]['Oct'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Nov", ($year[1]['Nov'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Dec", ($year[1]['Dec'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "Q4", ($year[1]['Q4'] ?? '')), 'colored' );


      $rendered .= $this->getCellRender( $this->getInputRender($year[0], "YDT", ($year[1]['YDT'] ?? '')), 'colored' );


      $rendered .= $this->printTab(1) . '</tr>' . PHP_EOL;
    }

    return $rendered;
  }

  function render() {
    $this->rendered .= '<input type="submit" value="Add year" name="'. $this->id .'" formaction="index.php"/>';

    $this->rendered .= '<table border="1px" width="100%">' . PHP_EOL;

    $this->rendered .= $this->getTopTableRender();
    $this->rendered .= $this->getYearsRender();

    $this->rendered .= '</table>' . PHP_EOL;


    return $this->rendered;
  }
}
