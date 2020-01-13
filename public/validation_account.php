<?php
require_once('utility.php');
session_start();
define("USR_NAME", "username");
define("USR_SURNME", "surname");
define("TYPE_ACCOUNT","account_type");

/* TYPE LOGGED IN CHECK */
if(!userTypeLoggedIn('SYS_ADMIN')) {   
    myRedirectTo('login.php', 'SessionTimeOut');
    exit;
}
header('Location: account_form.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['ssn']) && isset($_POST['name']) && isset($_POST[USR_SURNME]) && isset($_POST[USR_NAME]) && isset($_POST[TYPE_ACCOUNT]) 
        && !empty($_POST['ssn']) && !empty($_POST['name']) && !empty($_POST[USR_SURNME]) && !empty($_POST[USR_NAME]) && !empty($_POST[TYPE_ACCOUNT])) {

        /* get values from POST */
        $ssn = $_POST['ssn'];
        $name = $_POST['name'];
        $surname = $_POST[USR_SURNME];
        $username = $_POST[USR_NAME];
        $accountType = $_POST[TYPE_ACCOUNT];

        /* check value format */
        $isEmailCorrect = checkEmail($username);
        $isSSNCorrect = checkSSN($ssn);
        $isNameCorrect = checkNormalText($name);
        $isSurnameCorrect = checkNormalText($surname);
        $isAccountTypeCorrect = checkNormalText($accountType);
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
        else if(!$isAccountTypeCorrect) {
            $_SESSION[MSG] = USERTYPE_INCORRECT;
        }
        else {
            /* Sanitize strings */
            $ssn = mySanitizeString($ssn);
            $name = mySanitizeString($name);
            $surname = mySanitizeString($surname);
            $accountType = mySanitizeString($accountType);
            $username = mySanitizeString($username);

            /* Start query and get a result value */
            $retVal = tryInsertAccount($ssn, $name, $surname, $username, $password, $accountType, 0);
            if($retVal == INSERT_ACCOUNT_OK || $retVal == UPDATE_ACCOUNT_OK) {
                $_SESSION['time'] = time(); 
                $_SESSION[MSG] = $retVal;
                header('Location: account_form.php');
            } else {
                $_SESSION[MSG] = $retVal;
            }
        }
    } else {
        $_SESSION[MSG] = INSERT_ACCOUNT_FAILED;
    }
} else {
    $_SESSION[MSG] = INSERT_ACCOUNT_FAILED;
}
?>