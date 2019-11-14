<?php 

class Story2Cest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function testInsertTopicSuccess(AcceptanceTester $I)
    {
        $I->wait(1);
        // login as teacher
        $I->amOnPage('/login.php');
        $I->fillField('username', 'aaa@bbb.com');
        $I->fillField('password', 'a1a1a1a1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record lecture\'s topics');
        $I->waitForElementClickable('#markRecording', 10);
        $I->click('Record lecture\'s topics');
        
        // insert new topic
        // $I->waitForElement('#lessonRecordingTitle', 10);
        $I->selectOption("form select[name='class_sID_ssn']", "1A Geography");  
        $I->fillField('date', date('d/m/Y'));         
        $I->selectOption("form select[name='hour']", 3); 
        $I->fillField('title', 'Mock topic');
        $I->fillField('subtitle', 'Mock description');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('Confirm');

        // check if database updated
        $I->seeInDatabase('TOPIC', [
            'Class' => '1A',
            'Date' => date('Y/m/d'),
            'StartHour' => 3,
            'SubjectID' => 1,
            'TeacherSSN' => 'aaa111',
            'Title' => 'Mock topic',
            'Description' => 'Mock description'
        ]);
    }

    public function testInsertTopicWithoutAllInformation(AcceptanceTester $I)
    {
        $I->wait(1);
        // login as teacher
        $I->amOnPage('/login.php');
        $I->fillField('username', 'aaa@bbb.com');
        $I->fillField('password', 'a1a1a1a1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record lecture\'s topics');
        $I->waitForElementClickable('#markRecording', 10);
        $I->click('Record lecture\'s topics');

        // insert new topic leaving empty fields
        // $I->waitForElement('#lessonRecordingTitle', 10);
        $I->fillField('title', 'Mock topic');
        $I->fillField('subtitle', 'Mock description');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('Confirm');

        // error shoud be displayed
        $I->see('Please fill all the fields.');

        // database shoud not be updated
        $I->dontSeeInDatabase('TOPIC', [
            'Title' => 'Mock topic',
            'Description' => 'Mock description'
        ]);        
    }

    public function testInsertTopicWrongDate(AcceptanceTester $I)
    {
        $I->wait(1);
        // login as teacher
        $I->amOnPage('/login.php');
        $I->fillField('username', 'aaa@bbb.com');
        $I->fillField('password', 'a1a1a1a1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record lecture\'s topics');
        $I->waitForElementClickable('#markRecording', 10);
        $I->click('Record lecture\'s topics');

        // insert new topic with wrong data (too)
        // $I->waitForElement('#lessonRecordingTitle', 10);
        $I->selectOption("form select[name='class_sID_ssn']", "1A Geography");  
        $I->fillField('date', '05/05/1992');         
        $I->selectOption("form select[name='hour']", 3); 
        $I->fillField('title', 'Mock topic');
        $I->fillField('subtitle', 'Mock description');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('Confirm');

        // error shoud be displayed
        $I->see('Please fill all the fields.');
    }
}