<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
/* Handle Ajax response */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['childData'])) {
    //Set session variables 
    $result_explode = explode('|', $_POST['childData']);
    $_SESSION['childNameSurname'] = $result_explode[0];
    $_SESSION['child'] = $result_explode[1];

    //return to ajax
    echo '';
    exit();
}  
?>