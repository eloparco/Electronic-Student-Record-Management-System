<?php
define("JSON", "JSON");
require_once('utility.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['child'])) {
        echo '{"state" : "error",
        "result" : "Incomplete request."}';
        exit();
    }

    $child = $_POST['child'];

    $result = get_assignment_of_child($child);
    if(is_string($result)){
        echo '{"state": "error",
            "result":' . $result . '}';
    } else if(is_array($result)){
    $json_res = json_encode($result);
    echo '{"state" : "ok",
            "result" : '.$json_res.'}';
    } else {
        echo '{"state": "error",
            "result": "Unknown result"}';
    }
}
?>