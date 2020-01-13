<?php
require_once('utility.php');
session_start();
define("TEMP_NAME", "tmp_name");
define("USER_FILE", "userfile");
define("FILE_DATA_LABEL", "class_sID_ssn");

header('Location: publish_support_material.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo 'dentro post<br>';
    
    $_FILES[USER_FILE][TEMP_NAME];
    if(isset($_POST[FILE_DATA_LABEL]) && isset($_FILES[USER_FILE]) && is_uploaded_file($_FILES[USER_FILE][TEMP_NAME]) && !empty($_POST[FILE_DATA_LABEL]) ){        

        $fields = explode("_", $_POST[FILE_DATA_LABEL]);
        $class = mySanitizeString($fields[0]);
        $subjectID = mySanitizeString($fields[1]);

        //Get the temporary filename
        $userfile_tmp = mySanitizeString($_FILES[USER_FILE][TEMP_NAME]);

        //Get Original filename
        $userfile_name = mySanitizeString($_FILES[USER_FILE]['name']);

        //Get File Size
        $file_size = $_FILES[USER_FILE]['size'];

        $_SESSION[MSG] = uploadSupportMaterialFile($class, $subjectID, $userfile_tmp, $userfile_name, $file_size);  

    } else {
        $_SESSION[MSG] = "Upload Failed.";
    }
} else {
    $_SESSION[MSG] = "Upload Failed.";
}
?>