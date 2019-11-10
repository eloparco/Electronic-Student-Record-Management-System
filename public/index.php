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
  if(userLoggedIn()) { //stay in 'user page' until you do logout
    $_SESSION['msg_result'] = "";
    switch($_SESSION['myUserType']) {
      case 'TEACHER':
        header('Location: user_teacher.php');
        break;
      case 'PARENT':
        header('Location: user_parent.php');
        break;
      case 'SECRETARY_OFFICER':
        header('Location: user_secretary.php');
        break;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <script>
    var homeElement = document.getElementById("homeNav");
    var loginElement = document.getElementById("loginNav");
    if (homeElement.classList) {
      homeElement.classList.add("active");
    }   
    if (loginElement.classList) {
      loginElement.classList.remove("active");
    } 
  </script>
  <main role="main" class="container">
    <h1 class="mt-5">Electronic Student Record Management System</h1>
    <p class="lead">System to support electronic student records for High Schools.</p>
  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>