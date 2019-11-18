<?php
define("JSON", "JSON");
require_once('utility.php');
if(!userTypeLoggedIn('SECRETARY_OFFICER')) {   
    myRedirectTo('login.php', 'SessionTimeOut');
    exit;
}
$db_con = connect_to_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $query = "SELECT SSN, Name, Surname, Class FROM CHILD";

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

    mysqli_stmt_bind_result($prep_query, $SSN, $Name, $Surname, $Class);

    $rows = array();
    $students = array();

    while (mysqli_stmt_fetch($prep_query)) {
        //echo $Class.$Name.$ID.$SSN;
        $fields = array("SSN" => $SSN, "Name" => $Name, "Surname" => $Surname, "Class" => $Class);
        $students[] = $fields;

    }

    mysqli_stmt_close($prep_query);

    $json_res = json_encode($students);
    echo '{"state" : "ok",
            "result" : '.$json_res.'}';

}
?>