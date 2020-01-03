<?php require_once('utility.php'); ?>

<div class="col-md-3 col-lg-2 sidebar-offcanvas pl-0" role="navigation" id="sidebar">
    <ul class="nav flex-column mb-2">
        <li class="nav-item">
        <a id="homeDash" class="nav-link active" href="user_teacher.php">
            <span data-feather="home"></span>
            Home <span class="sr-only">(current)</span>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="logout.php">
            <span data-feather="log-out"></span>
            Logout
        </a>
        </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Operations</span>
    </h6>
    <ul class="nav flex-column mb-2">
        <li class="nav-item">
        <a id="recordLecture" class="nav-link" href="lecture_recording.php">
            <span data-feather="file-text"></span>
            Record lecture's topics  
        </a>
        </li>
        <li class="nav-item">
        <a id="recordMark" class="nav-link" href="mark_recording.php">
            <span data-feather="edit"></span>
            Record a student's mark
        </a>
        <li class="nav-item">
        <a id="recordAttendance" class="nav-link" href="attendance_recording.php">
            <span data-feather="check-circle"></span>
            Record attendance
        </a>
        </li>
        <li class="nav-item">
        <a id="publishMaterial" class="nav-link" href="publish_support_material.php">
            <span data-feather="upload-cloud"></span>
            Publish Material
        </a>
        </li>
        <li class="nav-item">
        <a id="recordAssignment" class="nav-link" href="assignment_recording.php">
            <span data-feather="file-text"></span>
            Record assignment
        </a>
        </li>

        </li>
        <li class="nav-item">
        <a id="recordNote" class="nav-link" href="note_recording.php">
            <span data-feather="file-text"></span>
            Record note
        </a>
        </li>

        <?php
            if(isCoordinator($_SESSION["mySession"])){
                echo '<li class="nav-item">
                        <a id="recordFinalMarks" class="nav-link" href="final_mark_recording.php">
                            <span data-feather="edit"></span>
                            Publish final marks
                        </a>
                    </li>';
            }    
        ?>

    </ul>
</div>