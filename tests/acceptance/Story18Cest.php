<?php
require_once('public/utility.php');

class Story18Cest{
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
        $I->waitForElementClickable('#classSelection', 10);
        $I->selectOption('#classSelection', '1A Physics');
        $I->waitForJS("return $.active === 0;", 10);
        $I->waitForElementClickable('#studentSelection');
        $I->selectOption('#studentSelection', 'Giuseppe Mandini');
        $I->waitForElementClickable('#dataSelection', 10);
        $today = date('d/m/Y');
        $today_db = date('Y-m-d');
        if(date('l') === 'Saturday' || date('l') === 'Sunday'){
            $today = date('d/m/Y', time()-2*24*60*60);
            $today_db = date('Y-m-d', time()-2*24*60*60);
        }
        $I->pressKey('#dataSelection', WebDriverKeys::ESCAPE);
        $I->fillField('#dataSelection', $today);
        $I->waitForElementClickable('#noteTextArea', 10);
        $I->fillField('#noteTextArea', 'Brief note description for Mandini related to Physics subject');
        $I->click('Confirm');
        $I->seeInDatabase('NOTE', [
            "StudentSSN" => "MNDGPP04E14L219U",
            "SubjectID" => 5,
            "Date" => $today_db
        ]);
        $I->see(NOTE_RECORDING_OK);
    }

    public function testNoteRecordingWithoutSubject(\AcceptanceTester $I){
        $I->waitForElementClickable('#classSelection', 10);
        $I->selectOption('#classSelection', '');
        $I->waitForJS("return $.active === 0;", 10);
        $I->waitForElementClickable('#dataSelection', 10);
        $today = date('d/m/Y');
        $today_db = date('Y-m-d');
        if(date('l') === 'Saturday' || date('l') === 'Sunday'){
            $today = date('d/m/Y', time()-2*24*60*60);
            $today_db = date('Y-m-d', time()-2*24*60*60);
        }
        $I->pressKey('#dataSelection', WebDriverKeys::ESCAPE);
        $I->fillField('#dataSelection', $today);
        $I->waitForElementClickable('#noteTextArea', 10);
        $I->fillField('#noteTextArea', 'Brief note description for Mandini related to which subject?');
        $I->click('Confirm');
        $I->dontSeeInDatabase('NOTE', [
            "StudentSSN" => "MNDGPP04E14L219U",
            "SubjectID" => 5,
            "Date" => $today_db
        ]);
        $I->see(NOTE_RECORDING_FAILED);
    }

    public function testNoteRecordingWithoutDate(\AcceptanceTester $I){
        $I->waitForElementClickable('#classSelection', 10);
        $I->selectOption('#classSelection', '1A Physics');
        $I->waitForJS("return $.active === 0;", 10);
        $I->waitForElementClickable('#studentSelection');
        $I->selectOption('#studentSelection', 'Giuseppe Mandini');
        $today_db = date('Y-m-d');
        if(date('l') === 'Saturday' || date('l') === 'Sunday'){
            $today = date('d/m/Y', time()-2*24*60*60);
            $today_db = date('Y-m-d', time()-2*24*60*60);
        }
        $I->waitForElementClickable('#noteTextArea', 10);
        $I->fillField('#noteTextArea', 'Brief note description for Mandini related to Physics subject');
        $I->click('Confirm');
        $I->dontSeeInDatabase('NOTE', [
            "StudentSSN" => "MNDGPP04E14L219U",
            "SubjectID" => 5,
            "Date" => $today_db
        ]);
        $I->see(NOTE_RECORDING_FAILED);
    }

    public function testNoteRecordingWithWrongDateFormat(\AcceptanceTester $I){
        $I->waitForElementClickable('#classSelection', 10);
        $I->selectOption('#classSelection', '1A Physics');
        $I->waitForJS("return $.active === 0;", 10);
        $I->waitForElementClickable('#studentSelection');
        $I->selectOption('#studentSelection', 'Giuseppe Mandini');
        $I->waitForElementClickable('#dataSelection', 10);
        $today = date('d-m-Y');
        $today_db = date('Y-m-d');
        if(date('l') === 'Saturday' || date('l') === 'Sunday'){
            $today = date('d-m-Y', time()-2*24*60*60);
            $today_db = date('Y-m-d', time()-2*24*60*60);
        }
        $I->pressKey('#dataSelection', WebDriverKeys::ESCAPE);
        $I->fillField('#dataSelection', $today);
        $I->waitForElementClickable('#noteTextArea', 10);
        $I->fillField('#noteTextArea', 'Brief note description for Mandini related to Physics subject');
        $I->click('Confirm');
        $I->dontSeeInDatabase('NOTE', [
            "StudentSSN" => "MNDGPP04E14L219U",
            "SubjectID" => 5,
            "Date" => $today_db
        ]);
        $I->see(NOTE_RECORDING_FAILED);
    }

    public function testNoteRecordingWithEmptyDescription(\AcceptanceTester $I){
        $I->waitForElementClickable('#classSelection', 10);
        $I->selectOption('#classSelection', '1A Physics');
        $I->waitForJS("return $.active === 0;", 10);
        $I->waitForElementClickable('#studentSelection');
        $I->selectOption('#studentSelection', 'Giuseppe Mandini');
        $I->waitForElementClickable('#dataSelection', 10);
        $today = date('d/m/Y');
        $today_db = date('Y-m-d');
        if(date('l') === 'Saturday' || date('l') === 'Sunday'){
            $today = date('d/m/Y', time()-2*24*60*60);
            $today_db = date('Y-m-d', time()-2*24*60*60);
        }
        $I->pressKey('#dataSelection', WebDriverKeys::ESCAPE);
        $I->fillField('#dataSelection', $today);
        $I->waitForElementClickable('#noteTextArea', 10);
        $I->fillField('#noteTextArea', '');
        $I->click('Confirm');
        $I->dontSeeInDatabase('NOTE', [
            "StudentSSN" => "MNDGPP04E14L219U",
            "SubjectID" => 5,
            "Date" => $today_db
        ]);
        $I->see(NOTE_RECORDING_FAILED);
    }
}

?>