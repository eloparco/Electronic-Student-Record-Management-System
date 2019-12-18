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
  session_start();
  /* LOGGED IN CHECK */
  if(userLoggedIn()) { //stay in 'user page' until you do logout
    $_SESSION['msg_result'] = "";
    switch($_SESSION['myUserType']) {
      case 'TEACHER':
        header('Location: user_teacher.php');
        break;
      case 'PARENT':
        header('Location: user_parent.php');
        break;
      case 'SECRETARY_OFFICER':
        header('Location: user_secretary.php');
        break;
      case 'PRINCIPAL':
        header('Location: user_principal.php');
        break;
      case 'SYS_ADMIN':
        header('Location: user_admin.php');
        break;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <title></title> <!-- already set in head.php, here only to remove sonarcloud error -->
  <link rel="stylesheet" type="text/css" href="css/carousel.css">
</head>

<body>
  <?php include("includes/header.php"); ?>
  <script>
    var homeElement = document.getElementById("homeNav");
    var loginElement = document.getElementById("loginNav");
    if (homeElement.classList) {
      homeElement.classList.add("active");
    }   
    if (loginElement.classList) {
      loginElement.classList.remove("active");
    } 
  </script>
  <main role="main" class="container">
    <h1 class="mt-0">Electronic Student Record Management System</h1>
    <p class="lead">System to support electronic student records for High Schools.</p>
    <?php 
      $communications = get_communications();
      if($communications == DB_ERROR || $communications == GET_COMMUNICATIONS_FAILED || empty($communications)) { 
        /* Insert default communication */?>
        <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="first-slide" src="images/slider/slider1.jpg" alt="First slide">
              <div class="container">
                <div class="carousel-caption text-left">
                  <h2 class="h2-responsive">Welcome to ESRMS System</h2>
                  <p>System to support electronic student records for High Schools</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      } else if(count($communications) == 1) { 
        /* Insert only one official communication */ ?>
        <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="first-slide" src="images/slider/slider1.jpg" alt="First slide">
              <div class="container">
                <div class="carousel-caption text-left">
                  <h2 class="h2-responsive"><?php echo $communications[0]['Title']; ?></h2>
                  <p><?php echo $communications[0]['Description']; ?></p>
                  <p><?php echo $communications[0]['Date']; ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      } else if(count($communications) == 2) { 
        /* Insert two official communications */ ?>
        <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="images/slider/slider1.jpg" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h2 class="h2-responsive"><?php echo $communications[0]['Title']; ?></h2>
                <p><?php echo $communications[0]['Description']; ?></p>
                <p><?php echo $communications[0]['Date']; ?></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="second-slide" src="images/slider/slider3.jpg" alt="Second slide">
            <div class="container">
              <div class="carousel-caption text-right">
                <h2 class="h2-responsive"><?php echo $communications[1]['Title']; ?></h2>
                <p><?php echo $communications[1]['Description']; ?></p>
                <p><?php echo $communications[1]['Date']; ?></p>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      <?php
      } else { 
        /* Insert all the 3(most recent) official communications */ ?>
        <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="images/slider/slider1.jpg" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h2 class="h2-responsive"><?php echo $communications[0]['Title']; ?></h2>
                <p><?php echo $communications[0]['Description']; ?></p>
                <p><?php echo $communications[0]['Date']; ?></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="second-slide" src="images/slider/slider2.jpg" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h2 class="h2-responsive"><?php echo $communications[1]['Title']; ?></h2>
                <p><?php echo $communications[1]['Description']; ?></p>
                <p><?php echo $communications[1]['Date']; ?></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="images/slider/slider3.jpg" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-right">
                <h2 class="h2-responsive"><?php echo $communications[2]['Title']; ?></h2>
                <p><?php echo $communications[2]['Description']; ?></p>
                <p><?php echo $communications[2]['Date']; ?></p>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      <?php
      }
    ?> 

  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>