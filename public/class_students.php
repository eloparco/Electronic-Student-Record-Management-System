<?php
define("JSON", "JSON");

$db_con = mysqli_connect("localhost", "root", "", "student_record_management");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['class'])) {
        echo '{"state" : "error",
        "result" : "Incomplete request."}';

        mysqli_close($db_con);
        exit();
    }

    $class = $_POST['class'];

    $query = "SELECT Name, Surname, SSN FROM CHILD WHERE Class = ?";

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
    if(!mysqli_stmt_bind_param($prep_query, "s", $class)){
        echo '{"state" : "error",
        "result" : "Param binding error." }';
    }
    if(!mysqli_stmt_execute($prep_query)){
        echo '{"state" : "error",
        "result" : "Database error (Query execution)." }';
    }

    mysqli_stmt_bind_result($prep_query, $Name, $Surname, $SSN);

    $rows = array();
    $students = array();
    
    while (mysqli_stmt_fetch($prep_query)) {
        //echo $Class.$Name.$ID.$SSN;
        $fields = array("SSN" => $SSN, "Name" => $Name, "Surname" => $Surname);
        $students[] = $fields;

    }

    mysqli_stmt_close($prep_query);

    $json_res = json_encode($students);
    echo '{"state" : "ok",
            "result" : '.$json_res.'}';

}
?>