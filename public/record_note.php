<?php
require_once('utility.php');
session_start();
header('Location: note_recording.php');
$db_con = connect_to_db();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if( isset($_POST['class_sID_ssn']) && isset($_POST['date']) && isset($_POST['student']) && isset($_POST['description']) 
    && !empty($_POST['class_sID_ssn']) && !empty($_POST['date']) && !empty($_POST['student']) && !empty($_POST['description'])) {

        $fields = explode("_", $_POST['class_sID_ssn']);
        $class = $fields[0];
        $subjectID = $fields[1];

        $date =$_POST['date']; 

        $student = $_POST['student'];
        $description = $_POST['description'];

        // Check if the student is present
        $queryCheck = "SELECT COUNT(*) FROM ATTENDANCE WHERE StudentSSN = ? AND DATE = CURRENT_DATE AND PRESENCE = 'ABSENT';";

        if(!$db_con){
            echo '{"state" : "error",
            "result" : "Error in connection to database." }';
        }
        
        $prep_query = mysqli_prepare($db_con, $queryCheck);
           
        if(!$prep_query){
            print('Error in preparing query: '.$prep_query);
            echo '{"state" : "error",
            "result" : "Database error." }';
        }
                 
        if(!mysqli_stmt_bind_param($prep_query, "s", $student)){
            echo '{"state" : "error",
            "result" : "Param binding error." }';
        }
        if(!mysqli_stmt_execute($prep_query)){
            echo '{"state" : "error",
            "result" : "Database error (Query execution)." }';
        }
           
        mysqli_stmt_bind_result($prep_query, $count);

        $rows = array();
    
        while (mysqli_stmt_fetch($prep_query)) {
           array_push($rows, $count);
        }
   
        
        if($rows[0] != 0){
            $_SESSION[MSG] = STUDENT_ABSENT;
            die();
        }
        // end check

        $retval = recordNote($student, $subjectID, $date, $description);
        
        $_SESSION[MSG] = $retval;

    } else {
        $_SESSION[MSG] = NOTE_RECORDING_FAILED;
    }
} else {
    $_SESSION[MSG] = NOTE_RECORDING_FAILED;
}
?>