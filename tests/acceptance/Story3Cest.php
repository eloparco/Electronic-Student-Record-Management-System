<?php 

class Story3Cest
{
    public function _before(AcceptanceTester $I)
    {
    }
    
    // tests
    public function testLoginSecretary(AcceptanceTester $I)
    {
        $I->amOnPage('/login.php');        
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');

        // redirect to parent page
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->see('User Secretary');
        $I->click('Logout');  
    }

    public function testLoginWrongPasswordSecretary(AcceptanceTester $I)
    {
        $I->amOnPage('/login.php');
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'notMilo1');
        $I->click('Sign in');

        // remain in same page, show error
        $I->seeInCurrentUrl('/login.php');
        $I->see('Invalid username or password.');
    }

    public function testInsertParentSuccess(AcceptanceTester $I)
    {
        $I->wait(1);
        // login as secretary
        $I->amOnPage('/login.php');
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_secretary.php');
             
        $I->click('Record parent');        
        
        $I->wait(3);
        // insert new parent    
        $I->fillField('ssn', 'DKDVHF36L48G407J');
        $I->fillField('name', 'Giorgio');
        $I->fillField('surname', 'Padovani');
        $I->fillField('username', 'giorgio@giorgio.it');        
        $I->click('Submit');        

        // check if Parent is inserted in Db
        $I->seeInDatabase('USER', [
            'SSN' => 'DKDVHF36L48G407J',
            'Name' => 'Giorgio',
            'Surname' => 'Padovani',
            'Email' => 'giorgio@giorgio.it',                    
            'AccountActivated' => 0
        ]);    
        $I->seeInDatabase('USER_TYPE', [
            'SSN' => 'DKDVHF36L48G407J',
            'USERTYPE' => 'PARENT'
        ]);     
        $I->click('Logout');  
    }
 
    public function testInsertParentDuplicate(AcceptanceTester $I)
    {
        $I->wait(1);
        // login as secretary
        $I->amOnPage('/login.php');
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->wait(2);    
        $I->click('Record parent');
               
        //$I->waitForElement('#myParentForm', 1);
        $I->wait(1);
        // insert duplicate parent    
        $I->fillField('ssn', 'DKDVHF36L48G407J');
        $I->fillField('name', 'Giorgio');
        $I->fillField('surname', 'Padovani');
        $I->fillField('username', 'giorgio@giorgio.it');        
        $I->click('Submit');  

        // che if it is showing an error
        //$I->seeInCurrentUrl('/parent_form.php');
        $I->wait(1);
        $I->see('SSN already exists.');  

        $I->click('Logout');  
    }

    public function testInsertWrongForm(AcceptanceTester $I)
    {
        $I->wait(1);
        // login as secretary
        $I->amOnPage('/login.php');
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->wait(2);    
        $I->click('Record parent');
               
        //$I->waitForElement('#myParentForm', 1);
        $I->wait(1);
        // insert duplicate parent    
        $I->fillField('ssn', 'ZQVQSF92R30D832R');
        $I->fillField('name', 'Giorgio');
        //surname is missing
        $I->fillField('username', 'test@test.it');        
        $I->click('Submit');  

        // che if it is showing an error in the form
        $I->wait(1);
        $I->cantSeeInField('surname', 'Padovani');
        //$I->see('Please fill out this field.'); 

        $I->click('Logout');  
    }
}
