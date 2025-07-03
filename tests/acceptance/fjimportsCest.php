<?php


class fjimportsCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function amOnImports(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Imports');
    }

    public function seeCtas(AcceptanceTester $I)
    {
        $I->see('Sell');
        $I->see('Service');
        $I->see('Shop');
    }

    public function seeThirdPartyTextUs(AcceptanceTester $I)
    {
        $I->see('Text Us');
    }

    public function seeVehicleCarousel(AcceptanceTester $I)
    {
        $I->click('New');
        $I->wait(1);
        $I->see('C-Class Sedan');
        $I->see('E-Class Sedan');
        $I->see('S-Class Sedan');
        $I->see('Mercedes-Maybach');
        $I->see('E-Class Wagon');

        $I->click('Coupes');
        $I->wait(1);
        $I->see('CLA');
        $I->see('CLS');

        $I->click('SUVS');
        $I->wait(1);
        $I->see('GLA SUV');
        $I->see('GLC SUV');

        $I->click('Convertibles & Roadsters');
        $I->wait(1);
        $I->see('C-Class Cabriolet');
        $I->see('E-Class Cabriolet');

        $I->click('Hybrid & Electric');
        $I->wait(1);
        $I->see('B-Class');
        $I->see('C-Class Hybrid');

    }

    public function seeGetPreApproved(AcceptanceTester $I) {
        $I->amOnPage('/new-vehicles/');
        $I->see('Get Pre-Approved');
    }
}
