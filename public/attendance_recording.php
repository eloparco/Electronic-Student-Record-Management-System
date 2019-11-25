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
                        <th>15 min late</th>
                        <th>1 hour late</th>
                        <th>Early leaving</th>
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


                  /*
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Default radio
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                    <label class="form-check-label" for="exampleRadios2">
                        Second default radio
                    </label>
                    </div>
                  */

                  for(var i=0; i<resJSON.length; i++){
                    var item = resJSON[i];
                    //$("#studentSelection").append('<option value='+item["SSN"]+'>'+ item["Name"]+ ' '+ item["Surname"]+'</option>');
                    $('#classTable > tbody:last-child').append(
                                '<tr id='+item["SSN"]+'><div class="form-check">'
                                
                                +'<td>'+(i+1)+'</td>'
                                +'<td>'+item["Name"]+' '+item["Surname"]+'</td>'
                                +'<td>'+item["SSN"]+'</td>'
                                +'<td><input class="form-check-input" type="radio" name="exampleRadios" id="presentRadio" value="option1" checked></td>'
                                +'<td><input class="form-check-input" type="radio" name="exampleRadios" id="absentRadio" value="option1"></td>'
                                +'<td><input class="form-check-input" type="radio" name="exampleRadios" id="late15Radio" value="option1"></td>'
                                +'<td><input class="form-check-input" type="radio" name="exampleRadios" id="late60Radio" value="option1"></td>'
                                +'<td><input class="form-check-input" type="radio" name="exampleRadios" id="leavingRadio" value="option1"></td>'
                                +'</div></tr>');

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
</body>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace() //for the icons
</script>

</html>