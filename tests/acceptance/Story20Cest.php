<?php
require_once('public/utility.php');

class Story20Cest{
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
            "Student" => "MNDLRT04E14L219I",
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
}

?>