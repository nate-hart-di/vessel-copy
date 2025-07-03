<?php

namespace DealerInspire\Vessel;

class VesselTest extends \Codeception\Test\Unit
{
  use \Codeception\Test\Feature\Stub;
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before() {}

  protected function _after() {}

  // tests
  public function testReturnsPluginDir()
  {
    $fj = $this->make(FJ::class);
    $vessel = new Vessel($fj);

    $dir = dirname(__DIR__, 2) . '/';

    $this->assertEquals($vessel->get_plugin_path(), $dir);
  }

  public function testReturnsNotProdEnv()
  {
    $fj = $this->make(FJ::class);
    $vessel = new Vessel($fj);

    $this->assertFalse($vessel->is_prod());
  }

  public function testCannotFindTemplate()
  {
    $fj = $this->make(FJ::class);
    $vessel = new Vessel($fj);

    $this->assertFalse($vessel->vessel_template_exists('fjsucks'));
  }
}
