<?php 

class Story17Cest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function testGetCommunications(AcceptanceTester $I)
    {
        $I->wait(1);
        //go on the initial page (index.php)
        $I->amOnPage('/index.php');
        $I->see('Electronic Student Record Management System');
        $I->see('System to support electronic student records for High Schools.');
        $I->wait(1);
        $I->see('She Hacks ESRMS 2020');
        $I->see('48 hours Hackathon at Polytechnic of Turin');
        $I->see('2019-12-23');
        $I->wait(5); //wait for the other communication
        $I->see('Dialogues on sustainability');
        $I->see('A conversation with a special guest: Piero Angela');
        $I->see('2019-12-21');
        $I->wait(5); //wait for the other communication
        $I->see('Suspension of teaching activities');
        $I->see('Teaching activities will be suspended from 19/04 to 26/04');
        $I->see('2019-12-20');
        $I->wait(1); 
    }
}
