<?php
class Story7Cest {
    // functional methods
    public function _before(AcceptanceTester $I){
        $I->maximizeWindow();
    }

    public function _after(AcceptanceTester $I){
        // logout [to perform several test in a row]
        $I->click('Logout');
    }

    public function testAssignmentVisualization(\AcceptanceTester $I){
        // login and go to the correct page
        $I->login('m.ponci@parent.esrmsystem.com', 'Massi75');
        $I->seeInCurrentUrl('/user_parent.php');
        $I->see('PARENT');
        $I->waitForElementClickable('#topic_dashboard', 10);
        $I->click('Visualize assignments');
        $I->waitForElement('#mon_list', 10);
        $I->waitForElement('#tue_list', 10);
        $I->waitForElement('#wed_list', 10);
        $I->waitForElement('#thu_list', 10);
        $I->waitForElement('#fri_list', 10);
        $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
        if(in_array(date("l"), $days)){
            $I->see('Prova');
            $I->see('Prova con file');
        } else {
            $I->dontSee('Prova');
            $I->dontSee('Prova con file');
        }
        $I->see('Refresh');
    }

    public function testChildWithoutAssignment(\AcceptanceTester $I){
        $I->login('mario.rossi@email.com', 'Mariorossi2');
        $I->seeInCurrentUrl('/user_parent.php');
        $I->see('PARENT');
        $I->waitForElementClickable('#topic_dashboard', 10);
        $I->click('Visualize assignments');
        $I->waitForElement('#mon_list', 10);
        $I->waitForElement('#tue_list', 10);
        $I->waitForElement('#wed_list', 10);
        $I->waitForElement('#thu_list', 10);
        $I->waitForElement('#fri_list', 10);
        $I->dontSee(date('Y-m-d'));
        $I->dontSee('Prova con file');
        $I->see('Refresh');
    }

    public function testParentWithoutChild(\AcceptanceTester $I){
        // login and not displaying operations
        $I->login('r.stelluti@parent.esrmsystem.com', 'Roberto66');
        $I->seeInCurrentUrl('/user_parent.php');
        $I->see('PARENT');
        $I->dontSee('Visualize assignments');
    }
}
?>