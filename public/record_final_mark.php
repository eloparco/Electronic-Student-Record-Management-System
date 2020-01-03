<?php
    require_once('utility.php');
    session_start();
    header('Location: final_mark_recording.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       if(isset($_POST['class_sID_ssn']) && isset($_POST['student']) && isset($_POST['score']) 
       && !empty($_POST['class_sID_ssn']) && !empty($_POST['student']) && !empty($_POST['score'])){

            $fields = explode("_", $_POST['class_sID_ssn']);
            $class = $fields[0];
            $subjectID = $fields[1];

            $student = $_POST['student'];
            $score = $_POST['score'];

            $retval = recordFinalMark($student, $subjectID, $score);
            $_SESSION[MSG] = $retval;
    
        } else {
            $_SESSION[MSG] = MARK_RECORDING_FAILED;
        }
   } else {
        $_SESSION[MSG] = MARK_RECORDING_FAILED;
}
?>