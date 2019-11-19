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
        $wrongSSN = "ZPPLDN04H44L219J";
        $subjectID = 4;
        $inexistentSubjectID = 10000;
        $negativeSubjectID = -2;
        $correctClass = "1A";
        $wrongClass = "1B";
        $inexistentClass = "8Z";
        $score = 6.75;
        $negativeScore = -2.25;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y'), $correctClass, $score, $ini_path);
        $this->assertEquals("Mark correctly recorded.", $result);
    }

    public function testWrongSSN(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $wrongSSN = "ZPPLDN04H44L219J";
        $subjectID = 4;
        $inexistentSubjectID = 10000;
        $negativeSubjectID = -2;
        $correctClass = "1A";
        $wrongClass = "1B";
        $inexistentClass = "8Z";
        $score = 6.75;
        $negativeScore = -2.25;
        $result = recordMark($wrongSSN, $subjectID, date('d/m/Y'), $correctClass, $score, $ini_path);
        $this->assertEquals("Mark recording failed.", $result);
    }

    public function testWrongSubjectID(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $wrongSSN = "ZPPLDN04H44L219J";
        $subjectID = 4;
        $inexistentSubjectID = 10000;
        $negativeSubjectID = -2;
        $correctClass = "1A";
        $wrongClass = "1B";
        $inexistentClass = "8Z";
        $score = 6.75;
        $negativeScore = -2.25;
        $result = recordMark($correctSSN, $inexistentSubjectID, date('d/m/Y'), $correctClass, $score, $ini_path);
        $this->assertEquals("Mark recording failed.", $result);
    }
    
    public function testNegativeSubjectID(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $wrongSSN = "ZPPLDN04H44L219J";
        $subjectID = 4;
        $inexistentSubjectID = 10000;
        $negativeSubjectID = -2;
        $correctClass = "1A";
        $wrongClass = "1B";
        $inexistentClass = "8Z";
        $score = 6.75;
        $negativeScore = -2.25;
        $result = recordMark($correctSSN, $negativeSubjectID, date('d/m/Y'), $correctClass, $score, $ini_path);
        $this->assertEquals("Mark recording failed.", $result);
    }
    
    public function testPreviousWeek(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $wrongSSN = "ZPPLDN04H44L219J";
        $subjectID = 4;
        $inexistentSubjectID = 10000;
        $negativeSubjectID = -2;
        $correctClass = "1A";
        $wrongClass = "1B";
        $inexistentClass = "8Z";
        $score = 6.75;
        $negativeScore = -2.25;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y', time()-10*24*60*60), $correctClass, $score, $ini_path);
        $this->assertEquals("Mark recording failed.", $result);
    }
    
    public function testFollowingWeek(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $wrongSSN = "ZPPLDN04H44L219J";
        $subjectID = 4;
        $inexistentSubjectID = 10000;
        $negativeSubjectID = -2;
        $correctClass = "1A";
        $wrongClass = "1B";
        $inexistentClass = "8Z";
        $score = 6.75;
        $negativeScore = -2.25;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y', time()+10*24*60*60), $correctClass, $score, $ini_path);
        $this->assertEquals("Mark recording failed.", $result);
    }
    
    public function testWrongClass(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $wrongSSN = "ZPPLDN04H44L219J";
        $subjectID = 4;
        $inexistentSubjectID = 10000;
        $negativeSubjectID = -2;
        $correctClass = "1A";
        $wrongClass = "1B";
        $inexistentClass = "8Z";
        $score = 6.75;
        $negativeScore = -2.25;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y'), $wrongClass, $score, $ini_path);
        $this->assertEquals("Mark recording failed.", $result);
    }
    
    public function testNotExistingClass(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $wrongSSN = "ZPPLDN04H44L219J";
        $subjectID = 4;
        $inexistentSubjectID = 10000;
        $negativeSubjectID = -2;
        $correctClass = "1A";
        $wrongClass = "1B";
        $inexistentClass = "8Z";
        $score = 6.75;
        $negativeScore = -2.25;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y'), $inexistentClass, $score, $ini_path);
        $this->assertEquals("Mark recording failed.", $result);
    }
    
    public function testNegativeScore(){
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $correctSSN = "MNDGPP04E14L219U";
        $wrongSSN = "ZPPLDN04H44L219J";
        $subjectID = 4;
        $inexistentSubjectID = 10000;
        $negativeSubjectID = -2;
        $correctClass = "1A";
        $wrongClass = "1B";
        $inexistentClass = "8Z";
        $score = 6.75;
        $negativeScore = -2.25;
        $result = recordMark($correctSSN, $subjectID, date('d/m/Y'), $correctClass, $negativeScore, $ini_path);
        $this->assertEquals("Mark recording failed.", $result);
    }
}

?>