<?php
include("includes/config.php"); 
require_once('utility.php'); 
https_redirect();

/* LOGGED IN CHECK */
if(!userLoggedIn() || !userTypeLoggedIn('SECRETARY_OFFICER')) {   
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <title></title> <!-- already set in head.php, here only to remove sonarcloud error -->
  <link href="css/dashboard.css" rel="stylesheet" type="text/css">
  <link href="css/responsive.css" rel="stylesheet" type="text/css">
</head>

<body>
  <?php include("includes/user_header.php"); ?> 
  <script>
    $(document).ready(function() {
      $('[data-toggle=offcanvas]').click(function() {
        $('.row-offcanvas').toggleClass('active');
      });
    });
  </script>
  <div class="container-fluid" style="height: 100%; margin-top:48px">
    <div class="row row-offcanvas row-offcanvas-left" style="height: 100%">
    <?php include("includes/dashboard_secretary.php"); ?> 
  <script>
    var homeElement = document.getElementById("homeDash");
    var recordParentElement = document.getElementById("recordParentDash");
    if (homeElement.classList) {
      homeElement.classList.add("active");
    }   
    if (recordParentElement.classList) {
        recordParentElement.classList.remove("active");
    } 
  </script>

  <div class="col main pt-3 bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p>  
    <h1 class="mt-5">User Secretary Officer Main Page</h1>
  </div>

</body>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

</html>