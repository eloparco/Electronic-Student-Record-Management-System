<?php
require_once('utility.php');
session_start();
header('Location: communication_recording.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['date']) && isset($_POST['title']) && isset($_POST['subtitle']) && 
    !empty($_POST['date']) && !empty($_POST['title']) && !empty($_POST['subtitle'])){

        $date =$_POST['date'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];

        $retval = recordCommunication($date,$title, $subtitle);
        $_SESSION['msg_result'] = $retval;

    } else {
        $_SESSION['msg_result'] = COMMUNICATION_RECORDING_INCORRECT;
    }
} else {
    $_SESSION['msg_result'] = COMMUNICATION_RECORDING_FAILED;
}
?>