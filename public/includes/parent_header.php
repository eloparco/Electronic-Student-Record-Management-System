<?php 
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $children = get_children_of_parent($_SESSION['mySession']);
    if(!empty($children)){
        $_SESSION['child'] = $children[0]['SSN'];
        $_SESSION['childFullName'] = $children[0]['Name'].' '.$children[0]['Surname'].' - '.$children[0]['SSN'];
    }
?>
<header>
    <nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href=<?php 
        if(isset($_SESSION['myUserType'])) {
            if($_SESSION['myUserType'] == 'PARENT')
                echo 'user_parent.php';
            else if($_SESSION['myUserType'] == 'SECRETARY_OFFICER')
                echo 'user_secretary.php';
            else if($_SESSION['myUserType'] == 'TEACHER')
                echo 'user_teacher.php';
            else if($_SESSION['myUserType'] == 'PRINCIPAL')
                echo 'user_principal.php';
        }?>>
            <?php 
                echo $_SESSION['myUserType']; 
            ?>
        </a>    
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Change child</a>    
            <div class="dropdown-menu" aria-labelledby="dropdown01">
                <?php   
                    foreach($children as $child) {
                        $ssn = $child['SSN'];
                        $fullName = $child['Name'].' '.$child['Surname'].' - '.$child['SSN'];
                        $value = $ssn.'|'.$fullName;
                        echo "<a class='dropdown-item' href='user_parent.php?name=$fullName' name=\"$fullName\">". $fullName . "</a>";
                        #echo "<a class='dropdown-item' href='javascript:changeChild(\"$fullName\");'>". $fullName . "</a>";
                    }       
                ?>
            </div>
          </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <div id="selectedChild" class="btn btn-static"><?php $_SESSION['childFullName'] ?></div>
        </div>
      </div> 
    </nav>
</header>