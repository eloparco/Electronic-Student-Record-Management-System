<?php
require_once('public/utility.php');

class NoteRecordingTest extends \Codeception\Test\Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before(){
        $this->ini_path = __DIR__ . '/../../config/database/database.ini';
    }
    public function _after(){

    }

    public function testNoteRecordingCorrectParams(){
        $student = "PNCRCR02C13L219K";
        $subjectID = 5;
        $actualDate = date('d/m/Y');
        $description = "A small description for a student note.\n";
        $result = recordNote($student, $subjectID, $actualDate, $description, $this->ini_path);
        codecept_debug($result);
        $this->assertStringStartsWith(NOTE_RECORDING_OK, $result);
    }

    public function testNoteRecordingNotExistingStudent(){
        $student = "ZZZYYY02C13L219K";
        $subjectID = 5;
        $actualDate = date('d/m/Y');
        $description = "A small description for a student note.\n";
        $result = recordNote($student, $subjectID, $actualDate, $description, $this->ini_path);
        codecept_debug($result);
        $this->assertStringStartsWith(NOTE_RECORDING_FAILED, $result);
    }

    public function testNoteRecordingNotExistingSubject(){
        $student = "PNCRCR02C13L219K";
        $subjectID = -3;
        $actualDate = date('d/m/Y');
        $description = "A small description for a student note.\n";
        $result = recordNote($student, $subjectID, $actualDate, $description, $this->ini_path);
        codecept_debug($result);
        $this->assertStringStartsWith(NOTE_RECORDING_FAILED, $result);
    }

    public function testNoteRecordingWrongFormattedDate(){
        $student = "PNCRCR02C13L219K";
        $subjectID = 5;
        $actualDate = date('Y-m-d');
        $description = "A small description for a student note.\n";
        $result = recordNote($student, $subjectID, $actualDate, $description, $this->ini_path);
        codecept_debug($result);
        $this->assertStringStartsWith(NOTE_RECORDING_FAILED, $result);
    }

    public function testNoteRecordingWithEmptyDescription(){
        $student = "PNCRCR02C13L219K";
        $subjectID = 5;
        $actualDate = date('d/m/Y');
        $description = "";
        $result = recordNote($student, $subjectID, $actualDate, $description, $this->ini_path);
        codecept_debug($result);
        $this->assertStringStartsWith(NOTE_RECORDING_FAILED, $result);
    }
}

?>