<?php
define("JSON", "JSON");
require_once('utility.php');
$db_con = connect_to_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['child'])) {
        echo '{"state" : "error",
        "result" : "Incomplete request."}';

        mysqli_close($db_con);
        exit();
    }

    $child = $_POST['child'];

    $query = "SELECT SUBJECT.Name, ASSIGNMENT.DateOfAssignment, ASSIGNMENT.DeadlineDate, ASSIGNMENT.Title, ASSIGNMENT.Description FROM ASSIGNMENT, CHILD, SUBJECT WHERE SUBJECT.ID = ASSIGNMENT.SubjectID AND ASSIGNMENT.Class = CHILD.Class AND CHILD.SSN = ?";

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
    if(!mysqli_stmt_bind_param($prep_query, "s", $child)){
        echo '{"state" : "error",
        "result" : "Param binding error." }';
    }
    if(!mysqli_stmt_execute($prep_query)){
        echo '{"state" : "error",
        "result" : "Database error (Query execution)." }';
    }

    mysqli_stmt_bind_result($prep_query, $Subject, $Date, $Deadline, $Title, $Description);

    $rows = array();

    while (mysqli_stmt_fetch($prep_query)) {
        //echo $Class.$Name.$ID.$SSN;
        $fields = array("Subject" => $Subject, "Date" => $Date, "Deadline" => $Deadline, "Title" => $Title, "Description" => $Description);
        $result[] = $fields;

    }

    mysqli_stmt_close($prep_query);

    $json_res = json_encode($result);
    echo '{"state" : "ok",
            "result" : '.$json_res.'}';
}
?>