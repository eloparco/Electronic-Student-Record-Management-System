<?php
    include('role_pages.php');
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
            else if($_SESSION['myUserType'] == 'ADMIN')
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
			<button type="button" class="btn btn-warning" id="username" value="<?php echo $_SESSION['mySession']; ?>">
            <?php echo $_SESSION['mySession']; ?>
            </button>
			<b class="caret"></b>
			</a>
            <ul class="dropdown-menu ml-auto" role="menu" aria-labelledby="dRoles" id="rolesList">
            <?php
                foreach($roles as $role){
                    echo '<li class="nav-item"><a class="role" href="' . name_page($role) . '">' . $role . '</a></li>'."\n";
                }
            ?>
            <div class="dropdown-divider"></div>
            <li class="nav-item"><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <?php
            }
        ?>
    </nav>
</header>