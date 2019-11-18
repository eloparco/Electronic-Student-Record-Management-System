<?php
require_once('utility.php');
session_start();
/* TYPE LOGGED IN CHECK */
if(!userTypeLoggedIn('SECRETARY_OFFICER')) {   
    myRedirectTo('login.php', 'SessionTimeOut');
    exit;
}
header('Location: student_form.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['SSN']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['parent1']) && isset($_POST['parent2']) && isset($_POST['class']) 
        && !empty($_POST['SSN']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['parent1']) && !empty($_POST['parent2']) && !empty($_POST['class'])) {

        /* get values from POST */
        $ssn = $_POST['SSN'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $parent1 = $_POST['parent1'];
        $parent2 = $_POST['parent2'];
        $class = $_POST['class'];
        
        $retval = insertStudent($ssn, $name, $surname, $parent1, $parent2, $class);
        $_SESSION['msg_result'] = $retval;
    }

} else {
    $_SESSION['msg_result'] = STUDENT_RECORDING_FAILED;
}

?>