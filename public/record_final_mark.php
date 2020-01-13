<?php
    require_once('utility.php');
    session_start();
    header('Location: final_mark_recording.php');
    define("SCORE", "score");
    define("STUDENT", "student");
    define("CLASS_SUBID_SSN", "class_sID_ssn");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       if(isset($_POST[CLASS_SUBID_SSN]) && isset($_POST[STUDENT]) && isset($_POST[SCORE]) 
       && !empty($_POST[CLASS_SUBID_SSN]) && !empty($_POST[STUDENT]) && !empty($_POST[SCORE])){

            $fields = explode("_", $_POST[CLASS_SUBID_SSN]);
            $class = $fields[0];
            $subjectID = $fields[1];

            $student = $_POST[STUDENT];
            $score = $_POST[SCORE];

            $retval = recordFinalMark($student, $subjectID, $score);
            $_SESSION[MSG] = $retval;
    
        } else {
            $_SESSION[MSG] = MARK_RECORDING_FAILED;
        }
   } else {
        $_SESSION[MSG] = MARK_RECORDING_FAILED;
}
?>