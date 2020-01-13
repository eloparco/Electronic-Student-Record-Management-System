<?php
include('utility.php');
session_start();
define("VAL_USRNAME", "username");
define("VAL_OLD_PWD", "oldPassword");
define("VAL_NEW_PWD","newPassword");
define("PAGE_ADDR", "update_password.php");
define("VAL_SESSION","mySession");
define("CURR_USR_TYPE", "myUserType");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST[VAL_USRNAME]) && isset($_POST[VAL_OLD_PWD]) && isset($_POST[VAL_NEW_PWD])  && 
        !empty($_POST[VAL_USRNAME]) && !empty($_POST[VAL_OLD_PWD]) && !empty($_POST[VAL_NEW_PWD])) {

        $username = mySanitizeString($_POST[VAL_USRNAME]);
        $oldPassword = mySanitizeString($_POST[VAL_OLD_PWD]);
        $newPassword = mySanitizeString($_POST[VAL_NEW_PWD]);

        $isPasswordCorrect1 = checkPassword($oldPassword);
        $isPasswordCorrect2 = checkPassword($newPassword);
        $isEmailCorrect = checkEmail($username);

        if(!$isEmailCorrect) {
            redirect(PAGE_ADDR, EMAIL_INCORRECT); 
        }
        else if(!$isPasswordCorrect1 && !$isPasswordCorrect2) {
            redirect(PAGE_ADDR, PASSWORD_INCORRECT); 
        }
        else if($newPassword == $oldPassword) {
            redirect(PAGE_ADDR, "The new password must be different from the current one");
        } 
        else {
            $username = mySanitizeString($username);
            $con = connect_to_db();
            try {  
                if(!$result = mysqli_query($con, 'SELECT UserType, Password FROM USER U, USER_TYPE UT WHERE U.SSN = UT.SSN AND Email="'.$username.'";')) {
                    throw new UnexpectedValueException('select error');
                }
                
                $row = mysqli_fetch_array($result);        
                $dbUserType = $row['UserType'];  
                $dbPassword = $row['Password'];
                if ($dbPassword != $oldPassword || empty($dbPassword)) {//Password or email not valid
                    redirect(PAGE_ADDR, "Invalid Username or Password"); 
                } else {                
                    if(!$result = mysqli_query($con,'UPDATE USER SET AccountActivated=1, Password="'.$newPassword.'" WHERE Email="'.$username.'" AND Password="'.$oldPassword.'";')) {
                        throw new UnexpectedValueException('update error');
                    }
                    mysqli_close($con);
                    if($dbUserType == 'TEACHER') {
                        $_SESSION['time'] = time(); 
                        $_SESSION[VAL_SESSION] = $username;
                        $_SESSION[CURR_USR_TYPE] = 'TEACHER';
                        redirect ('user_teacher.php', '');
                    }
                    else if($dbUserType == 'PARENT'){
                        $_SESSION['time'] = time(); 
                        $_SESSION[VAL_SESSION] = $username;
                        $_SESSION[CURR_USR_TYPE] = 'PARENT';                        
                        redirect ('user_parent.php', '');
                    }
                    else if($dbUserType == 'SECRETARY_OFFICER'){
                        $_SESSION['time'] = time(); 
                        $_SESSION[VAL_SESSION] = $username;
                        $_SESSION[CURR_USR_TYPE] = 'SECRETARY_OFFICER';
                        redirect ('user_secretary.php', '');  
                    } else if($dbUserType == 'PRINCIPAL'){
                        $_SESSION['time'] = time(); 
                        $_SESSION[VAL_SESSION] = $username;
                        $_SESSION[CURR_USR_TYPE] = 'PRINCIPAL';
                        redirect ('user_principal.php', '');  
                    } else if($dbUserType == 'SYS_ADMIN'){
                        $_SESSION['time'] = time(); 
                        $_SESSION[VAL_SESSION] = $username;
                        $_SESSION[CURR_USR_TYPE] = 'SYS_ADMIN';
                        redirect ('user_admin.php', '');  
                    } else {
                        redirect(PAGE_ADDR, LOGIN_USER_NOT_DEFINED);  
                    }   
            } 
                
            }catch (UnexpectedValueException $e) {                
                mysqli_close($con);
                redirect(PAGE_ADDR, "Something went wrong, retry Dberror");
            }               

        }
    } else {
        redirect(PAGE_ADDR, "Something went wrong, retry");    
    }
} else {
    redirect(PAGE_ADDR, "Something went wrong, retry"); 
}
?>