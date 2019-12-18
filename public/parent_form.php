<?php
include("includes/config.php"); 
require_once('utility.php');
https_redirect();
 
/* LOGGED IN CHECK */
if(!userLoggedIn() || !userTypeLoggedIn('SECRETARY_OFFICER')) {   
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}

if(isset($_SESSION[MSG])) {
    if(!empty($_SESSION[MSG]) && ($_SESSION[MSG] == LOGIN_PARENT_OK ||
        $_SESSION[MSG] == LOGIN_SECRETARY_OK || $_SESSION[MSG] == LOGIN_TEACHER_OK ||
        $_SESSION[MSG] == LOGIN_PRINCIPAL_OK || $_SESSION[MSG] == LOGIN_ADMIN_OK)) { 
        $_SESSION[MSG] = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <title></title> <!-- already set in head.php, here only to remove sonarcloud error -->
  <link href="css/dashboard.css" rel="stylesheet" type="text/css">
  <link href="css/responsive.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="css/customForm.css">
  <link rel="stylesheet" type="text/css" href="css/w3.css">
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
    var recordStudentElement = document.getElementById("recordStudentDash");
    var setupClassElement = document.getElementById("setupClassDash");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
      recordStudentElement.classList.remove("active");
      setupClassElement.classList.remove("active");
    }   
    if (recordParentElement.classList) {
        recordParentElement.classList.add("active");
    } 
  </script>

<div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p> 
    <form id="myParentForm" class="form-signin col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" action="validation_parent.php" method="post">
    <img id="parentImg" class="mb-4" src="images/icons/parent.png" alt="" width="102" height="102">
    <h1 class="h3 mb-3 font-weight-normal">Enter parent data</h1>
    <label for="inputSSN" class="sr-only">SSN</label>
    <input type="text" id="inputSSN" name="ssn" class="form-control" placeholder="SSN" pattern=".{16}" title="Please insert 16 alphanumeric characters." required autofocus>
    <label for="inputName" class="sr-only">Name</label>
    <input type="text" id="inputName" name="name" class="form-control" placeholder="Name" pattern=".{2,20}" title="Please insert a name with length between 2 and 20." required>
    <label for="inputSurname" class="sr-only">Surname</label>
    <input type="text" id="inputSurname" name="surname" class="form-control" placeholder="Surname" pattern=".{2,20}" title="Please insert a name with length between 2 and 20." required>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="username" class="form-control" placeholder="Email address" required>
      <?php 
        if(isset($_SESSION[MSG])) {
          if(!empty($_SESSION[MSG])) {
            if($_SESSION[MSG] == INSERT_PARENT_OK) { ?>
                <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
          <?php } else { ?>
                <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
            <?php } }
          else {
          $_SESSION[MSG] = "";} } ?>
      <?php 
        if(isset($_GET['msg'])) {
          if(!empty($_GET['msg'])) { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo 'Session expired: try to login again.';?></strong></span></div></strong>
          <?php }
          $_GET['msg'] = "";} ?>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
    </form>
  <div>
</body>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

</html>