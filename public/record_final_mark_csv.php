<?php
define("JSON", "JSON");
include('utility.php');
define("STUDENT_MARK_CSV", "student");
define("SUBJECT_MARK_CSV", "subject");
define("SCORE_CSV", "score");

$db_con = connect_to_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST[STUDENT_MARK_CSV]) || !isset($_POST[SCORE_CSV]) || !isset($_POST[SUBJECT_MARK_CSV]) ||
    empty($_POST[STUDENT_MARK_CSV]) || empty(intval(urldecode($_POST[SCORE_CSV]))) || empty(intval(urldecode($_POST[SUBJECT_MARK_CSV])))) {
        echo '{"state" : "error",
        "result" : "Incomplete request."}';

        mysqli_close($db_con);
        exit();
    }
    $student = htmlspecialchars($_POST[STUDENT_MARK_CSV]);
    $subject = htmlspecialchars($_POST[SUBJECT_MARK_CSV]);
    $score = htmlspecialchars($_POST[SCORE_CSV]);

    $tuple = "Student: ".$student." Subject: ".$subject." Mark: ".$score;

    $retval = recordFinalMark($student, $subject, $score);
    
    if($retval != MARK_RECORDING_OK) {
        $retval = MARK_RECORDING_FAILED;  
    }

    echo '{"state" : "ok",
        "result" :"'.$retval.'",
        "tuple" :"'.$tuple.'" }';
}
?>