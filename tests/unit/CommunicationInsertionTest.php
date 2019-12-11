<?php
require_once('public/utility.php');

class CommunicationInsertionTest extends \Codeception\Test\Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before(){
        $this->ini_path = __DIR__ . '/../../config/database/database.ini';
    }

    public function _after(){

    }

    public function testCommCorrectParams(){
        $title = "Official school communication in date " . date('j F Y');
        $description = "First school communication to parents and teachers of the day " . date('j F Y');
        $result = recordCommunication($title, $description, $this->ini_path);
        $this->assertEquals(COMMUNICATION_RECORDING_OK, $result);
    }

    public function testCommMissingTitle(){
        $title = "";
        $description = "First school communication to parents and teachers of the day " . date('j F Y');
        $result = recordCommunication($title, $description, $this->ini_path);
        $this->assertStringStartsWith(COMMUNICATION_RECORDING_FAILED, $result);
    }

    public function testCommMissingDescription(){
        $title = "Official school communication in date " . date('j F Y');
        $description = "";
        $result = recordCommunication($title, $description, $this->ini_path);
        $this->assertStringStartsWith(COMMUNICATION_RECORDING_FAILED, $result);
    }
}

?>