<?php
require_once('public/utility.php');

class Story20Cest{
    const STUDENT_SSN = "MNDLRT04E14L219I";
    const ATTACHMENT_ID = "#fileinput";
    const MARK_TABLE = "FINAL_MARK";
    const SSN = "Student";
    const SUBJECT = "Subject";
    const MARK_SCORE = "Mark";
    const WAIT_FOR_AJAX = "return $.active == 0;";

    public function _before(\AcceptanceTester $I){
        $I->maximizeWindow();
        $I->login('g.barbero@esrmsystem.com', 'Giuseppe57');
        $I->waitForElementClickable('#recordFinalMarks', 10);
        $I->click('Publish final marks');
        $I->seeInCurrentUrl('/final_mark_recording.php');
    }

    public function _after(\AcceptanceTester $I){
        $I->click('Logout');
    }

    public function testSingleFinalMarkCorrect(\AcceptanceTester $I){
        $I->waitForElementClickable('#classSelection', 10);
        $I->selectOption('#classSelection', '1A Mathematics');
        $I->waitForJS("return $.active == 0;", 10);
        $I->waitForElementClickable('#studentSelection', 10);
        $I->selectOption('#studentSelection', 'Alberto Mandini');
        $I->waitForElementClickable('#scoreSelection', 10);
        $I->selectOption('#scoreSelection', 7);
        $I->click('Confirm');
        $I->seeInDatabase('FINAL_MARK', [
            "Student" => self::STUDENT_SSN,
            "Subject" => 4,
            "Mark" => 7
        ]);
        $I->see(MARK_RECORDING_OK);
    }

    public function testSingleFinalMarkEmptySubject(\AcceptanceTester $I){
        $I->waitForElementClickable('#classSelection', 10);
        $I->selectOption('#classSelection', '');
        $I->waitForElementClickable('#scoreSelection', 10);
        $I->selectOption('#scoreSelection', 8);
        $I->click('Confirm');
        $I->dontSeeInDatabase('FINAL_MARK', [
            "Student" => "",
            "Subject" => "",
            "Mark" => 8
        ]);
        $I->see(MARK_RECORDING_FAILED);
    }

    protected function submitCSVFileWithParams($studentSSN='', $subjectId=0, $score=0){
        $codecept_dir = codecept_data_dir();
        $attachment_name = "test_mark.csv";
        $tmp_file_name = $codecept_dir . $attachment_name;
        $tmp_file = fopen($tmp_file_name, "w");
        if(is_string($studentSSN) && $studentSSN !== ''){
            fwrite($tmp_file, $studentSSN);
        }
        fwrite($tmp_file, ",");
        if(is_int($subjectId) && $subjectId !== 0){
            fwrite($tmp_file, $subjectId);
        }
        fwrite($tmp_file, ",");
        if(is_int($score) && $score !== 0){
            fwrite($tmp_file, $score);
        }
        fclose($tmp_file);
        return array("form_name" => $attachment_name, "link_name" => $tmp_file_name);
    }

    public function testCsvCorrectParams(\AcceptanceTester $I){
        $file_fields = $this->submitCSVFileWithParams(self::STUDENT_SSN, 1, 7);
        $I->attachFile(self::ATTACHMENT_ID, $file_fields['form_name']);
        $I->wait(1);
        $I->cancelPopup();
        $I->seeInDatabase(self::MARK_TABLE, [
            self::SSN => self::STUDENT_SSN,
            self::SUBJECT => 1,
            self::MARK_SCORE => 7
        ]);
        unlink($file_fields['link_name']);
    }

    public function testCsvEmptyStudent(\AcceptanceTester $I){
        $file_fields = $this->submitCSVFileWithParams('', 1, 7);
        $I->attachFile(self::ATTACHMENT_ID, $file_fields['form_name']);
        $I->wait(1);
        // s$I->cancelPopup();
        $I->dontSeeInDatabase(self::MARK_TABLE, [
            self::SSN => '',
            self::SUBJECT => 1,
            self::MARK_SCORE => 7
        ]);
        unlink($file_fields['link_name']);
    }

    public function testCsvNoSubject(\AcceptanceTester $I){
        $file_fields = $this->submitCSVFileWithParams(self::STUDENT_SSN, 0, 9);
        $I->attachFile(self::ATTACHMENT_ID, $file_fields['form_name']);
        $I->wait(1);
        $I->cancelPopup();
        $I->dontSeeInDatabase(self::MARK_TABLE, [
            self::SSN => self::STUDENT_SSN,
            self::SUBJECT => 0,
            self::MARK_SCORE => 9
        ]);
        unlink($file_fields['link_name']);
    }

    public function testCsvNoScore(\AcceptanceTester $I){
        $file_fields = $this->submitCSVFileWithParams(self::STUDENT_SSN, 4);
        $I->attachFile(self::ATTACHMENT_ID, $file_fields['form_name']);
        $I->wait(1);
        $I->cancelPopup();
        $I->dontSeeInDatabase(self::MARK_TABLE, [
            self::SSN => self::STUDENT_SSN,
            self::SUBJECT => 4,
            self::MARK_SCORE => 0
        ]);
        unlink($file_fields['link_name']);
    }

    public function testCsvNotExistingChild(\AcceptanceTester $I){
        $file_fields = $this->submitCSVFileWithParams("PRLMRZ51B24L219R", 3, 8);
        $I->attachFile(self::ATTACHMENT_ID, $file_fields['form_name']);
        $I->wait(1);
        $I->cancelPopup();
        $I->dontSeeInDatabase(self::MARK_TABLE, [
            self::SSN => "PRLMRZ51B24L219R",
            self::SUBJECT => 3,
            self::MARK_SCORE => 8
        ]);
        unlink($file_fields['link_name']);
    }
}

?>