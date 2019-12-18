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
  case "user_principal.php":
      $CURRENT_PAGE = "user_principal";
      $PAGE_TITLE = "Principal Page";
      break;
  case "user_admin.php":
    $CURRENT_PAGE = "user_admin";
    $PAGE_TITLE = "Admin Page";
    break;
  case "parent_form.php":
    $CURRENT_PAGE = "parent_form";
    $PAGE_TITLE = "Record Parent";
    break;
  case "marks.php":
    $CURRENT_PAGE = "listing_marks";
    $PAGE_TITLE = "Student marks";
    break;
  case "mark_recording.php":
    $CURRENT_PAGE = "mark_recording";
    $PAGE_TITLE = "Mark recording";
    break;
  case "class_composition.php":
    $CURRENT_PAGE = "class_composition";
    $PAGE_TITLE = "Class composition";
    break;
  case "student_form.php":
    $CURRENT_PAGE = "student_form";
    $PAGE_TITLE = "Record Student";
    break;
  case "account_form.php":
    $CURRENT_PAGE = "account_form";
    $PAGE_TITLE = "Setup accounts";
    break;
  case "attendance_recording.php":
    $CURRENT_PAGE = "attendance_recording";
    $PAGE_TITLE = "Attendance recording";
    break;
  case "topic_visualization.php":
    $CURRENT_PAGE = "topic_visualization";
    $PAGE_TITLE = "Students assignments";
    break;
  case "student_attendance.php":
    $CURRENT_PAGE = "student_attendance";
    $PAGE_TITLE = "Student attendance";
    break;  
  case "publish_timetable.php":
    $CURRENT_PAGE = "publish_timetable";
    $PAGE_TITLE = "Publish Timetable";
    break;
  case "communication_recording.php":
    $CURRENT_PAGE = "communication_recording";
    $PAGE_TITLE = "Publish Official Communication";
    break; 
  case "publish_support_material.php":
    $CURRENT_PAGE = "publish_support_material";
    $PAGE_TITLE = "Publish Support Material";
    break;
  case "assignment_recording.php":
    $CURRENT_PAGE = "record assignment";
    $PAGE_TITLE = "Record Assignment";
    break;
  case "show_child_notes.php":
    $CURRENT_PAGE = "show notes";
    $PAGE_TITLE = "Show Notes";
    break;
  case "publish_timetable.php":
    $CURRENT_PAGE = "publish timetable";
    $PAGE_TITLE = "Publish Timetable";
    break;
  }
?>