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
  /* LOGGED IN CHECK */
  if(userLoggedIn()) {
    $_SESSION['msg_result'] = "";
    header('Location: user_teacher.php'); //TODO: differentiate type of user (that means different page redirect)
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="css/main.css" rel="stylesheet">
</head>

<body>
  <?php include("includes/header.php"); ?>

  <main role="main" class="container">
    <h1 class="mt-5">Electronic Student Record Management System</h1>
    <p class="lead">System to support electronic student records for High Schools.</p>
  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>