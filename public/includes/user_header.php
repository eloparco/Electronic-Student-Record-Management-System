<?php
    include('role_pages.php');
    define("CURR_USER_TYPE", "myUserType");
    define("SESSION_VAR", "mySession");
?>
<header>    
    <nav class="navbar navbar-dark fixed-top bg-dark flex-nowrap p-0"> <!-- flex-md-nowrap -> flex-nowrap -->
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href=<?php 
        if(isset($_SESSION[CURR_USER_TYPE])) {
            if($_SESSION[CURR_USER_TYPE] == 'PARENT') {
                echo 'user_parent.php';
            }
            else if($_SESSION[CURR_USER_TYPE] == 'SECRETARY_OFFICER') {
                echo 'user_secretary.php';
            }
            else if($_SESSION[CURR_USER_TYPE] == 'TEACHER') {
                echo 'user_teacher.php';
            }
            else if($_SESSION[CURR_USER_TYPE] == 'PRINCIPAL') {
                echo 'user_principal.php';
            }
            else if($_SESSION[CURR_USER_TYPE] == 'SYS_ADMIN') {
                echo 'user_admin.php';
            }
        }?>>
            <?php 
                echo $_SESSION[CURR_USER_TYPE]; 
            ?>
        </a>
        <?php
            $roles = get_roles_per_user($_SESSION[SESSION_VAR]);
            if(count($roles) > 1){
        ?>
        <div class="dropdown ml-auto">
			<a id="dRoles" role="button" data-toggle="dropdown" href="#">
			<button type="button" class="btn btn-warning dropdown-toggle" id="username" value="<?php echo $_SESSION[SESSION_VAR]; ?>">
            <?php echo $_SESSION[SESSION_VAR]; ?>
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
