<?php
define("JSON", "JSON");
require_once('utility.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['SSN']) || !isset($_POST['Date']) || !isset($_POST['ExitHour'])) {
        echo '{"state" : "error",
        "result" : "Incomplete request."}';
        exit();
    }

    $ssn = $_POST['SSN'];
    $assignDate = $_POST['Date'];
    $ExitHour = $_POST['ExitHour'];

    if($ExitHour < 1 || $ExitHour > 6){
        echo '{"state" : "error",
            "result" : "Param values not admitted for exit hour." }';
    }

    $query_ok = register_early_exit($ssn, $assignDate, $ExitHour);

    if(is_bool($query_ok) && $query_ok){
        echo '{"state" : "ok",
                "result" : "ok"}';
    } else if(is_string($query_ok)){
        echo '{"state": "error",
            "result":' . $query_ok . '}';
    } else {
        echo '{"state": "error",
            "result": "A generic error occurred"}';
    }
}
?>