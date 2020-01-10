<?php
define("FILE_ID", 'file_id');
define("DIRECTORY_PATH", '../support_material/');

// Downloads files
if (isset($_GET[FILE_ID])) {
    $id = $_GET[FILE_ID];
    
    $file = get_file($id);
    
    if(empty($file)){
        echo 'Error fetching file from db, retry'; 
        exit;
    }
    // needed to know where is the file in the server
    $filepath = DIRECTORY_PATH.$file['ID'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');

        // To save locally with original file name
        header('Content-Disposition: attachment; filename="'.$file['Filename'].'"');    
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize(DIRECTORY_PATH.$file['ID']));
        readfile(DIRECTORY_PATH . $file['ID']); 
        
        unset($_GET[FILE_ID]);
        exit;          
    }
}
?> 