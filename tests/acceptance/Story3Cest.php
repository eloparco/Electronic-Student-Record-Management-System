<?php 

class Story3Cest
{
    const SEC_USERNAME = "milo@milo.it";
    const SEC_PSW = "Milo1";
    const SECRETARY_PAGE = "/user_secretary.php";
    const PARENT_SSN = "DKDVHF36L48G407J";
    const PARENT_NAME = "Giorgio";
    const SURNAME = "surname";
    const PARENT_SURNAME = "Padovani";
    const PARENT_USERNAME = "giorgio@giorgio.it";
    const RECORD_BUTTON = "Record parent";
    const SUBMIT_BUTTON = "Submit";
    const LOGOUT_BUTTON = "Logout";
    // tests
    public function testLoginSecretary(AcceptanceTester $I)
    {
        $I->login(self::SEC_USERNAME, self::SEC_PSW);

        // redirect to parent page
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
        $I->see('User Secretary');
        $I->click(self::LOGOUT_BUTTON);  
    }

    public function testLoginWrongPasswordSecretary(AcceptanceTester $I)
    {
        $I->login(self::SEC_USERNAME, 'notMilo1');

        // remain in same page, show error
        $I->seeInCurrentUrl('/login.php');
        $I->see('Invalid username or password.');
    }

    public function testInsertParentSuccess(AcceptanceTester $I)
    {
        // login as secretary
        $I->login(self::SEC_USERNAME, self::SEC_PSW);
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
             
        $I->click(self::RECORD_BUTTON);        
        
        $I->wait(2);
        // insert new parent    
        $I->fillField('ssn', self::PARENT_SSN);
        $I->fillField('name', self::PARENT_NAME);
        $I->fillField(self::SURNAME, self::PARENT_SURNAME);
        $I->fillField('username', self::PARENT_USERNAME);        
        $I->click(self::SUBMIT_BUTTON);        

        // check if Parent is inserted in Db
        $I->seeInDatabase('USER', [
            'SSN' => self::PARENT_SSN,
            'Name' => self::PARENT_NAME,
            self::SURNAME => self::PARENT_SURNAME,
            'Email' => self::PARENT_USERNAME,                    
            'AccountActivated' => 0
        ]);    
        $I->seeInDatabase('USER_TYPE', [
            'SSN' => self::PARENT_SSN,
            'USERTYPE' => 'PARENT'
        ]);     
        $I->click(self::LOGOUT_BUTTON);  
    }
 
    public function testInsertParentDuplicate(AcceptanceTester $I)
    {
        // login as secretary
        $I->login(self::SEC_USERNAME, self::SEC_PSW);
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
             
        $I->click(self::RECORD_BUTTON);        
        
        $I->wait(1);
        // insert new parent    
        $I->fillField('ssn', self::PARENT_SSN);
        $I->fillField('name', self::PARENT_NAME);
        $I->fillField(self::SURNAME, self::PARENT_SURNAME);
        $I->fillField('username', self::PARENT_USERNAME);        
        $I->click(self::SUBMIT_BUTTON);        

        $I->click(self::LOGOUT_BUTTON);

        $I->wait(1);
        // login as secretary
        $I->login(self::SEC_USERNAME, self::SEC_PSW);
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
        $I->wait(1);    
        $I->click(self::RECORD_BUTTON);
               
        $I->wait(1);
        // insert duplicate parent    
        $I->fillField('ssn', self::PARENT_SSN);
        $I->fillField('name', self::PARENT_NAME);
        $I->fillField(self::SURNAME, self::PARENT_SURNAME);
        $I->fillField('username', self::PARENT_USERNAME);        
        $I->click(self::SUBMIT_BUTTON);  

        // check if it is showing an error
        $I->wait(1);
        $I->see('SSN already exists.');  

        $I->click(self::LOGOUT_BUTTON);  
    }

    public function testInsertWrongForm(AcceptanceTester $I)
    {
        // login as secretary
        $I->login(self::SEC_USERNAME, self::SEC_PSW);
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
        $I->wait(1);    
        $I->click(self::RECORD_BUTTON);
               
        $I->wait(1);
        // insert duplicate parent    
        $I->fillField('ssn', 'ZQVQSF92R30D832R');
        $I->fillField('name', self::PARENT_NAME);
        //surname is missing
        $I->fillField('username', 'test@test.it');        
        $I->click(self::SUBMIT_BUTTON);  

        // check if it is showing an error in the form
        $I->wait(1);
        $I->cantSeeInField(self::SURNAME, self::PARENT_SURNAME);

        $I->click(self::LOGOUT_BUTTON);  
    }
}
