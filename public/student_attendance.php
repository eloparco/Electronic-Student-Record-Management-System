<?php
include("includes/config.php");
require_once('utility.php');
https_redirect();

/* LOGGED IN CHECK */
if (!userLoggedIn() || !userTypeLoggedIn('PARENT')) {
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
if (isset($_SESSION[MSG])) {
  if (!empty($_SESSION[MSG]) && ($_SESSION[MSG] == LOGIN_PARENT_OK)) {
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.js"></script>
  <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
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
    var visualizeMarkElement = document.getElementById("attendance_dashboard");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
    }   
    if (visualizeMarkElement.classList) {
        visualizeMarkElement.classList.add("active");
    } 
  </script>

  <div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p> 
    <div class="col-md-9 ml-lg-15 ml-md-5 ml-sm-1 col-lg-8 pt-3 px-8">
      <div class="row">
        <div class="col">                        
            <img class="mb-4" src="images/icons/calendar.png" alt="" width="102" height="102">    
        </div>
      </div>
      <div id="calendar"></div>
  </div>
  </div>
</body>

<script>
  $('#calendar').fullCalendar({
    weekends: false,
    // height: 500,
    aspectRatio: 2,
    events:
     <?php 
      $colors = array(
        'ABSENT' => 'lightCoral',
        '10_MIN_LATE' => 'lemonChiffon',
        '1_HOUR_LATE' => 'lightGreen',
        'EARLY_EXIT' => 'lightSalmon '
      );
      $titles = array(
        'ABSENT' => 'ABSENT',
        '10_MIN_LATE' => '10 MINUTES LATE',
        '1_HOUR_LATE' => '1 HOUR LATE',
        'EARLY_EXIT' => 'EARLY EXIT: HOUR '
      );

      $curr_child = $_SESSION['child'];
      // $attendances = get_attendance("MDUHPG46H50I748J");
      $attendances = get_attendance($curr_child);
      $events = array();
      foreach ($attendances as $attendance) {
        $att_code = $attendance['Presence'];
        $start = $attendance['Date'];

        if ($att_code !== NULL) {
          $title = $titles[$att_code];
          $color = $colors[$att_code];
          $events[] = array('title' => $title, 'color' => $color, 'start' => $start);
        }

        if ($attendance['ExitHour'] !== 6) {
          $title = $titles['EARLY_EXIT'] . $attendance['ExitHour'];
          $color = $colors['EARLY_EXIT'];
          $events[] = array('title' => $title, 'color' => $color, 'start' => $start);
        }
      }
      echo(json_encode($events));
    ?>
  });

  // override calendar button layout
  $('button:contains("today")').removeClass();
  $('button:contains("today")').addClass('btn btn-lg btn-primary ml-1');
  $('button span').parent().removeClass();
  $('button span').parent().addClass('btn btn-lg btn-primary ml-1 cal-button');
</script>
</html>