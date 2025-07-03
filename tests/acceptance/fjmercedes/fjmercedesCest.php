<?php

class fjmercedesCest
{
  public function _before(AcceptanceTester $I) {}

  public function _after(AcceptanceTester $I) {}

  // tests
  public function amOnNewportBeach(AcceptanceTester $I)
  {
    $I->amOnPage('/');
    $I->see('Newport Beach');
  }

  public function testingAskAQuestion(AcceptanceTester $I)
  {
    $I->click('.ask-question-btn');
    $I->wait(0.5);
    $I->see('We would love to hear from you!');
  }
}
