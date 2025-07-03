<?php
namespace DealerInspire\Vessel;

class Mercedes
{
  private $_mercedes_dealers;

  public function __construct()
  {
    $this->set_mercedes_dealers();
  }

  public function set_mercedes_dealers()
  {
    $this->_mercedes_dealers = [435, 571, 570, 416, 616, 615, 777, 1434, 535, 1702];
  }

  public function get_mercedes_dealers()
  {
    return $this->_mercedes_dealers;
  }
}
