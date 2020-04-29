<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('Log as Registered User');
$I->amOnPage('/');
$I->see('Home');
$I->fillField('uname', 'tester');
$I->fillField('pass', 'password');
//$I->click('submit');
$I->click('User Login');
$I->amOnPage('/');
$I->see('Home');
