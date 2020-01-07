<?php
include("includes/config.php"); 
require_once('utility.php');
https_redirect();
 
/* LOGGED IN CHECK */
if(!userLoggedIn() || !userTypeLoggedIn('TEACHER')) {   
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
if(isset($_SESSION[MSG]) && !empty($_SESSION[MSG]) && $_SESSION[MSG] == LOGIN_TEACHER_OK) { 
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
    <link rel="stylesheet" type="text/css" href="css/w3.css"> 
    <script src="https://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>
    
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="./css/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.css">
    <?php  
      if(isset($_GET[MSG]) && !empty($_GET[MSG])) {
        $_GET[MSG] = "";
      }
    ?>
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
  <?php include("includes/dashboard_teacher.php"); ?> 

    <script>
        var homeElement = document.getElementById("homeDash");
        var recordMark = document.getElementById("recordMark");
        var recordLecture = document.getElementById("recordLecture");
        var recordAttendance = document.getElementById("recordAttendance");
        var publishMaterial = document.getElementById("publishMaterial");

        if (homeElement.classList)
            homeElement.classList.remove("active");
        if (recordLecture.classList)
            recordLecture.classList.remove("active");
        if (recordMark.classList)
            recordMark.classList.remove("active");
        if (recordAttendance.classList)
            recordAttendance.classList.remove("active");
        if (publishMaterial.classList)
            publishMaterial.classList.add("active");
    </script>

<div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p> 
      <form enctype="multipart/form-data" id="markRecForm" class="form-record col-md-9 ml-lg-15 ml-md-5 ml-sm-1 col-lg-8 pt-3 px-4"  action="upload_support_material.php" method="POST" name="post_support_material">
          <img class="mb-4" src="images/icons/publish_support_material.png" alt="" width="102" height="102">
          <h1 class="h3 mb-3 font-weight-normal">Publish Support Material</h1>
          <!-- Class selection -->
          <div class="form-group-class">
              <label for="classSelection">Select a class and a subject</label>
              <select class="form-control" id="classSelection" name="class_sID_ssn" required></select>
          </div>

           <!-- Setup class selection with AJAX query -->
           <script>
            var user = "<?PHP echo $_SESSION["mySession"]; ?>";
            $( document ).ready(function() {
              $.ajax({
                url: "subject_info.php",
                data: {
                  "user_mail": user,
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
                    $("#classSelection").append('<option value='+item["Class"]+'_'+ item["ID"]+'_'+item["SSN"]+'>'+ item["Class"]+ ' '+ item["Name"]+'</option>');
                  }
                },
                error: function(request, state, error) {
                  console.log("State error " + state);
                  console.log("Value error " + error);
                }
              });
            });
        	</script>

        	<div class="form-group-class">
            	<label for="supportMaterialFileSelection">Select a file</label>
              <input type="hidden" name="MAX_FILE_SIZE" value="30000000">
							<input class="file btn-primary" name="userfile" type="file" required>							
					</div>

            <!-- POST Method response -->
          <?php 
          if(isset($_SESSION[MSG])) {
          if(!empty($_SESSION[MSG])) {
            if($_SESSION[MSG] != 'File correctly uploaded.'){ ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
          <?php } else { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
          <?php
          }
        }
          $_SESSION[MSG] = "";
          } ?>    
          <button class="btn btn-lg btn-primary btn-block" type="submit" value= "sendFile" >Upload</button>
          </form>
      </div>
  </body>
  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
    feather.replace() //for the icons    
  </script>
</html>