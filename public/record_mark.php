<?php
require_once('utility.php');
session_start();
header('Location: mark_recording.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['action']) && !empty($_POST['action'])){

        if($_POST['action'] =='record'){
            $teacher = $_POST['user_mail']; // Teacher mail

            $retval = getTeacherClasses($teacher);
            // $_SESSION['msg_result'] = $class." ".$date." ".$hour." ".$subjectID." ".$teacher." ".$title." ".$subtitle;
            $_SESSION['msg_result'] = json.encode($retval);
        }
        
    } else {
        $_SESSION['msg_result'] = TOPIC_RECORDING_INCORRECT;
    }
} else {
    $_SESSION['msg_result'] = TOPIC_RECORDING_FAILED;
}
?>