<?php
require_once('utility.php');
session_start();
define("CLASS_SUBJECT_ID_SSN_TOPIC", "class_sID_ssn");
define("TOPIC_TITLE", "title");
define("TOPIC_SUBTITLE", "subtitle");

header('Location: lecture_recording.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST[CLASS_SUBJECT_ID_SSN_TOPIC]) && isset($_POST['date']) && isset($_POST['hour']) && isset($_POST[TOPIC_TITLE]) && isset($_POST[TOPIC_SUBTITLE]) && 
    !empty($_POST[CLASS_SUBJECT_ID_SSN_TOPIC]) && !empty($_POST['date']) && !empty($_POST['hour']) && !empty($_POST[TOPIC_TITLE]) && !empty($_POST[TOPIC_SUBTITLE])){

        $fields = explode("_", $_POST[CLASS_SUBJECT_ID_SSN_TOPIC]);
        $class = $fields[0];
        $subjectID = $fields[1];
        $teacher = $fields[2];
        $date =$_POST['date'];
        $hour = $_POST['hour'];
        $title = $_POST[TOPIC_TITLE];
        $subtitle = $_POST[TOPIC_SUBTITLE];

        $retval = recordTopic($class, $date, $hour, $subjectID, $teacher, $title, $subtitle);
        $_SESSION[MSG] = $retval;

    } else {
        $_SESSION[MSG] = TOPIC_RECORDING_INCORRECT;
    }
} else {
    $_SESSION[MSG] = TOPIC_RECORDING_FAILED;
}
?>