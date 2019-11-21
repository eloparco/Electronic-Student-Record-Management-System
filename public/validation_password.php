<?php
include('utility.php');
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['username']) && isset($_POST['oldPassword']) && isset($_POST['newPassword'])  && 
        !empty($_POST['username']) && !empty($_POST['oldPassword']) && !empty($_POST['newPassword'])) {

        $username = $_POST['username'];
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];

        $isPasswordCorrect1 = checkPassword($oldPassword);
        $isPasswordCorrect2 = checkPassword($newPassword);
        $isEmailCorrect = checkEmail($username);

        if(!$isEmailCorrect)
            redirect(EMAIL_INCORRECT, 'update_password.php'); 
        else if(!$isPasswordCorrect1 && !$isPasswordCorrect1)
            redirect(PASSWORD_INCORRECT, 'update_password.php'); 
        else if($newPassword == $oldPassword)
            redirect("The new password must be different from the old one", 'update_password.php'); 
        else {
            $username = mySanitizeString($username);
            $con = connect_to_db();
            try {  
                if(!$result = mysqli_query($con, 'SELECT UserType, Password FROM USER WHERE Email="'.$username.'";'))
                    throw new Exception('select error');
                
                $row = mysqli_fetch_array($result);        
                $dbUserType = $row['UserType'];  
                $dbPassword = $row['Password'];
                if ($dbPassword != $oldPassword || empty($dbPassword)){//Password or email not valid
                    redirect("Invalid Username or Password", 'update_password.php'); 
                } else{                
                    if(!$result = mysqli_query($con,'UPDATE USER SET AccountActivated=1, Password="'.$newPassword.'" WHERE Email="'.$username.'" AND Password="'.$oldPassword.'";'))
                        throw new Exception('update error');
                        mysqli_close($con);
                    if($dbUserType == 'TEACHER'){
                        $_SESSION['time'] = time(); 
                        $_SESSION['mySession'] = $username;
                        $_SESSION['myUserType'] = 'TEACHER';
                        redirect ('', 'user_teacher.php');
                    }
                    else if($dbUserType == 'PARENT'){
                        $_SESSION['time'] = time(); 
                        $_SESSION['mySession'] = $username;
                        $_SESSION['myUserType'] = 'PARENT';                        
                        redirect ('', 'user_parent.php');
                    }
                    else if($dbUserType == 'SECRETARY_OFFICER'){
                        $_SESSION['time'] = time(); 
                        $_SESSION['mySession'] = $username;
                        $_SESSION['myUserType'] = 'SECRETARY_OFFICER';
                        redirect ('', 'user_secretary.php');  
                    } else if($dbUserType == 'PRINCIPAL'){
                        $_SESSION['time'] = time(); 
                        $_SESSION['mySession'] = $username;
                        $_SESSION['myUserType'] = 'PRINCIPAL';
                        redirect ('', 'user_principal.php');  
                    } else 
                        redirect(LOGIN_USER_NOT_DEFINED, 'update_password.php');     
            } 
                
            }catch (Exception $e) {                
                mysqli_close($con);
                //$msg =$e->getMessage(); //debug  
                //redirect($msg, 'update_password.php');                       
                redirect("Something went wrong, retry Dberror", 'update_password.php');
            }               

        }
    } else {
        redirect("Something went wrong, retry", 'update_password.php');    
    }
} else {
    redirect("Something went wrong, retry", 'update_password.php'); 
}
?>