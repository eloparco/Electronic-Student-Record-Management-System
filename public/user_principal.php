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
if(!userLoggedIn() || !userTypeLoggedIn('PRINCIPAL')) {   
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
  <?php include("includes/dashboard_principal.php"); ?> 
  <div class="col main pt-3 bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p>    
    <h1 class="mt-5">User Principal Main Page</h1>
  </div>
  
</body>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

</html>