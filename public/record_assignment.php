<?php
require_once('utility.php');
session_start();
header('Location: assignment_recording.php');
define("CLASS_SID_SSN", "class_sID_ssn");
define("SUBTITLE", "subtitle");
define("TITLE", "title");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST[CLASS_SID_SSN]) && isset($_POST['date']) && isset($_POST[TITLE]) && isset($_POST[SUBTITLE]) && 
    !empty($_POST[CLASS_SID_SSN]) && !empty($_POST['date'])  && !empty($_POST[TITLE]) && !empty($_POST[SUBTITLE])){

        if(isset($_FILES['file']) && !empty(strtolower(end(explode('.',$_FILES['file']['name']))))){
            // Get file data
            $file_name = mySanitizeString($_FILES['file']['name']);
            $file_size = mySanitizeString($_FILES['file']['size']);
            $file_tmp = mySanitizeString($_FILES['file']['tmp_name']);
            $file_type = mySanitizeString($_FILES['file']['type']);
            $file_ext=strtolower(end(explode('.',mySanitizeString($_FILES['file']['name']))));

            // Supported extension
            $extensions= array("jpeg","jpg","png", "pdf", "md", "txt", "ods");

            if(in_array($file_ext,$extensions) === false){
                $_SESSION[MSG] = WRONG_FILE_EXTENSION.". .".$file_ext." files are not allowed.";
                die();
             }

             if($file_size > 2097152){
                $_SESSION[MSG] = FILE_TOO_BIG;
                die();
             }

             
             if (file_exists($file_name)) {
                $_SESSION[MSG] = FILE_ALREADY_EXISTS;
                die();
            }

            $uploaded = move_uploaded_file($file_tmp,UPLOAD_PATH.$file_name);

            if(!$uploaded){
                $_SESSION[MSG] = "Error moving: ".$file_tmp." to ".UPLOAD_PATH.$file_name;
                die();
            }

            $fields = explode("_", $_POST[CLASS_SID_SSN]);
            
            $class = $fields[0];
            $subjectID = $fields[1];
            $teacher = $fields[2];

            $date =$_POST['date'];
            $title = $_POST[TITLE];
            $subtitle = $_POST[SUBTITLE];
            $attachment = "uploads/".$_FILES["file"]["name"];

            $retval = recordAssignment($class, $subjectID, $date, $title, $subtitle, $attachment);

            $_SESSION[MSG] = $retval;

            die();
        } else {
            $fields = explode("_", $_POST[CLASS_SID_SSN]);
            
            $class = $fields[0];
            $subjectID = $fields[1];
            $teacher = $fields[2];

            $date =$_POST['date'];
            $title = $_POST[TITLE];
            $subtitle = $_POST[SUBTITLE];
            $attachment = "NULL";

            $retval = recordAssignment($class, $subjectID, $date, $title, $subtitle, $attachment);

            $_SESSION[MSG] = $retval;
        }

    } else {
        $_SESSION[MSG] = ASSIGNMENT_RECORDING_INCORRECT;
    }
} else {
    $_SESSION[MSG] = ASSIGNMENT_RECORDING_FAILED;
}
?>