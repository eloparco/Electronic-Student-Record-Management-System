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
if (!userLoggedIn() || !userTypeLoggedIn('SECRETARY_OFFICER')) {
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
if (isset($_SESSION['msg_result'])) {
  if (!empty($_SESSION['msg_result']) && ($_SESSION['msg_result'] == LOGIN_SECRETARY_OK)) {
    $_SESSION['msg_result'] = '';
  }
}

if (isset($_FILES["file"]["type"]) && isset($_REQUEST['classSelection'])) {
  // error
  if ($_FILES["file"]["error"] > 0 || $_FILES["file"]["type"] !== "text/csv") {
    $_SESSION['msg_result'] = PUBLISH_TIMETABLE_FAILED;
  } else {
    $file = fopen($_FILES['file']['tmp_name'], 'r');
    $timetable = array();
    while (($row = fgetcsv($file, 8192)) !== FALSE) {
      $timetable[] = $row;
    }

    // check if class is empty
    $class = $_REQUEST['classSelection'];
    if ($class === '') {
      $_SESSION['msg_result'] = MISSING_INPUT;
    } else {
      // check file format
      $wrong_format = false;
      foreach ($timetable as $row) {
        if (count($row) !== 5) {
          $wrong_format = true;
        }
      }
      if (count($timetable) !== 6 || $wrong_format === true) {
        $_SESSION['msg_result'] = WRONG_FILE_FORMAT;
      } else {
        $_SESSION['msg_result'] = insert_timetable($class, $timetable);
        // print_r($timetable);
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="css/dashboard.css" rel="stylesheet" type="text/css">
  <link href="css/responsive.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="css/customForm.css">
  <link rel="stylesheet" type="text/css" href="css/w3.css">
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
    var publishTimetableElement = document.getElementById("publish_timetable_dashboard");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
    }
    if (publishTimetableElement.classList) {
      publishTimetableElement.classList.add("active");
    }
  </script>

<div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <i data-feather="menu"></i>
      </button>
    </p> 
      <form class="form-signin col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
      <img class="mb-4" src="images/icons/publish_timetable.png" alt="" width="102" height="102">
      <h1 class="h3 mb-3 font-weight-normal">Select CSV file <br>to import as timetable</h1>
      <p class="lead text-muted">Format:<br> 6 rows: one for each hour<br> 5 columns: one for each day</p>
      <div class="form-group mb-2">
        <label class="filterLabel" for="classSelection">Class</label>
        <select class="form-control" id="classSelection" name="classSelection">
          <option></option>
          <?php
          $classes= get_list_of_classes();
          foreach ($classes as $class) {
            echo "<option>" . $class . "</option>\n";
          }
          ?>
        </select>
      </div>
      <input type="file" id="file" name="file" class="form-control mt-4">

      <?php
      if (isset($_SESSION['msg_result'])) {
        if (!empty($_SESSION['msg_result'])) {
          if ($_SESSION['msg_result'] != PUBLISH_TIMETABLE_OK) { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><b><?php echo $_SESSION['msg_result']; ?></b></span></div></b>
          <?php } else { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><b><?php echo $_SESSION['msg_result']; ?></b></span></div></b>
      <?php
          }
        }
        $_SESSION['msg_result'] = "";
      } ?>

      <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Submit</button>
    </form>
  </div>
</body>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
  feather.replace();
</script>

</html>