<?php 

class Story8Cest
{
    // tests
    public function testCalendarVisualization(AcceptanceTester $I)
    {
        $I->login('r.filicaro@parent.esrmsystem.com', 'Roberta77');

        // redirect to parent page
        $I->seeInCurrentUrl('/user_parent.php');
        $I->see('Parent');

        $I->waitForElementClickable('#attendance_dashboard', 10);
        $I->click('Show lesson attendance');
        $I->waitForElement('#calendar', 10);
        
        // want to go to Novermber 2019:
        // calculate difference in months between today and 11/2019
        $ts2 = strtotime('now');
        $ts1 = strtotime('2019/11/1');
        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);
        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        
        // move back to the right month (11/2019)
        for($i = 0; $i < $diff; ++$i)
            $I->click('.cal-button'); 
        
        // check entries in table
        $entries = array("1 HOUR LATE", "ABSENT", "EARLY EXIT", "10 MINUTES LATE");
        foreach ($entries as $entry) {
            $I->see($entry);
        }
    }
    // tests
    public function testCalendarVisualizationEmptyCalendar(AcceptanceTester $I)
    {
        $I->login('f.mandini@parent.esrmsystem.com', 'Filippo68');

        // redirect to parent page
        $I->seeInCurrentUrl('/user_parent.php');
        $I->see('Parent');

        $I->waitForElementClickable('#attendance_dashboard', 10);
        $I->click('Show lesson attendance');
        $I->waitForElement('#calendar', 10);

        // want to go to Novermber 2019:
        // calculate difference in months between today and 11/2019
        $ts1 = strtotime('now');
        $ts2 = strtotime('2019/1/1');
        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);
        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        // move back to the right month (11/2019)
        for($i = 0; $i < $diff; ++$i)
            $I->click('.fc-prev-button');

        // calendar should be empty
        $I->dontSee("LATE");
        $I->dontSee("ABSENT");
        $I->dontSee("EARLY");
    }
}
