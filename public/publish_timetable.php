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
if (!userLoggedIn() || !userTypeLoggedIn('SECRETARY_OFFICER')) {
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
if (isset($_SESSION['msg_result'])) {
  if (!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_SECRETARY_OK)) {
    $_SESSION['msg_result'] = '';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="css/dashboard.css" rel="stylesheet" type="text/css">

  <link rel="stylesheet" type="text/css" href="css/customForm.css">
  <link rel="stylesheet" type="text/css" href="css/w3.css">
</head>

<body>
  <?php include("includes/user_header.php"); ?>
  <?php include("includes/dashboard_secretary.php"); ?>

  <script>
    var homeElement = document.getElementById("homeDash");
    var visualizeMarkElement = document.getElementById("publish_timetable_dashboard");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
    }
    if (visualizeMarkElement.classList) {
      visualizeMarkElement.classList.add("active");
    }
  </script>

  <div class="formContainer text-center">
    <form class="form-signin col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" action="upload_timetable.php" method="post" enctype="multipart/form-data">
      <img class="mb-4" src="images/icons/publish_timetable.png" alt="" width="102" height="102">
      <h1 class="h3 mb-3 font-weight-normal">Select CSV file <br>to import as timetable</h1>
      <p class="lead text-muted">Format:<br> 6 rows: one for each hour<br> 5 columns: one for each day</p>
      <input type="file" id="fileToUpload" class="form-control mt-4">
      <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Submit</button>
    </form>
  </div>
</body>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
  feather.replace();
</script>

</html>