<?php
define("JSON", "JSON");
require_once('utility.php');
$db_con = connect_to_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['user_mail'])) {
        echo '{"state" : "error",
        "result" : "Incomplete request.",
        "seat" : ""}';

        mysqli_close($db_con);
        exit();
    }

    $teacher = $_POST['user_mail'];

    $query = "SELECT TEACHER_SUBJECT.Class, SUBJECT.Name, SUBJECT.ID, USER.SSN FROM USER, TEACHER_SUBJECT, SUBJECT WHERE SUBJECT.ID = TEACHER_SUBJECT.SubjectID AND USER.SSN = TEACHER_SUBJECT.TeacherSSN AND USER.Email = ?";

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
    if(!mysqli_stmt_bind_param($prep_query, "s", $teacher)){
        echo '{"state" : "error",
        "result" : "Param binding error." }';
    }
    if(!mysqli_stmt_execute($prep_query)){
        echo '{"state" : "error",
        "result" : "Database error (Query execution)." }';
    }

    mysqli_stmt_bind_result($prep_query, $Class, $Name, $ID, $SSN);

    $rows = array();

    while (mysqli_stmt_fetch($prep_query)) {
        //echo $Class.$Name.$ID.$SSN;
        $fields = array("Class" => $Class, "Name" => $Name, "ID" => $ID, "SSN" => $SSN);
        $subjects[] = $fields;

    }

    mysqli_stmt_close($prep_query);

    $json_res = json_encode($subjects);
    echo '{"state" : "ok",
            "result" : '.$json_res.'}';

}
?>