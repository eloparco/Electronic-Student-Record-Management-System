<?php 

class Story15Cest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function testFileUploadSuccessAndDuplicate(AcceptanceTester $I)
    {
        // login as teacher
        $I->amOnPage('/login.php');
        $I->fillField('username', 'aaa@bbb.com');
        $I->fillField('password', 'a1a1a1a1');
        $I->click('Sign in');      

        // click on the option to publish timetable in the dashboard
        $I->waitForElementClickable('#publishMaterial', 10);
        $I->click('Publish Material');

        // insert class/subject and upload file        
        $I->selectOption("form select[name='class_sID_ssn']", '1A Geography');  
        $I->attachFile('input[name="userfile"]', 'uploads/support_material_test.txt');

        // UploadFile        
        $I->click('Upload');
        $I->waitForElement(['class' => 'success-back-color'], 10);
        $I->see('File correctly uploaded.');

        // check if at least the first entry is correctly inserted in db
        $I->seeInDatabase('SUPPORT_MATERIAL', [
            'SubjectID' => 1,
            'Class' => '1A',
            'Date' => date('Y-m-d'),
            'Filename' => 'support_material_test.txt'
        ]);

        //check upload of the same file
        
        // insert class/subject and upload file        
        $I->selectOption("form select[name='class_sID_ssn']", '1A Geography');  
        $I->attachFile('input[name="userfile"]', 'uploads/support_material_test.txt');

        // UploadFile        
        $I->click('Upload');
        $I->waitForElement(['class' => 'error-back-color'], 10);
        $I->see('File already exists, please select another one.');  
    }
    public function testFileUploadWrongExtension(AcceptanceTester $I)
    {
        // login as teacher
        $I->amOnPage('/login.php');
        $I->fillField('username', 'aaa@bbb.com');
        $I->fillField('password', 'a1a1a1a1');
        $I->click('Sign in');      

        // click on the option to publish timetable in the dashboard
        $I->waitForElementClickable('#publishMaterial', 10);
        $I->click('Publish Material');

        // insert class/subject and upload file        
        $I->selectOption("form select[name='class_sID_ssn']", '1A Geography');  
        $I->attachFile('input[name="userfile"]', 'uploads/support_material_test_wrong_extension.sql');

        // UploadFile and verify "extension not supported"        
        $I->click('Upload');
        $I->waitForElement(['class' => 'error-back-color'], 10);
        $I->see('File extension not supported.');        
    }
}
