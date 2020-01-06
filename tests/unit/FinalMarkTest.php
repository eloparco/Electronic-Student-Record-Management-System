<?php
require_once('public/utility.php');

class FinalMarkTest extends \Codeception\Test\Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before(){
        $this->ini_path = __DIR__ . '/../../config/database/database.ini';
    }

    public function _after(){

    }

    // UNIT tests on isCoordinator
    public function testValidCoordinator(){
        $teacher = "g.barbero@esrmsystem.com";
        $result = isCoordinator($teacher, $this->ini_path);
        $this->assertTrue($result);
    }

    public function testNotACoordinator(){
        $teacher = "m.longobardi@esrmsystem.com";
        $result = isCoordinator($teacher, $this->ini_path);
        $this->assertFalse($result);
    }

    public function testNotATeacher(){
        $teacher = "pippo@pareino.com";
        $result = isCoordinator($teacher, $this->ini_path);
        $this->assertFalse($result);
    }
    // END isCoordinator

    // UNIT tests on getCoordinatorSubject
    public function testNumberSubjectsOfClass1A(){
        $teacher = "g.barbero@esrmsystem.com";
        $result = getCoordinatorSubject($teacher, $this->ini_path);
        $this->assertTrue(is_array($result));
        $this->assertGreaterThanOrEqual(3, count($result));
    }

    public function testNumberSubjectsOfClass1B(){
        $teacher = "t.fanelli@esrmsystem.com";
        $result = getCoordinatorSubject($teacher, $this->ini_path);
        $this->assertTrue(is_array($result));
        $this->assertGreaterThanOrEqual(1, count($result));
    }

    public function testNotACoordinatorSubjects(){
        $teacher = "m.longobardi@esrmsystem.com";
        $result = getCoordinatorSubject($teacher, $this->ini_path);
        $this->assertTrue(is_array($result));
        $this->assertTrue(empty($result));
    }

    public function testNotATeacherSubjects(){
        $teacher = "pippo@paperino.com";
        $result = getCoordinatorSubject($teacher, $this->ini_path);
        $this->assertTrue(is_array($result));
        $this->assertTrue(empty($result));
    }
    // END getCoordinatorSubject

    // UNIT tests on recordFinalMark
    public function testFinalMarkCorrectParams(){
        $child = "MNDGPP04E14L219U";
        $subjectId = 2;
        $finalMark = 8;
        $result = recordFinalMark($child, $subjectId, $finalMark, $this->ini_path);
        $this->assertStringStartsWith(MARK_RECORDING_OK, $result);
    }

    public function testFinalMarkNotAStudent(){
        $child = "MNDFPP68C16L219N";
        $subjectId = 2;
        $finalMark = 8;
        $result = recordFinalMark($child, $subjectId, $finalMark, $this->ini_path);
        $this->assertStringStartsWith(MARK_RECORDING_FAILED, $result);
    }

    public function testFinalMarkNotExistingSubject(){
        $child = "MNDGPP04E14L219U";
        $subjectId = -2;
        $finalMark = 8;
        $result = recordFinalMark($child, $subjectId, $finalMark, $this->ini_path);
        $this->assertStringStartsWith(MARK_RECORDING_FAILED, $result);
    }

    public function testFinalMarkNotAValidMark(){
        $child = "MNDGPP04E14L219U";
        $subjectId = 2;
        $finalMark = 7.5;
        $result = recordFinalMark($child, $subjectId, $finalMark, $this->ini_path);
        $this->assertStringStartsWith(MARK_RECORDING_FAILED, $result);
    }

    public function testFinalMarkOutOfRangeMark(){
        $child = "MNDGPP04E14L219U";
        $subjectId = 2;
        $finalMark = 12;
        $result = recordFinalMark($child, $subjectId, $finalMark, $this->ini_path);
        $this->assertStringStartsWith(MARK_RECORDING_FAILED, $result);
        $finalMark = -3;
        $result = recordFinalMark($child, $subjectId, $finalMark, $this->ini_path);
        $this->assertStringStartsWith(MARK_RECORDING_FAILED, $result);
    }
    // END recordFinalMark
}
?>