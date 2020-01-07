<?php
define("JSON", "JSON");
require_once('utility.php');

$db_con = connect_to_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['ssn'])) {
        echo '{ "state" : "error",
                "result" : "Incomplete request." }';
        mysqli_close($db_con);
        exit();
    }

    $ssn = $_POST['ssn'];
    $query = "SELECT Name, Surname, Email FROM USER WHERE SSN = ? LIMIT 1";
    if(!$db_con) {
        echo '{ "state" : "error",
                "result" : "Error in connection to database." }';
    }
    $prep_query = mysqli_prepare($db_con, $query);
    if(!$prep_query) {
        print('Error in preparing query: '.$prep_query);
        echo '{ "state" : "error",
                "result" : "Database error." }';
    }
    if(!mysqli_stmt_bind_param($prep_query, "s", $ssn)) {
        echo '{ "state" : "error",
                "result" : "Param binding error." }';
    }
    if(!mysqli_stmt_execute($prep_query)) {
        echo '{ "state" : "error",
                "result" : "Database error (Query execution)." }';
    }
    mysqli_stmt_bind_result($prep_query, $Name, $Surname, $Email);
    $field = array();
    while (mysqli_stmt_fetch($prep_query)) {
        $field = array("Name" => $Name, "Surname" => $Surname, "Email" => $Email);
    }
    if(!empty($field)) {
        $json_res = json_encode($field);
        echo '{ "state" : "ok",
            "result" : '. $json_res .'}';
    }
    else {
        $json_res = "{}";
        echo '{ "state" : "error",
            "result" : "SSN not found." }';
    }
    mysqli_stmt_close($prep_query);
}
?>