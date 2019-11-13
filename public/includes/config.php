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
  case "lecture_recording.php":
    $CURRENT_PAGE = "lecture_recording";
    $PAGE_TITLE = "Lecture Recording";
    break;
  case "user_parent.php":
    $CURRENT_PAGE = "user_parent";
    $PAGE_TITLE = "Parent Page";
    break;
  case "user_teacher.php":
    $CURRENT_PAGE = "user_teacher";
    $PAGE_TITLE = "Teacher Page";
    break;
  case "user_secretary.php":
    $CURRENT_PAGE = "user_secretary";
    $PAGE_TITLE = "Secretary Officer Page";
    break;
  case "parent_form.php":
    $CURRENT_PAGE = "parent_form";
    $PAGE_TITLE = "Parent Form Page";
    break;
  case "marks.php":
    $CURRENT_PAGE = "listing_marks";
    $PAGE_TITLE = "Student marks";
    break;
}
