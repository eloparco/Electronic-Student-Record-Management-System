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
</head>

<body>
  <?php include("includes/user_header.php"); ?> 
  <?php include("includes/dashboard_parent.php"); ?> 

  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <h1 class="mt-5">Marks</h1>
    <table class="table table-bordered">
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
                $scores = get_scores_per_child_and_date($_SESSION['child'], date('Y-m-d', time()-7*24*60*60), date('Y-m-d'));
                foreach($scores as $score){
                    echo "<tr>\n";
                    echo "<td>" . $score['Subject'] . "</td>\n";
                    echo "<td>" . $score['Date'] . "</td>\n";
                    echo "<td>" . $score['Score'] . "</td>\n";
                    echo "</tr>\n";
                }
            }
        ?>
        </tbody>
    </table>
  </main>
</body>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

</html>