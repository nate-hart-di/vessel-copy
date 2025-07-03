<?php

class vrpCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests

    public function amOnVrp(AcceptanceTester $I)
    {
        $I->amOnPage('/new-vehicles/');
        $I->see('New Mercedes-Benz for Sale in Ontario, CA');
    }

    public function findVehicleWithLeaseOfferCtaAndTest(AcceptanceTester $I) {
        $I->appendField('#search', '153171');
        $I->pressKey('#search', WebDriverKeys::ENTER);
        $I->wait(2);

        $I->click('.lease-for-less');
        $I->wait(1);
        $I->see('Thank you for inquiring on lease payments for this vehicle.');
        $I->pressKey('body', WebDriverKeys::ESCAPE);
        $I->wait(1);
    }

    public function seeAllThreeCTAs(AcceptanceTester $I) {
        $I->scrollTo(['css' => '.vehicle-overview']);
        $I->see('Get Your Lease Offer Now');
        $I->see('Get My E-Price');
        $I->see('Get Pre-Approved');
    }
}
