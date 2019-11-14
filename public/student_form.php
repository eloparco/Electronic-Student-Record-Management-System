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

if(isset($_SESSION['msg_result'])) {
    if(!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_PARENT_OK ||
        $_SESSION['msg_result'] == LOGIN_SECRETARY_OK || $_SESSION['msg_result'] == LOGIN_TEACHER_OK)) { 
        $_SESSION['msg_result'] = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="../css/dashboard.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="css/customForm.css">
  <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
  <link rel="stylesheet" type="text/css" href="css/student_form.css">
  <link rel="stylesheet" type="text/css" href="css/w3.css">
  <script src="https://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>
</head>

<body>
  <?php include("includes/user_header.php"); ?> 
  <?php include("includes/dashboard_secretary.php"); ?> 

  <script>
    var homeElement = document.getElementById("homeDash");
    var recordParentElement = document.getElementById("recordParentDash");
    var recordStudentElement = document.getElementById("recordStudentDash");
    var setupClassElement = document.getElementById("setupClassDash");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
      recordParentElement.classList.remove("active");
      setupClassElement.classList.remove("active");
    }   
    if (recordStudentElement.classList)
        recordStudentElement.classList.add("active");
  </script>

  <div class="formContainer text-center">
    <form id="myStudentForm" class="form-signin col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" action="insert_student.php" method="post">

      <img class="mb-4" src="images/icons/student.png" alt="" width="102" height="102">
      <h1 id="myFormTitle" class="h3 mb-3 font-weight-normal">Enter student data</h1>
      <label for="inputSSN" class="sr-only">SSN</label>
      <input type="text" id="inputSSN" name="SSN" class="form-control" placeholder="SSN" pattern=".{16}" title="Please insert 16 alphanumeric characters." required autofocus>
      <label for="inputName" class="sr-only">Name</label>
      <input type="text" id="inputName" name="name" class="form-control" placeholder="Name" pattern=".{2,20}" title="Please insert a name with length between 2 and 20." required>
      <label for="inputSurname" class="sr-only">Surname</label>
      <input type="text" id="inputSurname" name="surname" class="form-control" placeholder="Surname" pattern=".{2,20}" title="Please insert a name with length between 2 and 20." required>
      
       <!-- Parent 1 selection -->
       <div id="parent1Div" class="form-group-class">
            <label for="parent1Selection">Parent #1</label>
            <select class="form-control" id="parent1Selection" name="parent1">
              <!-- <option>Parent 1</option> -->
           </select>
        </div>
         
       <!-- Parent 2 selection -->
       <div class="form-group-class">
            <label for="parent2Selection">Parent #2</label>
            <select class="form-control" id="parent2Selection" name="parent2">
              <!-- <option>Parent 2</option> -->
           </select>
        </div>

        <!-- Setup class selection with AJAX query -->
        <script>
            var user = "<?PHP echo $_SESSION["mySession"]; ?>";
            $( document ).ready(function() {
              $.ajax({
                url: "parents.php",
                data: {
                },

                type: "POST",
                success: function(data, state) {
                  var JSONdata = $.parseJSON(data);

                  if(JSONdata['state'] != "ok"){
                    console.log("Error: "+state);
                    return;
                  }

                  var resJSON = JSONdata['result'];

                  for(var i=0; i<resJSON.length; i++){
                    var item = resJSON[i];
                    // alert("Class " + item['Class'] + " Name " + item['Name'] + " ID " + item['ID'] + " SSN " + item['SSN'] );
                    $("#parent1Selection").append('<option value='+item["SSN"]+'>'+item["SSN"]+' </option>');
                    $("#parent2Selection").append('<option value='+item["SSN"]+'>'+item["SSN"]+' </option>');
                  }
                },
                error: function(request, state, error) {
                  console.log("State error " + state);
                  console.log("Value error " + error);
                }
              });
            });
          </script>


         <!-- Class selection -->
         <div class="form-group-class">
              <label for="classSelection">Class</label>
              <select class="form-control" id="classSelection" name="class">
                <!-- <option>1A</option> -->
              </select>
          </div>

           <!-- Setup class selection with AJAX query -->
           <script>
            var user = "<?PHP echo $_SESSION["mySession"]; ?>";
            $( document ).ready(function() {
              $.ajax({
                url: "classes.php",
                data: {
                },

                type: "POST",
                success: function(data, state) {
                  var JSONdata = $.parseJSON(data);

                  if(JSONdata['state'] != "ok"){
                    console.log("Error: "+state);
                    return;
                  }

                  var resJSON = JSONdata['result'];

                  for(var i=0; i<resJSON.length; i++){
                    var item = resJSON[i];
                    // alert("Class " + item['Class'] + " Name " + item['Name'] + " ID " + item['ID'] + " SSN " + item['SSN'] );
                    $("#classSelection").append('<option value= '+item["Class"]+'>'+item["Class"]+' </option>');
                  }
                },
                error: function(request, state, error) {
                  console.log("State error " + state);
                  console.log("Value error " + error);
                }
              });
            });
          </script>
          <!-- POST Method response -->
        <?php 
        if(isset($_SESSION['msg_result'])) {
          if(!empty($_SESSION['msg_result'])) {
            if($_SESSION['msg_result'] != STUDENT_RECORDING_OK){ ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><b><?php echo $_SESSION['msg_result'];?></b></span></div></b>
          <?php } else { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><b><?php echo $_SESSION['msg_result'];?></b></span></div></b>
          <?php
          }}
          $_SESSION['msg_result'] = "";} ?>
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