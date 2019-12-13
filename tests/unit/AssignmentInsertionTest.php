<?php
require_once('public/utility.php');

class AssignmentInsertionTest extends \Codeception\Test\Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before(){
        $this->ini_path = __DIR__ . '/../../config/database/database.ini';
    }

    public function _after(){

    }

    public function testAssignmentCorrectParams(){
        $class = "1A";
        $subjectId = 4;
        $deadline = date('Y-m-d', time()+7*24*60*60);
        $title = "Next lecture homeworks";
        $description = "Read the document in attachment and provide a brief report about its content.";
        $attachment = "uploads/temp.pdf";
        $result = recordAssignment($class, $subjectId, $deadline, $title, $description, $attachment, $this->ini_path);
        $this->assertStringStartsWith(ASSIGNMENT_RECORDING_OK, $result);
    }

    public function testAssignmentWrongClass(){
        $class = "7Q";
        $subjectId = 4;
        $deadline = date('Y-m-d', time()+7*24*60*60);
        $title = "Next lecture homeworks";
        $description = "Read the document in attachment and provide a brief report about its content.";
        $attachment = "uploads/temp.pdf";
        $result = recordAssignment($class, $subjectId, $deadline, $title, $description, $attachment, $this->ini_path);
        $this->assertStringStartsWith(ASSIGNMENT_RECORDING_FAILED, $result);
    }

    public function testAssignmentWrongSubject(){
        $class = "1A";
        $subjectId = -5;
        $deadline = date('Y-m-d', time()+7*24*60*60);
        $title = "Next lecture homeworks";
        $description = "Read the document in attachment and provide a brief report about its content.";
        $attachment = "uploads/temp.pdf";
        $result = recordAssignment($class, $subjectId, $deadline, $title, $description, $attachment, $this->ini_path);
        $this->assertStringStartsWith(ASSIGNMENT_RECORDING_FAILED, $result);
    }

    public function testAssignmentDateBeforeToday(){
        $class = "1A";
        $subjectId = 4;
        $deadline = date('Y-m-d', time()-7*24*60*60);
        $title = "Next lecture homeworks";
        $description = "Read the document in attachment and provide a brief report about its content.";
        $attachment = "uploads/temp.pdf";
        $result = recordAssignment($class, $subjectId, $deadline, $title, $description, $attachment, $this->ini_path);
        $this->assertStringStartsWith(ASSIGNMENT_RECORDING_FAILED, $result);
    }
}

?>