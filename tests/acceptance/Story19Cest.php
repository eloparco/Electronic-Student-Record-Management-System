<?php 

class Story19Cest
{
    // tests
    public function testShowChildNotes(AcceptanceTester $I)
    {
        // login as parent
        $I->login('m.ponci@parent.esrmsystem.com', 'Massi75');
        $I->seeInCurrentUrl('/user_parent.php');
        $I->see('User Parent');

        // select child
        $I->waitForElementClickable('#dropMenu', 10);
        $I->click('Select child');
        $I->click('Riccardo Ponci');

        // show page with child notes
        $I->waitForElementClickable('#notes_dashboard', 10);
        $I->click('Show child notes');

        // there should be two notes in the following dates
        $I->see('2019-12-17');
        $I->see('2019-12-15');

        // click on dates anc check the content
        $I->waitForElementClickable('#heading0', 10);
        $I->click('2019-12-17');
        $I->waitForElement('#cardBody0', 10);
        $I->see('Mathematics');
        
        $I->waitForElementClickable('#heading1', 10);
        $I->click('2019-12-15');
        $I->waitForElement('#cardBody1', 10);
        $I->see('Italian');
    }
    
    public function testShowChildWithoutNotes(AcceptanceTester $I)
    {
        // login as parent
        $I->login('m.ponci@parent.esrmsystem.com', 'Massi75');
        $I->seeInCurrentUrl('/user_parent.php');
        $I->see('User Parent');

        // select child (the one without notes)
        $I->waitForElementClickable('#dropMenu', 10);
        $I->click('Select child');
        $I->click('Giuseppe Ponci');

        // show page with child notes
        $I->waitForElementClickable('#notes_dashboard', 10);
        $I->click('Show child notes');

        // there should be no notes
        $I->see('No notes received.');
    }
}
