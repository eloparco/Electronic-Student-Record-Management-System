<?php
define("JSON", "JSON");
require_once('utility.php');
$db_con = connect_to_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['SSN']) || !isset($_POST['Date'])) {
        echo '{"state" : "error",
        "result" : "Incomplete request."}';

        mysqli_close($db_con);
        exit();
    }

    $ssn = $_POST['SSN'];
    $assignDate = $_POST['Date'];

    $query = "INSERT INTO ATTENDANCE (StudentSSN, Date, Presence, ExitHour) VALUES  (?, ?, 'ABSENT', 0) ON DUPLICATE KEY UPDATE Presence = 'ABSENT', ExitHour=0 ;";

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
    if(!mysqli_stmt_bind_param($prep_query, "ss", $ssn, $assignDate)){
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