<?php
include('includes/config.php');
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
if(!userLoggedIn()) {   
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="css/dashboard.css" rel="stylesheet" type="text/css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <!-- Bootstrap datepicker -->
  <link rel='stylesheet' type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="js/marks_visualization.js"></script>
</head>

<body>
  <?php include("includes/user_header.php"); ?> 
  <?php include("includes/dashboard_parent.php"); ?> 

  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <h1 class="mt-5">Marks</h1>
    <div>
    <form action="return false;" id="filters" class="form-inline">
        <!-- Subject selection -->
        <div class="form-group mb-2">
            <label for="subjectSelection">Subject</label>
            <select class="form-control" id="subjectSelection">
            <option></option>
            <?php
                $subjects = get_list_of_subjects($_SESSION['child']);
                foreach($subjects as $subject){
                    echo "<option>" . $subject . "</option>\n";
                }
            ?>
            </select>
        </div>
        <!-- Start date seletion -->
        <div class="form-group mb-2">
            <label for="startDateSelection">From</label>
            <input type="text" class="form-control date-selection" id='startDateSelection'>
        </div>
        <!-- End date seletion -->
        <div class="form-group mb-2">
            <label for="endDateSelection">To</label>
            <input type="text" class="form-control date-selection" id='endDateSelection'>
        </div>
    </div>
    <div>
    <table class="table table-bordered" id="marks_table">
        <thead class="thead-dark">
        <tr>
            <td>Subject</td>
            <td>Date</td>
            <td>Score</td>
        </tr>
        </thead>
        <tbody>
        <?php
            if(isset($_SESSION['child'])){
                $scores = get_scores_per_child_and_date($_SESSION['child'], date('Y-m-d', time()-365*24*60*60), date('Y-m-d'));
                foreach($scores as $score){
                    $date = date('jS M Y', strtotime($score['Date']));
                    $date_js = date('d/m/Y', strtotime($date));
                    echo '<tr data-subject="' . $score['Subject'] . '" data-date="' . $date_js . '">'."\n";
                    echo "<td>" . $score['Subject'] . "</td>\n";
                    echo '<td>' . $date . "</td>\n";
                    echo "<td>" . $score['Score'] . "</td>\n";
                    echo "</tr>\n";
                }
            }
        ?>
        </tbody>
    </table>
    </div>
  </main>
</body>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

</html>