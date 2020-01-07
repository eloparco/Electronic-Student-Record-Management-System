<?php

class Story6Cest{
    const MARK_PAGE = "Record a student's mark";
    const CLASS_SUBJECT_FORM = 'div select[name="class_sID_ssn"]';
    const CLASS_SUBJECT = "1A Mathematics";
    const STUDENT_FORM = 'div select[name="student"]';
    const STUDENT_SELECTED = "Giuseppe Mandini";
    const FIRST_DATE_FORMAT = "d/m/Y";
    const SECOND_DATE_FORMAT = "Y-m-d";
    const SATURDAY = 'Saturday';
    const SUNDAY = 'Sunday';
    const DATE_FORM = 'form input[name="date"]';
    const HOUR_FORM = 'div select[name="hour"]';
    const SCORE_FORM = 'div select[name="score"]';
    const CONFIRM = "Confirm";
    const STUDENT_SSN = 'StudentSSN';
    const STUDENT_EXAMPLE = 'MNDGPP04E14L219U';
    const SUBJECT_ID = 'SubjectID';
    const CLASS_WORD = 'Class';
    const SCORE = 'Score';

    public function _before(AcceptanceTester $I){
        $I->maximizeWindow();
        $I->login('t.fanelli@esrmsystem.com', 'Teresa72');
        $I->seeInCurrentUrl('/user_teacher.php');
    }

    public function _after(AcceptanceTester $I){
        // logout
        $I->click('Logout');
    }

    // tests
    public function testInsertNewMark(AcceptanceTester $I){
        $I->see(self::MARK_PAGE);
        $I->wait(1);
        $I->click(self::MARK_PAGE);
        // marks page
        $I->wait(1); // wait for ajax
        $I->selectOption(self::CLASS_SUBJECT_FORM, self::CLASS_SUBJECT);
        $I->wait(1); // wait for ajax
        $I->selectOption(self::STUDENT_FORM, self::STUDENT_SELECTED);
        $day = date('l');
        $date = date(self::FIRST_DATE_FORMAT);
        $dateInDatabase = date(self::SECOND_DATE_FORMAT);
        if ($day === self::SATURDAY || $day === self::SUNDAY){
            $date = date(self::FIRST_DATE_FORMAT, time()-2*24*60*60);
            $dateInDatabase = date(self::SECOND_DATE_FORMAT, time()-2*24*60*60);
        }
        $I->pressKey(self::DATE_FORM, WebDriverKeys::ESCAPE);
        $I->wait(2); // see if the datepicker diappears
        $I->fillField('date', $date);
        $I->selectOption(self::HOUR_FORM, "3");
        $I->selectOption(self::SCORE_FORM, "6");
        $I->click('+');
        $I->click('+');
        $I->click('+');
        $I->wait(1); // wait for partial increment
        $I->see('0.75');
        $I->click(self::CONFIRM);
        $I->wait(2); // wait for ajax and mark registered
        $I->see("Mark correctly recorded.");
        $I->seeInDatabase('MARK', [
            self::STUDENT_SSN => self::STUDENT_EXAMPLE,
            self::SUBJECT_ID => 4,
            "Date" => $dateInDatabase,
            self::CLASS_WORD => "1A",
            self::SCORE => 6.75
        ]);
    }

    public function testInsertDuplicateMark(AcceptanceTester $I){
        $I->see(self::MARK_PAGE);
        $I->wait(1);
        $I->click(self::MARK_PAGE);
        // marks page
        $I->wait(1); // wait for ajax
        $I->selectOption(self::CLASS_SUBJECT_FORM, self::CLASS_SUBJECT);
        $I->wait(1); // wait for ajax
        $I->selectOption(self::STUDENT_FORM, self::STUDENT_SELECTED);
        $day = date('l');
        $date = date(self::FIRST_DATE_FORMAT);
        $dateInDatabase = date(self::SECOND_DATE_FORMAT);
        if ($day === self::SATURDAY || $day === self::SUNDAY){
            $date = date(self::FIRST_DATE_FORMAT, time()-2*24*60*60);
            $dateInDatabase = date(self::SECOND_DATE_FORMAT, time()-2*24*60*60);
        }
        $I->pressKey(self::DATE_FORM, WebDriverKeys::ESCAPE);
        $I->wait(2); // see if the datepicker diappears
        $I->fillField('date', $date);
        $I->selectOption(self::HOUR_FORM, "3");
        $I->selectOption(self::SCORE_FORM, "6");
        $I->click('+');
        $I->click('+');
        $I->click('+');
        $I->wait(1); // wait for partial increment
        $I->see('0.75');
        $I->click(self::CONFIRM);
        $I->wait(2); // wait for ajax and mark registered
        $I->see("Mark correctly recorded.");
        $I->seeInDatabase('MARK', [
            self::STUDENT_SSN => self::STUDENT_EXAMPLE,
            self::SUBJECT_ID => 4,
            "Date" => $dateInDatabase,
            self::CLASS_WORD => "1A",
            self::SCORE => 6.75
        ]);
        // end first score
        $I->wait(2); // wait for ajax
        $I->seeInCurrentUrl('/mark_recording.php');
        $I->selectOption(self::CLASS_SUBJECT_FORM, self::CLASS_SUBJECT);
        $I->wait(1); // wait for ajax
        $I->selectOption(self::STUDENT_FORM, self::STUDENT_SELECTED);
        $I->pressKey(self::DATE_FORM, WebDriverKeys::ESCAPE);
        $I->wait(2); // see if the datepicker diappears
        $I->fillField('date', $date);
        $I->selectOption(self::HOUR_FORM, "4");
        $I->selectOption(self::SCORE_FORM, "7");
        $I->click('+');
        $I->click('+');
        $I->wait(1); // wait for partial increment
        $I->see('0.5');
        $I->click(self::CONFIRM);
        $I->wait(2); // wait for ajax and mark registered
        $I->see("Mark recording failed.");
        $I->dontSeeInDatabase('MARK', [
            self::STUDENT_SSN => self::STUDENT_EXAMPLE,
            self::SUBJECT_ID => 4,
            "Date" => $dateInDatabase,
            self::CLASS_WORD => "1A",
            self::SCORE => 7.5
        ]);
    }

    public function testMissingDate(AcceptanceTester $I){
        $I->see(self::MARK_PAGE);
        $I->wait(1);
        $I->click(self::MARK_PAGE);
        // marks page
        $I->wait(1); // wait for ajax
        $I->selectOption(self::CLASS_SUBJECT_FORM, self::CLASS_SUBJECT);
        $I->wait(1); // wait for ajax
        $I->selectOption(self::STUDENT_FORM, self::STUDENT_SELECTED);
        $I->selectOption(self::HOUR_FORM, "2");
        $I->selectOption(self::SCORE_FORM, "5");
        $I->click('+');
        $I->wait(1); // wait for partial increment
        $I->see('0.25');
        $I->click(self::CONFIRM);
        $I->wait(2); // wait for ajax and mark registered
        $I->see("Mark recording failed.");
    }

    public function testMissingSubject(AcceptanceTester $I){
        $I->see(self::MARK_PAGE);
        $I->wait(1);
        $I->click(self::MARK_PAGE);
        // marks page
        $I->wait(1); // wait for ajax
        $day = date('l');
        $date = date(self::FIRST_DATE_FORMAT);
        if ($day === self::SATURDAY || $day === self::SUNDAY){
            $date = date(self::FIRST_DATE_FORMAT, time()-2*24*60*60);
        }
        $I->pressKey(self::DATE_FORM, WebDriverKeys::ESCAPE);
        $I->wait(2); // see if the datepicker diappears
        $I->fillField('date', $date);
        $I->selectOption(self::HOUR_FORM, "6");
        $I->selectOption(self::SCORE_FORM, "8");
        $I->click(self::CONFIRM);
        $I->wait(2); // wait for ajax and mark registered
        $I->see("Mark recording failed.");
    }
}

?>