<?php
include('includes/config.php');
require_once('utility.php');
function get_scores_per_child_and_date($childSSN, $startDate, $endDate){
    $marks_query = "SELECT Name, Date, Score\n" +
                    "FROM mark m, subject s\n" +
                    "WHERE m.SubjectID=s.ID AND StudentSSN=? AND Date>=str_to_date('?','%Y-%m-%d') AND Date<=str_to_date('?','%y-%m-%d')\n" +
                    "ORDER BY Date";
    $db_con = connect_to_db();
    if(!$db_con){
        die('Error in connection to database. [Marks retrieving]\n');
    }
    $marks_prep = mysqli_prepare($db_con, $marks_query);
    if(!$marks_prep){
        print('Error in preparing query: '.$marks_query);
        die('Check database error:<br>'.mysqli_error($db_con));
    }
    if(!mysqli_stmt_bind_param($marks_prep, "sss", $childSSN, $startDate, $endDate)){
        die('Error in binding paramters to marks_prep.\n');
    }
    if(!mysqli_stmt_execute($marks_prep)){
        die('Error in executing marks query. Database error:<br>'.mysqli_error($db_con));
    }
    $marks_res = mysqli_stmt_get_result($marks_prep);
    $scores = array();
    while($row = mysqli_fetch_array($marks_res, MYSQLI_ASSOC)){
        $fields = array("Subject" => $row['Name'], "Date" => $row['Date'], "Score" => $row['Date']);
        $scores[] = $fields;
    }
    mysqli_stmt_close($marks_prep);
    return $scores;
}
?>