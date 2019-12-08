<?php
require_once('public/utility.php');
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
        $this->assertEquals("Parent inserted successfully.", tryInsertParent( 'FPNHNQ42A28A508A','Sebastian', 'Regio','sebastian@sebastian.it', 'Sebastian1', 'PARENT', 0, $ini_path) );
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
        $this->assertEquals("Student correctly recorded.", insertStudent( 'MCHFJF54D67H431E','Ludovico', 'Rossi', 'RSSMRA70A01F205V', 'FLCRRT77B43L219Q','1A', $ini_path) );
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals("Student already exists.", insertStudent( 'MCHFJF54D67H431E','Ludovico', 'Rossi', 'RSSMRA70A01F205V', 'FLCRRT77B43L219Q','1A', $ini_path) );

    }
    //story 15
    public function testInsertNotAllowedSizeFileSupportMaterial()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals('File size is higher than 20MB.', uploadSupportMaterialFile( '1A', 1, 'C:\xampp\tmp\php4E89.tmp', 'test.pdf', 20971528, $ini_path) );
    }
    public function testInsertNotAllowedExtensionFileSupportMaterial()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals('file extension is not supported.', uploadSupportMaterialFile( '1A', 1, 'C:\xampp\tmp\php4E89.tmp', 'test.sql', 1048576, $ini_path) );
    }
    public function testInsertInvalidTmpNameSupportMaterial()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $this->assertEquals('Please retry.', uploadSupportMaterialFile( '1A', 1, 'invalidtmpfile', 'test.pdf', 1048576, $ini_path) );
    }
    public function testInsertAlreadyExistsSupportMaterial()
    {
        $ini_path = __DIR__ . '/../../config/database/database.ini';
        $db_con = connect_to_db($ini_path);
        if(!$result = mysqli_query($db_con, 'INSERT INTO SUPPORT_MATERIAL(SubjectID, Class, Date, Filename) VALUES(1, "1A", CURRENT_DATE, "test.pdf");'))
            echo 'error on testInsertAlreadyExistsSupportMaterial';
        mysqli_close($db_con);
        $this->assertEquals('File already exists, please select another one.', uploadSupportMaterialFile( '1A', 1, 'tmpfile', 'test.pdf', 1048576, $ini_path) );
    }

    

}