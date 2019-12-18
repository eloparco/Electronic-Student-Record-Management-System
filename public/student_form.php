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
        $_SESSION[MSG] == INSERT_PARENT_OK || $_SESSION[MSG] == PUBLISH_TIMETABLE_OK ||
        $_SESSION[MSG] == COMMUNICATION_RECORDING_OK ||
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
  <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
  <link rel="stylesheet" type="text/css" href="css/student_form.css">
  <link rel="stylesheet" type="text/css" href="css/w3.css">
  <script src="https://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>
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
      recordParentElement.classList.remove("active");
      setupClassElement.classList.remove("active");
    }   
    if (recordStudentElement.classList)
        recordStudentElement.classList.add("active");
  </script>

<div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p> 
      <form id="myStudentForm" class="form-signin col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" action="insert_student.php" method="post">
      <img class="mb-4" src="images/icons/student.png" alt="" width="102" height="102">
      <h1 id="myFormTitle" class="h3 mb-3 font-weight-normal">Enter student data</h1>
      <label for="inputSSN" class="sr-only">SSN</label>
      <input type="text" id="inputSSN" name="SSN" class="form-control" placeholder="SSN" pattern=".{16}" title="Please insert 16 alphanumeric characters." required autofocus>
      <label for="inputName" class="sr-only">Name</label>
      <input type="text" id="inputName" name="name" class="form-control" placeholder="Name" pattern=".{2,20}" title="Please insert a name with length between 2 and 20." required>
      <label for="inputSurname" class="sr-only">Surname</label>
      <input type="text" id="inputSurname" name="surname" class="form-control" placeholder="Surname" pattern=".{2,20}" title="Please insert a name with length between 2 and 20." required>
      
      <!-- AJAX check for duplicate SSN -->
      <script>


         $("#inputSSN").change(function() {
              $.ajax({
                url: "students.php",
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
                    var currSSN = resJSON[i]["SSN"];
                    if($(inputSSN).val() === currSSN){
                      // alert("This SSN it's already registered. Please insert a new one.");
                      $(inputSSN).val("");
                      $("#duplicateError").show();
                      return;
                    }
                  }
                  $("#duplicateError").hide();
                },
                error: function(request, state, error) {
                  console.log("State error " + state);
                  console.log("Value error " + error);
                }
              });
            });
      </script>

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

          <div id="duplicateError" class="alert alert-danger" role="alert" style="display:none">
            This SSN it's already registered. Please insert a new one.
          </div>

          <!-- POST Method response -->
        <?php 
        if(isset($_SESSION[MSG])) {
          if(!empty($_SESSION[MSG])) {
            if($_SESSION[MSG] != STUDENT_RECORDING_OK){ ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
          <?php } else { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
          <?php
          }}
          $_SESSION[MSG] = "";} ?>
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