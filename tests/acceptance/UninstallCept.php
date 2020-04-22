<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('UnInstall Module');
$I->amOnPage('/');
$I->see('Home');
$I->fillField('uname', 'webmaster');
$I->fillField('pass', '123');
//$I->click('submit');
$I->click('User Login');
//$I->click('icon-white icon-user');
$I->see('Administration Menu');
$I->click('Administration Menu');

$I->amOnPage('/modules/system/admin.php?fct=modulesadmin');

$I->see('http://259alfred/modules/system/admin.php?fct=modulesadmin&amp;op=uninstall&amp;module=yogurt');
//$I->see('#mod_9 > td:nth-child(6) > a:nth-child(2)');
//$I->see('//*[@id="mod_9"]/td[6]/a[2]');
//$I->see('/modules/system/admin.php?fct=modulesadmin&op=uninstall&module=contact');
//$I->click('http://localhost/259zyspec/modules/system/admin.php?fct=modulesadmin&amp;op=uninstall&amp;module=contact');
//$I->see('Uninstall-contact');
//$I->see('uninstall_contact');
//$I->see('Uninstall2-contact');
//$I->seeLink('<img src="http://localhost/259zyspec/modules/system/images/icons/default/uninstall.png" alt="Uninstall" id="uninstall2_contact" title="Uninstall2-contact" />');
//$I->click('<img src="http://localhost/259zyspec/modules/system/images/icons/default/uninstall.png" alt="Uninstall" id="uninstall2_contact" title="Uninstall2-contact" />');
//$I->seeLink('Uninstall-contact');
//$I->seeLink('uninstall_contact');
//$I->seeLink('Uninstall2-contact');
//$I->click('Uninstall2-contact');

//$I->seeLink('', '/modules/contact/admin/index.php');
//$I->click('', '/modules/contact/admin/index.php');
//$I->seeLink(['img' => 'uninstall_contact']);
//$I->seeLink('img#uninstall2_contact');
//$I->seeLink(['img' => 'Uninstall2-contact']);

//$I->amOnPage('/modules/system/admin.php?fct=modulesadmin&op=uninstall&module=contact');

$I->amOnPage('modules/yogurt/admin/index.php');
//$I->see('Uninstall');
//$I->seeLink('Uninstall');
//$I->click('Uninstall');
$I->see('Uninstall');
$I->seeLink('Uninstall');
//$I->seeLink('uninstall1_contact');
//$I->seeLink('uninstall2_contact');
//$I->seeLink(['link' => 'uninstall_contact']);
//$I->click('uninstall_contact');
$I->click('Uninstall');
$I->see('confirm_submit');
$I->click('confirm_submit');

//$I->amOnPage('/modules/system/admin.php');

$I->see('XOOPS Module Administration');
$I->click('XOOPS Module Administration');

$I->amOnPage('/modules/system/admin.php?fct=modulesadmin');

