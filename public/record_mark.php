<?php
require_once('utility.php');
session_start();
/* LOGGED IN CHECK */
if(!userTypeLoggedIn('TEACHER')) {   
    myRedirectTo('login.php', 'SessionTimeOut');
    exit;
}
header('Location: mark_recording.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['class_sID_ssn']) && isset($_POST['date']) && isset($_POST['hour']) && isset($_POST['student']) 
        && isset($_POST['score']) && isset($_POST['decimalMarkValue']) && !empty($_POST['class_sID_ssn']) && 
        !empty($_POST['date']) && !empty($_POST['hour']) && !empty($_POST['student']) && !empty($_POST['score'])){

        $fields = explode("_", $_POST['class_sID_ssn']);
        $class = $fields[0];
        $subjectID = $fields[1];

        $date =$_POST['date']; 
        $hour = $_POST['hour'];

        $student = $_POST['student'];
        $score = $_POST['score'];

        //add decimal value to score
        if(empty($_POST['decimalMarkValue'])) 
            $decimalMark = "0";
        $decimalMark = $_POST['decimalMarkValue'];
        $score = $score.substr($decimalMark, 1); //remove '0' from '0.25' -> .25

        $retval = recordMark($student, $subjectID, $date, $class, $score);
        
        $_SESSION['msg_result'] = $retval;

    } else {
        $_SESSION['msg_result'] = MARK_RECORDING_FAILED;
    }
} else {
    $_SESSION['msg_result'] = MARK_RECORDING_FAILED;
}
?>