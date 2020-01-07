<?php
require_once('public/utility.php');

class Story18Cest{
    const CLASS_SELECTION = "#classSelection";
    const SUBJECT_SELECTED = "1A Physics";
    const WAIT_FOR_AJAX = "return $.active == 0;";
    const STUDENT_SELECTION = "#studentSelection";
    const STUDENT_SELECTED = "Giuseppe Mandini";
    const DATE_SELECTION = "#dataSelection";
    const FIRST_DATE_FORMAT = "d/m/Y";
    const SECOND_DATE_FORMAT = "Y-m-d";
    const SATURDAY = "Saturday";
    const SUNDAY = "Sunday";
    const NOTE_SELECTION = "#noteTextArea";
    const NOTE_EXAMPLE = "Brief note description for Mandini related to Physics subject";
    const CONFIRM = "Confirm";
    const STUDENT_FIELD = "StudentSSN";
    const STUDENT_SSN = 'MNDGPP04E14L219U';
    const SUBJECT_ID = 'SubjectID';

    public function _before(\AcceptanceTester $I){
        $I->maximizeWindow();
        $I->login('t.fanelli@esrmsystem.com', 'Teresa72');
        $I->waitForElementClickable('#recordNote', 10);
        $I->click('Record note');
        $I->seeInCurrentUrl('/note_recording.php');
    }

    public function _after(\AcceptanceTester $I){
        $I->click('Logout');
    }

    public function testNoteRecordingCorrectParams(\AcceptanceTester $I){
        $I->waitForElementClickable(self::CLASS_SELECTION, 10);
        $I->selectOption(self::CLASS_SELECTION, self::SUBJECT_SELECTED);
        $I->waitForJS(self::WAIT_FOR_AJAX, 10);
        $I->waitForElementClickable(self::STUDENT_SELECTION);
        $I->selectOption(self::STUDENT_SELECTION, self::STUDENT_SELECTED);
        $I->waitForElementClickable(self::DATE_SELECTION, 10);
        $today = date(self::FIRST_DATE_FORMAT);
        $today_db = date(self::SECOND_DATE_FORMAT);
        if(date('l') === self::SATURDAY || date('l') === self::SUNDAY){
            $today = date(self::FIRST_DATE_FORMAT, time()-2*24*60*60);
            $today_db = date(self::SECOND_DATE_FORMAT, time()-2*24*60*60);
        }
        $I->pressKey(self::DATE_SELECTION, WebDriverKeys::ESCAPE);
        $I->fillField(self::DATE_SELECTION, $today);
        $I->waitForElementClickable(self::NOTE_SELECTION, 10);
        $I->fillField(self::NOTE_SELECTION, self::NOTE_EXAMPLE);
        $I->click(self::CONFIRM);
        $I->seeInDatabase('NOTE', [
            self::STUDENT_FIELD => self::STUDENT_SSN,
            self::SUBJECT_ID => 5,
            "Date" => $today_db
        ]);
        $I->see(NOTE_RECORDING_OK);
    }

    public function testNoteRecordingWithoutSubject(\AcceptanceTester $I){
        $I->waitForElementClickable(self::CLASS_SELECTION, 10);
        $I->selectOption(self::CLASS_SELECTION, '');
        $I->waitForJS(self::WAIT_FOR_AJAX, 10);
        $I->waitForElementClickable(self::DATE_SELECTION, 10);
        $today = date(self::FIRST_DATE_FORMAT);
        $today_db = date(self::SECOND_DATE_FORMAT);
        if(date('l') === self::SATURDAY || date('l') === self::SUNDAY){
            $today = date(self::FIRST_DATE_FORMAT, time()-2*24*60*60);
            $today_db = date(self::SECOND_DATE_FORMAT, time()-2*24*60*60);
        }
        $I->pressKey(self::DATE_SELECTION, WebDriverKeys::ESCAPE);
        $I->fillField(self::DATE_SELECTION, $today);
        $I->waitForElementClickable(self::NOTE_SELECTION, 10);
        $I->fillField(self::NOTE_SELECTION, 'Brief note description for Mandini related to which subject?');
        $I->click(self::CONFIRM);
        $I->dontSeeInDatabase('NOTE', [
            self::STUDENT_FIELD => self::STUDENT_SSN,
            self::SUBJECT_ID => 5,
            "Date" => $today_db
        ]);
        $I->see(NOTE_RECORDING_FAILED);
    }

    public function testNoteRecordingWithoutDate(\AcceptanceTester $I){
        $I->waitForElementClickable(self::CLASS_SELECTION, 10);
        $I->selectOption(self::CLASS_SELECTION, self::SUBJECT_SELECTED);
        $I->waitForJS(self::WAIT_FOR_AJAX, 10);
        $I->waitForElementClickable(self::STUDENT_SELECTION);
        $I->selectOption(self::STUDENT_SELECTION, self::STUDENT_SELECTED);
        $today_db = date(self::SECOND_DATE_FORMAT);
        if(date('l') === self::SATURDAY || date('l') === self::SUNDAY){
            $today_db = date(self::SECOND_DATE_FORMAT, time()-2*24*60*60);
        }
        $I->waitForElementClickable(self::NOTE_SELECTION, 10);
        $I->fillField(self::NOTE_SELECTION, self::NOTE_EXAMPLE);
        $I->click(self::CONFIRM);
        $I->dontSeeInDatabase('NOTE', [
            self::STUDENT_FIELD => self::STUDENT_SSN,
            self::SUBJECT_ID => 5,
            "Date" => $today_db
        ]);
        $I->see(NOTE_RECORDING_FAILED);
    }

    public function testNoteRecordingWithWrongDateFormat(\AcceptanceTester $I){
        $I->waitForElementClickable(self::CLASS_SELECTION, 10);
        $I->selectOption(self::CLASS_SELECTION, self::SUBJECT_SELECTED);
        $I->waitForJS(self::WAIT_FOR_AJAX, 10);
        $I->waitForElementClickable(self::STUDENT_SELECTION);
        $I->selectOption(self::STUDENT_SELECTION, self::STUDENT_SELECTED);
        $I->waitForElementClickable(self::DATE_SELECTION, 10);
        $today = date('d-m-Y');
        $today_db = date(self::SECOND_DATE_FORMAT);
        if(date('l') === self::SATURDAY || date('l') === self::SUNDAY){
            $today = date('d-m-Y', time()-2*24*60*60);
            $today_db = date(self::SECOND_DATE_FORMAT, time()-2*24*60*60);
        }
        $I->pressKey(self::DATE_SELECTION, WebDriverKeys::ESCAPE);
        $I->fillField(self::DATE_SELECTION, $today);
        $I->waitForElementClickable(self::NOTE_SELECTION, 10);
        $I->fillField(self::NOTE_SELECTION, self::NOTE_EXAMPLE);
        $I->click(self::CONFIRM);
        $I->dontSeeInDatabase('NOTE', [
            self::STUDENT_FIELD => self::STUDENT_SSN,
            self::SUBJECT_ID => 5,
            "Date" => $today_db
        ]);
        $I->see(NOTE_RECORDING_FAILED);
    }

    public function testNoteRecordingWithEmptyDescription(\AcceptanceTester $I){
        $I->waitForElementClickable(self::CLASS_SELECTION, 10);
        $I->selectOption(self::CLASS_SELECTION, self::SUBJECT_SELECTED);
        $I->waitForJS(self::WAIT_FOR_AJAX, 10);
        $I->waitForElementClickable(self::STUDENT_SELECTION);
        $I->selectOption(self::STUDENT_SELECTION, self::STUDENT_SELECTED);
        $I->waitForElementClickable(self::DATE_SELECTION, 10);
        $today = date(self::FIRST_DATE_FORMAT);
        $today_db = date(self::SECOND_DATE_FORMAT);
        if(date('l') === self::SATURDAY || date('l') === self::SUNDAY){
            $today = date(self::FIRST_DATE_FORMAT, time()-2*24*60*60);
            $today_db = date(self::SECOND_DATE_FORMAT, time()-2*24*60*60);
        }
        $I->pressKey(self::DATE_SELECTION, WebDriverKeys::ESCAPE);
        $I->fillField(self::DATE_SELECTION, $today);
        $I->waitForElementClickable(self::NOTE_SELECTION, 10);
        $I->fillField(self::NOTE_SELECTION, '');
        $I->click(self::CONFIRM);
        $I->dontSeeInDatabase('NOTE', [
            self::STUDENT_FIELD => self::STUDENT_SSN,
            self::SUBJECT_ID => 5,
            "Date" => $today_db
        ]);
        $I->see(NOTE_RECORDING_FAILED);
    }
}

?>