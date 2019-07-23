<?php

/**
 * Class RenderTable
 * for render table
 */
class RenderTable {

  /**
   * @var array
   *  Structure table.
   */
  protected $structure;

  /**
   * @var string
   *  Contains rendered table after function render().
   */
  protected $rendered;

  /**
   * @var array
   *  Contains array years and mounts [year1 => mounts, ].
   */
  protected $years;

  /**
   * @var int
   *  Contains count tables.
   */
  private static $countId = 0;

  /**
   * @var int
   *  Contains current table id.
   */
  protected $id;

  /**
   * RenderTable constructor.
   *  Init table with default parameters.
   */
  function __construct() {
    $this->rendered = '';
    $this->years = [];
    $this->structure = [
      'Year',
      'Jan', 'Feb', 'Mar', 'Q1',
      'Apr', 'May', 'Jun', 'Q2',
      'Jul', 'Aug', 'Sep', 'Q3',
      'Oct', 'Nov', 'Dec', 'Q4',
      'YDT',
    ];
    $this->id = self::$countId;
    self::$countId++;
  }

  /**
   * Add year to mounts.
   * @param int $year
   * @param array $values = [NULL]
   */
  public function addYear(int $year, array $values = [NULL]) {
    $this->years[$year] = $values;
  }

  /**
   * Add prev year.
   */
  public function addPrevYear() {
   $tmp = $this->years;
   $this->years = null;
   $this->years = [ (min(array_keys($tmp)) - 1) => []] + $tmp;
  }

  /**
   * Print tabs for generated code. Good source -> good debugging.
   * @param int $i
   *  Count tabs to return.
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
   *    If NULL -> no add.
   * @param bool $useTh
   *  Usage TH or TD.
   * @param int $countTab
   *  Tabs to print.
   *
   * @return string
   *  Formatted html block with cell.
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
   *  Formatted html block with input.
   */
  private function getInputRender(int $year, string $mount, string $value = '') {
    return "<input type='number' step='any' name='arr[{$this->id}][{$year}][{$mount}]' width='100px' value='{$value}' />";
  }

  /**
   * @return string
   *  Formatted html table line block top table
   */
  private function getTopTableRender() {
    $rendered = '';

    $rendered .= $this->printTab(1) . '<tr>' . PHP_EOL;

    foreach ($this->structure as $item) {
      $rendered .= $this->getCellRender($item, NULL, TRUE);
    }

    $rendered .= $this->printTab(1) . '</tr>' . PHP_EOL;

    return $rendered;
  }

  /**
   * @return string
   *  Formatted html table line year and mounts with inputs.
   */
  private function getYearsRender() {
    $rendered = '';

    foreach ($this->years as $key=>$year) {
      $rendered .= $this->printTab(1) . '<tr>' . PHP_EOL;


      foreach ($this->structure as $item) {
        $rendered .= ($item != 'Year')
          ? $this->getCellRender(
              $this->getInputRender($key, $item, ($year[$item] ?? ''))
            )
          : $this->getCellRender($key);
      }


      $rendered .= $this->printTab(1) . '</tr>' . PHP_EOL;
    }

    return $rendered;
  }

  /**
   * @return string
   *  Formatted html table with years, mounts.
   */
  function render() {
    $this->rendered .= '<input type="submit" value="Add year" name="'. $this->id .'" />';

    $this->rendered .= '<table>' . PHP_EOL;

    $this->rendered .= $this->getTopTableRender();
    $this->rendered .= $this->getYearsRender();

    $this->rendered .= '</table>' . PHP_EOL;


    return $this->rendered;
  }
}
