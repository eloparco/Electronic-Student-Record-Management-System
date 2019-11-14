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
  if(!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_TEACHER_OK)) { 
      $_SESSION['msg_result'] = '';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include("includes/head.php");?>
    <link href="../css/dashboard.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
      integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
    <link rel="stylesheet" type="text/css" href="css/w3.css"> 
    <script src="https://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>
    
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="./css/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.css">
    <?php  
      if(isset($_GET['msg_result'])) {
        if(!empty($_GET['msg_result'])) {
          $_GET['msg_result'] = "";
        }
      }
    ?>
 </head>

  <body>
    <?php include("includes/user_header.php"); ?>
    <?php include("includes/dashboard_teacher.php"); ?> 

    <script>
      var homeElement = document.getElementById("homeDash");
      var recordMark = document.getElementById("recordMark");
      var recordLecture = document.getElementById("recordLecture");
      if (homeElement.classList)
        homeElement.classList.remove("active");
      if(recordMark.classList) 
        recordMark.classList.remove("active");
      if (recordLecture.classList)
        recordLecture.classList.add("active");
    </script>

  <div class="formContainer text-center">
    <form class="form-record col-md-9 ml-lg-15 ml-md-5 ml-sm-1 col-lg-4 pt-3 px-4" action="record_topic.php" method="post" name="post_recording"> 
    <img class="mb-4" src="images/icons/lecture_recording.png" alt="" width="102" height="102">  
    <h1 class="h3 mb-3 font-weight-normal">Lesson recording</h1>
      <!-- Class and subject selection -->
      <div class="form-group-class">
        <label for="classSelection">Select a class and a subject</label>
        <select class="form-control" id="classSelection" name="class_sID_ssn">
          <!-- <option>1A</option> -->
        </select>
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
                // alert("Class " + item['Class'] + " Name " + item['Name'] + " ID " + item['ID'] + " SSN " + item['SSN'] );
                $("#classSelection").append('<option value= '+item["Class"]+'_'+ item["ID"]+'_'+item["SSN"]+'>'+ item["Class"]+ ' '+ item["Name"]+'</option>');
              }
            },
            error: function(request, state, error) {
              console.log("State error " + state);
              console.log("Value error " + error);
            }
          });
        });
      </script>

      <!-- Date picker -->
      <div class="form-group-class">
        <label for="dataSelection" class="col-form-label">Select a date</label>
        <input type="text" class="form-control" id="dataSelection" name="date">
      </div>

      <!-- Setup datepicler -->
      <script>
        var minDate=new Date();
        var minDay=minDate.getDay();

        minDate.setDate( minDate.getDate() - (minDay - 1) );

        var maxDate=new Date();

        maxDate.setDate( maxDate.getDate() + (5 - minDay) );

        $('#dataSelection').datepicker({
            format: 'dd/mm/yyyy',
            startDate: minDate,
            endDate: maxDate,
            todayBtn: true,
            daysOfWeekDisabled: "0,6",
            autoclose: true
        });
        
      </script>

        <!-- Hour selection -->
        <div class="form-group-hour">
          <label for="hourSelection">Select an hour</label>
          <select class="form-control" id="hourSelection" name="hour">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
          </select>
        </div>
        
        <!-- Text area for lecture's topic recording -->
        <div class="form-group-text">
          <label for="topicTitleTextArea">Insert the lecture title</label>
          <textarea class="form-control" id="topicTitleTextArea" rows="1" name="title"></textarea>
        </div>

        <!-- Text area for lecture's topic recording -->
        <div class="form-group-text">
          <label for="lectureTextArea">Insert the lecture topics</label>
          <textarea class="form-control" id="lectureTextArea" rows="3" name="subtitle"></textarea>
        </div>        
        <!-- POST Method response -->
        <?php 
          if(isset($_SESSION['msg_result'])) {
          if(!empty($_SESSION['msg_result'])) {
            if($_SESSION['msg_result'] != TOPIC_RECORDING_OK){ ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><b><?php echo $_SESSION['msg_result'];?></b></span></div></b>
          <?php } else { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><b><?php echo $_SESSION['msg_result'];?></b></span></div></b>
          <?php
          }}
          $_SESSION['msg_result'] = "";} ?>    
          <button class="btn btn-lg btn-primary btn-block" type="submit">Confirm</button>
    </form>
  </div>
  </body>
  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
      feather.replace()
  </script>
</html>