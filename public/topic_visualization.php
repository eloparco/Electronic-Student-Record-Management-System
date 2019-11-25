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
if(!userLoggedIn() || !userTypeLoggedIn('PARENT')) {   
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
if(isset($_SESSION['msg_result'])) {
  if(!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_PARENT_OK)) { 
      $_SESSION['msg_result'] = '';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include("includes/head.php");?>
    <link href="css/dashboard.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
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
    <?php include("includes/dashboard_parent.php"); ?> 

    <!-- TODO: To be adapted to parent dashboard
    <script>
    var homeElement = document.getElementById("homeDash");
    var recordMark = document.getElementById("recordMark");
    var recordLecture = document.getElementById("recordLecture");
    if (homeElement.classList)
      homeElement.classList.remove("active");
    if(recordLecture.classList) 
      recordLecture.classList.remove("active");
    if (recordMark.classList)
      recordMark.classList.add("active");
    </script>
      -->

    <div class="formContainer text-center">
        
        <div id="assignments_div" class="form-record">  
            <div id="compositionContainer" class="container">
                <!-- Child selection -->
                <div class="row">
                    <div class="col">
                        <h1 class="h3 mb-3 font-weight-normal">Student assignments</h1> 
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h3 id="compositionTitle" class="h3 mb-3 font-weight-normal">Weekly assignments</h3>
                        <img class="mb-4" src="images/icons/mark_recording.png" alt="" width="102" height="102">    
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="form-group-class">
                            <label for="studentSelection">Select a student</label>
                            <select class="form-control" id="studentSelection" name="student_SSN">
                                <option>Mario Rossi</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row" style="height: 30%;">
                        
                    <!-- Monday's assignments -->
                    <div class="col">
                        <h4>Monday</h4>
                        <div class="overflow-auto">
                            <ul id="mon_list" class="list-group" style="max-height: 400px; margin-bottom: 10px; overflow:scroll; -webkit-overflow-scrolling: touch;">
                                <li>There are no assignment for that day</li>
                            </ul>
                        </div>
                    </div>


                    <!-- Tuesday's assignments -->
                    <div class="col">
                        <h4>Tuesday</h4>
                        <div class="overflow-auto">
                            <ul id="tue_list" class="list-group" style="max-height: 400px; margin-bottom: 10px; overflow:scroll;-webkit-overflow-scrolling: touch;">
                                <li>There are no assignment for that day</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Wedsney's assignments -->
                    <div class="col">
                        <h4>Wedsney</h4>
                        <div class="overflow-auto">
                            <ul id="wed_list" class="list-group" style="max-height: 400px; margin-bottom: 10px; overflow:scroll;-webkit-overflow-scrolling: touch;">
                                <li>There are no assignment for that day</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Thursday's assignments -->
                    <div class="col">
                        <h4>Thursday</h4>
                        <div class="overflow-auto">
                            <ul id="thu_list" class="list-group" style="max-height: 400px; margin-bottom: 10px; overflow:scroll;-webkit-overflow-scrolling: touch;">
                                <li>There are no assignment for that day</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Friday's assignments -->
                    <div class="col">
                        <h4>Friday</h4>
                        <div class="overflow-auto">
                            <ul id="fri_list" class="list-group" style="max-height: 400px; margin-bottom: 10px; overflow:scroll;-webkit-overflow-scrolling: touch;">
                                <li>There are no assignment for that day</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

           <!-- Populate lists with an AJAX query -->
           <script>
            var child = "<?PHP echo $_SESSION['child']; ?>";
            // alert(child);

            
            $( document ).ready(function() {

              var minDate=new Date();
              var minDay=minDate.getDay();

              minDate.setDate( minDate.getDate() - (minDay - 1) );
              var maxDate=new Date();

              maxDate.setDate( maxDate.getDate() + (5 - minDay) );

              $.ajax({
                url: "get_assignments.php",
                data: {
                  "child": child,
                },

                type: "POST",
                success: function(data, state) {
                  var JSONdata = $.parseJSON(data);

                  if(JSONdata['state'] != "ok"){
                    console.log("Error: "+state);
                    return;
                  }

                  var resJSON = JSONdata['result'];
                  $("#mon_list").empty();

                  for(var i=0; i<resJSON.length; i++){
                    var item = resJSON[i];
                    var itemDate = new Date(item['Deadline']);

                    if(itemDate.getTime()>= minDate.getTime() && itemDate.getTime() <= maxDate.getTime()){
                      
                      switch(itemDate.getDay()){
                        case 1:
                          $("#mon_list").empty().append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                        case 2:
                          $("#tue_list").empty().append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                        case 3:
                          $("#wed_list").empty().append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                        case 4:
                          $("#thu_list").empty().append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                        case 5:
                          $("#fri_list").empty().append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                      }
                    }
                    //$fields = array("Subject" => $Subject, "Date" => $Date, "Deadline" => $Deadline, "Title" => $Title, "Description" => $Description);
                  }
                },
                error: function(request, state, error) {
                  console.log("State error " + state);
                  console.log("Value error " + error);
                }
              });
            });

          </script>
        
          <button class="btn btn-lg btn-primary btn-block" onClick="window.location.reload()">Refresh</button>
          </form>
      </div>
  </body>
</html>
