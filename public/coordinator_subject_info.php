<?php
define("JSON", "JSON");
require_once('utility.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['user_mail'])) {
        echo '{"state" : "error",
        "result" : "Incomplete request.",
        "seat" : ""}';

        mysqli_close($db_con);
        exit();
    }

$teacher = $_POST['user_mail'];

$json_res = json_encode(getCoordinatorSubject($teacher));
    echo '{"state" : "ok",
            "result" : '.$json_res.'}';
}

?>