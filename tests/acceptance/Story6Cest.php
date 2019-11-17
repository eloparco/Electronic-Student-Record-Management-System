<?php

class Story6Cest{
    public function _before(AcceptanceTester $I){
        $I->maximizeWindow();
    }

    public function _after(AcceptanceTester $I){
        // logout
        $I->click('Logout');
    }

    // tests
    public function testInsertNewMark(AcceptanceTester $I){
        $I->amOnPage('/login.php');
        $I->fillField('username', 't.fanelli@esrmsystem.com');
        $I->fillField('password', 'Teresa72');
        $I->click('Sign in');
        // end login
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record a student\'s mark');
        $I->wait(1);
        $I->click('Record a student\'s mark');
        // marks page
        $I->wait(1); // wait for ajax
        $I->selectOption("div select[name='class_sID_ssn']", '1A Mathematics');
        $I->wait(1); // wait for ajax
        $I->selectOption("div select[name='student']", 'Giuseppe Mandini');
        $day = date('l');
        $date = date('d/m/Y');
        $dateInDatabase = date('Y-m-d');
        if ($day === "Saturday" || $day === "Sunday"){
            $date = date('d/m/Y', time()-2*24*60*60);
            $dateInDatabase = date('Y-m-d', time()-2*24*60*60);
        }
        $I->pressKey("form input[name='date']", WebDriverKeys::ESCAPE);
        $I->wait(2); // see if the datepicker diappears
        $I->fillField('date', $date);
        $I->selectOption("div select[name='hour']", "3");
        $I->selectOption("div select[name='score']", "6");
        $I->click('+');
        $I->click('+');
        $I->click('+');
        $I->wait(1); // wait for partial increment
        $I->see('0.75');
        $I->click('Confirm');
        $I->wait(2); // wait for ajax and mark registered
        $I->see("Mark correctly recorded.");
        $I->seeInDatabase('MARK', [
            "StudentSSN" => "MNDGPP04E14L219U",
            "SubjectID" => 4,
            "Date" => $dateInDatabase,
            "Class" => "1A",
            "Score" => 6.75
        ]);
    }

    public function testInsertDuplicateMark(AcceptanceTester $I){
        $I->amOnPage('/login.php');
        $I->fillField('username', 't.fanelli@esrmsystem.com');
        $I->fillField('password', 'Teresa72');
        $I->click('Sign in');
        // end login
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record a student\'s mark');
        $I->wait(1);
        $I->click('Record a student\'s mark');
        // marks page
        $I->wait(1); // wait for ajax
        $I->selectOption("div select[name='class_sID_ssn']", '1A Mathematics');
        $I->wait(1); // wait for ajax
        $I->selectOption("div select[name='student']", 'Giuseppe Mandini');
        $day = date('l');
        $date = date('d/m/Y');
        $dateInDatabase = date('Y-m-d');
        if ($day === "Saturday" || $day === "Sunday"){
            $date = date('d/m/Y', time()-2*24*60*60);
            $dateInDatabase = date('Y-m-d', time()-2*24*60*60);
        }
        $I->pressKey("form input[name='date']", WebDriverKeys::ESCAPE);
        $I->wait(2); // see if the datepicker diappears
        $I->fillField('date', $date);
        $I->selectOption("div select[name='hour']", "3");
        $I->selectOption("div select[name='score']", "6");
        $I->click('+');
        $I->click('+');
        $I->click('+');
        $I->wait(1); // wait for partial increment
        $I->see('0.75');
        $I->click('Confirm');
        $I->wait(2); // wait for ajax and mark registered
        $I->see("Mark correctly recorded.");
        $I->seeInDatabase('MARK', [
            "StudentSSN" => "MNDGPP04E14L219U",
            "SubjectID" => 4,
            "Date" => $dateInDatabase,
            "Class" => "1A",
            "Score" => 6.75
        ]);
        // end first score
        $I->wait(2); // wait for ajax
        $I->seeInCurrentUrl('/mark_recording.php');
        $I->selectOption("div select[name='class_sID_ssn']", '1A Mathematics');
        $I->wait(1); // wait for ajax
        $I->selectOption("div select[name='student']", 'Giuseppe Mandini');
        $I->pressKey("form input[name='date']", WebDriverKeys::ESCAPE);
        $I->wait(2); // see if the datepicker diappears
        $I->fillField('date', $date);
        $I->selectOption("div select[name='hour']", "4");
        $I->selectOption("div select[name='score']", "7");
        $I->click('+');
        $I->click('+');
        $I->wait(1); // wait for partial increment
        $I->see('0.5');
        $I->click('Confirm');
        $I->wait(2); // wait for ajax and mark registered
        $I->see("Mark recording failed.");
        $I->dontSeeInDatabase('MARK', [
            "StudentSSN" => "MNDGPP04E14L219U",
            "SubjectID" => 4,
            "Date" => $dateInDatabase,
            "Class" => "1A",
            "Score" => 7.5
        ]);
    }

    public function testMissingDate(AcceptanceTester $I){
        $I->amOnPage('/login.php');
        $I->fillField('username', 't.fanelli@esrmsystem.com');
        $I->fillField('password', 'Teresa72');
        $I->click('Sign in');
        // end login
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record a student\'s mark');
        $I->wait(1);
        $I->click('Record a student\'s mark');
        // marks page
        $I->wait(1); // wait for ajax
        $I->selectOption("div select[name='class_sID_ssn']", '1A Mathematics');
        $I->wait(1); // wait for ajax
        $I->selectOption("div select[name='student']", 'Giuseppe Mandini');
        $I->selectOption("div select[name='hour']", "2");
        $I->selectOption("div select[name='score']", "5");
        $I->click('+');
        $I->wait(1); // wait for partial increment
        $I->see('0.25');
        $I->click('Confirm');
        $I->wait(2); // wait for ajax and mark registered
        $I->see("Mark recording failed.");
    }

    public function testMissingSubject(AcceptanceTester $I){
        $I->amOnPage('/login.php');
        $I->fillField('username', 't.fanelli@esrmsystem.com');
        $I->fillField('password', 'Teresa72');
        $I->click('Sign in');
        // end login
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record a student\'s mark');
        $I->wait(1);
        $I->click('Record a student\'s mark');
        // marks page
        $I->wait(1); // wait for ajax
        $day = date('l');
        $date = date('d/m/Y');
        if ($day === "Saturday" || $day === "Sunday"){
            $date = date('d/m/Y', time()-2*24*60*60);
        }
        $I->pressKey("form input[name='date']", WebDriverKeys::ESCAPE);
        $I->wait(2); // see if the datepicker diappears
        $I->fillField('date', $date);
        $I->selectOption("div select[name='hour']", "6");
        $I->selectOption("div select[name='score']", "8");
        $I->click('Confirm');
        $I->wait(2); // wait for ajax and mark registered
        $I->see("Mark recording failed.");
    }
}

?>