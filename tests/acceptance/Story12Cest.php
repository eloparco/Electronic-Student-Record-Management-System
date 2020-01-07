<?php
require_once('public/utility.php');

class Story12Cest{
    const SECRETARY_PAGE = "/user_secretary.php";
    const COMMUNICATION_BUTTON_ID = "#publish_communication_dashboard";
    const COMMUNICATION_BUTTON = "Publish official communication";
    const TITLE_AREA = "#topicTitleTextArea";
    const COMMUNICATION_AREA = "#lectureTextArea";
    const TITLE_EXAMPLE = "First school communication to parents";
    const COMMUNICATION_EXAMPLE = "A very simple and short communication to parents to tell them nothing";
    const CONFIRM_ID = "#confirm";
    const RESULT_MESSAGE = "#msg-result";
    const COMMUNICATION_TABLE = 'COMMUNICATION';
    const TITLE = "Title";
    const DESCRIPTION = "Description";
    const DATE_FORMAT = "Y-m-d";

    public function _before(\AcceptanceTester $I){
        $I->maximizeWindow();
        $I->login('milo@milo.it', 'Milo1');
    }

    public function _after(\AcceptanceTester $I){
        $I->click('Logout'); // logout to execute new test with new credentials
    }

    // tests
    public function testInsertCorrectCommunication(\AcceptanceTester $I){
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
        // go to the correct menu
        $I->waitForElementClickable(self::COMMUNICATION_BUTTON_ID, 10);
        $I->click(self::COMMUNICATION_BUTTON);

        // fill the form fields
        $I->waitForElementClickable(self::TITLE_AREA, 10);
        $I->click(self::TITLE_AREA);
        $I->fillField(self::TITLE_AREA, self::TITLE_EXAMPLE);
        $I->waitForElementClickable(self::COMMUNICATION_AREA, 10);
        $I->click(self::COMMUNICATION_AREA);
        $I->fillField(self::COMMUNICATION_AREA, self::COMMUNICATION_EXAMPLE);
        $I->waitForElementClickable(self::CONFIRM_ID, 10);
        $I->click(self::CONFIRM_ID);
        $I->waitForElement(self::RESULT_MESSAGE, 10);
        $I->see(COMMUNICATION_RECORDING_OK);
        $I->seeInDatabase(self::COMMUNICATION_TABLE, [
            self::TITLE => self::TITLE_EXAMPLE,
            self::DESCRIPTION => self::COMMUNICATION_EXAMPLE,
            'Date' => date(self::DATE_FORMAT)
        ]);
    }

    public function testInsertCommunicationNoTitle(\AcceptanceTester $I){
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
        // go to the correct menu
        $I->waitForElementClickable(self::COMMUNICATION_BUTTON_ID, 10);
        $I->click(self::COMMUNICATION_BUTTON);

        // fill the form fields
        $I->waitForElementClickable(self::COMMUNICATION_AREA, 10);
        $I->click(self::COMMUNICATION_AREA);
        $I->fillField(self::COMMUNICATION_AREA, self::COMMUNICATION_EXAMPLE);
        $I->waitForElementClickable(self::CONFIRM_ID, 10);
        $I->click(self::CONFIRM_ID);
        $I->waitForElement(self::RESULT_MESSAGE, 10);
        $I->see("Please fill all the fields.");
        $I->dontSeeInDatabase(self::COMMUNICATION_TABLE, [
            self::TITLE => '',
            self::DESCRIPTION => self::COMMUNICATION_EXAMPLE,
            'Date' => date(self::DATE_FORMAT)
        ]);
    }

    public function testInsertCommunicationNoDescription(\AcceptanceTester $I){
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
        // go to the correct menu
        $I->waitForElementClickable(self::COMMUNICATION_BUTTON_ID, 10);
        $I->click(self::COMMUNICATION_BUTTON);

        // fill the form fields
        $I->waitForElementClickable(self::TITLE_AREA, 10);
        $I->click(self::TITLE_AREA);
        $I->fillField(self::TITLE_AREA, self::TITLE_EXAMPLE);
        $I->waitForElementClickable(self::CONFIRM_ID, 10);
        $I->click(self::CONFIRM_ID);
        $I->waitForElement(self::RESULT_MESSAGE, 10);
        $I->see("Please fill all the fields.");
        $I->dontSeeInDatabase(self::COMMUNICATION_TABLE, [
            self::TITLE => self::TITLE_EXAMPLE,
            self::DESCRIPTION => '',
            'Date' => date(self::DATE_FORMAT)
        ]);
    }
}
?>