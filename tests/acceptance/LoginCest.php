<?php 

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {

    }

    // tests
    public function testLoginSuccess(AcceptanceTester $I)
    {
        $I->amOnPage('/login.php');        
        $I->fillField('username', 'john@doe.it');
        $I->fillField('password', 'pass123');
        $I->click('Sign in');

        $I->seeInCurrentUrl('/user_parent.php');
    }

    public function testLoginWrongEmail(AcceptanceTester $I)
    {
        $I->amOnPage('/login.php');
        $I->fillField('username', 'wrong@username');
        $I->fillField('password', 'wrong_password1');
        $I->click('Sign in');

        $I->seeInCurrentUrl('/login.php');
        $I->see('Email entered is incorrect.');
    }

    public function testLoginWrongPassword(AcceptanceTester $I)
    {
        $I->amOnPage('/login.php');
        $I->fillField('username', 'john@doe.it');
        $I->fillField('password', 'wrong_password1');
        $I->click('Sign in');

        $I->seeInCurrentUrl('/login.php');
        $I->see('Invalid username or password.');
    }
}
