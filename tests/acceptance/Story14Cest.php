<?php 
require_once('public/utility.php');

class Story14Cest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function testFileUploadSuccess(AcceptanceTester $I)
    {
        // login as secretary officer
        $I->login('milo@milo.it', 'Milo1');
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->see('User Secretary');

        // click on the option to publish timetable in the dashboard
        $I->waitForElementClickable('#publish_timetable_dashboard', 10);
        $I->click('Publish timetable');

        // insert class name and upload file
        $I->selectOption("form select[name='classSelection']", "1A");  
        $I->attachFile('input[name="file"]', 'uploads/timetable_success.csv');

        // submit
        $I->waitForElementClickable('#submit', 10);
        $I->click('Submit');
        $I->waitForElement(['class' => 'success-back-color'], 10);
        $I->see(PUBLISH_TIMETABLE_OK);

        // check if at least the first entry is correctly inserted in db
        $I->seeInDatabase('CLASS_TIMETABLE', [
            'DayOfWeek' => 'Monday',
            'Hour' => 1,
            'Class' => '1A',
            'SubjectID' => 4
        ]);
    }

    public function testFileUploadWrongContent(AcceptanceTester $I)
    {
        // login as secretary officer
        $I->login('milo@milo.it', 'Milo1');
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->see('User Secretary');

        // click on the option to publish timetable in the dashboard
        $I->waitForElementClickable('#publish_timetable_dashboard', 10);
        $I->click('Publish timetable');

        // insert class name and upload file
        $I->selectOption("form select[name='classSelection']", "1A");  
        $I->attachFile('input[name="file"]', 'uploads/timetable_wrong_format.csv');

        // submit
        $I->waitForElementClickable('#submit', 10);
        $I->click('Submit');
        $I->waitForElement(['class' => 'error-back-color'], 10);
        $I->see(WRONG_FILE_FORMAT);
    }

    public function testFileUploadWrongFormat(AcceptanceTester $I)
    {
        // login as secretary officer
        $I->login('milo@milo.it', 'Milo1');
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->see('User Secretary');

        // click on the option to publish timetable in the dashboard
        $I->waitForElementClickable('#publish_timetable_dashboard', 10);
        $I->click('Publish timetable');

        // insert class name and upload file
        $I->selectOption("form select[name='classSelection']", "1A");  
        $I->attachFile('input[name="file"]', 'uploads/timetable.txt');

        // submit
        $I->waitForElementClickable('#submit', 10);
        $I->click('Submit');
        $I->waitForElement(['class' => 'error-back-color'], 10);
        $I->see(PUBLISH_TIMETABLE_FAILED);
    }

    public function testFileUploadNonExistingSubject(AcceptanceTester $I)
    {
        // login as secretary officer
        $I->login('milo@milo.it', 'Milo1');
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->see('User Secretary');

        // click on the option to publish timetable in the dashboard
        $I->waitForElementClickable('#publish_timetable_dashboard', 10);
        $I->click('Publish timetable');

        // insert class name and upload file
        $I->selectOption("form select[name='classSelection']", "1A");  
        $I->attachFile('input[name="file"]', 'uploads/timetable_wrong_subject.csv');

        // submit
        $I->waitForElementClickable('#submit', 10);
        $I->click('Submit');
        $I->waitForElement(['class' => 'error-back-color'], 10);
        $I->see(SUBJECT_INCORRECT);
    }
}
