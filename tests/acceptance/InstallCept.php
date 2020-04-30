<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('Install Module');
$I->amOnPage('/');
$I->see('Home');
$I->fillField('uname', 'webmaster');
$I->fillField('pass', '123');
//$I->click('submit');
$I->click('User Login');
//$I->click('icon-white icon-user');
$I->see('Administration Menu');
$I->click('Administration Menu');
$I->see('Modules');
$I->click('Modules');
$I->amOnPage('/modules/system/admin.php?fct=modulesadmin');
$I->see('Install module');
$I->click('Install module');
$I->amOnPage('/modules/system/admin.php?fct=modulesadmin&op=installlist');
//need to find a way to click on image
//$I->seeElement('//img[@src="/install.png"]');
$I->amOnPage('/modules/system/admin.php?fct=modulesadmin&op=install&module=suico');
$I->see('Install');
$I->click('Install');
//Factory
//$I->havePosts(40);
//if (!$suicoHandler->insert($suicoObj)) {
//    redirect_header('index.php', 3, _MD_CONTACT_MES_NOTSAVE);
//    exit();
//}
//$I->amOnPage('/modules/system/admin.php');
$I->see('This Module Admin');
$I->click('This Module Admin');
$I->amOnPage('/modules/contact/admin/index.php');

