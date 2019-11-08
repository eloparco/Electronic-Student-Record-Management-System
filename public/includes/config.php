<?php
switch (basename($_SERVER["SCRIPT_NAME"])) {
  case "index.php":
    $CURRENT_PAGE = "index";
    $PAGE_TITLE = "Home";
    break;
  case "login.php":
    $CURRENT_PAGE = "login";
    $PAGE_TITLE = "Login";
    break;
}
