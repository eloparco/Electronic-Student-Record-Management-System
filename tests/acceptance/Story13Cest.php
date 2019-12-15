<?php
require_once('public/utility.php');

class Story13Cest{
    public function _before(\AcceptanceTester $I){
        $I->maximizeWindow();
        $I->login('t.fanelli@esrmsystem.com', 'Teresa72');
        $I->waitForElementClickable('#recordAttendance', 10);
        $I->click('Record attendance');
        $I->waitForElementClickable('#classSelection', 10);
        $I->selectOption("select[name='class_sID_ssn']", '1A');
        $I->waitForElementVisible('#MNDGPP04E14L219UpresentRadio', 10);
        $I->waitForElementVisible('#PNCRCR02C13L219KpresentRadio', 10);
        $I->waitForElementVisible('#MNDLRT04E14L219IpresentRadio', 10);
    }

    public function _after(\AcceptanceTester $I){
        $I->click('Logout'); // logout to execute new test with new credentials
    }

    // tests
    public function testAcceptableEarlyExit(\AcceptanceTester $I){
        $I->seeElement('#MNDGPP04E14L219Utp:disabled');
        $I->waitForElementClickable('#MNDGPP04E14L219UleavingRadio', 10);
        $I->click('#MNDGPP04E14L219UleavingRadio');
        $I->seeElement('#MNDGPP04E14L219Utp:not(:disabled)');
        $I->fillField('#MNDGPP04E14L219Utp', '2');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('Confirm');
        $I->cancelPopup();
        $I->seeInDatabase('ATTENDANCE', [
            'StudentSSN' => 'MNDGPP04E14L219U',
            'Date' => date('Y-m-d'),
            'ExitHour' => 2
        ]);
        $I->amOnPage('/attendance_recording.php');
        $I->waitForElementClickable('#classSelection', 10);
        $I->selectOption("select[name='class_sID_ssn']", '1A');
        $I->waitForJS("return $.active == 0;", 60);
        #$I->seeElement('#MNDGPP04E14L219UleavingRadio:checked');
        #$I->seeElement('#MNDGPP04E14L219Utp:not(:disabled)');
        $I->seeInField('#MNDGPP04E14L219Utp', '2');
    }

    public function testBoundariesEarlyExit(\AcceptanceTester $I){
        $I->waitForElementClickable('#PNCRCR02C13L219KleavingRadio', 10);
        $I->click('#PNCRCR02C13L219KleavingRadio');
        $I->waitForElementClickable('#PNCRCR02C13L219Ktp');
        $I->fillField('#PNCRCR02C13L219Ktp', '0');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('Confirm');
        $I->cancelPopup();
        $I->cancelPopup();
        $I->dontSeeInDatabase('ATTENDANCE', [
            'StudentSSN' => 'PNCRCR02C13L219K',
            'Date' => date('Y-m-d'),
            'ExitHour' => 0
        ]);
        $I->waitForElementClickable('#PNCRCR02C13L219Ktp');
        $I->fillField('#PNCRCR02C13L219Ktp', '6');
        $I->click('Confirm');
        $I->cancelPopup();
        $I->cancelPopup();
        $I->dontSeeInDatabase('ATTENDANCE', [
            'StudentSSN' => 'PNCRCR02C13L219K',
            'Date' => date('Y-m-d'),
            'ExitHour' => 6
        ]);
    }

    public function testNegativeNumberExitHour(\AcceptanceTester $I){
        $I->waitForElementClickable('#MNDLRT04E14L219IleavingRadio', 10);
        $I->click('#MNDLRT04E14L219IleavingRadio');
        $I->waitForElementClickable('#MNDLRT04E14L219Itp', 10);
        $I->fillField('#MNDLRT04E14L219Itp', '-2');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('Confirm');
        $I->cancelPopup();
        $I->cancelPopup();
        $I->dontSeeInDatabase('ATTENDANCE', [
            'StudentSSN' => 'MNDLRT04E14L219I',
            'Date' => date('Y-m-d'),
            'ExitHour' => -2
        ]);
    }

    public function testTooHighNumberExitHour(\AcceptanceTester $I){
        $I->waitForElementClickable('#MNDLRT04E14L219IleavingRadio', 10);
        $I->click('#MNDLRT04E14L219IleavingRadio');
        $I->waitForElementClickable('#MNDLRT04E14L219Itp', 10);
        $I->fillField('#MNDLRT04E14L219Itp', '9');
        $I->waitForElementClickable('#confirm', 10);
        $I->click('Confirm');
        $I->cancelPopup();
        $I->cancelPopup();
        $I->dontSeeInDatabase('ATTENDANCE', [
            'StudentSSN' => 'MNDLRT04E14L219I',
            'Date' => date('Y-m-d'),
            'ExitHour' => 9
        ]);
    }
}

?>