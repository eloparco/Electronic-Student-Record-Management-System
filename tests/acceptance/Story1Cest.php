<?php 

class Story1Cest
{
    public function _before(AcceptanceTester $I)
    {
    }
    
    // tests
    public function testLoginSuccess(AcceptanceTester $I)
    {
        // $I->amOnPage('/login.php');        
        // $I->fillField('username', 'john@doe.it');
        // $I->fillField('password', 'pass123');
        // $I->click('Sign in');
        $I->login('john@doe.it', 'pass123');

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
        // login as parent
        $I->amOnPage('/login.php');
        $I->fillField('username', 'r.filicaro@parent.esrmsystem.com');
        $I->fillField('password', 'Roberta77');
        $I->click('Sign in');

        $I->seeInCurrentUrl('/user_parent.php');
        // $I->see('Marks');
        
        // // check marks
        $I->wait(1);  // without this nothing works 
        // $I->waitForElement('#marks_dashboard', 10);

        $I->click('Marks');
        // $I->wait(5);   
        $I->waitForElement('#filters', 10);
        $table = array(
            array('Geography', '4th Nov 2019', '8.75'),
            array('History', '7th Nov 2019', '6.50'),
            array('Italian', '7th Nov 2019', '7.25'),
            array('Physics', '8th Nov 2019', '6.75'),
            array('Mathematics', '11th Nov 2019', '8.00')
        );

        // check entries in table
        foreach ($table as $row) {
            foreach ($row as $item) {
                $I->see($item);
            }
        }
    }

    public function testMarkSingleSubject(AcceptanceTester $I)
    {
        // login as parent
        $I->amOnPage('/login.php');
        $I->fillField('username', 'r.filicaro@parent.esrmsystem.com');
        $I->fillField('password', 'Roberta77');
        $I->click('Sign in');

        $I->seeInCurrentUrl('/user_parent.php');
        $I->see('Marks');
        $I->wait(1);
        $I->click('Marks');

        // select subject
        $I->selectOption("form select[name='subjectSelection']", 'Geography');
        $I->wait(1);
        $mark = array('Geography', '4th Nov 2019', '8.75');
        foreach ($mark as $item) {
            $I->see($item);
        }

        $subjects = array('7th Nov 2019', '7th Nov 2019', '8th Nov 2019', '11th Nov 2019');
        foreach ($subjects as $subject)
            $I->dontSee($subject);
    }

    // public function testMarkFromStartingDate(AcceptanceTester $I)
    // {
    //     // login as parent
    //     $I->amOnPage('/login.php');
    //     $I->fillField('username', 'r.filicaro@parent.esrmsystem.com');
    //     $I->fillField('password', 'Roberta77');
    //     $I->click('Sign in');

    //     $I->seeInCurrentUrl('/user_parent.php');
    //     $I->see('Marks');
    //     $I->wait(1);
    //     $I->click('Marks');

    //     // select date
    //     $I->fillField('startDateSelection', '11/11/2019');

    //     $I->wait(1);
    //     $I->see('11th Nov 2019');

    //     $subjects = array('4th Nov 2019', '7th Nov 2019', '7th Nov 2019', '8th Nov 2019', '11th Nov 2019');
    //     foreach ($subjects as $subject)
    //         $I->dontSee($subject);
    // }
}
