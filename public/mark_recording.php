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
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include("includes/head.php");?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
    <link rel="stylesheet" type="text/css" href="css/w3.css"> 
    <link href="css/lecture_rec.css" rel="stylesheet">
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
    <?php include("includes/header.php"); ?>
    
    <main role="main" class="container-fluid">
    <div class="bootstrap-iso">
      <h1 class="h3 mb-3 font-weight-normal">Mark recording</h1>
        <form action="record_mark.php" method="post" name="post_mark_recording">

          <!-- Class selection -->
          <div class="form-group-class">
              <label for="classSelection">Select a class and a subject</label>
              <select class="form-control" id="classSelection" name="class_sID_ssn">
                <!-- <option>1A</option> -->
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
              <select class="form-control" id="hourSelection" name ="hour">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
              </select>
            </div>

            <!-- Mark selection -->
            <div class="form-group-hour">
              <label for="hourSelection">Select the score</label>
              <select class="form-control" id="hourSelection" name="score">
                <option>1</option>
                <option>1.5</option>
                <option>2</option>
                <option>2.5</option>
                <option>3</option>
                <option>3.5</option>
                <option>4</option>
                <option>4.5</option>
                <option>5</option>
                <option>5.5</option>
                <option>6</option>
                <option>6.5</option>
                <option>7</option>
                <option>7.5</option>
                <option>8</option>
                <option>8.5</option>
                <option>9</option>
                <option>9.5</option>
                <option>10</option>
                <option>10L</option>
              </select>
            </div>      
            <button class="btn btn-lg btn-primary btn-block" type="submit">Confirm</button>
          </form>

           <!-- POST Method response -->
           <?php 
        if(isset($_SESSION['msg_result'])) {
          if(!empty($_SESSION['msg_result'])) {
            if($_SESSION['msg_result'] != MARK_RECORDING_OK){ ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><b><?php echo $_SESSION['msg_result'];?></b></span></div></b></span></div>
          <?php } else { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom w3-text-green"><span><b><?php echo $_SESSION['msg_result'];?></b></span></div></b></span></div>
          <?php
          }}
          $_SESSION['msg_result'] = "";} ?>
      </div>
    </main>

    <?php include("includes/footer.php"); ?>
  </body>
</html>