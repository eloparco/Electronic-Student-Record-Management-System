<?php
include("includes/config.php"); 
require_once('utility.php');
https_redirect();
 
/* LOGGED IN CHECK */
if(!userLoggedIn() || !userTypeLoggedIn('TEACHER')) {   
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
if(isset($_SESSION[MSG])) {
  if(!empty($_SESSION[MSG]) && ($_SESSION[MSG] == LOGIN_TEACHER_OK)) { 
      $_SESSION[MSG] = '';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include("includes/head.php");?>
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
      if(isset($_GET[MSG])) {
        if(!empty($_GET[MSG])) {
          $_GET[MSG] = "";
        }
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
    var recordNote = document.getElementById("recordNote");
    var recordFinalMark = document.getElementById("recordFinalMarks");

    if (homeElement.classList)
      homeElement.classList.remove("active");
    if(recordLecture.classList) 
      recordLecture.classList.remove("active");
    if (recordMark.classList)
      recordMark.classList.remove("active");
    if (recordNote.classList)
      recordNote.classList.remove("active");
    if(recordFinalMark.classList)
        recordFinalMark.classList.add("active");
    </script>

<div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p> 
    <form id="markRecForm" class="form-record col-md-9 ml-lg-15 ml-md-5 ml-sm-1 col-lg-7 pt-3 px-4" action="record_final_mark.php" method="post">
        <img class="mb-4" src="images/icons/mark_recording.png" alt="" width="102" height="102">
        <h1 class="h3 mb-3 font-weight-normal">Final mark recording</h1>
        <!-- Class selection -->
        <div class="form-group-class">
            <label for="classSelection">Select a class and a subject</label>
            <select class="form-control" id="classSelection" name="class_sID_ssn">
              <!-- <option>1A</option> -->
              <option></option>
            </select>
        </div>

        <!-- Show student of the selected class with AJAX query -->
        <script>
          $(document).ready(function() {
            $('#classSelection').change(function(){
              $.ajax({
              url: "class_students.php",
              data: {
                "class": this.value.split("_")[0],
              },

              type: "POST",
              success: function(data, state) {

                //alert(data);
                var JSONdata = $.parseJSON(data);

                if(JSONdata['state'] != "ok"){
                  console.log("Error: "+state);
                  return;
                }
                var resJSON = JSONdata['result'];
                $("#studentSelection").empty();

                for(var i=0; i<resJSON.length; i++){
                  var item = resJSON[i];

                  $("#studentSelection").append('<option value='+item["SSN"]+'>'+ item["Name"]+ ' '+ item["Surname"]+'</option>');
                }
              },
              error: function(request, state, error) {
                console.log("State error " + state);
                console.log("Value error " + error);
              }
            });
          });
        });
        
        </script>

          <!-- Setup class selection with AJAX query -->
          <script>
          var user = "<?PHP echo $_SESSION["mySession"]; ?>";
          $( document ).ready(function() {
            $.ajax({
              url: "coordinator_subject_info.php",
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

        <!-- Student selection -->
        <div class="form-group-class">
          <label for="studentSelection">Select a student</label>
          <select class="form-control" id="studentSelection" name="student">
            <!-- <option>Science</option> -->
          </select>
        </div>

        <!-- Mark selection -->
        <div class="form-group-hour">
            <label for="hourSelection">Select the score</label>
            <div id="selection" class="form-group-hour">
              <select class="form-control" id="scoreSelection" name="score">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>10L</option>
              </select>
            </div>  
          </div>  


          <!-- Use CSV file -->
          
          <label for="fileinput">Upload a CSV file with marks</label>
          
          <input type="file" id="fileinput" />
          <script>
            function readSingleFile(evt) {
              var f = evt.target.files[0]; 
             
              if (f) {
                var r = new FileReader();
                r.onload = function(e) { 
                  if(f.type != "csv"){
                    alert("The file must be in a CSV format.");
                    return;
                  }
                  
                  var contents = e.target.result;
                  var lines = contents.split("\n"), output = [];
             
                  for (var i=0; i<lines.length; i++){
                    var fields = lines[i].split(",");
                      
                    var student = fields[0];
                    var subject = fields[1];
                    var score = fields [2];
                
                    if(student != ""){
                      $.ajax({
                        type : "POST", 
                        url  : "record_final_mark_csv.php",
                        data : { student : student, subject : subject, score : score },
                        success: function(JSONres){  
                          var res = JSON.parse(JSONres);

                          var succesCode = "<?php echo MARK_RECORDING_OK;?>";
                          if(res['result'] != succesCode){
                            alert("Error during mark recording with values: "+res['tuple']+" values are not valid.");
                          } else {
                            alert("Mark successfully recorded for values: "+res['tuple']);
                          }
                        },
                        
                        error: function (xhr, ajaxOptions, thrownError) {
                          alert("Error during mark recording with values: "+res['tuple']+" values are not valid.");
                        }
                      });
                    }
                  }
                }
                r.readAsText(f);
              } else { 
                alert("Failed to load file");
              }
            }
            document.getElementById('fileinput').addEventListener('change', readSingleFile);
          </script>
        
        
        <!-- POST Method response -->
          <?php 
        if(isset($_SESSION[MSG])) {
        if(!empty($_SESSION[MSG])) {
          if($_SESSION[MSG] != MARK_RECORDING_OK){ ?>
          <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
        <?php } else { ?>
          <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
        <?php
        }}
        $_SESSION[MSG] = "";} ?>    
        <button class="btn btn-lg btn-primary btn-block" type="submit">Confirm</button>
        </form>
      </div>
  </body>
  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
    feather.replace() //for the icons
  </script>
</html>