<?php
  include("includes/config.php"); 
  require_once('utility.php');
  https_redirect();
  
  /* LOGGED IN CHECK */
  if(!userLoggedIn() || !userTypeLoggedIn('PARENT')) {   
    myRedirectTo('login.php', 'SessionTimeOut');
    exit;
  }
  if(isset($_SESSION[MSG])) {
    if(!empty($_SESSION[MSG]) && ($_SESSION[MSG] == LOGIN_PARENT_OK)) { 
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
    <link rel="stylesheet" type="text/css" href="css/w3.css"> 
    
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="./css/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.css">
    <?php  
      if(isset($_GET[MSG])) {
        if(!empty($_GET[MSG])) {
          $_GET[MSG] = "";
        }
      }
      
      // Delete cookie used for weekIndex
      if (isset($_COOKIE['weekIndex'])) {
        unset($_COOKIE['weekIndex']);
        setcookie('weekIndex', '', time() - 3600, '/'); // Empty value and old timestamp
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
    <?php include("includes/dashboard_parent.php"); ?> 
     
    <script>
    var homeElement = document.getElementById("homeNavig");
    var topicDashboardElement = document.getElementById("topic_dashboard");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
    }   
    if (topicDashboardElement.classList) {
      topicDashboardElement.classList.add("active");
    } 
    </script>

    <div class="col main formContainer text-center bg-light">
      <!--toggle sidebar button-->
      <p class="visible-xs" id="sidebar-toggle-btn">
        <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
          <em data-feather="menu"></em>
        </button>
      </p> 
        <div id="assignments_div" class="table-responsive col-md-9 ml-lg-15 ml-md-5 ml-sm-1 col-lg-8 pt-3 px-8">  
            <div id="compositionContainer" class="container">
                <div class="row">
                    <div class="col">                        
                        <img class="mb-4" src="images/icons/assignments.png" alt="" width="102" height="102">    
                    </div>
                </div>
                <!-- It's not necessary, the student is selected in the dashboard.
                <div class="row">
                    <div class="col-12">
                        <div class="form-group-class">
                            <label for="studentSelection">Select a student</label>
                            <select class="form-control" id="studentSelection" name="student_SSN">
                                php
                                    $children = get_children_of_parent($_SESSION['mySession']);
                                    foreach($children as $child){
                                      echo '<option value="' . $child['SSN'] . '">' . $child['Name'] . ' ' . $child['Surname'] . "</option>\n";
                                    }
                                
                            </select>
                        </div>
                    </div>
                </div>
                -->                
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

                  for(var i=0; i<resJSON.length; i++){
                    var item = resJSON[i];
                    var itemDate = new Date(item['Deadline']);

                    if( itemDate >= minDate && itemDate <= maxDate){

                      var c1, c2, c3, c4, c5 = false;//erase the content of each box, only for the first time
                      switch(itemDate.getDay()){
                        case 1:
                          if(!c1){
                            $("#mon_list").empty();
                            c1=true;
                          }
                          if(item['Attachment'] !== 'NULL')
                            $("#mon_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'Attachment: <a href="'+item['Attachment']+'">Link</a></p></li>');
                          else
                            $("#mon_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                        case 2:
                          if(!c2){
                            $("#tue_list").empty();
                            c2=true;
                          }
                          if(item['Attachment'] !== 'NULL')
                            $("#tue_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'Attachment: <a href="'+item['Attachment']+'">Link</a></p></li>');
                          else
                            $("#tue_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                        case 3:
                          if(!c3){
                            $("#wed_list").empty();
                            c3=true;
                          }
                          if(item['Attachment'] !== 'NULL')
                            $("#wed_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'Attachment: <a href="'+item['Attachment']+'">Link</a></p></li>');
                          else
                            $("#wed_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                        case 4:
                          if(!c4){
                            $("#thu_list").empty();
                            c4=true;
                          }
                          if(item['Attachment'] !== 'NULL')
                            $("#thu_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'Attachment: <a href="'+item['Attachment']+'">Link</a></p></li>');
                          else
                            $("#thu_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                           break;
                        case 5:
                          if(!c5){
                            $("#fri_list").empty();
                            c5=true;
                          }
                          if(item['Attachment'] !== 'NULL')
                            $("#fri_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'Attachment: <a href="'+item['Attachment']+'">Link</a></p></li>');
                          else
                            $("#fri_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
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

          <button class="btn btn-lg btn-outline-primary" onClick="prevWeekAssign()">
            <span class="glyphicon glyphicon-chevron-right"></span> << Previous week
          </button>

          <button class="btn btn-lg btn-outline-primary" onClick="nextWeekAssign()">
            <span class="glyphicon glyphicon-chevron-left"></span> Next week >>
          </button>

          <button style="margin-top: 15px;" class="btn btn-lg btn-primary btn-block" onClick="window.location.reload()">Refresh</button>

          <script>

            function prevWeekAssign(){
              var wkIndex = getCookie("weekIndex");

              if(wkIndex == "" || wkIndex == null){
                setCookie("weekIndex", "-1", "1");
                wkIndex = -1;
              } else {
                eraseCookie("weekIndex");
                wkIndex--;
                setCookie("weekIndex", ""+wkIndex, "1");
              }

              //alert("Cookie value: "+wkIndex);
              updateCalendar(wkIndex);
            }

            function nextWeekAssign(){
              var wkIndex = getCookie("weekIndex");

              if(wkIndex == "" || wkIndex == null){
                setCookie("weekIndex", "1", "1");
                wkIndex = 1;
              } else {
                eraseCookie("weekIndex");
                wkIndex++;
                setCookie("weekIndex", ""+wkIndex, "1");
              }

              //alert("Cookie value: "+wkIndex);
              updateCalendar(wkIndex);
            }

            function updateCalendar(weekIndex){
      
              var minDate=new Date();
              var minDay=minDate.getDay();

              minDate.setDate( minDate.getDate() - (minDay - 1) + 7*weekIndex);
              var maxDate=new Date();

              maxDate.setDate( maxDate.getDate() + (5 - minDay) +7*weekIndex);

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
                  $("#mon_list").empty().append("<li>There are no assignment for that day</li>");
                  $("#tue_list").empty().append("<li>There are no assignment for that day</li>");
                  $("#wed_list").empty().append("<li>There are no assignment for that day</li>");
                  $("#thu_list").empty().append("<li>There are no assignment for that day</li>");
                  $("#fri_list").empty().append("<li>There are no assignment for that day</li>");

                  for(var i=0; i<resJSON.length; i++){
                    var item = resJSON[i];
                    var itemDate = new Date(item['Deadline']);

                    if( itemDate >= minDate && itemDate <= maxDate){

                      var c1, c2, c3, c4, c5 = false;//erase the content of each box, only for the first time
                      switch(itemDate.getDay()){
                        case 1:
                          if(!c1){
                            $("#mon_list").empty();
                            c1=true;
                          }
                          if(item['Attachment'] !== 'NULL')
                            $("#mon_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'Attachment: <a href="'+item['Attachment']+'">Link</a></p></li>');
                          else
                            $("#mon_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                           break;
                        case 2:
                          if(!c2){
                            $("#tue_list").empty();
                            c2=true;
                          }
                          if(item['Attachment'] !== 'NULL')
                            $("#tue_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'Attachment: <a href="'+item['Attachment']+'">Link</a></p></li>');
                          else
                            $("#tue_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                        case 3:
                          if(!c3){
                            $("#wed_list").empty();
                            c3=true;
                          }
                          if(item['Attachment'] !== 'NULL')
                            $("#wed_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'Attachment: <a href="'+item['Attachment']+'">Link</a></p></li>');
                          else
                            $("#wed_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                        case 4:
                          if(!c4){
                            $("#thu_list").empty();
                            c4=true;
                          }
                          if(item['Attachment'] !== 'NULL')
                            $("#thu_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'Attachment: <a href="'+item['Attachment']+'">Link</a></p></li>');
                          else
                            $("#thu_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
                          break;
                        case 5:
                          if(!c5){
                            $("#fri_list").empty();
                            c5=true;
                          }
                          if(item['Attachment'] !== 'NULL')
                            $("#fri_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'Attachment: <a href="'+item['Attachment']+'">Link</a></p></li>');
                          else
                            $("#fri_list").append('<li class="list-group-item"><div class="d-flex w-100 justify-content-between"><h5>'+item['Title']+' '+item['Subject']+'</h5></div><p class="mb-1">Assignment date: '+item['Date']+' '+item['Description']+' Deadline:'+item['Deadline']+'</p></li>');
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
            }

            function setCookie(cname, cvalue, exdays) {
              var d = new Date();
              d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
              var expires = "expires="+d.toUTCString();
              document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }
                        
            function getCookie(cname) {
              var name = cname + "=";
              var decodedCookie = decodeURIComponent(document.cookie);
              var ca = decodedCookie.split(';');
              for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                  c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                  return c.substring(name.length, c.length);
                }
              }
              return "";
            }

            function eraseCookie(name) {   
                document.cookie = name+'=; Max-Age=-99999999;';  
            }
          </script>

          </form>
      </div>
  </body>
  <!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>
</html>
