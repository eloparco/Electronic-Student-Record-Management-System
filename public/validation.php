<?php
require_once('utility.php');
session_start();
header('Location: login.php');

define("PWD", "password");
define("USR", "username");
define("CONST_TIME", "time");
define("SESSION_LBL", "mySession");
define("USR_TYPE", "myUserType");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST[USR]) && isset($_POST[PWD]) && 
        !empty($_POST[USR]) && !empty($_POST[PWD])) {

        $username = $_POST[USR];
        $password = $_POST[PWD];

        $isPasswordCorrect = checkPassword($password);
        $isEmailCorrect = checkEmail($username);

        if(!$isEmailCorrect) {
            $_SESSION[MSG] = EMAIL_INCORRECT;
        }
        else if(!$isPasswordCorrect) {
            $_SESSION[MSG] = PASSWORD_INCORRECT;
        }
        else {
            $username = mySanitizeString($username);
            $retVal = tryLogin($username, $password);
            if($retVal == LOGIN_TEACHER_OK) {
                $_SESSION[CONST_TIME] = time(); 
                $_SESSION[SESSION_LBL] = $username;
                $_SESSION[USR_TYPE] = 'TEACHER';
                header('Location: user_teacher.php');
            } else if($retVal == LOGIN_PARENT_OK) {
                $_SESSION[CONST_TIME] = time(); 
                $_SESSION[SESSION_LBL] = $username;
                $_SESSION[USR_TYPE] = 'PARENT';
                header('Location: user_parent.php');
            } else if($retVal == LOGIN_SECRETARY_OK) {
                $_SESSION[CONST_TIME] = time(); 
                $_SESSION[SESSION_LBL] = $username;
                $_SESSION[USR_TYPE] = 'SECRETARY_OFFICER';
                header('Location: user_secretary.php');
            } else if($retVal == LOGIN_PRINCIPAL_OK) {
                $_SESSION[CONST_TIME] = time(); 
                $_SESSION[SESSION_LBL] = $username;
                $_SESSION[USR_TYPE] = 'PRINCIPAL';
                header('Location: user_principal.php');
            } else if($retVal == LOGIN_ADMIN_OK) {
                $_SESSION[CONST_TIME] = time(); 
                $_SESSION[SESSION_LBL] = $username;
                $_SESSION[USR_TYPE] = 'SYS_ADMIN';
                header('Location: user_admin.php');
            } else if($retVal == CHANGE_PASSWORD) {                
                header('Location: update_password.php');
            } else {
                $_SESSION[MSG] = $retVal;
            }
        }
    } else {
        $_SESSION[MSG] = LOGIN_FAILED;
    }
} else {
    $_SESSION[MSG] = LOGIN_FAILED;
}
?>