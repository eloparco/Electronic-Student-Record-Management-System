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
    <link href="css/dashboard.css" rel="stylesheet" type="text/css">
    <link href="css/responsive.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
      integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
    <link rel="stylesheet" type="text/css" href="css/w3.css"> 
    <script src="https://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>
    
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="./css/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.css">
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
      var recordLecture = document.getElementById("recordAssignment");
      if (homeElement.classList)
        homeElement.classList.remove("active");
      if(recordMark.classList) 
        recordMark.classList.remove("active");
      if (recordLecture.classList)
        recordLecture.classList.add("active");
    </script>

<div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p>  
    <form class="form-record col-md-9 ml-lg-15 ml-md-5 ml-sm-1 col-lg-7 pt-3 px-4" action="record_assignment.php" method="post" name="post_recording" enctype="multipart/form-data"> 
    <img class="mb-4" src="images/icons/lecture_recording.png" alt="" width="102" height="102">  
    <h1 class="h3 mb-3 font-weight-normal" id='lessonRecordingTitle'>Lesson recording</h1>
      <!-- Class and subject selection -->
      <div class="form-group-class">
        <label for="classSelection">Select a class and a subject</label>
        <select class="form-control" id="classSelection" name="class_sID_ssn"></select>
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

        <!-- Text area for title -->
        <div class="form-group-text">
          <label for="topicTitleTextArea">Insert the assignment title</label>
          <textarea class="form-control" id="topicTitleTextArea" rows="1" name="title"></textarea>
        </div>

        <!-- Text area for description -->
        <div class="form-group-text">
          <label for="lectureTextArea">Insert the assignment description</label>
          <textarea class="form-control" id="lectureTextArea" rows="3" name="subtitle"></textarea>
        </div>

         <!-- Date picker -->
      <div class="form-group-class">
        <label for="dataSelection" class="col-form-label">Select a deadline</label>
        <input type="text" class="form-control" id="dataSelection" name="date">
      </div>

      <!-- Setup datepicker -->
      <script>
        var minDate=new Date();
        var minDay=minDate.getDay();

        minDate.setDate( minDate.getDate() + 1 );
/*
        var maxDate=new Date();

        maxDate.setDate( maxDate.getDate() + (5 - minDay) );
*/
        $('#dataSelection').datepicker({
            format: 'yyyy-mm-dd',
            startDate: minDate,
            todayBtn: true,
            daysOfWeekDisabled: "0,6",
            autoclose: true
        });
        
      </script>
        

       <!-- Attachment upload -->
       <div class="input-group">

            <div class="custom-file">
                 <input id="attachment" class="custom-file-input" type="file" name="file">
                 <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div>
        <script>
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        </script>

        <!-- POST Method response -->
        <?php 
          if(isset($_SESSION[MSG])) {
          if(!empty($_SESSION[MSG])) {
            if($_SESSION[MSG] != ASSIGNMENT_RECORDING_OK){ ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
          <?php } else { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
          <?php
          }
          }
          $_SESSION[MSG] = "";
          } ?>

        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <span>&nbsp;</span>
          </div>
        </div>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="confirm">Confirm</button>


        <!-- Assignment already loaded -->
        <div id="assignments_list">
            <label for="assignments">Assignment already uploaded</label>
                <ul id="assignments" class="list-group">
        </select>
        </div>


    </form>

    <script>
        $( document ).ready(function() {
            $.ajax({
                    url: "get_all_assignment.php",
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
                        if(resJSON.length === 0){
                          var assignList = document.getElementById('assignments_list');
                          assignList.style.display = 'none';
                        } else {
                          for(var i=0; i<resJSON.length; i++){
                              var item = resJSON[i];
                              // $fields = array("Class" => $Class, "Date" => $Date, "Deadline" => $Deadline, 
                              //                 "Title" => $Title, "Description" => $Description, "Attachment" => $Attachment);
                              $("#assignments").append("<li class='list-group-item'>Title: "+item['Title']+" Date: "+item['Date']+" Deadline: "+item['Deadline']+"</li>");   
                          }
                        }
                    },
                    error: function(request, state, error) {
                        console.log("State error " + state);
                        console.log("Value error " + error);
                    }
            });
        });
    </script>

  </div>
  </body>
  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
      feather.replace()
  </script>
</html>