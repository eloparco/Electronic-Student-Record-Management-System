<?php 
require_once('public/utility.php');

class UtilityTest extends \Codeception\Test\Unit
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

    // TRY LOGIN
    public function testTryLoginTeacher()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        // codecept_debug($ini_path);
        $this->assertEquals(LOGIN_TEACHER_OK, tryLogin('johnny@doe.it', 'a1a1a1a1', $ini_path));
    }
    public function testTryLoginParent()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals(LOGIN_PARENT_OK, tryLogin('john@doe.it', 'pass123', $ini_path));
    }
    public function testTryLoginSecretaryOfficer()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals(LOGIN_SECRETARY_OK, tryLogin('milo@milo.it', 'Milo1', $ini_path));
    }
    public function testTryLoginChangePassword()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals(CHANGE_PASSWORD, tryLogin('jane@doe.it', 'pass456', $ini_path));
    }
    public function testTryLoginWrongEmail()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals(LOGIN_NOT_MATCH, tryLogin('jane@doe.com', 'pass456', $ini_path));
    }
    public function testTryLoginUserNotDefined()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals(LOGIN_USER_NOT_DEFINED, tryLogin('mario@rossi.it', 'Mario12', $ini_path));
    }

    // GET CHILDREN OF PARENT

    // GET SCORES PER CHILD AND DATE

    // GET LIST OF SUBJECTS

    // RECORD TOPIC
    public function testRecordTopicSuccess()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals(TOPIC_RECORDING_OK, recordTopic('1A', date('d/m/Y'), 3, 1, 'aaa111', 'Mock topic', 'Mock description', $ini_path));
    }
    public function testRecordTopicNonExistingClass()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals(TOPIC_RECORDING_FAILED, recordTopic('ZZZ', date('d/m/Y'), 3, 1, 'aaa111', 'Mock topic', 'Mock description', $ini_path));
    }
    public function testRecordTopicEmptyDate()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals(TOPIC_RECORDING_FAILED, recordTopic('1A', '', 3, 1, 'aaa111', 'Mock topic', 'Mock description', $ini_path));
    }
    public function testRecordTopicNonExistingTeacher()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals(TOPIC_RECORDING_FAILED, recordTopic('1A', date('d/m/Y'), 3, 1, 'TEST', 'Mock topic', 'Mock description', $ini_path));
    }
    public function testRecordTopicDateTooOld()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals(TOPIC_RECORDING_FAILED, recordTopic('1A', '01/01/1996', 3, 1, 'aaa111', 'Mock topic', 'Mock description', $ini_path));
    }
}