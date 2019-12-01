<?php
function name_page($role){
    switch($role){
        case "PARENT":
            $page = "user_parent.php";
        break;
        case "TEACHER":
            $page = "user_teacher.php";
        break;
        case "SECRETARY_OFFICER":
            $page = "user_secretary.php";
        break;
        case "PRINCIPAL":
            $page = "user_principal.php";
        break;
        case "SYS_ADMIN":
            $page = "user_admin.php";
        break;
        default:
        $page = "";
    }
    return $page;
}
?>