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
$children = get_children_of_parent($_SESSION['mySession']);
if(!empty($children)){
  $_SESSION['child'] = $children[0]['SSN'];
  $_SESSION['childFullName'] = $children[0]['Name'].$children[0]['Surname'].' - '.$children[0]['SSN'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="css/dashboard.css" rel="stylesheet" type="text/css">
</head>

<body>
  <?php include("includes/user_header.php"); ?> 
  <?php include("includes/dashboard_parent.php"); ?> 

  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <h1 class="mt-5">User Parent Main Page</h1>
  </main>
  
</body>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

</html>