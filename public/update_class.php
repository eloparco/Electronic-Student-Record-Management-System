<?php
define("JSON", "JSON");
include('utility.php');

$db_con = mysqli_connect("localhost", "root", "", "student_record_management");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['class']) && !isset($_POST['students'])) {
        echo '{"state" : "error",
        "result" : "Incomplete request."}';

        mysqli_close($db_con);
        exit();
    }

    $class = $_POST['class'];
    $students = array();
    $students = json_decode($_POST['students']);
    $con = connect_to_db();

    if(!$result = mysqli_query($con, 'SELECT COUNT(*) AS Count FROM CLASS WHERE Name ="'.$class.'";')){
        echo '{"state" : "error",
            "result" : Error, please retry..}';
        exit();
    }

    $row = mysqli_fetch_array($result);        
    $count = $row['Count'];  
    
    // Create a new class
    if($count == 0){
        if(!$result = mysqli_query($con,'INSERT INTO CLASS VALUES ("'.$class.'");')){
            echo '{"state" : "error",
                "result" : Error, please retry..}';
            exit();
        }
    }


    foreach ($students as $student){
        if(!$result = mysqli_query($con,'UPDATE CHILD set Class = "'.$class.'" WHERE SSN = "'.$student.'"')){
            echo '{"state" : "error",
                    "result" : Error, please retry..}';
            exit();
        }
    }

    echo '{"state" : "ok",
            "result" : "Class composition recorded"}';

}

?>