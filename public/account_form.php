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
if(!userLoggedIn() || !userTypeLoggedIn('ADMIN')) {   
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}

if(isset($_SESSION['msg_result'])) {
    if(!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_PARENT_OK ||
        $_SESSION['msg_result'] == LOGIN_SECRETARY_OK || $_SESSION['msg_result'] == LOGIN_TEACHER_OK ||
        $_SESSION['msg_result'] == LOGIN_PRINCIPAL_OK || $_SESSION['msg_result'] == LOGIN_ADMIN_OK)) { 
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
  <!--<link href="https://maxcdn.bootstrapcdn.com/bootswatch/4.0.0-beta.3/materia/bootstrap.min.css" rel="stylesheet"/>-->
</head>

<body>
  <?php include("includes/user_header.php"); ?> 
  <?php include("includes/dashboard_admin.php"); ?> 

  <script>
    var homeElement = document.getElementById("homeNavig");
    var setupAccountsElement = document.getElementById("setupAccountDash");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
    }   
    if (setupAccountsElement.classList) {
      setupAccountsElement.classList.add("active");
    } 
  </script>

  <div class="formContainer text-center">
    <form id="myAccountForm" class="form-signin col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" action="validation_account.php" method="post">
      <img id="accountImg" class="mb-4" src="images/icons/account.png" alt="" width="102" height="102">
      <h1 class="h3 mb-3 font-weight-normal">Enter account data</h1>
      <label for="inputSSN" class="sr-only">SSN</label>
      <input type="text" id="inputSSN" onblur="tryAutocomplete(this)" name="ssn" class="form-control" placeholder="SSN" pattern=".{16}" title="Please insert 16 alphanumeric characters." required autofocus>
      <label for="inputName" class="sr-only">Name</label>
      <input type="text" id="inputName" name="name" class="form-control" placeholder="Name" pattern=".{2,20}" title="Please insert a name with length between 2 and 20." required>
      <label for="inputSurname" class="sr-only">Surname</label>
      <input type="text" id="inputSurname" name="surname" class="form-control" placeholder="Surname" pattern=".{2,20}" title="Please insert a name with length between 2 and 20." required>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" name="username" class="form-control" placeholder="Email address" required>
      <div>
      <div class="form-group">
      <div class="col-sm-11" style="margin-left: 10px;">
        <label for="input-type">Account Type:</label>
        <div id="input-type" class="row">
            <div class="col-sm-4">
                <label class="radio-inline">
                    <input name="account_type" id="input-type-teacher" value="TEACHER" type="radio" />Teacher
                </label>
            </div>
            <div class="col-sm-4">
                <label class="radio-inline">
                    <input name="account_type" id="input-type-secretary" value="SECRETARY_OFFICER" type="radio" />Secretary
                </label>
            </div>
            <div class="col-sm-4">
                <label class="radio-inline">
                    <input name="account_type" id="input-type-principal" value="PRINCIPAL" type="radio" />Principal
                </label>
            </div>
        </div>
      </div>
      </div>
    </div>
      <?php 
        if(isset($_SESSION['msg_result'])) {
          if(!empty($_SESSION['msg_result'])) {
            if($_SESSION['msg_result'] == INSERT_ACCOUNT_OK || $_SESSION['msg_result'] == UPDATE_ACCOUNT_OK) { ?>
                <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><b><?php echo $_SESSION['msg_result'];?></b></span></div></b>
          <?php } else { ?>
                <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><b><?php echo $_SESSION['msg_result'];?></b></span></div></b>
            <?php } }
          else {
          $_SESSION['msg_result'] = "";} } ?>
      <?php 
        if(isset($_GET['msg'])) {
          if(!empty($_GET['msg'])) { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><b><?php echo 'Session expired: try to login again.';?></b></span></div></b>
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

    function tryAutocomplete(inputSSN) {
      var ssn = inputSSN.value;
      $.ajax({
        url: "autocomplete_form.php",
        data: {
          "ssn": ssn,
        },
        type: "POST",
        success: function(data, state) {
          var JSONdata = $.parseJSON(data);
          if(JSONdata['state'] != "ok") {
            console.log("Error: " + state);
            return;
          }
          var resJSON = JSONdata['result'];
          $("#inputName").val(resJSON['Name']);
          $("#inputSurname").val(resJSON['Surname']);
          $("#inputEmail").val(resJSON['Email']);
        },
        error: function(request, state, error) {
          console.log("State error " + state);
          console.log("Value error " + error);
        }
      });
    }
</script>

</html>