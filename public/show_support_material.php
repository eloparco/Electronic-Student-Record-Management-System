<?php
include("includes/config.php");
require_once('utility.php');
include("download_file.php");//needed to download file
define("MSG_RES", "msg_result");
define("TABLE_ELMNT", " </td>");

https_redirect();

/* LOGGED IN CHECK */
if (!userLoggedIn() || !userTypeLoggedIn('PARENT')) {
  myRedirectTo('login.php', 'SessionTimeOut');
  exit;
}
if (isset($_SESSION[MSG_RES]) && !empty($_SESSION[MSG_RES]) && ($_SESSION[MSG_RES] == LOGIN_PARENT_OK)) {
  $_SESSION[MSG_RES] = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <title></title> <!-- already set in head.ph, here only to remove sonarcloud error -->
  <link href="css/dashboard.css" rel="stylesheet" type="text/css">
  <link href="css/responsive.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style type="text/css">

  #materialTable th:hover {
  background: #cccccc;
  cursor: pointer;
  }
  #myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
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
        var support_material_element = document.getElementById("support_material_dashboard");
        if (homeElement.classList) {
          homeElement.classList.remove("active");
        }
        if (support_material_element.classList) {
            support_material_element.classList.add("active");
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
          <!-- top image -->
          <div class="row">
            <div class="col">
              <img class="mb-4" src="images/icons/download.png" alt="" width="102" height="102">
            </div>
          </div>
          <h1 class="h3 mb-3 font-weight-normal">Support Material</h1>
                    

          <!-- table -->          
          <input type="text" id="myInput" onkeyup="sortFunction()" placeholder="Search file.." title="Type in a name">
          
          <?php
                $files = get_list_of_support_material($_SESSION['child']);                
                if (count($files) ===0) {
                    echo '<p class="lead text-muted" class="text-center">No support material available.</p>';
                } 
          ?> 
            <div class="row">
            <table class="col table" id="materialTable">
                <caption>Show support material</caption>
                <thead>
                    <tr>
                        <th id="date_show_support_mat" onclick="sortTableDate()">Date</th>
                        <th id="subj_show_support_mat" onclick="sortTableSubject()">Subject</th>
                        <th id="file_show_support_mat" onclick="sortTableFilename()">File</th>
                        <th id="null_support_mat"></th>                        
                    </tr>
                </thead>
                <tbody>

                <?php                  
                foreach ($files as $file) {
                    echo '<tr>';
                        echo '<td>'.$file['Date'].TABLE_ELMNT;
                        echo '<td>'.$file['Subject'].TABLE_ELMNT;
                        echo '<td>'.$file['Filename'].TABLE_ELMNT;                        
                        echo '<td><a href="show_support_material.php?file_id='.$file['Id'].'" id="download'.$file['Id'].'">Download</a></td>';
                    echo '</tr>';                    
                }                            
                ?>

                </tbody>
            </table>            
            </div>            
          </div>
        </div>
        </div>
      </div>
    </div>
</body>

<script>

function sortFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("materialTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function sortTableFilename() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("materialTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    
    switching = false;
    rows = table.rows;
    
    for (i = 1; i < (rows.length - 1); i++) {      
      shouldSwitch = false;
      
      x = rows[i].getElementsByTagName("TD")[2];
      y = rows[i + 1].getElementsByTagName("TD")[2];
      
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {        
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {      
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
function sortTableSubject() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("materialTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    
    switching = false;
    rows = table.rows;
    
    for (i = 1; i < (rows.length - 1); i++) {      
      shouldSwitch = false;
      
      x = rows[i].getElementsByTagName("TD")[1];
      y = rows[i + 1].getElementsByTagName("TD")[1];
      
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {        
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {      
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
function sortTableDate() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("materialTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    
    switching = false;
    rows = table.rows;
    
    for (i = 1; i < (rows.length - 1); i++) {      
      shouldSwitch = false;
      
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {        
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {      
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
  feather.replace();
</script>

</html>