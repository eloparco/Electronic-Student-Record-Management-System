<?php 

class Story4Cest
{
    public function _before(AcceptanceTester $I)
    {
    }
    
    // tests
    public function testInsertStudentSuccess(AcceptanceTester $I)
    {
        // login as secretary
        $I->amOnPage('/login.php');
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->wait(1);
        $I->click('Record student');   
        $I->wait(1);

        // insert new child    
        $I->fillField('SSN', 'CNVZPR41L20G324K');
        $I->fillField('name', 'Mirco');
        $I->fillField('surname', 'Rossi');             
            
        $I->selectOption("form select[name='parent1']", "RSSMRA70A01F205V");  
        $I->selectOption("form select[name='parent2']", "FLCRRT77B43L219Q");  
        $I->selectOption("form select[name='class']", "1A");

        $I->wait(1);

        $I->click('Submit');           

        // check if CHILD is inserted in Db
        $I->seeInDatabase('CHILD', [
            'SSN' => 'CNVZPR41L20G324K',
            'Name' => 'Mirco',
            'Surname' => 'Rossi',
            'SSNParent1' => 'RSSMRA70A01F205V',
            'SSNParent2' => 'FLCRRT77B43L219Q',
            'Class' => '1A',            
        ]);      
        $I->click('Logout');  
    }    

    public function testInsertStudentDuplicate(AcceptanceTester $I)
    {
        // login as secretary
        $I->amOnPage('/login.php');
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_secretary.php');
        $I->wait(1);
        $I->click('Record student');   
        $I->wait(1);

        // insert new child    
        $I->fillField('SSN', 'CNVZPR41L20G324K');
        $I->fillField('name', 'Mirco');
        $I->fillField('surname', 'Rossi');             
            
        $I->selectOption("form select[name='parent1']", "RSSMRA70A01F205V");  
        $I->selectOption("form select[name='parent2']", "FLCRRT77B43L219Q");  
        $I->selectOption("form select[name='class']", "1A");

        $I->wait(1);

        $I->click('Submit');     

    
        $I->click('Logout');  

        $I->wait(1);
        // login as secretary
        $I->amOnPage('/login.php');
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_secretary.php');

        $I->wait(1);
        $I->click('Record student');   
        $I->wait(1);

        // insert new child    
        $I->fillField('SSN', 'CNVZPR41L20G324K');
        $I->fillField('name', 'Mirco');
        $I->fillField('surname', 'Rossi');             
            
        $I->selectOption("form select[name='parent1']", "RSSMRA70A01F205V");  
        $I->selectOption("form select[name='parent2']", "FLCRRT77B43L219Q");  
        $I->selectOption("form select[name='class']", "1A");

        $I->wait(1);

        $I->click('Submit');           

        // che if it is showing an error
        //$I->seeInCurrentUrl('/parent_form.php');
        $I->wait(1);
        $I->see('Student already exists.');
        $I->click('Logout');        
        
    }

    public function testInsertStudentWrongForm(AcceptanceTester $I)
    {
        // login as secretary
        $I->amOnPage('/login.php');
        $I->fillField('username', 'milo@milo.it');
        $I->fillField('password', 'Milo1');
        $I->click('Sign in');
        $I->seeInCurrentUrl('/user_secretary.php');
        
        $I->click('Record student');   
        $I->wait(1);

        // insert new child    
        $I->fillField('SSN', 'CNVZPR41L20G324K');
        $I->fillField('name', 'Mirco');
        //surname is missing            
            
        $I->selectOption("form select[name='parent1']", "RSSMRA70A01F205V");  
        $I->selectOption("form select[name='parent2']", "FLCRRT77B43L219Q");  
        $I->selectOption("form select[name='class']", "1A");

        $I->wait(1);

        $I->click('Submit');           

        //check if surname is missing
        $I->cantSeeInField('surname', 'Rossi');

        $I->click('Logout');  
    }

   
}
