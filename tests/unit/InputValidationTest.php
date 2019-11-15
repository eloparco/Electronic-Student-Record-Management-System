<?php 
require_once('public/utility.php');

class InputValidationTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // PASSWORD
    public function testPasswordSuccess()
    {
        $this->assertTrue(checkPassword('P4sswd'));
    }
    public function testPasswordEmpty()
    {
        $this->assertFalse(checkPassword(''));
    }
    public function testPasswordTooShort()
    {
        $this->assertFalse(checkPassword('P'));
    }
    public function testPasswordLowercaseMissing()
    {
        $this->assertFalse(checkPassword('PASSWORD12'));
    }
    public function testPasswordNeitherNumericNorUppercase()
    {
        $this->assertFalse(checkPassword('password'));
    }

    // EMAIL
    public function testEmailSuccess()
    {
        $this->assertEquals('test@test.it', checkEmail('test@test.it'));
    }
    public function testEmailEmpty()
    {
        $this->assertEquals('', checkEmail(''));
    }
    public function testEmailWrongFormat1()
    {
        $this->assertEquals('', checkEmail('test'));
    }
    public function testEmailWrongFormat2()
    {
        $this->assertEquals('', checkEmail('test@test'));
    }
    public function testEmailWrongFormat3()
    {
        $this->assertEquals('', checkEmail('test.it'));
    }

    // SSN
    public function testSSNSuccess()
    {
        $this->assertEquals(1, checkSSN('AA12BBcD1234AAAB'));
    }
    public function testSSNEmpty()
    {
        $this->assertFalse(checkSSN(''));
    }
    public function testSSNTooShort()
    {
        $this->assertFalse(checkSSN('AA1234BB'));
    }
    public function testSSNSpecialCharacters()
    {
        $this->assertFalse(checkSSN('AAA123@!!!'));
    }

    // INPUT LENGTH
    public function testInputLengthSucccess()
    {
        $this->assertTrue(checkNormalText('testtest'));
    }
    public function testInputLengthTooShort()
    {
        $this->assertFalse(checkNormalText('t'));
    }
    public function testInputLengthTooLong()
    {
        $this->assertFalse(checkNormalText('testtesttesttesttest'));
    }

    // USER TYPE
    public function testUserTypeSuccessTeacher()
    {
        $this->assertTrue(checkUserType('TEACHER'));
    }
    public function testUserTypeSuccessSecretaryOfficer()
    {
        $this->assertTrue(checkUserType('SECRETARY_OFFICER'));
    }
    public function testUserTypeSuccessParent()
    {
        $this->assertTrue(checkUserType('PARENT'));
    }
    public function testUserTypeStudent()
    {
        $this->assertFalse(checkUserType('STUDENT'));
    }
    public function testUserTypeFail()
    {
        $this->assertFalse(checkUserType('0'));
    }

    // SANITIZE STRING
    public function testSanitizeHTML()
    {
        $this->assertEquals('aaa', mySanitizeString('<h1>aaa</h1>'));
    }
    public function testSanitizePHP()
    {
        $this->assertEquals('outside', mySanitizeString('<?php aaa ?>outside'));
    }
}