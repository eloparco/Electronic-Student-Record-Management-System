<?php 

class Story9Cest
{
    // tests
    public function testPresentStudent(AcceptanceTester $I)
    {        
        //so important, without maximize, in small screen, logout and home button will be not visible, and so not clickable     
        $I->maximizeWindow();
        // login as teacher
        $I->amOnPage('/login.php');
        $I->fillField('username', 'aaa@bbb.com');
        $I->fillField('password', 'a1a1a1a1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record attendance');
        $I->waitForElementClickable('#recordAttendance', 10);
        $I->click('Record attendance');        
        
        // Select the class
        $I->selectOption("select[name='class_sID_ssn']", "1A");
                
        //send request to db        
        $I->click('Confirm');
        
        $I->wait(1);
        // check if students are inserted in attendance table in the DB
        $I->dontseeInDatabase('ATTENDANCE', [
            'StudentSSN' => 'MNDGPP04E14L219U',
            'Date' => date('Y-m-d'),            
            'Presence' => 'ABSENT',
            'ExitHour' => '6'
        ]);
        $I->acceptPopup();         
    }
    public function testInsertAbsentStudent(AcceptanceTester $I)
    {        
        // login as teacher
        $I->amOnPage('/login.php');
        $I->fillField('username', 'aaa@bbb.com');
        $I->fillField('password', 'a1a1a1a1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record attendance');
        $I->wait(1);
        $I->click('Record attendance');        
        
        // Select the class
        $I->selectOption("select[name='class_sID_ssn']", "1A");
        $I->wait(1);
        //select 1 students absent
        $I->click('input[for="MNDGPP04E14L219UabsentRadio"]'); 
        //select 1 students late       
        $I->click('input[for="PNCRCR02C13L219Klate15Radio"]');        
        //send request to db        
        $I->click('Confirm');
        
        $I->wait(1);
        // check if students are inserted in attendance table in the DB
        $I->seeInDatabase('ATTENDANCE', [
            'StudentSSN' => 'MNDGPP04E14L219U',
            'Date' => date('Y-m-d'),            
            'Presence' => 'ABSENT',
            'ExitHour' => '6'
        ]);   

        $I->seeInDatabase('ATTENDANCE', [
            'StudentSSN' => 'PNCRCR02C13L219K',
            'Date' => date('Y-m-d'),            
            'Presence' => '10_MIN_LATE',
            'ExitHour' => '6'
        ]); 
        $I->acceptPopup();      
    }
}
