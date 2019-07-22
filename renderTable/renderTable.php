<?php

/**
 * Class RenderTable
 * for render table
 */
class RenderTable {

  /**
   * @var string
   *  Contains rendered table after function render()
   */
  protected $rendered;

  /**
   * @var array
   *  Contains array years and mounts [year1 => mounts, ]
   */
  protected $years;

  /**
   * @var int
   *  Contains count tables
   */
  static $countId = 0;

  /**
   * @var int
   *  Contains current table id
   */
  protected $id;

  /**
   * RenderTable constructor.
   *  Init table with default parameters
   */
  function __construct() {
    $this->rendered = '';
    $this->years = [];
    $this->id = self::$countId;
    self::$countId++;
  }

  /**
   * Add year to mounts
   * @param int $year
   * @param array $values = [NULL]
   */
  public function addYear(int $year, array $values = [NULL]) {
    $this->years[$year] = $values;
  }

  /**
   * Add prev year
   */
  public function addPrevYear() {
   $tmp = $this->years;
   $this->years = null;
   $this->years = [ (min(array_keys($tmp)) - 1) => []] + $tmp;
  }

  /**
   * Print tabs for generated code. Good source -> good debugging.
   * @param int $i
   *  Count tabs to return
   * @return string
   */
  private function printTab(int $i) {
    return str_repeat("\t", $i);
  }

  /**
   * Print Cell
   * @param string $cell
   *  Cell value
   * @param string|NULL $addClass
   *  Class to add.
   *    If NULL -> no add
   * @param bool $useTh
   *  Usage TH or TD
   * @param int $countTab
   *  Tabs to print
   *
   * @return string
   *  Formatted html block with cell
   */
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

  /**
   * @param int $year
   * @param string $mount
   * @param string $value
   *
   * @return string
   *  Formatted html block with input
   */
  private function getInputRender(int $year, string $mount, string $value = '') {
    return "<input type='number' name='arr[{$this->id}][{$year}][{$mount}]' width='100px' value='{$value}' />";
  }

  /**
   * @return string
   *  Formatted html table line block top table
   */
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

  /**
   * @return string
   *  Formatted html table line year and mounts with inputs
   */
  private function getYearsRender() {
    $rendered = '';

    foreach ($this->years as $key=>$year) {
      $rendered .= $this->printTab(1) . '<tr>' . PHP_EOL;

      $rendered .= $this->getCellRender($key);
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Jan", ($year['Jan'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Feb", ($year['Feb'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Mar", ($year['Mar'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Q1", ($year['Q1'] ?? '')), 'colored' );

      $rendered .= $this->getCellRender( $this->getInputRender($key, "Apr", ($year['Apr'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "May", ($year['May'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Jun", ($year['Jun'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Q2", ($year['Q2'] ?? '')), 'colored' );


      $rendered .= $this->getCellRender( $this->getInputRender($key, "Jul", ($year['Jul'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Aug", ($year['Aug'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Sep", ($year['Sep'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Q3", ($year['Q3'] ?? '')), 'colored' );

      $rendered .= $this->getCellRender( $this->getInputRender($key, "Oct", ($year['Oct'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Nov", ($year['Nov'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Dec", ($year['Dec'] ?? '')) );
      $rendered .= $this->getCellRender( $this->getInputRender($key, "Q4", ($year['Q4'] ?? '')), 'colored' );


      $rendered .= $this->getCellRender( $this->getInputRender($key, "YDT", ($year['YDT'] ?? '')), 'colored' );


      $rendered .= $this->printTab(1) . '</tr>' . PHP_EOL;
    }

    return $rendered;
  }

  /**
   * @return string
   *  Formatted html table with years, mounts.
   */
  function render() {
    $this->rendered .= '<input type="submit" value="Add year" name="'. $this->id .'" formaction="index.php"/>';

    $this->rendered .= '<table border="1px" width="100%">' . PHP_EOL;

    $this->rendered .= $this->getTopTableRender();
    $this->rendered .= $this->getYearsRender();

    $this->rendered .= '</table>' . PHP_EOL;


    return $this->rendered;
  }
}
