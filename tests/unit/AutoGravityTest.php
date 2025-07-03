<?php
namespace DealerInspire\Vessel;

class AutoGravityTest extends \Codeception\Test\Unit
{
  use \Codeception\Test\Feature\Stub;
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before() {}

  protected function _after() {}

  // tests hi
  public function testAutoGravityVdpHtml()
  {
    $vessel = $this->make(Vessel::class);
    $fj = $this->make(FJ::class);

    $AG = new FJAutoGravity($fj, $vessel);

    ob_start();
    $AG::app_banner_placement($location = 'vdp');
    $html = ob_get_clean();

    $this->assertContains('fj-drive vdp', $html);
  }
}
