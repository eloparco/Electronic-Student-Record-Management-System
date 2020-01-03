<?php
define("JSON", "JSON");
include('utility.php');
$db_con = connect_to_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['student']) || !isset($_POST['score']) || !isset($_POST['subject']) ||
    empty($_POST['student']) || empty($_POST['score']) || empty($_POST['subject'])) {
        echo '{"state" : "error",
        "result" : "Incomplete request."}';

        mysqli_close($db_con);
        exit();
    }
    $student = $_POST['student'];
    $subject = $_POST['subject'];
    $score = $_POST['score'];

    $tuple = "Student: ".$student." Subject: ".$subject." Mark: ".$score;

    $retval = recordFinalMark($student, $subject, $score);
    
    // $_SESSION[MSG] =  $retval;

    if($retval != MARK_RECORDING_OK)
        $retval = MARK_RECORDING_FAILED;  

    echo '{"state" : "ok",
        "result" :"'.$retval.'",
        "tuple" :"'.$tuple.'" }';
}
?>