<?php
include("includes/config.php");
require_once('utility.php');
/* HTTPS CHECK */
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
} else {
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
  <link href="css/responsive.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style type="text/css">
	.accordion .card-header .btn {
		width: 100%;
		text-align: left;
		padding-left: 0;
		padding-right: 0;
	}
	.accordion .card-header i {
		font-size: 1.3rem;
		position: absolute;
		top: 15px;
		right: 1rem;
	}			
</style>

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
        var visualizeMarkElement = document.getElementById("notes_dashboard");
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
            <i data-feather="menu"></i>
          </button>
        </p>
        <div class="col-md-9 ml-lg-15 ml-md-5 ml-sm-1 col-lg-8 pt-3 px-8">
          <!-- top image -->
          <div class="row">
            <div class="col">
              <img class="mb-4" src="images/icons/notes.png" alt="" width="102" height="102">
            </div>
          </div>

          <!-- accordion -->
          <div class="accordion mt-1" id="accordion">
            <?php
            $notes = array(
              array(
                'SubjectName' => 'Math',
                'Description' => 'description aaa',
                'Date' => '01/01/01'
              ),
              array(
                'SubjectName' => 'Italian',
                'Description' => 'description bbb',
                'Date' => '02/02/02'
              )
            );
            $i = 0;
            foreach ($notes as $note) {
            ?>
            
              <div class="card">
                <div class="card-header" id="heading<?php echo $i ?>">
                  <h2 class="clearfix mb-0">
                    <a class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $i ?>" aria-expanded="true" aria-controls="collapse<?php echo $i ?>"><?php echo $note['Date'] ?><i class="fa fa-angle-down"></i></a>
                  </h2>
                </div>
                <div id="collapse<?php echo $i ?>" class="collapse" aria-labelledby="heading<?php echo $i ?>" data-parent="#accordion">
                  <div class="card-body">
                    <div class="media">
                      <div class="media-body">
                        <h5 class="mt-0"><?php echo $note['SubjectName'] ?></h5>
                        <p><?php echo $note['Description'] ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            
            <?php
               $i++;
            }
            ?>

          </div>
        </div>
      </div>
    </div>
</body>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
  feather.replace();
</script>

</html>