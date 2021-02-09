<?php
declare(strict_types=1);

namespace Trois\Cms\View\Cell;

use Cake\View\Cell;

/**
* Default cell
*/
class DefaultCell extends Cell
{
  /**
  * List of valid options that can be passed into this
  * cell's constructor.
  *
  * @var array
  */
  protected $_validCellOptions = [];

  /**
  * Initialization logic run at the end of object construction.
  *
  * @return void
  */
  public function initialize(): void
  {
  }

  /**
  * Default display method.
  *
  * @return void
  */
  public function display()
  {
  }
}
