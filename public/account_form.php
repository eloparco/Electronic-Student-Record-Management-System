<?php
include("includes/config.php"); 
require_once('utility.php');
https_redirect();
 
/* LOGGED IN CHECK */
if(!userLoggedIn() || !userTypeLoggedIn('SYS_ADMIN')) {   
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}

if(isset($_SESSION[MSG]) && !empty($_SESSION[MSG]) && ($_SESSION[MSG] == LOGIN_PARENT_OK ||
        $_SESSION[MSG] == LOGIN_SECRETARY_OK || $_SESSION[MSG] == LOGIN_TEACHER_OK ||
        $_SESSION[MSG] == LOGIN_PRINCIPAL_OK || $_SESSION[MSG] == LOGIN_ADMIN_OK)) { 
        $_SESSION[MSG] = ''; 
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
 
  <div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p>  
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
        if(isset($_SESSION[MSG])) {
          if(!empty($_SESSION[MSG])) {
            if($_SESSION[MSG] == INSERT_ACCOUNT_OK || $_SESSION[MSG] == UPDATE_ACCOUNT_OK) { ?>
                <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
          <?php } else { ?>
                <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
            <?php } 
            }
          else {
          $_SESSION[MSG] = "";
          } 
          } ?>
      <?php 
        if(isset($_GET['msg'])) {
          if(!empty($_GET['msg'])) { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo 'Session expired: try to login again.';?></strong></span></div></strong>
          <?php }
          $_GET['msg'] = "";
          } ?>
      <button class="btn btn-lg btn-primary btn-block" type="submit"  id="confirmInsertAccount">Submit</button>
    </form>
  </div>
  </div>
</div>
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
            // return;
          }
          var retJSON = JSONdata['state'];
         
          if(retJSON !== "error"){
            $("#inputName").val(JSONdata['result']['Name']);
            $("#inputSurname").val(JSONdata['result']['Surname']);
            $("#inputEmail").val(JSONdata['result']['Email']);
            
            // Disable the input
            $("#inputName").attr('readonly', true); 
            $("#inputSurname").attr('readonly', true); 
            $("#inputEmail").attr('readonly', true); 

          } else {
            $("#inputName").val("");
            $("#inputSurname").val("");
            $("#inputEmail").val("");

            // Enable input
            $("#inputName").attr('readonly', false); 
            $("#inputSurname").attr('readonly', false); 
            $("#inputEmail").attr('readonly', false); 
            
          }

        },
        error: function(request, state, error) {
          console.log("State error " + state);
          console.log("Value error " + error);
        }
      });
    }
</script>
</html>