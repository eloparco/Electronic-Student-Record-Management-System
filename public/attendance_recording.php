<?php
include("includes/config.php");
require_once('utility.php');
/* HTTPS CHECK */
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') { } else {
    $redirectHTTPS = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    myRedirectToHTTPS($redirectHTTPS);
    exit;
}
check_inactivity();
if (!isset($_SESSION))
    session_start();

/* LOGGED IN CHECK */
if (!userLoggedIn() || !userTypeLoggedIn('TEACHER')) {
    myRedirectTo('login.php', 'SessionTimeOut');
    exit;
}
if (isset($_SESSION['msg_result'])) {
    if (!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_TEACHER_OK)) {
        $_SESSION['msg_result'] = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("includes/head.php"); ?>
    <link href="css/dashboard.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
<link rel="stylesheet" type="text/css" href="css/w3.css">
<script src="https://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="./css/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.css">
<?php
if (isset($_GET['msg_result'])) {
    if (!empty($_GET['msg_result'])) {
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
        var recordAttendance = document.getElementById("recordAttendance");

        if (homeElement.classList)
            homeElement.classList.remove("active");
        if (recordLecture.classList)
            recordLecture.classList.remove("active");
        if (recordMark.classList)
            recordMark.classList.remove("active");
        if (recordAttendance.classList)
            recordAttendance.classList.add("active");
    </script>

    <div class="formContainer text-center">
        <div class="table-responsive col-md-9 ml-lg-15 ml-md-5 ml-sm-1 col-lg-8 pt-3 px-8">
            <img class="mb-4" src="images/icons/mark_recording.png" alt="" width="102" height="102">
            <h1 class="h3 mb-3 font-weight-normal">Attendance recording</h1>
            <!-- Class selection -->
            <div class="form-group-class">
                <label for="classSelection">Select a class</label>
                <select class="form-control" id="classSelection" name="class_sID_ssn">
                    <!-- <option>1A</option> -->
                    <option></option>
                </select>
            </div>
            <table class="table" id="classTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>SSN</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>10 min late</th>
                        <th>1 hour late</th>
                        <th>Early leaving</th>
                        <th>Leaving hour</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- Setup class selection with AJAX query -->
        <script>
            var user = "<?PHP echo $_SESSION["mySession"]; ?>";
            $(document).ready(function() {
                $.ajax({
                    url: "class_info.php",
                    data: {
                        "user_mail": user,
                    },

                    type: "POST",
                    success: function(data, state) {
                        var JSONdata = $.parseJSON(data);

                        if (JSONdata['state'] != "ok") {
                            console.log("Error: " + state);
                            return;
                        }

                        var resJSON = JSONdata['result'];

                        for (var i = 0; i < resJSON.length; i++) {
                            var item = resJSON[i];
                            // alert("Class " + item['Class'] + " Name " + item['Name'] + " ID " + item['ID'] + " SSN " + item['SSN'] );
                            $("#classSelection").append('<option value=' + item["Class"] + '_' + item["SSN"] + '>' + item["Class"] + '</option>');

                        }
                    },
                    error: function(request, state, error) {
                        console.log("State error " + state);
                        console.log("Value error " + error);
                    }
                });
            });
        </script>

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
                  $('#classTable > tbody:last-child').empty();

                  for(var i=0; i<resJSON.length; i++){
                    var item = resJSON[i];
                    //$("#studentSelection").append('<option value='+item["SSN"]+'>'+ item["Name"]+ ' '+ item["Surname"]+'</option>');
                    $('#classTable > tbody:last-child').append(
                                '<tr><form id='+item['SSN']+'>'
                                
                                +'<td>'+(i+1)+'</td>'
                                +'<td>'+item["Name"]+' '+item["Surname"]+'</td>'
                                +'<td>'+item["SSN"]+'</td>'
                                +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)"class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="presentRadio" value="present" checked></div></td>'
                                +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="absentRadio" value="absent"></div></td>'
                                +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="late15Radio" value="late15m"></div></td>'
                                +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="late60Radio" value="late1h"></div></td>'
                                +'<td><div class="form-check"><input onclick="enableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="leavingRadio" value="leave"></td>'
                                    +'<td><div class="input-group date">'
                                        +'<input type="text" class="form-control" id="'+item["SSN"]+'tp" disabled="disabled"/>'
                                        +'<span class="input-group-addon">'
                                            +'<span class="glyphicon glyphicon-time"></span>'
                                        +'</span>'
                                    +'</div>'
                                +'</div></td>'
                                +'</form></tr>');
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
    </div>
    <div class="formContainer text-center">
        <button class="btn btn-lg btn-primary btn-block col-md-1 ml-lg-1 ml-md-2 ml-sm-2 col-lg-4 pt-1 px-4" id="confirm" onClick="registerAttendance()">Confirm</button>
    </div>

    <script>
        
        function enableHour(id, radioButton){

            var inputId = id+"tp";
            
            if(radioButton.checked){
                $('#'+inputId).attr("disabled", false);
            } else {
                $('#'+inputId).attr("disabled", true);
            }
        }

        function disableHour(id, radioButton){

            var inputId = id+"tp";

            if(radioButton.checked){
                $('#'+inputId).attr("disabled", true);
            } 
        }

        function registerAttendance(){
            $('#classTable > tbody:last-child > tr').each(function(index, tr) {
                var SSN = tr.cells[2].innerText;
                var date = new Date();
                var value;
                var exitHour = 0;
                var updateDB = true;
                var recordLeaving = false;
                
                // Present
                if(tr.getElementsByTagName("input")[0].checked){ 
                    value = "PRESENT";
                    updateDB = false;
                } else if(tr.getElementsByTagName("input")[1].checked) { // Absent
                    value = "ABSENT";
                    exitHour = 0;
                } else if(tr.getElementsByTagName("input")[2].checked){  // Late 10 min
                    value = "10_MIN_LATE";
                    exitHour = 0;
                } else if(tr.getElementsByTagName("input")[3].checked){  // Late 1 hour
                    value = "1_HOUR_LATE";
                    exitHour = 0;
                } else if(tr.getElementsByTagName("input")[4].checked){  // Leaving eary
                    recordLeaving = true;
                    exitHour = tr.getElementsByTagName("input")[5].value;
                }

                // alert("INSERT INTO `ATTENDANCE`(`StudentSSN`, `Date`, `Presence`, `ExitHour`) VALUES ("+SSN+", "+date.toISOString().substr(0, 10)+", "+value+", "+exitHour+");");

                if(updateDB){
                    if(!recordLeaving){
                        $.ajax({
                            url: "register_attendance.php",
                            data: { "SSN": SSN,
                                    "Date":  date.toISOString().substr(0, 10),
                                    "Presence": value
                            },

                            type: "POST",
                            success: function(data, state) {
                                // alert(data);
                                var JSONdata = $.parseJSON(data);

                                if(JSONdata['state'] != "ok"){
                                    console.log("Error: "+state);
                                    return;
                                }   else {
                                    alert("Action sucessfully executed.");
                                }
                                
                            },
                            error: function(request, state, error) {
                            console.log("State error " + state);
                            console.log("Value error " + error);
                            }
                        });
                    } else {
                        $.ajax({
                            url: "register_leaving.php",
                            data: { "SSN": SSN,
                                    "Date":  date.toISOString().substr(0, 10),
                                    "ExitHour": exitHour
                            },

                            type: "POST",
                            success: function(data, state) {
                                var JSONdata = $.parseJSON(data);

                                if(JSONdata['state'] != "ok"){
                                    console.log("Error: "+state);
                                    return;
                                }   else {
                                    alert("Action sucessfully executed.");
                                }
                                
                            },
                            error: function(request, state, error) {
                            console.log("State error " + state);
                            console.log("Value error " + error);
                            }
                        });

                    }
                } 
            });
        }
    </script>
</body>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace() //for the icons
</script>

</html>