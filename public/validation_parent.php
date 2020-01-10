<?php
require_once('utility.php');
session_start();
/* TYPE LOGGED IN CHECK */
if(!userTypeLoggedIn('SECRETARY_OFFICER')) {   
    myRedirectTo('login.php', 'SessionTimeOut');
    exit;
}
//header('Location: parent_form.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['ssn']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username']) 
        && !empty($_POST['ssn']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['username'])) {

        /* get values from POST */
        $ssn = $_POST['ssn'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];

        /* check value format */
        $isEmailCorrect = checkEmail($username);
        $isSSNCorrect = checkSSN($ssn);
        $isNameCorrect = checkNormalText($name);
        $isSurnameCorrect = checkNormalText($surname);
        $password = generatePass($name);

        if(!$isEmailCorrect) {
            $_SESSION[MSG] = EMAIL_INCORRECT;
        }
        else if(!$isSSNCorrect) {
            $_SESSION[MSG] = SSN_INCORRECT;
        }
        else if(!$isNameCorrect) {
            $_SESSION[MSG] = NAME_INCORRECT;
        }
        else if(!$isSurnameCorrect) {
            $_SESSION[MSG] = SURNAME_INCORRECT;
        }
        else {
            /* Sanitize strings */
            $ssn = mySanitizeString($ssn);
            $name = mySanitizeString($name);
            $surname = mySanitizeString($surname);
            $username = mySanitizeString($username);

            /* Start query and get a result value */
            $retVal = tryInsertParent($ssn, $name, $surname, $username, $password, 'PARENT', 0);
            if($retVal == INSERT_PARENT_OK) {
                $_SESSION['time'] = time(); 
                $_SESSION[MSG] = $retVal;
                header('Location: parent_form.php');
            } else {
                $_SESSION[MSG] = $retVal;
            }
        }
    } else {
        $_SESSION[MSG] = INSERT_PARENT_FAILED;
    }
} else {
    $_SESSION[MSG] = INSERT_PARENT_FAILED;
}
?>