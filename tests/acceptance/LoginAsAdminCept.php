<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Log as Admin');
$I->amOnPage('/');
$I->see('Home');
$I->fillField('uname', 'webmaster');
$I->fillField('pass', '123');
//$I->click('submit');
$I->click('User Login');
//$I->click('icon-white icon-user');
$I->seeLink('Administration Menu');
