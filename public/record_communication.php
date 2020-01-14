<?php
require_once('utility.php');
session_start();
header('Location: communication_recording.php');
define("SUBTITLE_COMM", "subtitle");
define("TITLE_COMM", "title");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if( isset($_POST[TITLE_COMM]) && isset($_POST[SUBTITLE_COMM]) && 
    !empty($_POST[TITLE_COMM]) && !empty($_POST[SUBTITLE_COMM]) ){

        $title = $_POST[TITLE_COMM];
        $subtitle = $_POST[SUBTITLE_COMM];

        $retval = recordCommunication($title, $subtitle);
        $_SESSION[MSG] = $retval;

    } else {
        $_SESSION[MSG] = COMMUNICATION_RECORDING_INCORRECT;
    }
} else {
    $_SESSION[MSG] = COMMUNICATION_RECORDING_FAILED;
}
?>