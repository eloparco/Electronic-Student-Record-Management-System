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
        $this->ini_path = __DIR__ . '/../../config/database/database.ini';
    }

    protected function _after()
    {
    }

    // TRY LOGIN
    public function testTryLoginTeacher()
    {
        $this->assertEquals(LOGIN_TEACHER_OK, tryLogin('johnny@doe.it', 'a1a1a1a1', $this->ini_path));
    }
    public function testTryLoginParent()
    {
        $this->assertEquals(LOGIN_PARENT_OK, tryLogin('john@doe.it', 'pass123', $this->ini_path));
    }
    public function testTryLoginSecretaryOfficer()
    {
        $this->assertEquals(LOGIN_SECRETARY_OK, tryLogin('milo@milo.it', 'Milo1', $this->ini_path));
    }
    public function testTryLoginChangePassword()
    {
        $this->assertEquals(CHANGE_PASSWORD, tryLogin('jane@doe.it', 'pass456', $this->ini_path));
    }
    public function testTryLoginWrongEmail()
    {
        $this->assertEquals(LOGIN_NOT_MATCH, tryLogin('jane@doe.com', 'pass456', $this->ini_path));
    }
    public function testTryLoginUserNotDefined()
    {
        $this->assertEquals(LOGIN_USER_NOT_DEFINED, tryLogin('mario@rossi.it', 'Mario12', $this->ini_path));
    }

    // GET CHILDREN OF PARENT
    public function testGetChild()
    {
        $children = get_children_of_parent('r.filicaro@parent.esrmsystem.com', $this->ini_path);
        $this->assertEquals(1, count($children));

        $child = $children[0];
        $this->assertEquals(3, count($child));

        $this->assertEquals('PNCRCR02C13L219K', $child['SSN']);
        $this->assertEquals('Riccardo', $child['Name']);
        $this->assertEquals('Ponci', $child['Surname']);
    }
    public function testGetNoChild()
    {
        $children = get_children_of_parent('john@doe.it', $this->ini_path);
        $this->assertEquals(0, count($children));
    }
    public function testGetTwoChildren()
    {
        $children = get_children_of_parent('f.mandini@parent.esrmsystem.com', $this->ini_path);
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
        $children = get_children_of_parent('TEST', $this->ini_path);
        $this->assertEquals(0, count($children));
    }

    // GET SCORES PER CHILD AND DATE
    public function testGetScoresSuccess() {
        $scores = get_scores_per_child_and_date('PNCRCR02C13L219K', '2019-11-08', '2019-11-12', $this->ini_path);
        $this->assertEquals(2, count($scores));

        $this->assertTrue(in_array('6.75', $scores[0]));
        $this->assertTrue(in_array('8.00', $scores[1]));
        $this->assertFalse(in_array('7.25', $scores[0]));
        $this->assertFalse(in_array('7.25', $scores[1]));
    }
    public function testGetScoresWrongChild() {
        $scores = get_scores_per_child_and_date('TEST', '2019-11-08', '2019-11-12', $this->ini_path);
        $this->assertEquals(0, count($scores));
    }
    public function testGetScoresFromChildWithoutScores() {
        $scores = get_scores_per_child_and_date('MNDGPP04E14L219U', '2019-11-08', '2019-11-12', $this->ini_path);
        $this->assertEquals(0, count($scores));
    }
    public function testGetScoresWrongDate() {
        $scores = get_scores_per_child_and_date('MNDGPP04E14L219U', 'TEST', 'TEST', $this->ini_path);
        $this->assertEquals(0, count($scores));
    }

    // GET LIST OF SUBJECTS
    public function testGetListSubjects()
    {
        $subjects = get_list_of_subjects('PNCRCR02C13L219K', $this->ini_path);
        $this->assertEquals(5, count($subjects));

        $this->assertTrue(in_array('Geography', $subjects));
        $this->assertTrue(in_array('History', $subjects));
        $this->assertTrue(in_array('Italian', $subjects));
        $this->assertTrue(in_array('Mathematics', $subjects));
        $this->assertTrue(in_array('Physics', $subjects));
    }
    public function testGetListSubjectsWrongStudent()
    {
        $subjects = get_list_of_subjects('TEST', $this->ini_path);
        $this->assertEquals(0, count($subjects));
    }

    // RECORD TOPIC
    public function testRecordTopicSuccess()
    {
        $day_of_week = date('l', strtotime('now'));

        if ($day_of_week === "Sunday")
            $this->assertEquals(TOPIC_RECORDING_WRONG_DATE, recordTopic('1A', date('d/m/Y'), 3, 1, 'aaa111', 'Mock topic', 'Mock description', $this->ini_path));
        else
            $this->assertEquals(TOPIC_RECORDING_OK, recordTopic('1A', date('d/m/Y'), 3, 1, 'aaa111', 'Mock topic', 'Mock description', $this->ini_path));
    }
    public function testRecordTopicNonExistingClass()
    {
        $day_of_week = date('l', strtotime('now'));
        if ($day_of_week === "Sunday")
            $this->assertEquals(TOPIC_RECORDING_WRONG_DATE, recordTopic('1A', date('d/m/Y'), 3, 1, 'aaa111', 'Mock topic', 'Mock description', $this->ini_path));
        else
            $this->assertEquals(TOPIC_RECORDING_FAILED, recordTopic('ZZZ', date('d/m/Y'), 3, 1, 'aaa111', 'Mock topic', 'Mock description', $this->ini_path));
    }
    public function testRecordTopicEmptyDate()
    {
        $this->assertEquals(TOPIC_RECORDING_WRONG_DATE, recordTopic('1A', '', 3, 1, 'aaa111', 'Mock topic', 'Mock description', $this->ini_path));
    }
    public function testRecordTopicNonExistingTeacher()
    {
        $day_of_week = date('l', strtotime('now'));
        if ($day_of_week === "Sunday")
            $this->assertEquals(TOPIC_RECORDING_WRONG_DATE, recordTopic('1A', date('d/m/Y'), 3, 1, 'aaa111', 'Mock topic', 'Mock description', $this->ini_path));
        else
            $this->assertEquals(TOPIC_RECORDING_FAILED, recordTopic('1A', date('d/m/Y'), 3, 1, 'TEST', 'Mock topic', 'Mock description', $this->ini_path));
    }
    public function testRecordTopicDateTooOld()
    {
        $this->assertEquals(TOPIC_RECORDING_WRONG_DATE, recordTopic('1A', '01/01/1996', 3, 1, 'aaa111', 'Mock topic', 'Mock description', $this->ini_path));
    }

    // GET ATTENDANCE
    public function testGetAttendance() {
        $attendances = get_attendance('PNCRCR02C13L219K', $this->ini_path);

        $expected = array();
        $expected[] = array(
            'StudentSSN' => 'PNCRCR02C13L219K',
            'Date' => '2019-11-07',
            'Presence' => '1_HOUR_LATE',
            'ExitHour' => 3
        );
        $expected[] = array(
            'StudentSSN' => 'PNCRCR02C13L219K',
            'Date' => '2019-11-13',
            'Presence' => 'ABSENT',
            'ExitHour' => 6
        );
        $expected[] = array(
            'StudentSSN' => 'PNCRCR02C13L219K',
            'Date' => '2019-11-18',
            'Presence' => '10_MIN_LATE',
            'ExitHour' => 6
        );

        // check if the entries are the expected ones
        $this->assertEquals(3, count($attendances));
        $this->assertTrue(in_array($attendances[0], $expected));
        $this->assertTrue(in_array($attendances[1], $expected));
        $this->assertTrue(in_array($attendances[2], $expected));
    }
    public function testGetAttendanceFakeSSN() {
        $attendances = get_attendance('FAKE_SSN', $this->ini_path);
        $this->assertEquals(0, count($attendances));
    }

    public function testTryInsertAccount() {
        $this->assertEquals(INSERT_ACCOUNT_OK, 
            tryInsertAccount('LNGMRNKKK51L219R', 'NameTest', 'SurnameTest', 'test@test.tt', 'Test99', 'TEACHER', 1, $this->ini_path));            
    }
    public function testTryInsertAccountRoleTaken() {
        $this->assertEquals(ROLE_ALREADY_TAKEN, 
        tryInsertAccount('FLCRRT77B43L219Q', 'NameTest', 'SurnameTest', 'test@test.tt', 'Test99', 'PARENT', 1, $this->ini_path));
    }
    public function testTryInsertAccountOk() {
        $this->assertEquals(UPDATE_ACCOUNT_OK, 
        tryInsertAccount('FLCRRT77B43L219Q', 'NameTest', 'SurnameTest', 'test@test.tt', 'Test99', 'TEACHER', 1, $this->ini_path));
    }
    public function testTryInsertAccountRoleNotAllowed() {
        $this->assertEquals(ROLE_NOT_ALLOWED, 
        tryInsertAccount('LNGMRN58M51L219R', 'NameTest', 'SurnameTest', 'test@test.tt', 'Test99', 'SECRETARY_OFFICER', 1, $this->ini_path));
    }
    public function testTryInsertAccountOk2() {
        $this->assertEquals(UPDATE_ACCOUNT_OK, 
        tryInsertAccount('FLCRRT77B43L219Q', 'NameTest', 'SurnameTest', 'test@test.tt', 'Test99', 'PRINCIPAL', 1, $this->ini_path));
    }
    public function testTryInsertAccountMaxRoles() {
        $this->assertEquals(UPDATE_ACCOUNT_OK, 
        tryInsertAccount('FLCRRT77B43L219Q', 'NameTest', 'SurnameTest', 'test@test.tt', 'Test99', 'TEACHER', 1, $this->ini_path));
        $this->assertEquals(UPDATE_ACCOUNT_OK, 
        tryInsertAccount('FLCRRT77B43L219Q', 'NameTest', 'SurnameTest', 'test@test.tt', 'Test99', 'PRINCIPAL', 1, $this->ini_path));
        $this->assertEquals(MAX_ROLES_ALLOWED, 
        tryInsertAccount('FLCRRT77B43L219Q', 'NameTest', 'SurnameTest', 'test@test.tt', 'Test99', 'SECRETARY_OFFICER', 1, $this->ini_path));
    }

    // GET LIST OF CLASSES
    public function testGetClassList() {
        $classes = get_list_of_classes($this->ini_path);
        $this->assertEquals(2, count($classes));
        $this->assertTrue(in_array("1A", $classes));
        $this->assertTrue(in_array("1B", $classes));
    }

    // INSERT TIMETABLE
    public function testInsertTimetable() {
        $subjects = array(
            array("Mathematics", "History", "Italian", "English", "Physics"),
            array("Italian", "Italian", "Italian", "History", "Gym"),
            array("Art", "English", "English", "Mathematics", "Latin"),
            array("Latin", "Gym", "Science", "Mathematics", "Science"),
            array("Latin", "Mathematics", "Latin", "Religion", "Mathematics"),
            array("-", "Physics",  "-", "-", "Art")
        );

        $this->assertEquals(PUBLISH_TIMETABLE_OK, insert_timetable("1A", $subjects, $this->ini_path));
    }
    public function testInsertTimetableNonExistingClass() {
        $subjects = array(
            array("Mathematics", "History", "Italian", "English", "Physics"),
            array("Italian", "Italian", "Italian", "History", "Gym"),
            array("Art", "English", "English", "Mathematics", "Latin"),
            array("Latin", "Gym", "Science", "Mathematics", "Science"),
            array("Latin", "Mathematics", "Latin", "Religion", "Mathematics"),
            array("-", "Physics",  "-", "-", "Art")
        );

        $this->assertEquals(DB_QUERY_ERROR, insert_timetable("7FAKE", $subjects, $this->ini_path));
    }
    public function testInsertTimetableNonExistingSubject() {
        $subjects = array(
            array("FakeSubject", "History", "Italian", "English", "Physics")
        );

        $this->assertEquals(SUBJECT_INCORRECT, insert_timetable("1A", $subjects, $this->ini_path));
    }

    // GET STUDENT NOTES
    public function testGetStudentNotes() {
        $notes = get_list_of_student_notes('PNCRCR02C13L219K', $this->ini_path);
        $this->assertEquals(2, count($notes));

        $notes_in_db = array(
            array(
                'SubjectName' => 'Mathematics',
                'Date' => '2019-12-15'
            ),
            array(
                'SubjectName' => 'Italian',
                'Date' => '2019-12-17'
            )
        );

        // check if first entry id notes_in_db is present
        $this->assertTrue(in_array($notes_in_db[0]['SubjectName'], $notes[0]) ||
                                in_array($notes_in_db[0]['SubjectName'], $notes[1]));
        $this->assertTrue(in_array($notes_in_db[0]['Date'], $notes[0]) ||
                                in_array($notes_in_db[0]['Date'], $notes[1]));

        // check if second entry id notes_in_db is present
        $this->assertTrue(in_array($notes_in_db[1]['SubjectName'], $notes[0]) ||
                                in_array($notes_in_db[1]['SubjectName'], $notes[1]));
        $this->assertTrue(in_array($notes_in_db[1]['Date'], $notes[0]) ||
                                in_array($notes_in_db[1]['Date'], $notes[1]));
    }
    // get notes from a student without notes
    public function testGetStudentNoNotes() {
        $notes = get_list_of_student_notes('AAABBBCCC1234567', $this->ini_path);
        $this->assertEquals(0, count($notes));
    }
    public function testGetStudentNotesNonExistingStudent() {
        $notes = get_list_of_student_notes('FakeSSN', $this->ini_path);
        $this->assertEquals(0, count($notes));
    }
}