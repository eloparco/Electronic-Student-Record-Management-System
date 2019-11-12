<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

   /**
    * Define custom actions here
    */
    public function teacherLogin() {
        $I = this;
        $I->amOnPage('/login.php');
        $I->submitForm('#login_form', [
            'username' => 'johnny@doe.it',
            'password' => 'a1a1a1a1'
        ]);
    }

    public function parentLogin() {
        $I = this;
        $I->amOnPage('/login.php');
        $I->submitForm('#login_form', [
            'username' => 'john@doe.it',
            'password' => 'pass123'
        ]);
    }
}
