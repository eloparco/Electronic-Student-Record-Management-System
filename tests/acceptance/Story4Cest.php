<?php 

class Story4Cest
{
    const USER = "milo@milo.it";
    const AUTHENTICATION = "Milo1";
    const SECRETARY_PAGE = "/user_secretary.php";
    const BUTTON_RECORD_STUDENT = "Record student";
    const SSN_EXAMPLE = "CNVZPR41L20G324K";
    const NAME_EXAMPLE = "Mirco";
    const SURNAME = "surname";
    const SURNAME_EXAMPLE = "Rossi";
    const PARENT1_FORM = 'form select[name="parent1"]';
    const PARENT2_FORM = 'form select[name="parent2"]';
    const CLASS_FORM = 'form select[name="class"]';
    const PARENT1_SSN = 'RSSMRA70A01F205V';
    const PARENT2_SSN = 'FLCRRT77B43L219Q';
    const BUTTON_SUBMIT = "Submit";
    const BUTTON_LOGOUT = "Logout";
    // tests
    public function testInsertStudentSuccess(AcceptanceTester $I)
    {
        // login as secretary
        $I->login(self::USER, self::AUTHENTICATION);
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
        $I->wait(1);
        $I->click(self::BUTTON_RECORD_STUDENT);   
        $I->wait(1);

        // insert new child    
        $I->fillField('SSN', self::SSN_EXAMPLE);
        $I->fillField('name', self::NAME_EXAMPLE);
        $I->fillField(self::SURNAME, self::SURNAME_EXAMPLE);             
            
        $I->selectOption(self::PARENT1_FORM, self::PARENT1_SSN);  
        $I->selectOption(self::PARENT2_FORM, self::PARENT2_SSN);  
        $I->selectOption(self::CLASS_FORM, "1A");

        $I->wait(1);

        $I->click(self::BUTTON_SUBMIT);           

        // check if CHILD is inserted in Db
        $I->seeInDatabase('CHILD', [
            'SSN' => self::SSN_EXAMPLE,
            'Name' => self::NAME_EXAMPLE,
            self::SURNAME => self::SURNAME_EXAMPLE,
            'SSNParent1' => 'RSSMRA70A01F205V',
            'SSNParent2' => 'FLCRRT77B43L219Q',
            'Class' => '1A',            
        ]);      
        $I->click(self::BUTTON_LOGOUT);  
    }    

    public function testInsertStudentDuplicate(AcceptanceTester $I)
    {
        // login as secretary
        $I->login(self::USER, self::AUTHENTICATION);
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
        $I->wait(1);
        $I->click(self::BUTTON_RECORD_STUDENT);   
        $I->wait(1);

        // insert new child    
        $I->fillField('SSN', self::SSN_EXAMPLE);
        $I->fillField('name', self::NAME_EXAMPLE);
        $I->fillField(self::SURNAME, self::SURNAME_EXAMPLE);             
            
        $I->selectOption(self::PARENT1_FORM, self::PARENT1_SSN);  
        $I->selectOption(self::PARENT2_FORM, self::PARENT2_SSN);  
        $I->selectOption(self::CLASS_FORM, "1A");

        $I->wait(1);

        $I->click(self::BUTTON_SUBMIT);     

    
        $I->click(self::BUTTON_LOGOUT);  

        $I->wait(1);
        // login as secretary
        $I->login(self::USER, self::AUTHENTICATION);
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);

        $I->wait(1);
        $I->click(self::BUTTON_RECORD_STUDENT);   
        $I->wait(1);

        // insert new child    
        $I->fillField('SSN', self::SSN_EXAMPLE);
        $I->fillField('name', self::NAME_EXAMPLE);
        $I->fillField(self::SURNAME, self::SURNAME_EXAMPLE);             
            
        $I->selectOption(self::PARENT1_FORM, self::PARENT1_SSN);  
        $I->selectOption(self::PARENT2_FORM, self::PARENT2_SSN);  
        $I->selectOption(self::CLASS_FORM, "1A");

        $I->wait(1);

        $I->click(self::BUTTON_SUBMIT);           

        // che if it is showing an error
        $I->wait(1);
        $I->see("This SSN it's already registered. Please insert a new one.");
        $I->click(self::BUTTON_LOGOUT);        
        
    }

    public function testInsertStudentWrongForm(AcceptanceTester $I)
    {
        // login as secretary
        $I->login(self::USER, self::AUTHENTICATION);
        $I->seeInCurrentUrl(self::SECRETARY_PAGE);
        
        $I->click(self::BUTTON_RECORD_STUDENT);   
        $I->wait(1);

        // insert new child    
        $I->fillField('SSN', self::SSN_EXAMPLE);
        $I->fillField('name', self::NAME_EXAMPLE);
        //surname is missing            
            
        $I->selectOption(self::PARENT1_FORM, self::PARENT1_SSN);  
        $I->selectOption(self::PARENT2_FORM, self::PARENT2_SSN);  
        $I->selectOption(self::CLASS_FORM, "1A");

        $I->wait(1);

        $I->click(self::BUTTON_SUBMIT);           

        //check if surname is missing
        $I->cantSeeInField(self::SURNAME, self::SURNAME_EXAMPLE);

        $I->click(self::BUTTON_LOGOUT);  
    }

   
}
