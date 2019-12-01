<?php 

class Storyz10Cest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function testRadioCheckedStudent(AcceptanceTester $I)
    {        
        // login as teacher
        $I->amOnPage('/login.php');
        $I->fillField('username', 'aaa@bbb.com');
        $I->fillField('password', 'a1a1a1a1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record attendance');
        //$I->waitForElementClickable('#recordAttendance', 10);
        $I->wait(1);
        $I->click('Record attendance');        
        
        // Select the class
        $I->selectOption("select[name='class_sID_ssn']", "1A");
        $I->wait(1);
        //check if Early Leaving button is checked
        $I->seeCheckboxIsChecked('input[for="MNDGPP04E14L219UabsentRadio"]');


        $I->click('Logout');
    }
    public function testInsertEarlyLeavingStudent(AcceptanceTester $I)
    {        
        // login as teacher
        $I->amOnPage('/login.php');
        $I->fillField('username', 'aaa@bbb.com');
        $I->fillField('password', 'a1a1a1a1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record attendance');
        //$I->waitForElementClickable('#recordAttendance', 10);
        $I->wait(1);
        $I->click('Record attendance');        
        
        // Select the class
        $I->selectOption("select[name='class_sID_ssn']", "1A");
        $I->wait(1);
        //select 1 student Early Leaving
        $I->click('input[for="PNCRCR02C13L219KleavingRadio"]'); 
        //select 1 insert hour of Early Leaving
        $I->fillField('PNCRCR02C13L219KearlyleavingText', '4');    

        $I->click('Confirm');
        $I->wait(1);
        // check if early leaving in attendance table in the DB
        $I->seeInDatabase('ATTENDANCE', [
            'StudentSSN' => 'PNCRCR02C13L219K',
            'Date' => date('Y-m-d'),         
            'ExitHour' => '4'
        ]);
        $I->acceptPopup();     
        $I->acceptPopup();
        $I->click('Logout');
    }

}
