<?php
require_once('utility.php');
session_start();
header('Location: assignment_recording.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['class_sID_ssn']) && isset($_POST['date']) && isset($_POST['title']) && isset($_POST['subtitle']) && 
    !empty($_POST['class_sID_ssn']) && !empty($_POST['date'])  && !empty($_POST['title']) && !empty($_POST['subtitle'])){

        if(isset($_FILES['file'])){
            // Get file data
            $file_name = $_FILES['file']['name'];
            $file_size =$_FILES['file']['size'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));

            // Uncomment for debug
            // $_SESSION['msg_result'] = "DEBUG: filename: ".$file_name." File size: ".$file_size." file tmp: ".file_tmp." file type: ".$file_type." file ext: ".$file_ext;
            // die();

            // Supported extension
            $extensions= array("jpeg","jpg","png", "pdf", "md", "txt", "ods");

            if(in_array($file_ext,$extensions) === false){
                $_SESSION['msg_result'] = WRONG_FILE_EXTENSION.". .".$file_ext." files are not allowed.";
                die();
             }

             if($file_size > 2097152){
                $_SESSION['msg_result'] = FILE_TOO_BIG;
                die();
             }

             
             if (file_exists($file_name)) {
                $_SESSION['msg_result'] = FILE_ALREADY_EXISTS;
                die();
            }

            move_uploaded_file($file_tmp,"./uploads/".$file_name);
            
            $_SESSION['msg_result'] = "File uploaded, path: /upload/".$_FILES["file"]["name"];
            die();
        }

        $fields = explode("_", $_POST['class_sID_ssn']);
        
        $class = $fields[0];
        $subjectID = $fields[1];
        $teacher = $fields[2];

        $date =$_POST['date'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];

        // TODO: Add to utility
        // $retval = recordAssignment();

        $_SESSION['msg_result'] = $retval;

    } else {
        $_SESSION['msg_result'] = ASSIGNMENT_RECORDING_INCORRECT;
    }
} else {
    $_SESSION['msg_result'] = ASSIGNMENT_RECORDING_FAILED;
}
?>