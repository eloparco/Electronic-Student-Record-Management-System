<?php 

class Story1Cest
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

        // redirect to parent page
        $I->seeInCurrentUrl('/user_parent.php');
        $I->see('Parent');
    }

    public function testLoginWrongEmail(AcceptanceTester $I)
    {
        $I->amOnPage('/login.php');
        $I->fillField('username', 'wrong@username');
        $I->fillField('password', 'wrong_password1');
        $I->click('Sign in');

        // remain in same page, show error
        $I->seeInCurrentUrl('/login.php');
        $I->see('Email entered is incorrect.');
    }

    public function testLoginWrongPassword(AcceptanceTester $I)
    {
        $I->amOnPage('/login.php');
        $I->fillField('username', 'john@doe.it');
        $I->fillField('password', 'wrong_password1');
        $I->click('Sign in');

        // remain in same page, show error
        $I->seeInCurrentUrl('/login.php');
        $I->see('Invalid username or password.');
    }

    public function testLoginFirstAccess(AcceptanceTester $I)
    {
        $I->amOnPage('/login.php');
        $I->fillField('username', 'jane@doe.it');
        $I->fillField('password', 'pass456');
        $I->click('Sign in');

        // redirect to update password page
        $I->seeInCurrentUrl('/update_password.php');
        $I->see('Update password');
        $I->see('Old Password');
        $I->see('New Password');
    }

    public function testMarkVisualization(AcceptanceTester $I)
    {
        $I->amOnPage('/login.php');
        $I->fillField('username', 'r.filicaro@parent.esrmsystem.com');
        $I->fillField('password', 'Roberta77');
        $I->click('Sign in');

        $I->seeInCurrentUrl('/user_parent.php');
        $I->see('Marks');
        
        $I->wait(1);
        $first_row = array('Geography', '4th Nov 2019', '8.75');
        foreach ($first_row as $item)
            $I->see($item);
    }
}
