<?php 
include("includes/config.php"); 
require_once('utility.php');
https_redirect();
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

    <form class="form-signin" action="validation_password.php" method="post">
      <img class="mb-4" src="images/login.svg" alt="" width="102" height="102">
      <h1 class="h3 mb-3 font-weight-normal">Update password</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" name="username" class="form-control" placeholder="Email address" required autofocus>
      <label for="inputOldPassword" class="sr-only">Current password</label>
      <input type="password" name="oldPassword" class="form-control" placeholder="Current password" pattern="(?=.*[a-z])(?=.*[A-Z\d]).+" title="Password must contain at least one lowercase alphabetic character, and at least another uppercase alphabetic character or numeric character." required>
      <label for="inputNewPassword" class="sr-only">New Password</label>
      <input type="password" name="newPassword" class="form-control" placeholder="New password" pattern="(?=.*[a-z])(?=.*[A-Z\d]).+" title="Password must contain at least one lowercase alphabetic character, and at least another uppercase alphabetic character or numeric character." required>
      <?php 
        if(isset($_SESSION[MSG])) {
          if(!empty($_SESSION[MSG])) { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong></span></div>
          <?php }
          $_SESSION[MSG] = "";} ?>
      <?php 
        if(isset($_GET['msg'])) {
          if(!empty($_GET['msg'])) { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo 'Session expired: try to login again.';?></strong></span></div></strong></span></div>
          <?php }
          $_GET['msg'] = "";} ?>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Send Request</button>
    </form>

  <?php include("includes/footer.php"); ?>
</body>

</html>