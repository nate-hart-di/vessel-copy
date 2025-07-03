<?php

class vrpCest
{
  public function _before(AcceptanceTester $I) {}

  public function _after(AcceptanceTester $I) {}

  // tests
  public function amOnVrp(AcceptanceTester $I)
  {
    $I->amOnPage('/new-vehicles/');
    $I->see('New Mercedes-Benz for Sale in Newport Beach, CA');
  }

  public function seeVYT(AcceptanceTester $I)
  {
    $I->see('Value Your Trade');
  }

  public function seeGetPreApprovedCta(AcceptanceTester $I)
  {
    $I->see('Get Pre-Approved');
  }

  public function findVehicleWithLeaseOfferCta(AcceptanceTester $I)
  {
    $I->appendField('#search', 'N145098');
    $I->pressKey('#search', WebDriverKeys::ENTER);
    $I->wait(2);

    $I->click('.vehicle-title.clearfix a');
  }

  public function testLeaseOfferCta(AcceptanceTester $I)
  {
    $I->wait(1);
    $I->click('Get Your Lease Offer Now');
    $I->wait(1);
    $I->see('Thank you for inquiring on lease payments for this vehicle.');
  }
}
