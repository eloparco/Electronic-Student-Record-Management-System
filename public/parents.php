<?php
define("JSON", "JSON");
require_once('utility.php');
$db_con = connect_to_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $query = "SELECT USER.SSN FROM USER, USER_TYPE  WHERE USER.SSN = USER_TYPE.SSN AND  UserType = 'PARENT'";

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

    if(!mysqli_stmt_execute($prep_query)){
        echo '{"state" : "error",
        "result" : "Database error (Query execution)." }';
    }

    mysqli_stmt_bind_result($prep_query, $SSN);

    $rows = array();
    $parents = array();

    while (mysqli_stmt_fetch($prep_query)) {
        $fields = array("SSN" => $SSN);
        $parents[] = $fields;

    }

    mysqli_stmt_close($prep_query);

    $json_res = json_encode($parents);
    echo '{"state" : "ok",
            "result" : '.$json_res.'}';

}
?>