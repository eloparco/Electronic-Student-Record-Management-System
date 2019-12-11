<?php
    include('role_pages.php');
?>
<header>    
    <nav class="navbar navbar-dark fixed-top bg-dark flex-nowrap p-0"> <!-- flex-md-nowrap -> flex-nowrap -->
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
            else if($_SESSION['myUserType'] == 'SYS_ADMIN')
                echo 'user_admin.php';
        }?>>
            <?php 
                echo $_SESSION['myUserType']; 
            ?>
        </a>
        <?php
            $roles = get_roles_per_user($_SESSION['mySession']);
            if(count($roles) > 1){
        ?>
        <div class="dropdown ml-auto">
			<a id="dRoles" role="button" data-toggle="dropdown" href="#">
			<button type="button" class="btn btn-warning dropdown-toggle" id="username" value="<?php echo $_SESSION['mySession']; ?>">
            <?php echo $_SESSION['mySession']; ?>
            </button>
			<span class="caret"></span>
			</a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dRoles" id="rolesList">
            <?php
                foreach($roles as $role){
                    echo '<li class="dropdown-item"><a id="userTypeLink" class="role" href="' . name_page($role) . '">' . $role . '</a></li>'."\n";
                }
            ?>
            </ul>   
        </div>
        <?php
            }
        ?>
    </nav>
</header>
