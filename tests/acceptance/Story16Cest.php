<?php 

class Story16Cest
{
    const PARENT_USER = "r.filicaro@parent.esrmsystem.com";
    const PARENT_PSW = "Roberta77";
    // tests
    public function testDownloadFileNotAvailable(AcceptanceTester $I)
    {
        //so important, without maximize, in small screen, logout and home button will be not visible, and so not clickable     
        $I->maximizeWindow();

        // login as a parent
        $I->login(self::PARENT_USER, self::PARENT_PSW);
        
        // click on the option to download support material
        $I->waitForElementClickable('#support_material_dashboard', 10);
        $I->click('Show support material');

        $I->see('No support material available.');
    }
    public function testDownloadFile(AcceptanceTester $I)
    {
        //so important, without maximize, in small screen, logout and home button will be not visible, and so not clickable     
        $I->maximizeWindow();

        // login as teacher
        $I->login(self::PARENT_USER, self::PARENT_PSW);

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

        $I->click('Logout');

        // login as a parent
        $I->login(self::PARENT_USER, self::PARENT_PSW);
        
        // click on the option to download support material
        $I->waitForElementClickable('#support_material_dashboard', 10);
        $I->click('Show support material');

        $I->wait(1);//without this wait the download doesn't start 
        $I->click('#download1');        
        $I->wait(1);
    }
}
