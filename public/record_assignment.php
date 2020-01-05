<?php
require_once('utility.php');
session_start();
header('Location: assignment_recording.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['class_sID_ssn']) && isset($_POST['date']) && isset($_POST['title']) && isset($_POST['subtitle']) && 
    !empty($_POST['class_sID_ssn']) && !empty($_POST['date'])  && !empty($_POST['title']) && !empty($_POST['subtitle'])){

        if(isset($_FILES['file']) && !empty(strtolower(end(explode('.',$_FILES['file']['name']))))){
            // Get file data
            $file_name = mySanitizeString($_FILES['file']['name']);
            $file_size =$_FILES['file']['size'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));

            // Uncomment for debug
            // $_SESSION[MSG] = "DEBUG: filename: ".$file_name." File size: ".$file_size." file tmp: ".file_tmp." file type: ".$file_type." file ext: ".$file_ext;
            // die();

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
                // $_SESSION[MSG] = FILE_UPLOAD_ERROR. " File: ".$file_name." uploading failed. ";
                die();
            }
            //copy($file_tmp, PATH_UPLOADS.$file_name);

            $fields = explode("_", $_POST['class_sID_ssn']);
            
            $class = $fields[0];
            $subjectID = $fields[1];
            $teacher = $fields[2];

            $date =$_POST['date'];
            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];
            $attachment = "uploads/".$_FILES["file"]["name"];

            $retval = recordAssignment($class, $subjectID, $date, $title, $subtitle, $attachment);

            $_SESSION[MSG] = $retval;

            die();
        } else {
            $fields = explode("_", $_POST['class_sID_ssn']);
            
            $class = $fields[0];
            $subjectID = $fields[1];
            $teacher = $fields[2];

            $date =$_POST['date'];
            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];
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