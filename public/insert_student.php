<?php
require_once('utility.php');
session_start();
header('Location: student_form.php');
define("SURNAME", "surname");
define("STUDENT_CLASS", "class");
define("PARENT1", "parent1");
define("PARENT2", "parent2");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['SSN']) && isset($_POST['name']) && isset($_POST[SURNAME]) && isset($_POST[PARENT1]) && isset($_POST[PARENT2]) && isset($_POST[STUDENT_CLASS]) 
        && !empty($_POST['SSN']) && !empty($_POST['name']) && !empty($_POST[SURNAME]) && !empty($_POST[PARENT1]) && !empty($_POST[PARENT2]) && !empty($_POST[STUDENT_CLASS])) {

        /* get values from POST */
        $ssn = $_POST['SSN'];
        $name = $_POST['name'];
        $surname = $_POST[SURNAME];
        $parent1 = $_POST[PARENT1];
        $parent2 = $_POST[PARENT2];
        $class = $_POST[STUDENT_CLASS];
        
        $retval = insertStudent($ssn, $name, $surname, $parent1, $parent2, $class);
        $_SESSION[MSG] = $retval;
    }

} else {
    $_SESSION[MSG] = STUDENT_RECORDING_FAILED;
}

?>