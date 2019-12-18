<?php
include("includes/config.php");
require_once('utility.php');
https_redirect();

/* LOGGED IN CHECK */
if (!userLoggedIn() || !userTypeLoggedIn('TEACHER')) {
    myRedirectTo('login.php', 'SessionTimeOut');
    exit;
}
if (isset($_SESSION[MSG])) {
    if (!empty($_SESSION[MSG]) && ($_SESSION[MSG] == LOGIN_TEACHER_OK)) {
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
<link rel="stylesheet" type="text/css" href="css/w3.css">
<script src="https://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="./css/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.css">
<?php
if (isset($_GET[MSG])) {
    if (!empty($_GET[MSG])) {
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

<div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p>  
    <div id="attendance-rec-div" class="table-responsive col-md-12 ml-lg-15 ml-sm-1 col-lg-10 col-sm-11 pt-3 px-8">
        <div id="compositionContainer" class="">  
        <div class="row">
            <div class="col">                        
                <img class="mb-4" src="images/icons/attendance_recording.png" alt="" width="102" height="102">
                <h1 class="h3 mb-3 font-weight-normal">Attendance recording</h1>
            </div>
        </div>  
        <!-- Class selection -->
        <div class="row">
            <div class="col form-group-class">
                <label for="classSelection">Select a class</label>
                <select class="form-control" id="classSelection" name="class_sID_ssn">
                    <!-- <option>1A</option> -->
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">
        <table class="col table" id="classTable">
            <thead>
                <tr>
                    <th id="idNum">#</th>
                    <th id="student">Student</th>
                    <th id="ssn">SSN</th>
                    <th id="present">Present</th>
                    <th id="absent">Absent</th>
                    <th id="10minLate">10 min late</th>
                    <th id="1hourLate">1 hour late</th>
                    <th id="earlyLeaving">Early leaving</th>
                    <th id="leavingHour">Leaving hour</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
        <div class="formContainer text-center bg-light">
            <button class="btn btn-lg btn-primary btn-block col-md-5 ml-lg-1 ml-md-2 ml-sm-2 col-lg-4 pt-1 px-4" id="confirm" onClick="registerAttendance()">Confirm</button>
        </div>
        </div>
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
            url: "students_attendance.php",
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
                var leavingHour = item['ExitHour'];

                if(leavingHour === null || leavingHour === 6)
                    leavingHour="";

                if(item['Presence'] == "ABSENT"){ // Absent
                    $('#classTable > tbody:last-child').append(
                            '<tr><form id='+item['SSN']+'>'
                        
                            +'<td>'+(i+1)+'</td>'
                            +'<td>'+item["Name"]+' '+item["Surname"]+'</td>'
                            +'<td>'+item["SSN"]+'</td>'
                            //new attribute for="" needed to identify globally radio buttons during tests
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)"class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'presentRadio" for="'+item["SSN"]+'presentRadio" value="present"></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'absentRadio" for="'+item["SSN"]+'absentRadio" value="absent" checked></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'late15Radio" for="'+item["SSN"]+'late15Radio" value="late15m"></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'late60Radio" for="'+item["SSN"]+'late60Radio" value="late1h"></div></td>'
                            +'<td><div class="form-check"><input onclick="enableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'leavingRadio" for="'+item["SSN"]+'leavingRadio" value="leave"></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)"class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="presentRadio"  value="present"></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="absentRadio"  value="absent" checked></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="late15Radio"  value="late15m"></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="late60Radio"  value="late1h"></div></td>'
                            // +'<td><div class="form-check"><input onclick="enableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="leavingRadio"  value="leave"></td>'
                                +'<td><div class="input-group date">'
                                    +'<input type="text"  pattern="[0-5]" class="form-control" id="'+item["SSN"]+'tp" name="'+item["SSN"]+'earlyleavingText" disabled="disabled" value="'+leavingHour+'"/>'
                                    +'<span class="input-group-addon">'
                                        +'<span class="glyphicon glyphicon-time"></span>'
                                    +'</span>'
                                +'</div>'
                            +'</div></td>'
                            +'</form></tr>');
                } else if(item['Presence'] == "10_MIN_LATE"){ // 10 minutes late
                    $('#classTable > tbody:last-child').append(
                            '<tr><form id='+item['SSN']+'>'
                            
                            +'<td>'+(i+1)+'</td>'
                            +'<td>'+item["Name"]+' '+item["Surname"]+'</td>'
                            +'<td>'+item["SSN"]+'</td>'
                            //new attribute for="" needed to identify globally radio buttons during tests
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)"class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'presentRadio" for="'+item["SSN"]+'presentRadio" value="present"></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'absentRadio" for="'+item["SSN"]+'absentRadio" value="absent"></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'late15Radio" for="'+item["SSN"]+'late15Radio" value="late15m" checked></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'late60Radio" for="'+item["SSN"]+'late60Radio" value="late1h"></div></td>'
                            +'<td><div class="form-check"><input onclick="enableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'leavingRadio" for="'+item["SSN"]+'leavingRadio" value="leave"></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)"class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="presentRadio"  value="present"></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="absentRadio"  value="absent"></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="late15Radio"  value="late15m" checked></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="late60Radio"  value="late1h"></div></td>'
                            // +'<td><div class="form-check"><input onclick="enableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="leavingRadio"  value="leave"></td>'
                                +'<td><div class="input-group date">'
                                    +'<input type="text"  pattern="[0-5]" class="form-control" id="'+item["SSN"]+'tp" name="'+item["SSN"]+'earlyleavingText" disabled="disabled" value="'+leavingHour+'"/>'
                                    +'<span class="input-group-addon">'
                                        +'<span class="glyphicon glyphicon-time"></span>'
                                    +'</span>'
                                +'</div>'
                            +'</div></td>'
                            +'</form></tr>');
                } else if(item['Presence'] == "1_HOUR_LATE"){ // 1 hour late
                    $('#classTable > tbody:last-child').append(
                            '<tr><form id='+item['SSN']+'>'
                            
                            +'<td>'+(i+1)+'</td>'
                            +'<td>'+item["Name"]+' '+item["Surname"]+'</td>'
                            +'<td>'+item["SSN"]+'</td>'
                            //new attribute for="" needed to identify globally radio buttons during tests
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)"class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'presentRadio" for="'+item["SSN"]+'presentRadio" value="present"></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'absentRadio" for="'+item["SSN"]+'absentRadio" value="absent"></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'late15Radio" for="'+item["SSN"]+'late15Radio" value="late15m"></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'late60Radio" for="'+item["SSN"]+'late60Radio" value="late1h" checked></div></td>'
                            +'<td><div class="form-check"><input onclick="enableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'leavingRadio" for="'+item["SSN"]+'leavingRadio" value="leave"></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)"class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="presentRadio"  value="present"></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="absentRadio"  value="absent"></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="late15Radio"  value="late15m"></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="late60Radio"  value="late1h" checked></div></td>'
                            // +'<td><div class="form-check"><input onclick="enableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="leavingRadio"  value="leave"></td>'
                                +'<td><div class="input-group date">'
                                    +'<input type="text"  pattern="[0-5]" class="form-control" id="'+item["SSN"]+'tp" name="'+item["SSN"]+'earlyleavingText" disabled="disabled" value="'+leavingHour+'"/>'
                                        +'<span class="glyphicon glyphicon-time"></span>'
                                    +'</span>'
                                +'</div>'
                            +'</div></td>'
                            +'</form></tr>');
                } else { // Student present
                    $('#classTable > tbody:last-child').append(
                            '<tr><form id='+item['SSN']+'>'
                            
                            +'<td>'+(i+1)+'</td>'
                            +'<td>'+item["Name"]+' '+item["Surname"]+'</td>'
                            +'<td>'+item["SSN"]+'</td>'
                            //new attribute for="" needed to identify globally radio buttons during tests
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)"class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'presentRadio" for="'+item["SSN"]+'presentRadio" value="present" checked></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'absentRadio" for="'+item["SSN"]+'absentRadio" value="absent"></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'late15Radio" for="'+item["SSN"]+'late15Radio" value="late15m"></div></td>'
                            +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'late60Radio" for="'+item["SSN"]+'late60Radio" value="late1h"></div></td>'
                            +'<td><div class="form-check"><input onclick="enableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="'+item["SSN"]+'leavingRadio" for="'+item["SSN"]+'leavingRadio" value="leave"></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)"class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="presentRadio"  value="present" checked></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="absentRadio"  value="absent"></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="late15Radio"  value="late15m"></div></td>'
                            // +'<td><div class="form-check"><input onclick="disableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="late60Radio"  value="late1h"></div></td>'
                            // +'<td><div class="form-check"><input onclick="enableHour(\'' + item["SSN"] + '\', this)" class="form-check-input" type="radio" name="'+item["SSN"]+'Radios" id="leavingRadio"  value="leave"></td>'
                                +'<td><div class="input-group date">'
                                    +'<input type="text"  pattern="[0-5]" class="form-control" id="'+item["SSN"]+'tp" name="'+item["SSN"]+'earlyleavingText" disabled="disabled" value="'+leavingHour+'"/>'
                                    +'<span class="input-group-addon">'
                                        +'<span class="glyphicon glyphicon-time"></span>'
                                    +'</span>'
                                +'</div>'
                            +'</div></td>'
                            +'</form></tr>');
                }
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
            var check_if_all_ok = true;
            $('#classTable > tbody:last-child > tr').each(function(index, tr) {
                var SSN = tr.cells[2].innerText;
                var date = new Date();
                var value;
                var exitHour = 0;
                var updateDB = true;
                var recordLeaving = false;
                var absent = false;

                // Present
                if(tr.getElementsByTagName("input")[0].checked){ 
                    value = "PRESENT";
                    updateDB = false;
                } else if(tr.getElementsByTagName("input")[1].checked) { // Absent
                    value = "ABSENT";
                    exitHour = 0;
                    absent = true;
                } else if(tr.getElementsByTagName("input")[2].checked){  // Late 10 min
                    value = "10_MIN_LATE";
                    exitHour = 0;
                } else if(tr.getElementsByTagName("input")[3].checked){  // Late 1 hour
                    value = "1_HOUR_LATE";
                    exitHour = 0;
                } else if(tr.getElementsByTagName("input")[4].checked){  // Leaving early
                    recordLeaving = true;
                    exitHour = tr.getElementsByTagName("input")[5].value;
                }

                if(updateDB){
                    if(!recordLeaving && !absent){
                        //alert("DEBUG: Late 10 min / 1h");
                        $.ajax({ // Late 10 min / 1h
                            url: "register_attendance.php", // Late 10 min - Late 1 hour 
                            data: { "SSN": SSN,
                                    "Date":  date.toISOString().substr(0, 10),
                                    "Presence": value
                            },

                            type: "POST",
                            success: function(data, state) {
                                //alert(data);
                                var JSONdata = $.parseJSON(data);

                                if(JSONdata['state'] != "ok"){
                                    console.log("Error: "+state);
                                    check_if_all_ok = false;
                                    return;
                                }   else {
                                    //alert("Action sucessfully executed.");                                    
                                }
                                
                            },
                            error: function(request, state, error) {
                            console.log("State error " + state);
                            console.log("Value error " + error);
                            }
                        });
                    } else if(absent){ // absent
                        //alert("DEBUG: absent");
                        $.ajax({
                            url: "register_absent.php",
                            data: { "SSN": SSN,
                                    "Date":  date.toISOString().substr(0, 10)
                            },

                            type: "POST",
                            success: function(data, state) {
                                //alert(data);
                                var JSONdata = $.parseJSON(data);

                                if(JSONdata['state'] != "ok"){
                                    console.log("Error: "+state);
                                    check_if_all_ok = false;
                                    return;
                                }   else {
                                    //alert("Action sucessfully executed.");
                                }
                                
                            },
                            error: function(request, state, error) {
                            console.log("State error " + state);
                            console.log("Value error " + error);
                            }
                        });
                    }else { // early leaving
                        //alert("DEBUG: early leaving");
                        
                        if(exitHour < 1 || exitHour >= 6){
                            alert("Please insert a valid value for field: leaving hour, in range: [1-5]");
                            return;
                        }

                        $.ajax({
                            url: "register_leaving.php",
                            data: { "SSN": SSN,
                                    "Date":  date.toISOString().substr(0, 10),
                                    "ExitHour": exitHour
                            },

                            type: "POST",
                            success: function(data, state) {
                                //alert(data);
                                var JSONdata = $.parseJSON(data);

                                if(JSONdata['state'] != "ok"){
                                    console.log("Error: "+state);
                                    check_if_all_ok = false;
                                    return;
                                }   else {
                                    //alert("Action sucessfully executed.");
                                }
                                
                            },
                            error: function(request, state, error) {
                            console.log("State error " + state);
                            console.log("Value error " + error);
                            }
                        });

                    }
                } else {
                    $.ajax({
                            url: "student_to_present.php",
                            data: { "SSN": SSN,
                                    "Date":  date.toISOString().substr(0, 10)
                            },

                            type: "POST",
                            success: function(data, state) {
                                //alert(data);
                                var JSONdata = $.parseJSON(data);

                                if(JSONdata['state'] != "ok"){
                                    console.log("Error: "+state);
                                    check_if_all_ok = false;
                                    return;
                                }   else {
                                    //alert("Action sucessfully executed.");
                                }
                                
                            },
                            error: function(request, state, error) {
                            console.log("State error " + state);
                            console.log("Value error " + error);
                            }
                        });

                } 
            });
            if(check_if_all_ok){
                alert("Action sucessfully executed.");
            } else 
                alert("Something went wrong, retry.");
        }
    </script>
</body>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace() //for the icons
</script>

</html>