<?php
// Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];
    
    $file = get_file($id);
    
    if(empty($file)){
        echo 'Error fetching file from db, retry'; 
        exit;
    }
    // needed to know where is the file in the server
    $filepath = '../support_material/'.$file['ID'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');

        // To save locally with original file name
        header('Content-Disposition: attachment; filename="'.$file['Filename'].'"');    
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize('../support_material/'.$file['ID']));
        readfile('../support_material/' . $file['ID']); 
        
        unset($_GET['file_id']);
        exit;          
    }
}
?> 