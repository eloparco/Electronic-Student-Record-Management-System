<?php 

class Story2Cest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function testInsertTopicSuccess(AcceptanceTester $I)
    {
        // login as teacher
        $I->amOnPage('/login.php');
        $I->fillField('username', 'johnny@doe.it');
        $I->fillField('password', 'a1a1a1a1');
        $I->click('Sign in');

        $I->seeInCurrentUrl('/user_teacher.php');
        $I->see('Record lecture\'s topics');
        
        // insert new topic
        $I->wait(1);
        $I->click('Record lecture\'s topics');
        $I->wait(5);
        // $I->selectOption("form select[name='class_sID_ssn']", "1A Geography");  
        $I->fillField('date', '13/11/2019');         
        $I->selectOption("form select[name='hour']", 3); 
        $I->fillField('title', 'Mock topic');
        $I->fillField('subtitle', 'Mock description');
        $I->click('Confirm');
    }
}
