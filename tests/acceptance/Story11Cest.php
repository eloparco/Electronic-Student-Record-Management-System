<?php
require_once('public/utility.php');

class Story11Cest{
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
        $I->waitForElementVisible('#classSelection', 10);
        $I->selectOption('#classSelection', '1A Physics');
        $I->waitForElementClickable('#topicTitleTextArea', 10);
        $I->fillField('#topicTitleTextArea', 'Test Assignment 1');
        $I->waitForElementClickable('#lectureTextArea', 10);
        $I->fillField('#lectureTextArea', 'Body of test assignment: description 1');
        $I->waitForElementClickable('#dataSelection', 10);
        $I->pressKey('#dataSelection', WebDriverKeys::ESCAPE);
        $I->fillField('#dataSelection', date('Y-m-d', time()+7*24*60*60));
        $I->waitForElementClickable('#confirm');
        $I->click('Confirm');
        $I->seeInDatabase('ASSIGNMENT', [
            'Class' => '1A',
            'SubjectID' => 5,
            'DateOfAssignment' => date('Y-m-d'),
            'DeadlineDate' => date('Y-m-d', time()+7*24*60*60),
            'Title' => 'Test Assignment 1',
            'Description' => 'Body of test assignment: description 1'
        ]);
        $I->see(ASSIGNMENT_RECORDING_OK);
    }

    public function testInsertAssignmentWithOneAttachment(\AcceptanceTester $I){
        $I->waitForElementVisible('#classSelection', 10);
        $I->selectOption('#classSelection', '1A Physics');
        $I->waitForElementClickable('#topicTitleTextArea', 10);
        $I->fillField('#topicTitleTextArea', 'Test Assignment 2');
        $I->waitForElementClickable('#lectureTextArea', 10);
        $I->fillField('#lectureTextArea', 'Body of test assignment: description 2');
        $I->waitForElementClickable('#dataSelection', 10);
        $I->pressKey('#dataSelection', WebDriverKeys::ESCAPE);
        $I->fillField('#dataSelection', date('Y-m-d', time()+14*24*60*60));
        $codecept_dir = codecept_data_dir();
        $attachName = "first_test.txt";
        $tmpFileName = $codecept_dir . $attachName;
        $tmpFile = fopen($tmpFileName, "w");
        fwrite($tmpFile, "A blanc line\n");
        fseek($tmpFile, 0);
        fclose($tmpFile);
        $I->attachFile('#attachment', $attachName);
        $I->waitForElementClickable('#confirm');
        $I->click('Confirm');
        $I->seeInDatabase('ASSIGNMENT', [
            'Class' => '1A',
            'SubjectID' => 5,
            'DateOfAssignment' => date('Y-m-d'),
            'DeadlineDate' => date('Y-m-d', time()+14*24*60*60),
            'Title' => 'Test Assignment 2',
            'Description' => 'Body of test assignment: description 2',
            'Attachment' => "uploads/".$attachName
        ]);
        $I->see(ASSIGNMENT_RECORDING_OK);
        unlink($tmpFileName);
    }

    public function testInsertAssignmentWithoutTitle(\AcceptanceTester $I){
        $I->waitForElementVisible('#classSelection', 10);
        $I->selectOption('#classSelection', '1A Physics');
        $I->waitForElementClickable('#lectureTextArea', 10);
        $I->fillField('#lectureTextArea', 'Body of test assignment: description 3');
        $I->waitForElementClickable('#dataSelection', 10);
        $I->pressKey('#dataSelection', WebDriverKeys::ESCAPE);
        $I->fillField('#dataSelection', date('Y-m-d', time()+7*24*60*60));
        $codecept_dir = codecept_data_dir();
        $attachName = "notitle_test.txt";
        $tmpFileName = $codecept_dir . $attachName;
        $tmpFile = fopen($tmpFileName, "w");
        fwrite($tmpFile, "There is no title!\n");
        fseek($tmpFile, 0);
        fclose($tmpFile);
        $I->attachFile('#attachment', $attachName);
        $I->waitForElementClickable('#confirm');
        $I->click('Confirm');
        $I->dontSeeInDatabase('ASSIGNMENT', [
            'Class' => '1A',
            'SubjectID' => 5,
            'DateOfAssignment' => date('Y-m-d'),
            'DeadlineDate' => date('Y-m-d', time()+7*24*60*60),
            'Description' => 'Body of test assignment: description 3',
            'Attachment' => "uploads/".$attachName
        ]);
        $I->see(ASSIGNMENT_RECORDING_INCORRECT);
        unlink($tmpFileName);
    }

    public function testInsertAssignmentWithoutDescription(\AcceptanceTester $I){
        $I->waitForElementVisible('#classSelection', 10);
        $I->selectOption('#classSelection', '1A Physics');
        $I->waitForElementClickable('#topicTitleTextArea', 10);
        $I->fillField('#topicTitleTextArea', 'Test Assignment 4');
        $I->waitForElementClickable('#dataSelection', 10);
        $I->pressKey('#dataSelection', WebDriverKeys::ESCAPE);
        $I->fillField('#dataSelection', date('Y-m-d', time()+14*24*60*60));
        $codecept_dir = codecept_data_dir();
        $attachName = "nodescription_test.txt";
        $tmpFileName = $codecept_dir . $attachName;
        $tmpFile = fopen($tmpFileName, "w");
        fwrite($tmpFile, "Here the homework explanation is missing.\n");
        fseek($tmpFile, 0);
        fclose($tmpFile);
        $I->attachFile('#attachment', $attachName);
        $I->waitForElementClickable('#confirm');
        $I->click('Confirm');
        $I->dontSeeInDatabase('ASSIGNMENT', [
            'Class' => '1A',
            'SubjectID' => 5,
            'DateOfAssignment' => date('Y-m-d'),
            'DeadlineDate' => date('Y-m-d', time()+14*24*60*60),
            'Title' => 'Test Assignment 4',
            'Attachment' => "uploads/".$attachName
        ]);
        $I->see(ASSIGNMENT_RECORDING_INCORRECT);
        unlink($tmpFileName);
    }

    public function testInsertAssignmentWithPastDate(\AcceptanceTester $I){
        $I->waitForElementVisible('#classSelection', 10);
        $I->selectOption('#classSelection', '1A Physics');
        $I->waitForElementClickable('#topicTitleTextArea', 10);
        $I->fillField('#topicTitleTextArea', 'Test Assignment 5');
        $I->waitForElementClickable('#lectureTextArea', 10);
        $I->fillField('#lectureTextArea', 'Body of test assignment: description 5');
        $I->waitForElementClickable('#dataSelection', 10);
        $I->pressKey('#dataSelection', WebDriverKeys::ESCAPE);
        $I->fillField('#dataSelection', date('Y-m-d', time()-7*24*60*60));
        $codecept_dir = codecept_data_dir();
        $attachName = "wrongdate_test.txt";
        $tmpFileName = $codecept_dir . $attachName;
        $tmpFile = fopen($tmpFileName, "w");
        fwrite($tmpFile, "We cannot go back to the past.\n");
        fseek($tmpFile, 0);
        fclose($tmpFile);
        $I->attachFile('#attachment', $attachName);
        $I->waitForElementClickable('#confirm');
        $I->click('Confirm');
        $I->dontSeeInDatabase('ASSIGNMENT', [
            'Class' => '1A',
            'SubjectID' => 5,
            'DateOfAssignment' => date('Y-m-d'),
            'DeadlineDate' => date('Y-m-d', time()-7*24*60*60),
            'Title' => 'Test Assignment 5',
            'Description' => 'Body of test assignment: description 5',
            'Attachment' => "uploads/".$attachName
        ]);
        $I->see(ASSIGNMENT_RECORDING_FAILED);
        unlink($tmpFileName);
    }
}

?>