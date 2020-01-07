<?php
require_once('public/utility.php');

class Story11Cest{
    const CLASS_SELECTION = "#classSelection";
    const CLASS_SUBJECT = "1A Physics";
    const TITLE_AREA = "#topicTitleTextArea";
    const ASSIGNMENT_AREA = "#lectureTextArea";
    const DATE_SELECTION = "#dataSelection";
    const DATE_FORMAT = "Y-m-d";
    const CONFIRM_ID = "#confirm";
    const CONFIRM_BUTTON = "Confirm";
    const ASSIGNMENT_TABLE = "ASSIGNMENT";
    const CLASS_WORD = "Class";
    const SUBJECT_ID = "SubjectID";
    const ASSIGNMENT_DATE = "DateOfAssignment";
    const DEADLINE_DATE = "DeadlineDate";
    const TITLE = "Title";
    const DESCRIPTION = "Description";
    const ATTACHMENT = "Attachment";
    const ATTACHMENT_ID = "#attachment";
    const UPLOAD_DIR = 'uploads/';

    public function _before(\AcceptanceTester $I){
        $I->maximizeWindow();
        $I->login('t.fanelli@esrmsystem.com', 'Teresa72');
        $I->waitForElementClickable('#recordAssignment', 10);
        $I->click('Record assignment');
        $I->seeInCurrentUrl('/assignment_recording.php');
    }

    public function _after(\AcceptanceTester $I){
        $I->click('Logout');
    }

    public function testInsertAssignmentWithNoAttachment(\AcceptanceTester $I){
        $I->waitForElementVisible(self::CLASS_SELECTION, 10);
        $I->selectOption(self::CLASS_SELECTION, self::CLASS_SUBJECT);
        $I->waitForElementClickable(self::TITLE_AREA, 10);
        $I->fillField(self::TITLE_AREA, 'Test Assignment 1');
        $I->waitForElementClickable(self::ASSIGNMENT_AREA, 10);
        $I->fillField(self::ASSIGNMENT_AREA, 'Body of test assignment: description 1');
        $I->waitForElementClickable(self::DATE_SELECTION, 10);
        $I->pressKey(self::DATE_SELECTION, WebDriverKeys::ESCAPE);
        $I->fillField(self::DATE_SELECTION, date(self::DATE_FORMAT, time()+7*24*60*60));
        $I->waitForElementClickable(self::CONFIRM_ID);
        $I->click(self::CONFIRM_BUTTON);
        $I->seeInDatabase(self::ASSIGNMENT_TABLE, [
            self::CLASS_WORD => '1A',
            self::SUBJECT_ID => 5,
            self::ASSIGNMENT_DATE => date(self::DATE_FORMAT),
            self::DEADLINE_DATE => date(self::DATE_FORMAT, time()+7*24*60*60),
            self::TITLE => 'Test Assignment 1',
            self::DESCRIPTION => 'Body of test assignment: description 1'
        ]);
        $I->see(ASSIGNMENT_RECORDING_OK);
    }

    public function testInsertAssignmentWithOneAttachment(\AcceptanceTester $I){
        $I->waitForElementVisible(self::CLASS_SELECTION, 10);
        $I->selectOption(self::CLASS_SELECTION, self::CLASS_SUBJECT);
        $I->waitForElementClickable(self::TITLE_AREA, 10);
        $I->fillField(self::TITLE_AREA, 'Test Assignment 2');
        $I->waitForElementClickable(self::ASSIGNMENT_AREA, 10);
        $I->fillField(self::ASSIGNMENT_AREA, 'Body of test assignment: description 2');
        $I->waitForElementClickable(self::DATE_SELECTION, 10);
        $I->pressKey(self::DATE_SELECTION, WebDriverKeys::ESCAPE);
        $I->fillField(self::DATE_SELECTION, date(self::DATE_FORMAT, time()+14*24*60*60));
        $codecept_dir = codecept_data_dir();
        $attachName = "first_test.txt";
        $tmpFileName = $codecept_dir . $attachName;
        $tmpFile = fopen($tmpFileName, "w");
        fwrite($tmpFile, "A blanc line\n");
        fseek($tmpFile, 0);
        fclose($tmpFile);
        $I->attachFile(self::ATTACHMENT_ID, $attachName);
        $I->waitForElementClickable(self::CONFIRM_ID);
        $I->click(self::CONFIRM_BUTTON);
        $I->seeInDatabase(self::ASSIGNMENT_TABLE, [
            self::CLASS_WORD => '1A',
            self::SUBJECT_ID => 5,
            self::ASSIGNMENT_DATE => date(self::DATE_FORMAT),
            self::DEADLINE_DATE => date(self::DATE_FORMAT, time()+14*24*60*60),
            self::TITLE => 'Test Assignment 2',
            self::DESCRIPTION => 'Body of test assignment: description 2',
            self::ATTACHMENT => self::UPLOAD_DIR.$attachName
        ]);
        $I->see(ASSIGNMENT_RECORDING_OK);
        unlink($tmpFileName);
    }

    public function testInsertAssignmentWithoutTitle(\AcceptanceTester $I){
        $I->waitForElementVisible(self::CLASS_SELECTION, 10);
        $I->selectOption(self::CLASS_SELECTION, self::CLASS_SUBJECT);
        $I->waitForElementClickable(self::ASSIGNMENT_AREA, 10);
        $I->fillField(self::ASSIGNMENT_AREA, 'Body of test assignment: description 3');
        $I->waitForElementClickable(self::DATE_SELECTION, 10);
        $I->pressKey(self::DATE_SELECTION, WebDriverKeys::ESCAPE);
        $I->fillField(self::DATE_SELECTION, date(self::DATE_FORMAT, time()+7*24*60*60));
        $codecept_dir = codecept_data_dir();
        $attachName = "notitle_test.txt";
        $tmpFileName = $codecept_dir . $attachName;
        $tmpFile = fopen($tmpFileName, "w");
        fwrite($tmpFile, "There is no title!\n");
        fseek($tmpFile, 0);
        fclose($tmpFile);
        $I->attachFile(self::ATTACHMENT_ID, $attachName);
        $I->waitForElementClickable(self::CONFIRM_ID);
        $I->click(self::CONFIRM_BUTTON);
        $I->dontSeeInDatabase(self::ASSIGNMENT_TABLE, [
            self::CLASS_WORD => '1A',
            self::SUBJECT_ID => 5,
            self::ASSIGNMENT_DATE => date(self::DATE_FORMAT),
            self::DEADLINE_DATE => date(self::DATE_FORMAT, time()+7*24*60*60),
            self::DESCRIPTION => 'Body of test assignment: description 3',
            self::ATTACHMENT => self::UPLOAD_DIR.$attachName
        ]);
        $I->see(ASSIGNMENT_RECORDING_INCORRECT);
        unlink($tmpFileName);
    }

    public function testInsertAssignmentWithoutDescription(\AcceptanceTester $I){
        $I->waitForElementVisible(self::CLASS_SELECTION, 10);
        $I->selectOption(self::CLASS_SELECTION, self::CLASS_SUBJECT);
        $I->waitForElementClickable(self::TITLE_AREA, 10);
        $I->fillField(self::TITLE_AREA, 'Test Assignment 4');
        $I->waitForElementClickable(self::DATE_SELECTION, 10);
        $I->pressKey(self::DATE_SELECTION, WebDriverKeys::ESCAPE);
        $I->fillField(self::DATE_SELECTION, date(self::DATE_FORMAT, time()+14*24*60*60));
        $codecept_dir = codecept_data_dir();
        $attachName = "nodescription_test.txt";
        $tmpFileName = $codecept_dir . $attachName;
        $tmpFile = fopen($tmpFileName, "w");
        fwrite($tmpFile, "Here the homework explanation is missing.\n");
        fseek($tmpFile, 0);
        fclose($tmpFile);
        $I->attachFile(self::ATTACHMENT_ID, $attachName);
        $I->waitForElementClickable(self::CONFIRM_ID);
        $I->click(self::CONFIRM_BUTTON);
        $I->dontSeeInDatabase(self::ASSIGNMENT_TABLE, [
            self::CLASS_WORD => '1A',
            self::SUBJECT_ID => 5,
            self::ASSIGNMENT_DATE => date(self::DATE_FORMAT),
            self::DEADLINE_DATE => date(self::DATE_FORMAT, time()+14*24*60*60),
            self::TITLE => 'Test Assignment 4',
            self::ATTACHMENT => self::UPLOAD_DIR.$attachName
        ]);
        $I->see(ASSIGNMENT_RECORDING_INCORRECT);
        unlink($tmpFileName);
    }

    public function testInsertAssignmentWithPastDate(\AcceptanceTester $I){
        $I->waitForElementVisible(self::CLASS_SELECTION, 10);
        $I->selectOption(self::CLASS_SELECTION, self::CLASS_SUBJECT);
        $I->waitForElementClickable(self::TITLE_AREA, 10);
        $I->fillField(self::TITLE_AREA, 'Test Assignment 5');
        $I->waitForElementClickable(self::ASSIGNMENT_AREA, 10);
        $I->fillField(self::ASSIGNMENT_AREA, 'Body of test assignment: description 5');
        $I->waitForElementClickable(self::DATE_SELECTION, 10);
        $I->pressKey(self::DATE_SELECTION, WebDriverKeys::ESCAPE);
        $I->fillField(self::DATE_SELECTION, date(self::DATE_FORMAT, time()-7*24*60*60));
        $codecept_dir = codecept_data_dir();
        $attachName = "wrongdate_test.txt";
        $tmpFileName = $codecept_dir . $attachName;
        $tmpFile = fopen($tmpFileName, "w");
        fwrite($tmpFile, "We cannot go back to the past.\n");
        fseek($tmpFile, 0);
        fclose($tmpFile);
        $I->attachFile(self::ATTACHMENT_ID, $attachName);
        $I->waitForElementClickable(self::CONFIRM_ID);
        $I->click(self::CONFIRM_BUTTON);
        $I->dontSeeInDatabase(self::ASSIGNMENT_TABLE, [
            self::CLASS_WORD => '1A',
            self::SUBJECT_ID => 5,
            self::ASSIGNMENT_DATE => date(self::DATE_FORMAT),
            self::DEADLINE_DATE => date(self::DATE_FORMAT, time()-7*24*60*60),
            self::TITLE => 'Test Assignment 5',
            self::DESCRIPTION => 'Body of test assignment: description 5',
            self::ATTACHMENT => self::UPLOAD_DIR.$attachName
        ]);
        $I->see(ASSIGNMENT_RECORDING_FAILED);
        unlink($tmpFileName);
    }
}

?>