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
if (!userLoggedIn() || !userTypeLoggedIn('PARENT')) {
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
if (isset($_SESSION['msg_result'])) {
  if (!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_PARENT_OK)) {
    $_SESSION['msg_result'] = '';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="css/dashboard.css" rel="stylesheet" type="text/css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.js"></script>

</head>

<body>
  <?php include("includes/user_header.php"); ?>
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

  <div class="formContainer text-center">
    <img class="mb-4 mt-5" src="images/icons/calendar.png" alt="" width="102" height="102">
    <div id="calendar" class="mx-auto" style="width: 900px;"></div>
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
        $title = $titles[$att_code];
        $color = $colors[$att_code];
        $start = $attendance['Date'];
        $events[] = array('title' => $title, 'color' => $color, 'start' => $start);

        if ($attendance['ExitHour'] !== 6) {
          $title = $titles['EARLY_EXIT'] . $attendance['ExitHour'];
          $color = $colors[$att_code];
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
  $('button span').parent().addClass('btn btn-lg btn-primary ml-1');
</script>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
</html>