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
if(!userLoggedIn() || !userTypeLoggedIn('SECRETARY_OFFICER')) {   
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include("includes/head.php");?>
    <link href="css/dashboard.css" rel="stylesheet" type="text/css">
    <link href="css/responsive.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
      integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
    <link rel="stylesheet" type="text/css" href="css/class_composition.css">
    <link rel="stylesheet" type="text/css" href="css/w3.css"> 
    <script src="https://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>    
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
    <script>
    $(document).ready(function() {
      $('[data-toggle=offcanvas]').click(function() {
        $('.row-offcanvas').toggleClass('active');
      });
    });
  </script>
  <div class="container-fluid" style="height: 100%; margin-top:48px">
    <div class="row row-offcanvas row-offcanvas-left" style="height: 100%">
    <?php include("includes/dashboard_secretary.php"); ?> 

    <script>
      var homeElement = document.getElementById("homeDash");
      var recordParentElement = document.getElementById("recordParentDash");
      var recordStudentElement = document.getElementById("recordStudentDash");
      var setupClassElement = document.getElementById("setupClassDash");
      if (homeElement.classList) {
        homeElement.classList.remove("active");
        recordStudentElement.classList.remove("active");
        recordParentElement.classList.remove("active");
      }   
      if (setupClassElement.classList) {
        setupClassElement.classList.add("active");
      } 
    </script>

<div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <i data-feather="menu"></i>
      </button>
    </p> 
    <div id="compositionDiv" class="form-record col-md-9 ml-lg-15 ml-md-5 ml-sm-1 col-lg-7 pt-4 px-4">
      <img class="mb-4" src="images/icons/composition.svg" alt="" width="102" height="102">  
      <h1 id="compositionTitle" class="h3 mb-3 font-weight-normal">Class composition</h1>
          <div id="compositionContainer" class="container">
              <div class="row" style="height: 30%;">

                  <div class="col-sm">
                      <!-- Student list -->
                      <h4>Select the student</h4>
                      <div class="overflow-auto">
                          <ul id="student_list" class="list-group" style="max-height: 400px; margin-bottom: 10px; overflow:scroll; -webkit-overflow-scrolling: touch;"></ul>
                      </div>
                  </div>
                  <div class="col-sm-1"></div>
                  <div class="col-sm">
                      <!-- Student of the new class list -->
                      <h4>Students of the new class</h4>
                      <div class="overflow-auto">
                          <ul id="new_student_list" class="list-group" style="max-height: 400px; margin-bottom: 10px; overflow:scroll;-webkit-overflow-scrolling: touch;"></ul>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Setup students list with AJAX -->
          <script>
              var user = "<?PHP echo $_SESSION["mySession"]; ?>";
              $( document ).ready(function() {
                  $.ajax({
                      url: "students.php",
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

                      for(var i=0; i<resJSON.length; i++){
                          var item = resJSON[i];
                          // alert("Class " + item['Class'] + " Name " + item['Name'] + " ID " + item['ID'] + " SSN " + item['SSN'] );
                          $("#student_list").append('<li studentID="'+item['SSN']+'" class="list-group-item  list-group-item-action"><div class="d-flex w-100 justify-content-between"><h5>'+item['SSN']+'</h5></div><p class="mb-1">'+item['Name']+' '+item['Surname']+' '+item['Class']+'</p></li>');
                      }
                      },
                      error: function(request, state, error) {
                      console.log("State error " + state);
                      console.log("Value error " + error);
                      }
                  });
              });
          </script>

        <!-- Handle the click event -->
        <script>
          $(function() {
              $("#student_list li div").live("click",function() {
                  var index = $(this).parent('li').index();
                  var id = $(this).parent('li').attr("studentID");
                  var exist = false;

                  $("#new_student_list").find('li').each(function(j, li){
                          if(li.getAttribute("studentID") == id){
                              exist = true;
                          }
                  });

                  if(!exist)
                      $("#new_student_list").append('<li studentID='+id+' class="list-group-item list-group-item-action">'+$(this).parent('li').html()+'</li>');
                  else
                      alert("Student already selected.")
              });
          });
        </script>

          <!-- Year selection -->
          <div class="form-group-hour">
            <label for="yearSelection">Select the year and the label of the new class</label>
            <select class="form-control" id="yearSelection" name="year">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
            <select class="form-control" id="letterArea" name="letter">
              <option>A</option>
              <option>B</option>
              <option>C</option>
              <option>D</option>
              <option>E</option>
              <option>F</option>
              <option>G</option>
              <option>H</option>
              <option>I</option>
              <option>J</option>
              <option>K</option>
              <option>L</option>
              <option>M</option>
              <option>N</option>
              <option>O</option>
              <option>P</option>
              <option>Q</option>
              <option>R</option>
              <option>S</option>
              <option>T</option>
              <option>U</option>
              <option>V</option>
              <option>W</option>
              <option>X</option>
              <option>Y</option>
              <option>Z</option>
            </select>
          </div>

          <button class="btn btn-lg btn-primary btn-block" id="confirm">Confirm</button>
          <button class="btn btn-lg btn-danger btn-block" id="cancel">Clear</button>
          
          <!-- Handle confirm button on click event -->
          <script>
              $(document).ready(function() {
                  $("#confirm").click(function(){
                      var sel = document.getElementById("letterArea");
                      var newClass = sel.options[sel.selectedIndex].text;
                      var year = $("#yearSelection").children("option:selected").val();
                      var students = [];
                      var classYear = ""+year+newClass;

                      $("#new_student_list").find('li').each(function(j, li){
                          students.push(li.getAttribute("studentID"));
                      });

                      
                      $.ajax({
                          url: "update_class.php",
                          data: { "class": classYear,
                                  "students": JSON.stringify(students)
                          },

                          type: "POST",
                          success: function(data, state) {
                              var JSONdata = $.parseJSON(data);

                              if(JSONdata['state'] != "ok"){
                                  console.log("Error: "+state);
                                  return;
                              }
                              var resJSON = JSONdata['result'];
                              alert(resJSON);
                              location.reload(true);
                              
                          },
                          error: function(request, state, error) {
                          console.log("State error " + state);
                          console.log("Value error " + error);
                          }
                      });
                  }); 
              });
          </script>

          <!-- Handle clear button on click event -->
          <script>
              $(document).ready(function() {
                  $("#cancel").click(function(){
                      $("#new_student_list").empty();
                  }); 
              });
          </script>
    </div>
  </div>
  </div>
  </body>
  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
    feather.replace() //for the icons
  </script>
</html>