<?php
require_once('utility.php');
session_start();
header('Location: publish_support_material.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo 'dentro post<br>';
    
    $_FILES['userfile']['tmp_name'];
    if(isset($_POST['class_sID_ssn']) && isset($_FILES['userfile']) && is_uploaded_file($_FILES['userfile']['tmp_name']) && !empty($_POST['class_sID_ssn']) ){        

        $fields = explode("_", $_POST['class_sID_ssn']);
        $class = mySanitizeString($fields[0]);
        $subjectID = mySanitizeString($fields[1]);
        $teacher = mySanitizeString($fields[2]);        

        $_SESSION['msg_result'] = uploadSupportMaterialFile($class, $subjectID, $teacher);  

    } else {
        $_SESSION['msg_result'] = "Upload Failed.";
    }
} else {
    $_SESSION['msg_result'] = "Upload Failed.";
}
?>