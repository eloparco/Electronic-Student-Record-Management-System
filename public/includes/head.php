<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="images/icons/favicon.ico">
<title><?php print $PAGE_TITLE; ?></title>

<base href="public" />

<!-- bootstrap -->
<link href="css/bootstrap-4.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="css/sticky-footer-navbar.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet" type="text/css">

<!-- jquery -->
<!-- For the dropdown sidebar -->
<script src="https://code.jquery.com/jquery-1.9.1.min.js" type="text/javascript"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- roles script -->
<?php
if(userLoggedIn()){
?>
<script src="js/change_role.js"></script>
<?php
}
?>
