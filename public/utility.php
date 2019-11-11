<?php
define("LOGIN_TEACHER_OK", "Login Teacher success.");
define("LOGIN_PARENT_OK", "Login Parent success.");
define("LOGIN_SECRETARY_OK", "Login Secretary Officer success.");
define("LOGIN_USER_NOT_DEFINED", "User not defined.");
define("LOGIN_FAILED", "Login failed.");
define("CHANGE_PASSWORD", "Password entered needs to be changed");
define("DB_ERROR", "Error on db connection.");
define("DB_QUERY_ERROR", "Error on query db.");
define("PASSWORD_INCORRECT", "Password entered is incorrect.");
define("EMAIL_INCORRECT", "Email entered is incorrect.");
define("LOGIN_NOT_MATCH", "Invalid username or password.");
define("SESSION_EXPIRED", "session-expired");
define("MAX_INACTIVITY", 120);

function connect_to_db() {
    return mysqli_connect("localhost", "root", "", "student_record_management"); //returns FALSE on error
}

function myDestroySession() {
    $_SESSION = array();
    if(ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time()-3600*24, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
}

function userLoggedIn() {
    if(isset($_SESSION['mySession']))
        return $_SESSION['mySession'];
    else 
        return false;
}

function myRedirectHome($msg="") {
    header('HTTP/1.1 307 temporary redirect');
    header("Location: index.php?msg=".urlencode($msg));
    exit;
}

function myRedirectTo($toRedirect, $msg="") {
    header('HTTP/1.1 307 temporary redirect');
    header('Location: '.$toRedirect.'?msg='.urlencode($msg));
    exit;
}

function redirect($msg='', $new_location){
    if(!empty($msg)){
        $_SESSION['msg_result'] = $msg;
    }    
    header("HTTP/1.1 303 See Other");
    header('Location: '.$new_location);
    exit;
}

function myRedirectToHTTPS($toRedirect) {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: '.$toRedirect);
}

function checkPassword($pwd) {
    return strlen($pwd) >= 2 && preg_match("#[a-z]+#", $pwd) && (preg_match("#[0-9]+#", $pwd) || preg_match("#[A-Z]+#", $pwd));
}

function checkEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function mySanitizeString($var) {
	$var = strip_tags($var); //remove all HTML and PHP tag, and also NULL characters
    $var = htmlentities($var); //convert all special characters in HTML entities
    if(get_magic_quotes_gpc()) 
        $var = stripslashes($var); //remove backslashes
    return $var;
}

function tryLogin($username, $password) {
    $con = connect_to_db();
    if($con && mysqli_connect_error() == NULL) {
        try {
            if(!$prep = mysqli_prepare($con, "SELECT Password, UserType, AccountActivated FROM `USER` WHERE Email = ?")) 
                throw new Exception();
            if(!mysqli_stmt_bind_param($prep, "s", $username)) 
                throw new Exception();
            if(!mysqli_stmt_execute($prep)) 
                throw new Exception();
            if(!mysqli_stmt_bind_result($prep, $dbPass, $dbUserType, $isActive))
                throw new Exception();  
            if(!mysqli_stmt_store_result($prep))
                throw new Exception();

            $count = mysqli_stmt_num_rows($prep);
            if($count == 0) { //email not found in db
                mysqli_stmt_close($prep);
                mysqli_close($con);
                return LOGIN_NOT_MATCH;
            } else {
                if(!mysqli_stmt_fetch($prep))
                    throw new Exception(); 
                if($password == $dbPass && $isActive == 1) { 
                    mysqli_stmt_close($prep);
                    mysqli_close($con);
                    if($dbUserType == 'TEACHER')
                        return LOGIN_TEACHER_OK;
                    else if($dbUserType == 'PARENT')
                        return LOGIN_PARENT_OK;
                    else if($dbUserType == 'SECRETARY_OFFICER')
                        return LOGIN_SECRETARY_OK;
                    else 
                        return LOGIN_USER_NOT_DEFINED;
                } else if($password == $dbPass && $isActive == 0) {//password needs to be changed
                    mysqli_stmt_close($prep);
                    mysqli_close($con);
                    return CHANGE_PASSWORD;
                } else { //password not correct 
                    mysqli_stmt_close($prep);
                    mysqli_close($con);
                    return LOGIN_NOT_MATCH;
                }
            }
        } catch (Exception $e) {
            mysqli_close($con);
            return LOGIN_FAILED;
        }
    } else {
        return DB_ERROR;
    }
}

function check_inactivity () {
    if(!isset($_SESSION))
        session_start();
	$t = time();
	$diff = 0;
    $new = false;
    
	if(isset($_SESSION['time'])) {
		$t0 = $_SESSION['time'];
		$diff = ($t - $t0); 
	}
	else {
		$new = true;
	}
	if ($new || ($diff > MAX_INACTIVITY)) {
		$_SESSION = array(); //in this way I delete session variable (initializing it to a new array) but ID remains for the next session!

		if(ini_get("session.use_cookies")) { //to kill the session, delete also session cookie! (by setting it to a past expiry time)
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 3600*24, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        //By using the above mechanism, the next session does NOT see the cookie, and so it will give a new ID for the session :)
        session_destroy(); 
		if ($new) { 
			header('HTTP/1.1 307 temporary redirect');
			header('Location: index.php');
		}
        else { //Redirect client to login page
            return -1;
		}
		exit; //IMPORTANT to avoid further output from the script
	}
	else {
        $_SESSION['time'] = time(); //Update time
	}
}

?>