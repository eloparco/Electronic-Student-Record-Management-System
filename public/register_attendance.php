<?php
define("JSON", "JSON");
require_once('utility.php');
$db_con = connect_to_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['SSN']) || !isset($_POST['Date']) || !isset($_POST['Presence'])) {
        echo '{"state" : "error",
        "result" : "Incomplete request."}';

        mysqli_close($db_con);
        exit();
    }

    $ssn = $_POST['SSN'];
    $assignDate = $_POST['Date'];
    $Presence = $_POST['Presence'];

    $query = "INSERT INTO ATTENDANCE(StudentSSN, Date, Presence) VALUES  (?, ?, ?) ON DUPLICATE KEY UPDATE Presence = ?;";

    if(!$db_con){
        echo '{"state" : "error",
        "result" : "Error in connection to database." }';
    }

    $prep_query = mysqli_prepare($db_con, $query);
    if(!$prep_query){
        print('Error in preparing query: '.$prep_query);
        echo '{"state" : "error",
        "result" : "Database error." }';
    }
    if(!mysqli_stmt_bind_param($prep_query, "ssss", $ssn, $assignDate, $Presence, $Presence)){
        echo '{"state" : "error",
        "result" : "Param binding error." }';
    }
    

    if(!mysqli_stmt_execute($prep_query)){
        echo '{"state" : "error",
        "result" : "Database error (Query execution)." }';
    }

    mysqli_stmt_close($prep_query);

    echo '{"state" : "ok",
            "result" : "ok"}';
}
?>