<?php

class homepageCest
{
  public function _before(AcceptanceTester $I) {}

  public function _after(AcceptanceTester $I) {}

  // tests
  public function amOnOntario(AcceptanceTester $I)
  {
    $I->amOnPage('/');
    $I->seeInTitle('Ontario');
  }

  public function ontarioAddress(AcceptanceTester $I)
  {
    $I->see('3787 EAST GUASTI ROAD • ONTARIO, CA 91761');
  }

  public function testingAskAQuestion(AcceptanceTester $I)
  {
    $I->click('.ask-question-btn');
    $I->wait(0.5);
    $I->see('We would love to hear from you!');
  }
}
