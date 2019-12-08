<?php
define("JSON", "JSON");
require_once('utility.php');
$db_con = connect_to_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $query = "SELECT ASSIGNMENT.Class, ASSIGNMENT.DateOfAssignment, ASSIGNMENT.DeadlineDate, ASSIGNMENT.Title, ASSIGNMENT.Description, ASSIGNMENT.Attachment FROM ASSIGNMENT";

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

    mysqli_stmt_bind_result($prep_query, $Class, $Date, $Deadline, $Title, $Description, $Attachment);

    $rows = array();

    while (mysqli_stmt_fetch($prep_query)) {
        $fields = array("Class" => $Class, "Date" => $Date, "Deadline" => $Deadline, "Title" => $Title, "Description" => $Description, "Attachment" => $Attachment);
        $result[] = $fields;

    }

    mysqli_stmt_close($prep_query);

    $json_res = json_encode($result);
    echo '{"state" : "ok",
            "result" : '.$json_res.'}';
}
?>