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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="css/main.css" rel="stylesheet">
</head>

<body>
  <?php include("includes/header.php"); ?> <!-- TODO: remove login button in header -->

  <main role="main" class="container">
    <h1 class="mt-5">User Parent Page - TODO</h1>
  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>