<?php
require_once('public/utility.php');

class AssignmentTest extends \Codeception\Test\Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before(){
        $this->ini_path = __DIR__ . '/../../config/database/database.ini';
    }

    public function _after(){

    }

    public function testInsertAssignmentCorrectParams(){
        $class = "1A";
        $subjectId = 4;
        $deadline = date('Y-m-d', time()+7*24*60*60);
        $title = "Next lecture homeworks";
        $description = "Read the document in attachment and provide a brief report about its content.";
        $attachment = "uploads/temp.pdf";
        $result = recordAssignment($class, $subjectId, $deadline, $title, $description, $attachment, $this->ini_path);
        $this->assertStringStartsWith(ASSIGNMENT_RECORDING_OK, $result);
    }

    public function testInsertAssignmentWrongClass(){
        $class = "7Q";
        $subjectId = 4;
        $deadline = date('Y-m-d', time()+7*24*60*60);
        $title = "Next lecture homeworks";
        $description = "Read the document in attachment and provide a brief report about its content.";
        $attachment = "uploads/temp.pdf";
        $result = recordAssignment($class, $subjectId, $deadline, $title, $description, $attachment, $this->ini_path);
        $this->assertStringStartsWith(ASSIGNMENT_RECORDING_FAILED, $result);
    }

    public function testInsertAssignmentWrongSubject(){
        $class = "1A";
        $subjectId = -5;
        $deadline = date('Y-m-d', time()+7*24*60*60);
        $title = "Next lecture homeworks";
        $description = "Read the document in attachment and provide a brief report about its content.";
        $attachment = "uploads/temp.pdf";
        $result = recordAssignment($class, $subjectId, $deadline, $title, $description, $attachment, $this->ini_path);
        $this->assertStringStartsWith(ASSIGNMENT_RECORDING_FAILED, $result);
    }

    public function testInsertAssignmentDateBeforeToday(){
        $class = "1A";
        $subjectId = 4;
        $deadline = date('Y-m-d', time()-7*24*60*60);
        $title = "Next lecture homeworks";
        $description = "Read the document in attachment and provide a brief report about its content.";
        $attachment = "uploads/temp.pdf";
        $result = recordAssignment($class, $subjectId, $deadline, $title, $description, $attachment, $this->ini_path);
        $this->assertStringStartsWith(ASSIGNMENT_RECORDING_FAILED, $result);
    }

    public function testChildWithAssignments(){
        $child = 'PNCRCR02C13L219K';
        $result = get_assignment_of_child($child, $this->ini_path);
        $this->assertTrue(is_array($result));
        $this->assertTrue(!empty($result));
    }

    public function testChildWithoutAssignments(){
        $child = 'BRBSMN04A24L219R';
        $result = get_assignment_of_child($child, $this->ini_path);
        $this->assertTrue(is_array($result) && empty($result));
    }

    public function testEmptyChild(){
        $child = '';
        $result = get_assignment_of_child($child, $this->ini_path);
        $this->assertTrue(is_string($result));
        $this->assertStringStartsWith('Child SSN cannot be empty', $result);
    }

    public function testNonExistingChild(){
        $child = 'FHGPHX28P21E608Q';
        $result = get_assignment_of_child($child, $this->ini_path);
        codecept_debug($result);
        $this->assertTrue(is_array($result) && empty($result));
    }
}

?>