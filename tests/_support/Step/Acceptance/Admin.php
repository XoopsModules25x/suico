<?php

namespace Step\Acceptance;

class Admin extends \AcceptanceTester
{
    public function loginAsAdmin()
    {
        $I = $this;

        $I->amOnPage('/admin');

        $I->fillField('username', 'webmaster');

        $I->fillField('password', '123');

        $I->click('Login');
    }
}
