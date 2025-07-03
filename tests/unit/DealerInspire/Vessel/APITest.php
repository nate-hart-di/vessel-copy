<?php
namespace DealerInspire\Vessel;

class APITest extends \Codeception\Test\Unit
{
  use \Codeception\Test\Feature\Stub;
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before() {}

  protected function _after() {}

  // tests
  public function testAPIKeyIsValidated()
  {
    $fj = $this->make(FJ::class);
    $api = new API($fj);

    $_REQUEST['vessel_key'] = 'OOwEcUp4DgQDyOYmOh1OQsW0laCNSpjW';

    $this->assertTrue($api->check_vessel_auth_key());
  }

  public function testAPIKeyIsRejected()
  {
    $fj = $this->make(FJ::class);
    $api = $this->make(API::class, [
      'die_safely' => function () {
        return true;
      },
    ]);

    $_REQUEST['vessel_key'] = 'jesustakethewheel';

    $this->assertEquals($api->die_safely(), true);
  }
}
