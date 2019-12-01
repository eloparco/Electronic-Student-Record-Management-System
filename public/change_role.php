<?php
require_once('utility.php');
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(!isset($_POST['user_mail']) || !isset($_POST['role'])){
        return false;
    }
    $change = false;
    $user = $_POST['user_mail'];
    $role = $_POST['role'];
    if(check_change_role($user, $role)){
        $_SESSION['myUserType'] = $role;
        $change = true;
    }
    echo json_encode($change);
}
?>