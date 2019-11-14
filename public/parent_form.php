<?php
include("includes/config.php"); 
require_once('utility.php');
/* HTTPS CHECK */
if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
} else {
  $redirectHTTPS = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  myRedirectToHTTPS($redirectHTTPS);
  exit;
}
check_inactivity();
if(!isset($_SESSION)) 
  session_start();
 
/* LOGGED IN CHECK */
if(!userLoggedIn()) {   
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}

if(isset($_SESSION['msg_result'])) {
    if(!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_PARENT_OK ||
        $_SESSION['msg_result'] == LOGIN_SECRETARY_OK || $_SESSION['msg_result'] == LOGIN_TEACHER_OK)) { 
        $_SESSION['msg_result'] = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="../css/dashboard.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="css/customForm.css">
  <link rel="stylesheet" type="text/css" href="css/w3.css">
</head>

<body>
  <?php include("includes/user_header.php"); ?> 
  <?php include("includes/dashboard_secretary.php"); ?> 

  <script>
    var homeElement = document.getElementById("homeDash");
    var recordParentElement = document.getElementById("recordParentDash");
    var recordStudentElement = document.getElementById("recordStudentDash");
    var setupClassElement = document.getElementById("setupClassDash");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
      recordStudentElement.classList.remove("active");
      setupClassElement.classList.remove("active");
    }   
    if (recordParentElement.classList) {
        recordParentElement.classList.add("active");
    } 
  </script>

  <div class="formContainer text-center">
    <form id="myParentForm" class="form-signin col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" action="validation_parent.php" method="post">
      <img id="parentImg" class="mb-4" src="images/icons/parent.png" alt="" width="102" height="102">
      <h1 class="h3 mb-3 font-weight-normal">Enter parent data</h1>
      <label for="inputSSN" class="sr-only">SSN</label>
      <input type="text" id="inputSSN" name="ssn" class="form-control" placeholder="SSN" pattern=".{16}" title="Please insert 16 alphanumeric characters." required autofocus>
      <label for="inputName" class="sr-only">Name</label>
      <input type="text" id="inputName" name="name" class="form-control" placeholder="Name" pattern=".{2,20}" title="Please insert a name with length between 2 and 20." required>
      <label for="inputSurname" class="sr-only">Surname</label>
      <input type="text" id="inputSurname" name="surname" class="form-control" placeholder="Surname" pattern=".{2,20}" title="Please insert a name with length between 2 and 20." required>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" name="username" class="form-control" placeholder="Email address" required>
      <?php 
        if(isset($_SESSION['msg_result'])) {
          if(!empty($_SESSION['msg_result'])) {
            if($_SESSION['msg_result'] == INSERT_PARENT_OK) { ?>
                <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><b><?php echo $_SESSION['msg_result'];?></b></span></div></b>
          <?php } else { ?>
                <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><b><?php echo $_SESSION['msg_result'];?></b></span></div></b>
            <?php } }
          else {
          $_SESSION['msg_result'] = "";} } ?>
      <?php 
        if(isset($_GET['msg'])) {
          if(!empty($_GET['msg'])) { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><b><?php echo 'Session expired: try to login again.';?></b></span></div></b>
          <?php }
          $_GET['msg'] = "";} ?>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
    </form>
  <div>
</body>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

</html>