<?php

class insertParentStudentTest extends \Codeception\Test\Unit
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

    // tests
    //WARNING: to test db function is needed to change path: "$db = parse_ini_file("../config/database/database.ini");" used by connect_to_db() in utility.php because tests are not in /public directory
    public function testTryInsertParent()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals("Parent inserted successfully.", tryInsertParent( 'FPNHNQ42A28A508A','Sebastian', 'Regio','sebastian@sebastian.it', 'Sebastian1', 'PARENT', 0, $ini_path) );
    }
    public function testTryInsertParentDuplicate()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals("SSN already exists.", tryInsertParent( 'FPNHNQ42A28A508A','Sebastian', 'Regio','sebastian@sebastian.it', 'Sebastian1', 'PARENT', 0, $ini_path) );

    }
    public function testInsertStudent()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals("Student correctly recorded.", insertStudent( 'MCHFJF54D67H431E','Ludovico', 'Rossi', 'RSSMRA70A01F205V', 'FLCRRT77B43L219Q','1A', $ini_path) );

    }
    public function testInsertStudentDuplicate()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals("Student already exists.", insertStudent( 'MCHFJF54D67H431E','Ludovico', 'Rossi', 'RSSMRA70A01F205V', 'FLCRRT77B43L219Q','1A', $ini_path) );

    }
}