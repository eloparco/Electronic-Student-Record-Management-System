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
session_start();
if(isset($_SESSION['msg_result'])) {
  if(!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_TEACHER_OK ||
    $_SESSION['msg_result'] == LOGIN_PARENT_OK || $_SESSION['msg_result'] == LOGIN_SECRETARY_OK ||
    $_SESSION['msg_result'] == LOGIN_PRINCIPAL_OK || $_SESSION['msg_result'] == LOGIN_ADMIN_OK)) { 
      $_SESSION['msg_result'] = '';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <title></title> <!-- already set in head.php, here only to remove sonarcloud error -->
  <link rel="stylesheet" type="text/css" href="css/signin.css">
  <link rel="stylesheet" type="text/css" href="css/w3.css">
</head>

<body class="text-center">
  <?php include("includes/header.php"); ?>
  <script>
    var homeElement = document.getElementById("homeNav");
    var loginElement = document.getElementById("loginNav");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
    }   
    if (loginElement.classList) {
      loginElement.classList.add("active");
    } 
  </script>
    <form class="form-signin" action="validation.php" method="post" id="login_form">
      <img class="mb-4" src="images/login.svg" alt="" width="102" height="102">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" name="username" class="form-control" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" pattern="(?=.*[a-z])(?=.*[A-Z\d]).+" title="Password must contain at least one lowercase alphabetic character, and at least another uppercase alphabetic character or numeric character." required>
      <?php 
        if(isset($_SESSION['msg_result'])) {
          if(!empty($_SESSION['msg_result'])) { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo $_SESSION['msg_result'];?></strong></span></div></strong></span></div>
          <?php }
          $_SESSION['msg_result'] = "";} ?>
      <?php 
        if(isset($_GET['msg'])) {
          if(!empty($_GET['msg'])) { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo 'Session expired: try to login again.';?></strong></span></div></strong></span></div>
          <?php }
          $_GET['msg'] = "";} ?>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

  <?php include("includes/footer.php"); ?>
</body>

</html>