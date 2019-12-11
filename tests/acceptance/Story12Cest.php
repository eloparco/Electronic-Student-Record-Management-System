<?php
require_once('public/utility.php');

class Story12Cest{
    public function _before(\AcceptanceTester $I){
        $I->maximizeWindow();
        $I->login('milo@milo.it', 'Milo1');
    }

    public function _after(\AcceptanceTester $I){
        $I->click('Logout'); // logout to execute new test with new credentials
    }

    // tests
    public function testInsertCorrectCommunication(\AcceptanceTester $I){
        $I->seeInCurrentUrl('/user_secretary.php');
        // go to the correct menu
        $I->waitForElementClickable('#publish_communication_dashboard', 10);
        $I->click('Publish official communication');

        // fill the form fields
        $I->waitForElementClickable('#topicTitleTextArea', 10);
        $I->click('#topicTitleTextArea');
        $I->fillField('#topicTitleTextArea', 'First school communication to parents');
        $I->waitForElementClickable('#lectureTextArea', 10);
        $I->click('#lectureTextArea');
        $I->fillField('#lectureTextArea', 'A very simple and short communication to parents to tell them nothing');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('#confirm');
        $I->waitForElement('#msg-result', 10);
        $I->see(COMMUNICATION_RECORDING_OK);
        $I->seeInDatabase("COMMUNICATION", [
            'Title' => 'First school communication to parents',
            'Description' => 'A very simple and short communication to parents to tell them nothing',
            'Date' => date('Y-m-d')
        ]);
    }

    public function testInsertCommunicationNoTitle(\AcceptanceTester $I){
        $I->seeInCurrentUrl('/user_secretary.php');
        // go to the correct menu
        $I->waitForElementClickable('#publish_communication_dashboard', 10);
        $I->click('Publish official communication');

        // fill the form fields
        $I->waitForElementClickable('#lectureTextArea', 10);
        $I->click('#lectureTextArea');
        $I->fillField('#lectureTextArea', 'A very simple and short communication to parents to tell them nothing');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('#confirm');
        $I->waitForElement('#msg-result', 10);
        $I->see("Please fill all the fields.");
        $I->dontSeeInDatabase("COMMUNICATION", [
            'Title' => '',
            'Description' => 'A very simple and short communication to parents to tell them nothing',
            'Date' => date('Y-m-d')
        ]);
    }

    public function testInsertCommunicationNoDescription(\AcceptanceTester $I){
        $I->seeInCurrentUrl('/user_secretary.php');
        // go to the correct menu
        $I->waitForElementClickable('#publish_communication_dashboard', 10);
        $I->click('Publish official communication');

        // fill the form fields
        $I->waitForElementClickable('#topicTitleTextArea', 10);
        $I->click('#topicTitleTextArea');
        $I->fillField('#topicTitleTextArea', 'First school communication to parents');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('#confirm');
        $I->waitForElement('#msg-result', 10);
        $I->see("Please fill all the fields.");
        $I->dontSeeInDatabase("COMMUNICATION", [
            'Title' => 'First school communication to parents',
            'Description' => '',
            'Date' => date('Y-m-d')
        ]);
    }

    /*
    public function testInsertCommunicationNonAsciiTitle(\AcceptanceTester $I){
        $I->seeInCurrentUrl('/user_secretary.php');
        // go to the correct menu
        $I->waitForElementClickable('#publish_communication_dashboard', 10);
        $I->click('Publish official communication');

        // fill the form fields
        $I->waitForElementClickable('#topicTitleTextArea', 10);
        $I->click('#topicTitleTextArea');
        $I->fillField('#topicTitleTextArea', '#$^*#(%&#^#&(@$)!*&');
        $I->waitForElementClickable('#lectureTextArea', 10);
        $I->click('#lectureTextArea');
        $I->fillField('#lectureTextArea', 'A very simple and short communication to parents to tell them nothing');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('#confirm');
        $I->waitForElement('#msg-result', 10);
        $I->see(COMMUNICATION_RECORDING_FAILED);
        $I->dontSeeInDatabase("COMMUNICATION", [
            'Title' => 'First school communication to parents',
            'Description' => 'A very simple and short communication to parents to tell them nothing',
            'Date' => date('Y-m-d')
        ]);
    }
    */
}
?>