<?php 
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<header>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
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
    </nav>
</header>