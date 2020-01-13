<?php

class Story5Cest{
    // tests
    public function testAssignSingleStudent(AcceptanceTester $I){
        $I->amOnPage('/login.php');        
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');
        // end login
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->see('Setup class composition');
        $I->wait(1);
        $I->click('Setup class composition');
        // select student and class and submit
        $I->wait(2);
        $I->click(['css' => '#student_list > li[studentid="MNDLRT04E14L219I"]']);
        $I->wait(1);
        $I->seeNumberOfElements(['css' => '#new_student_list > li'], 1);
        $I->selectOption("div select[name='year']", "1");
        $I->selectOption("div select[name='letter']", "B");
        $I->click('Confirm');
        $I->wait(1);
        // to dismiss alert or other popups
        $I->cancelPopup(); // /*NOT*/ $I->click('OK');
        // check correct data after reloading
        $I->amOnPage('/class_composition.php');
        $I->wait(1);
        $I->seeInDatabase('CHILD', [
            'SSN' => 'MNDLRT04E14L219I',
            'Name' => 'Alberto',
            'Surname' => 'Mandini',
            'SSNParent1' => 'MNDFPP68C16L219N',
            'SSNParent2' => 'PLLMRT70E68L219Q',
            'Class' => '1B'
        ]);
        $I->wait(5);
        $I->click('Logout');
    }

    public function testClearButton(AcceptanceTester $I){
        $I->amOnPage('/login.php');        
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');
        // end login
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->see('Setup class composition');
        $I->wait(1);
        $I->click('Setup class composition');
        // select student and then remove it from new_student_list
        $I->wait(2);
        $I->click(['css' => '#student_list > li[studentid="MNDGPP04E14L219U"]']);
        $I->wait(1);
        $I->seeNumberOfElements(['css' => '#new_student_list > li'], 1);
        $I->selectOption("div select[name='year']", "2");
        $I->selectOption("div select[name='letter']", "A");
        $I->click('Clear');
        $I->seeNumberOfElements(['css' => '#new_student_list > li'], 0);
        $I->wait(5);
        $I->click('Logout');
    }

    public function testCorrectListing(AcceptanceTester $I){
        $I->amOnPage('/login.php');        
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');
        // end login
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->see('Setup class composition');
        $I->wait(1);
        $I->click('Setup class composition');
        // check correct number of elements inside lists
        $I->wait(1);
        $I->seeNumberOfElements(['css' => '#student_list > li'], 5);
        // control the numbers of elements in each list of students to match the correct number of related students
        $I->wait(5);
        $I->click('Logout');
    }
}

?>