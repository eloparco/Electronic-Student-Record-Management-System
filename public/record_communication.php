<?php
require_once('utility.php');
session_start();
header('Location: communication_recording.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['title']) && isset($_POST['subtitle']) && 
    !empty($_POST['title']) && !empty($_POST['subtitle'])){

        // $date =$_POST['date'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];

        $retval = recordCommunication($title, $subtitle);
        $_SESSION[MSG] = $retval;

    } else {
        $_SESSION[MSG] = COMMUNICATION_RECORDING_INCORRECT;
    }
} else {
    $_SESSION[MSG] = COMMUNICATION_RECORDING_FAILED;
}
?>