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
 
$children = get_children_of_parent($_SESSION['mySession']);
if(!empty($children) && !isset($_SESSION['child'])){
  $_SESSION['child'] = $children[0]['SSN'];
  $_SESSION['childFullName'] = $children[0]['Name'].' '.$children[0]['Surname'].' - '.$children[0]['SSN'];
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
  <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
  <link rel="stylesheet" type="text/css" href="css/w3.css">
</head>

<body>
  <?php include("includes/user_header.php"); ?> 
  <?php include("includes/dashboard_parent.php"); ?> 

  <script>
    var homeElement = document.getElementById("homeNavig");
    var visualizeMarkElement = document.getElementById("marks_dashboard");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
    }   
    if (visualizeMarkElement.classList) {
        visualizeMarkElement.classList.add("active");
    } 
  </script>

  <div class="formContainer text-center">
  <main role="main" >
    <div>
    <!-- Child selection -->
    <form id="visualizeMarksImg" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <img class="mb-4" src="images/icons/mark_visual.png" alt="" width="102" height="102">    
    </form>
    <form action="return false;" id="filters" class="form-inline">
        <!-- Subject selection -->
        <div class="form-group mb-2">
            <label class="filterLabel" for="subjectSelection">Subject</label>
            <select class="form-control" id="subjectSelection" name="subjectSelection">
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
            <label class="filterLabel" for="startDateSelection">From</label>
            <input type="text" class="form-control date-selection" id='startDateSelection' name='startDateSelection'>
        </div>
        <!-- End date seletion -->
        <div class="form-group mb-2">
            <label class="filterLabel" for="endDateSelection">To</label>
            <input type="text" class="form-control date-selection" id='endDateSelection'>
        </div>
    </div>
    <div>
    <table class="table table-bordered" id="marks_table">
        <thead class="thead-dark">
        <tr>
            <td><b>Subject</b></td>
            <td><b>Date</b></td>
            <td><b>Score</b></td>
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
</div>
</body>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>

</html>