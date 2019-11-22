<?php
include("includes/config.php");
require_once('utility.php');
/* HTTPS CHECK */
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') { } else {
  $redirectHTTPS = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  myRedirectToHTTPS($redirectHTTPS);
  exit;
}
check_inactivity();
if (!isset($_SESSION))
  session_start();

/* LOGGED IN CHECK */
if (!userLoggedIn() || !userTypeLoggedIn('PARENT')) {
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
if (isset($_SESSION['msg_result'])) {
  if (!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_PARENT_OK)) {
    $_SESSION['msg_result'] = '';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="css/dashboard.css" rel="stylesheet" type="text/css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.js"></script>
</head>

<body>
  <?php include("includes/user_header.php"); ?>
  <?php include("includes/dashboard_parent.php"); ?>

  <main role="main" class="container">
    <div id="calendar"></div>
  </main>

  <?php 
    $message = get_attendance("MDUHPG46H50I748J");
    print_r($message);
  ?>
  
</body>

<script>
  $('#calendar').fullCalendar({
    weekends: false,
    eventClick: function(calEvent, jsEvent, view) {

    }
  });
</script>

</html>