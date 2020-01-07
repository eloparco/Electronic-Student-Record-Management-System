<?php
include('utility.php');
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['username']) && isset($_POST['oldPassword']) && isset($_POST['newPassword'])  && 
        !empty($_POST['username']) && !empty($_POST['oldPassword']) && !empty($_POST['newPassword'])) {

        $username = mySanitizeString($_POST['username']);
        $oldPassword = mySanitizeString($_POST['oldPassword']);
        $newPassword = mySanitizeString($_POST['newPassword']);

        $isPasswordCorrect1 = checkPassword($oldPassword);
        $isPasswordCorrect2 = checkPassword($newPassword);
        $isEmailCorrect = checkEmail($username);

        if(!$isEmailCorrect)
            redirect('update_password.php', EMAIL_INCORRECT); 
        else if(!$isPasswordCorrect1 && !$isPasswordCorrect2)
            redirect('update_password.php', PASSWORD_INCORRECT); 
        else if($newPassword == $oldPassword)
            redirect('update_password.php', "The new password must be different from the current one"); 
        else {
            $username = mySanitizeString($username);
            $con = connect_to_db();
            try {  
                if(!$result = mysqli_query($con, 'SELECT UserType, Password FROM USER U, USER_TYPE UT WHERE U.SSN = UT.SSN AND Email="'.$username.'";'))
                    throw new Exception('select error');
                
                $row = mysqli_fetch_array($result);        
                $dbUserType = $row['UserType'];  
                $dbPassword = $row['Password'];
                if ($dbPassword != $oldPassword || empty($dbPassword)){//Password or email not valid
                    redirect('update_password.php', "Invalid Username or Password"); 
                } else{                
                    if(!$result = mysqli_query($con,'UPDATE USER SET AccountActivated=1, Password="'.$newPassword.'" WHERE Email="'.$username.'" AND Password="'.$oldPassword.'";'))
                        throw new Exception('update error');
                        mysqli_close($con);
                    if($dbUserType == 'TEACHER'){
                        $_SESSION['time'] = time(); 
                        $_SESSION['mySession'] = $username;
                        $_SESSION['myUserType'] = 'TEACHER';
                        redirect ('user_teacher.php', '');
                    }
                    else if($dbUserType == 'PARENT'){
                        $_SESSION['time'] = time(); 
                        $_SESSION['mySession'] = $username;
                        $_SESSION['myUserType'] = 'PARENT';                        
                        redirect ('user_parent.php', '');
                    }
                    else if($dbUserType == 'SECRETARY_OFFICER'){
                        $_SESSION['time'] = time(); 
                        $_SESSION['mySession'] = $username;
                        $_SESSION['myUserType'] = 'SECRETARY_OFFICER';
                        redirect ('user_secretary.php', '');  
                    } else if($dbUserType == 'PRINCIPAL'){
                        $_SESSION['time'] = time(); 
                        $_SESSION['mySession'] = $username;
                        $_SESSION['myUserType'] = 'PRINCIPAL';
                        redirect ('user_principal.php', '');  
                    } else if($dbUserType == 'SYS_ADMIN'){
                        $_SESSION['time'] = time(); 
                        $_SESSION['mySession'] = $username;
                        $_SESSION['myUserType'] = 'SYS_ADMIN';
                        redirect ('user_admin.php', '');  
                    } else 
                        redirect('update_password.php', LOGIN_USER_NOT_DEFINED);     
            } 
                
            }catch (Exception $e) {                
                mysqli_close($con);
                redirect('update_password.php', "Something went wrong, retry Dberror");
            }               

        }
    } else {
        redirect('update_password.php', "Something went wrong, retry");    
    }
} else {
    redirect('update_password.php', "Something went wrong, retry"); 
}
?>