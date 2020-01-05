<?php
include("includes/config.php");
require_once('utility.php');
https_redirect();

/* LOGGED IN CHECK */
if (!userLoggedIn() || !userTypeLoggedIn('SECRETARY_OFFICER')) {
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
if (isset($_SESSION[MSG])) {
  if (!empty($_SESSION[MSG]) && ($_SESSION[MSG] == LOGIN_SECRETARY_OK)) {
    $_SESSION[MSG] = '';
  }
}

if (isset($_FILES["file"]["type"]) && isset($_REQUEST['classSelection'])) {
  // error
  $extension = end(explode('.', $_FILES["file"]["name"]));
  if ($_FILES["file"]["error"] > 0 || $extension !== "csv") {
    $_SESSION[MSG] = PUBLISH_TIMETABLE_FAILED;
  } else {
    $file = fopen($_FILES['file']['tmp_name'], 'r');
    $timetable = array();
    while (($row = fgetcsv($file, 8192)) !== FALSE) {
      $timetable[] = $row;
    }

    // check if class is empty
    $class = htmlspecialchars($_REQUEST['classSelection']);
    if ($class === '') {
      $_SESSION[MSG] = MISSING_INPUT;
    } else {
      // check file format
      $wrong_format = false;
      foreach ($timetable as $row) {
        if (count($row) !== 5) {
          $wrong_format = true;
        }
      }
      if (count($timetable) !== 6 || $wrong_format === true) {
        $_SESSION[MSG] = WRONG_FILE_FORMAT;
      } else {
        $_SESSION[MSG] = insert_timetable($class, $timetable);
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
  <title></title> <!-- already set in head.php, here only to remove sonarcloud error -->
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
        <em data-feather="menu"></em>
      </button>
    </p> 
      <form class="form-signin col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
      <img class="mb-4" src="images/icons/publish_timetable.png" alt="" width="102" height="102">
      <h1 class="h3 mb-3 font-weight-normal">Select CSV file <br>to import as timetable</h1>
      <p class="lead text-muted">Format:<br> 6 rows: one for each hour<br> 5 columns: one for each day <br> Use dash symbol for empty hours </p>
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
      if (isset($_SESSION[MSG])) {
        if (!empty($_SESSION[MSG])) {
          if ($_SESSION[MSG] != PUBLISH_TIMETABLE_OK) { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span><strong><?php echo $_SESSION[MSG]; ?></strong></span></div></strong>
          <?php } else { ?>
            <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span><strong><?php echo $_SESSION[MSG]; ?></strong></span></div></strong>
      <?php
          }
        }
        $_SESSION[MSG] = "";
      } ?>

      <button class="btn btn-lg btn-primary btn-block mt-2" type="submit" id="submit">Submit</button>
    </form>
  </div>
</body>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>
</html>