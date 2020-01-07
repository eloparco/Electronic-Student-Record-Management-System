<?php
require_once('public/utility.php');

class StudentGradeTest extends \Codeception\Test\Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before(){
        
    }
    protected function _after(){

    }

    public function testCorrectArguments(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $subjectID = 4;
        $correctClass = "1A";
        $score = 6.75;
        $today = date('l');
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y'), $correctClass, $score, $ini_path);
        if($today !== 'Sunday'){
            $this->assertEquals(MARK_RECORDING_OK, $result);
        } else {
            $this->assertEquals(MARK_RECORDING_FAILED, $result);
        }
    }

    public function testWrongSSN(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $wrongSSN = "ZPPLDN04H44L219J";
        $subjectID = 4;
        $correctClass = "1A";
        $score = 6.75;
        $result = recordMark($wrongSSN, $subjectID, date('d/m/Y'), $correctClass, $score, $ini_path);
        $this->assertEquals(MARK_RECORDING_FAILED, $result);
    }

    public function testWrongSubjectID(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $inexistentSubjectID = 10000;
        $correctClass = "1A";
        $score = 6.75;
        $result = recordMark($correctSSN, $inexistentSubjectID, date('d/m/Y'), $correctClass, $score, $ini_path);
        $this->assertEquals(MARK_RECORDING_FAILED, $result);
    }
    
    public function testNegativeSubjectID(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $negativeSubjectID = -2;
        $correctClass = "1A";
        $score = 6.75;
        $result = recordMark($correctSSN, $negativeSubjectID, date('d/m/Y'), $correctClass, $score, $ini_path);
        $this->assertEquals(MARK_RECORDING_FAILED, $result);
    }
    
    public function testPreviousWeek(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $subjectID = 4;
        $correctClass = "1A";
        $score = 6.75;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y', time()-10*24*60*60), $correctClass, $score, $ini_path);
        $this->assertEquals(MARK_RECORDING_FAILED, $result);
    }
    
    public function testFollowingWeek(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $subjectID = 4;
        $correctClass = "1A";
        $score = 6.75;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y', time()+10*24*60*60), $correctClass, $score, $ini_path);
        $this->assertEquals(MARK_RECORDING_FAILED, $result);
    }
    
    public function testWrongClass(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $subjectID = 4;
        $wrongClass = "1C";
        $score = 6.75;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y'), $wrongClass, $score, $ini_path);
        $this->assertEquals(MARK_RECORDING_FAILED, $result);
    }
    
    public function testNotExistingClass(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $subjectID = 4;
        $inexistentClass = "8Z";
        $score = 6.75;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y'), $inexistentClass, $score, $ini_path);
        $this->assertEquals(MARK_RECORDING_FAILED, $result);
    }
    
    public function testNegativeScore(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $subjectID = 4;
        $correctClass = "1A";
        $negativeScore = -2.25;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y'), $correctClass, $negativeScore, $ini_path);
        $this->assertEquals(MARK_RECORDING_FAILED, $result);
    }
}

?>