<?php
require_once('utility.php');
session_start();
header('Location: communication_recording.php');
define("SUBTITLE", "subtitle");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST[TITLE]) && isset($_POST[SUBTITLE]) && 
    !empty($_POST[TITLE]) && !empty($_POST[SUBTITLE])){

        $title = $_POST[TITLE];
        $subtitle = $_POST[SUBTITLE];

        $retval = recordCommunication($title, $subtitle);
        $_SESSION[MSG] = $retval;

    } else {
        $_SESSION[MSG] = COMMUNICATION_RECORDING_INCORRECT;
    }
} else {
    $_SESSION[MSG] = COMMUNICATION_RECORDING_FAILED;
}
?>