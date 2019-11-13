<?php
define("LOGIN_TEACHER_OK", "Login Teacher success.");
define("LOGIN_PARENT_OK", "Login Parent success.");
define("LOGIN_SECRETARY_OK", "Login Secretary Officer success.");
define("LOGIN_USER_NOT_DEFINED", "User not defined.");
define("LOGIN_FAILED", "Login failed.");
define("USER_ALREADY_EXIST", "SSN already exists.");
define("INSERT_PARENT_OK", "Parent inserted successfully.");
define("INSERT_PARENT_FAILED", "Insert Parent failed.");
define("CHANGE_PASSWORD", "Password entered needs to be changed");
define("DB_ERROR", "Error on db connection.");
define("DB_QUERY_ERROR", "Error on query db.");
define("PASSWORD_INCORRECT", "Password entered is incorrect.");
define("EMAIL_INCORRECT", "Email entered is incorrect.");
define("SSN_INCORRECT", "SSN entered is incorrect.");
define("NAME_INCORRECT", "Name entered is incorrect.");
define("SURNAME_INCORRECT", "Surname entered is incorrect.");
define("USERTYPE_INCORRECT", "User type not recognized.");
define("LOGIN_NOT_MATCH", "Invalid username or password.");
define("SESSION_EXPIRED", "session-expired");
define("TOPIC_RECORDING_FAILED", "Topic recording failed.");
define("TOPIC_RECORDING_OK", "Topics correctly recorded.");
define("TOPIC_RECORDING_INCORRECT", "Please fill all the fields.");
define("MARK_RECORDING_OK", "Mark correctly recorded.");
define("MARK_RECORDING_FAILED", "Mark recording failed.");
define("MAX_INACTIVITY", 120);

function connect_to_db() {
    $db = parse_ini_file("../config/database/database.ini");
    $user = $db['user'];
    $pass = $db['pass'];
    $name = $db['name'];
    $host = $db['host'];

    $conn = mysqli_connect($host, $user, $pass, $name); //returns FALSE on error
    if($conn){
        $conn->set_charset("utf8");
    }
    return $conn;
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

function checkSSN($ssn) {
    if($ssn == '' || strlen($ssn) != 16)
        return false;
    $ssn = strtoupper($ssn);
    return preg_match("/[A-Z0-9]+$/", $ssn);
}

function checkNormalText($input) {
    return strlen($input) >= 2 && strlen($input) < 20;
}

function checkUserType($type) {
    return $type == 'TEACHER' || $type == 'SECRETARY_OFFICER' || $type == 'PARENT';
}

function generatePass($name) {
    return $name.'5';
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
                } else if($password == $dbPass && $isActive == 0) { //password needs to be changed
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

function tryInsertParent($ssn, $name, $surname, $username, $password, $usertype, $accountactivated) {
    $con = connect_to_db();
    if($con && mysqli_connect_error() == NULL) {
        mysqli_autocommit($con, FALSE);
        try {
            /* Check if user already exists */
            if(!$prep = mysqli_prepare($con, "SELECT * FROM `USER` WHERE SSN = ? FOR UPDATE"))
                throw new Exception();
            if(!mysqli_stmt_bind_param($prep, "s", $ssn)) 
                throw new Exception();
            if(!mysqli_stmt_execute($prep))
                throw new Exception();
            if(!mysqli_stmt_store_result($prep))
                throw new Exception();
            $count = mysqli_stmt_num_rows($prep);
            mysqli_stmt_free_result($prep);
            mysqli_stmt_close($prep);
            if($count == 1) {
                mysqli_rollback($con);
                mysqli_autocommit($con, TRUE);
                mysqli_close($con);
                return USER_ALREADY_EXIST;
            } 
            else {
                /* Insert parent data into db */
                if(!$prep2 = mysqli_prepare($con, "INSERT INTO `USER` (`SSN`, `Name`, `Surname`, `Email`, `Password`, `UserType`, `AccountActivated`) VALUES (?, ?, ?, ?, ?, ?, ?)"))
                    throw new Exception();
                if(!mysqli_stmt_bind_param($prep2, "ssssssi", $ssn, $name, $surname, $username, $password, $usertype, $accountactivated)) 
                    throw new Exception();
                if(!mysqli_stmt_execute($prep2)) 
                    throw new Exception();
                else { 
                    mysqli_stmt_close($prep2);
                    if(!mysqli_commit($con)) // do the final commit
                        throw new Exception();
                    mysqli_autocommit($con, TRUE);
                    mysqli_close($con);
                    return INSERT_PARENT_OK;
                }
            }
        } catch (Exception $e) {
            mysqli_rollback($con);
            mysqli_autocommit($con, TRUE);
            mysqli_close($con);
            return INSERT_PARENT_FAILED;
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

# get children given the parent
function get_children_of_parent($parentUsername){
    $children_query = "SELECT C.SSN, C.Name, C.Surname\n" .
                      "FROM CHILD C, USER P\n" .
                      "WHERE (SSNParent1=P.SSN OR SSNParent2=P.SSN) AND P.Email=?";
    if(!($db_con = connect_to_db())){
        die('Error in connection to database. [Children query]'."\n");
    }
    $children_prep = mysqli_prepare($db_con, $children_query);
    if(!$children_prep){
        print('Error in preparing query: '.$children_query);
        die('Check database error:<br>'.mysqli_error($db_con));
    }
    if(!mysqli_stmt_bind_param($children_prep, "s", $parentUsername)){
        die('Error in binding parameters to children_prep.'."\n");
    }
    if(!mysqli_stmt_execute($children_prep)){
        die('Error in executing children query. Database error:<br>'.mysqli_error($db_con));
    }
    $children_res = mysqli_stmt_get_result($children_prep);
    $children_data = array();
    while($row = mysqli_fetch_array($children_res, MYSQLI_ASSOC)){
        $fields = array("SSN" => $row['SSN'], "Name" => $row['Name'], "Surname" => $row['Surname']);
        $children_data[] = $fields;
    }
    mysqli_stmt_close($children_prep);
    return $children_data;
}
# end children of a parent

# functions to manage Marks from Parent side
function get_scores_per_child_and_date($childSSN, $startDate, $endDate){
    $marks_query = "SELECT Name, Date, Score\n" .
                    "FROM MARK M, SUBJECT S\n" .
                    "WHERE M.SubjectID=S.ID AND StudentSSN=? AND Date>=str_to_date(?,'%Y-%m-%d') AND Date<=str_to_date(?,'%Y-%m-%d')\n" .
                    "ORDER BY Date";
    $db_con = connect_to_db();
    if(!$db_con){
        die('Error in connection to database. [Marks retrieving]'."\n");
    }
    $marks_prep = mysqli_prepare($db_con, $marks_query);
    if(!$marks_prep){
        print('Error in preparing query: '.$marks_query);
        die('Check database error:<br>'.mysqli_error($db_con));
    }
    if(!mysqli_stmt_bind_param($marks_prep, "sss", $childSSN, $startDate, $endDate)){
        die('Error in binding paramters to marks_prep.'."\n");
    }
    if(!mysqli_stmt_execute($marks_prep)){
        die('Error in executing marks query. Database error:<br>'.mysqli_error($db_con));
    }
    $marks_res = mysqli_stmt_get_result($marks_prep);
    $scores = array();
    while($row = mysqli_fetch_array($marks_res, MYSQLI_ASSOC)){
        $fields = array("Subject" => $row['Name'], "Date" => $row['Date'], "Score" => $row['Score']);
        $scores[] = $fields;
    }
    mysqli_stmt_close($marks_prep);
    return $scores;
}

function get_list_of_subjects($childSSN){
    $subjects_query = "SELECT DISTINCT(Name)\n" . 
                      "FROM MARK M, SUBJECT S\n" . 
                      "WHERE M.SubjectID=S.ID AND StudentSSN=?\n" . 
                      "ORDER BY Name";
    $db_con = connect_to_db();
    if(!$db_con){
        die('Error in connection to database. [Retrieving subjects of student]'."\n");
    }
    $subjects_prep = mysqli_prepare($db_con, $subjects_query);
    if(!$subjects_prep){
        print('Error in preparing query: '.$subjects_query);
        die('Check database error:<br>'.mysqli_error($db_con));
    }
    if(!mysqli_stmt_bind_param($subjects_prep, "s", $childSSN)){
        die('Error in binding paramters to marks_prep.'."\n");
    }
    if(!mysqli_stmt_execute($subjects_prep)){
        die('Error in executing marks query. Database error:<br>'.mysqli_error($db_con));
    }
    $subjects_res = mysqli_stmt_get_result($subjects_prep);
    $subjects = array();
    while($row = mysqli_fetch_array($subjects_res, MYSQLI_ASSOC)){
        $subjects[] = $row['Name'];
    }
    mysqli_stmt_close($subjects_prep);
    return $subjects;
}

function get_score_visualization($decimalScore){
    # TODO: conversion from decimal to human-known score
}
# end Marks Parent

function recordTopic($class, $date, $startHour, $SubjectID, $teacherSSN, $Title, $Description) {
    $con = connect_to_db();
    if($con && mysqli_connect_error() == NULL) {
        try {
            if(!$prep = mysqli_prepare($con, "INSERT INTO TOPIC VALUES(?, STR_TO_DATE(?,'%d/%m/%Y'), ?, ?, ?, ?, ?);")) 
                throw new Exception();
            if(!mysqli_stmt_bind_param($prep, "ssiisss", $class, $date, $startHour, $SubjectID, $teacherSSN, $Title, $Description)) 
                throw new Exception();
            if(!mysqli_stmt_execute($prep)) 
                throw new Exception();
            else{
                return TOPIC_RECORDING_OK;
            }
        } catch (Exception $e) {
            mysqli_close($con);
            //return TOPIC_RECORDING_FAILED." ".$e;
            return TOPIC_RECORDING_FAILED;
        }
    } else {
        return DB_ERROR;
    }
}

function recordMark($student, $subject, $date, $class, $score) {
    $con = connect_to_db();
    if($con && mysqli_connect_error() == NULL) {
        try {
            if(!$prep = mysqli_prepare($con, "INSERT INTO MARK VALUES(?, ?, STR_TO_DATE(?,'%d/%m/%Y'), ?, ?);")) 
                throw new Exception();
            if(!mysqli_stmt_bind_param($prep, "sissd", $student, $subject, $date, $class, $score)) 
                throw new Exception();
            if(!mysqli_stmt_execute($prep)) 
                throw new Exception();
            else{
                return MARK_RECORDING_OK;
            }
        } catch (Exception $e) {
            mysqli_close($con);
            //return MARK_RECORDING_FAILED." ".$e;
            return MARK_RECORDING_FAILED;
        }
    } else {
        return DB_ERROR;
    }
}
?>