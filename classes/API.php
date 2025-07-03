<?php

namespace DealerInspire\Vessel;

class API
{
  protected $_auth_key = 'OOwEcUp4DgQDyOYmOh1OQsW0laCNSpjW';
  protected $_fj;

  public function __construct(FJ $FJ)
  {
    $this->_fj = $FJ;
  }

  public function check_vessel_auth_key()
  {
    if (empty($_REQUEST['vessel_key']) || $_REQUEST['vessel_key'] !== $this->_auth_key) {
      $this->die_safely();
    } else {
      return true;
    }
  }

  public function die_safely()
  {
    wp_die('Invalid key.', 403);
  }
}
