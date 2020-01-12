<?php 

class Story30Cest
{
    const SSN_INPUT = "#inputSSN";
    const SSN_EXAMPLE = "FLCRRT77B43L219Q";
    const TEACHER_RADIO_B = "input[id='input-type-teacher']";
    const SUBMIT_BUTTON_HASH = "#confirmInsertAccount";
    const SUBMIT_BUTTON = "Submit";

    public function _before(AcceptanceTester $I){
        $I->login('mamma@mia.it', 'Mamma');
        $I->seeInCurrentUrl('/user_admin.php');
        $I->see('Setup accounts');
        $I->waitForElementClickable('#setupAccountDash', 10);
        $I->click('Setup accounts');
    }
    // tests
    public function testInsertAccountAutocompletion(AcceptanceTester $I)
    {        
        // insert new account
        $I->waitForElementClickable(self::SSN_INPUT, 10);
        $I->click(self::SSN_INPUT);
        $I->fillField(self::SSN_INPUT, 'PNCMSM75D20L219X');

        $I->wait(3);
        $I->click(self::TEACHER_RADIO_B);
        $I->waitForElementClickable(self::SUBMIT_BUTTON_HASH, 10);
        $I->click(self::SUBMIT_BUTTON);
        $I->wait(3);

        // check if database updated
        $I->seeInDatabase('USER_TYPE', [
            'SSN' => 'PNCMSM75D20L219X',
            'UserType' => 'TEACHER'
        ]);
    }

    public function testInsertAccountSuccess(AcceptanceTester $I)
    {        
        // insert new account
        $I->waitForElementClickable(self::SSN_INPUT, 10);
        $I->click(self::SSN_INPUT);
        $I->fillField(self::SSN_INPUT, self::SSN_EXAMPLE);

        $I->wait(3);
        $I->click(self::TEACHER_RADIO_B);
        $I->waitForElementClickable(self::SUBMIT_BUTTON_HASH, 10);
        $I->click(self::SUBMIT_BUTTON);
        $I->wait(3);

        // check if database updated
        $I->seeInDatabase('USER_TYPE', [
            'SSN' => self::SSN_EXAMPLE,
            'UserType' => 'TEACHER'
        ]);
    }

    public function testInsertAccountFailure(AcceptanceTester $I)
    {        
        // insert new account
        $I->waitForElementClickable(self::SSN_INPUT, 10);
        $I->click(self::SSN_INPUT);
        $I->fillField(self::SSN_INPUT, self::SSN_EXAMPLE);

        $I->wait(3);
        $I->click(self::TEACHER_RADIO_B);
        $I->wait(2);
        $I->waitForElementClickable(self::SUBMIT_BUTTON_HASH, 10);
        $I->click(self::SUBMIT_BUTTON);
        $I->wait(3);

        // insert new account
        $I->waitForElementClickable(self::SSN_INPUT, 10);
        $I->click(self::SSN_INPUT);
        $I->fillField(self::SSN_INPUT, self::SSN_EXAMPLE);

        $I->wait(3);
        $I->click(self::TEACHER_RADIO_B);
        $I->wait(2);
        $I->waitForElementClickable(self::SUBMIT_BUTTON_HASH, 10);
        $I->click(self::SUBMIT_BUTTON);
        $I->wait(3);
        
        // check if database updated
        $I->see('The account has already this role.');
    }

}
