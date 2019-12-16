<?php
require_once('public/utility.php');

class AttendanceTest extends \Codeception\Test\Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before(){
        $this->ini_path = __DIR__ . '/../../config/database/database.ini';
    }

    public function _after(){

    }

    public function testAllowedEarlyExit(){
        $child = 'MNDGPP04E14L219U';
        $date = date('Y-m-d');
        $hour = 5;
        $result = register_early_exit($child, $date, $hour, $this->ini_path);
        $this->assertTrue(is_bool($result) && $result);
    }

    public function testNegativeEarlyExit(){
        $child = 'MNDGPP04E14L219U';
        $date = date('Y-m-d');
        $hour = -1;
        $result = register_early_exit($child, $date, $hour, $this->ini_path);
        $this->assertTrue(is_string($result));
        $this->assertStringStartsWith('Exit hour', $result);
    }

    public function testHighEarlyExit(){
        $child = 'MNDGPP04E14L219U';
        $date = date('Y-m-d');
        $hour = 8;
        $result = register_early_exit($child, $date, $hour, $this->ini_path);
        $this->assertTrue(is_string($result));
        $this->assertStringStartsWith('Exit hour', $result);
    }

    public function testPreviousDay(){
        $child = 'MNDGPP04E14L219U';
        $date = date('Y-m-d', time()-24*60*60);
        $hour = 4;
        $result = register_early_exit($child, $date, $hour, $this->ini_path);
        $this->assertTrue(is_string($result));
        $this->assertStringStartsWith('Cannot register early exits on a different day than today.', $result);
    }

    public function testFollowingDay(){
        $child = 'MNDGPP04E14L219U';
        $date = date('Y-m-d', time()+24*60*60);
        $hour = 4;
        $result = register_early_exit($child, $date, $hour, $this->ini_path);
        $this->assertTrue(is_string($result));
        $this->assertStringStartsWith('Cannot register early exits on a different day than today.', $result);
    }

    public function testWrongChild(){
        $child = 'WRXBTR27A16H453X';
        $date = date('Y-m-d');
        $hour = 5;
        $result = register_early_exit($child, $date, $hour, $this->ini_path);
        $this->assertTrue(is_string($result));
    }

    public function testEmptyChild(){
        $child = '';
        $date = date('Y-m-d');
        $hour = 3;
        $result = register_early_exit($child, $date, $hour, $this->ini_path);
        $this->assertTrue(is_string($result));
        $this->assertStringStartsWith('Parameter missing', $result);
    }

    public function testEmptyDate(){
        $child = 'WRXBTR27A16H453X';
        $date = '';
        $hour = 3;
        $result = register_early_exit($child, $date, $hour, $this->ini_path);
        $this->assertTrue(is_string($result));
        $this->assertStringStartsWith('Parameter missing', $result);
    }

    public function testEmptyHour(){
        $child = 'WRXBTR27A16H453X';
        $date = date('Y-m-d');
        $hour = null;
        $result = register_early_exit($child, $date, $hour, $this->ini_path);
        $this->assertTrue(is_string($result));
        $this->assertStringStartsWith('Parameter missing', $result);
    }
}

?>