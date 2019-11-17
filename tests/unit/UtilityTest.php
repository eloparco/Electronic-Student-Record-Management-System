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
    public function testGetChild()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $children = get_children_of_parent('r.filicaro@parent.esrmsystem.com', $ini_path);
        $this->assertEquals(1, count($children));

        $child = $children[0];
        $this->assertEquals(3, count($child));

        $this->assertEquals('PNCRCR02C13L219K', $child['SSN']);
        $this->assertEquals('Riccardo', $child['Name']);
        $this->assertEquals('Ponci', $child['Surname']);
    }
    public function testGetNoChild()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $children = get_children_of_parent('john@doe.it', $ini_path);
        $this->assertEquals(0, count($children));
    }
    public function testGetTwoChildren()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $children = get_children_of_parent('f.mandini@parent.esrmsystem.com', $ini_path);
        $this->assertEquals(2, count($children));

        $child1 = $children[0];
        $this->assertEquals(3, count($child1));
        $child2 = $children[1];
        $this->assertEquals(3, count($child2));
        
        // don't know the order of the results
        $this->assertTrue('MNDLRT04E14L219I' === $child1['SSN'] || 'MNDLRT04E14L219I' === $child2['SSN']);
        $this->assertTrue('Alberto' === $child1['Name'] || 'Alberto' === $child2['Name']);
        $this->assertTrue('Mandini' === $child1['Surname'] || 'Mandini' === $child2['Surname']);

        $this->assertTrue('MNDGPP04E14L219U' === $child1['SSN'] || 'MNDGPP04E14L219U' === $child2['SSN']);
        $this->assertTrue('Giuseppe' === $child1['Name'] || 'Giuseppe' === $child2['Name']);
        $this->assertTrue('Mandini' === $child1['Surname'] || 'Mandini' === $child2['Surname']);
    }
    public function testGetChildrenWrongParent()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $children = get_children_of_parent('TEST', $ini_path);
        $this->assertEquals(0, count($children));
    }

    // GET SCORES PER CHILD AND DATE
    public function testGetScoresSuccess() {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $scores = get_scores_per_child_and_date('PNCRCR02C13L219K', '2019-11-08', '2019-11-12', $ini_path);
        $this->assertEquals(2, count($scores));

        $this->assertTrue(in_array('6.75', $scores[0]));
        $this->assertTrue(in_array('8.00', $scores[1]));
        $this->assertFalse(in_array('7.25', $scores[0]));
        $this->assertFalse(in_array('7.25', $scores[1]));
    }
    public function testGetScoresWrongChild() {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $scores = get_scores_per_child_and_date('TEST', '2019-11-08', '2019-11-12', $ini_path);
        $this->assertEquals(0, count($scores));
    }
    public function testGetScoresFromChildWithoutScores() {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $scores = get_scores_per_child_and_date('MNDGPP04E14L219U', '2019-11-08', '2019-11-12', $ini_path);
        $this->assertEquals(0, count($scores));
    }
    public function testGetScoresWrongDate() {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $scores = get_scores_per_child_and_date('MNDGPP04E14L219U', 'TEST', 'TEST', $ini_path);
        $this->assertEquals(0, count($scores));
    }

    // GET LIST OF SUBJECTS
    public function testGetListSubjects()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $subjects = get_list_of_subjects('PNCRCR02C13L219K', $ini_path);
        $this->assertEquals(5, count($subjects));

        $this->assertTrue(in_array('Geography', $subjects));
        $this->assertTrue(in_array('History', $subjects));
        $this->assertTrue(in_array('Italian', $subjects));
        $this->assertTrue(in_array('Mathematics', $subjects));
        $this->assertTrue(in_array('Physics', $subjects));
    }
    public function testGetListSubjectsWrongStudent()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $subjects = get_list_of_subjects('TEST', $ini_path);
        $this->assertEquals(0, count($subjects));
    }

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