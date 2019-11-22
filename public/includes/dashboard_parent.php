<?php 
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $children = get_children_of_parent($_SESSION['mySession']);
    if(!empty($children) && !isset($_SESSION['child'])){
        $_SESSION['child'] = $children[0]['SSN'];
        $_SESSION['childFullName'] = $children[0]['Name'].' '.$children[0]['Surname'].' - '.$children[0]['SSN'];
    }
?>
<div class="container-fluid">
    <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
            <a id="homeNavig" class="nav-link active" href="user_parent.php">
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

<?php
if(isset($_SESSION['child'])){
?>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Child selection</span>
        </h6>
        <ul class="nav flex-column mb-2">
        <li class="nav-item dropdown-toggle liDropdown">
                <a class="nav-link sideDropdown" href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">
                    <span id="arrowDownDropdown" data-feather="chevron-down"></span>
                    <span id="arrowUpDropdown" data-feather="chevron-up"></span>
                    Select child
                </a>    
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <?php   
                    foreach($children as $child) {
                        $ssn = $child['SSN'];
                        $nameAndsurname = $child['Name'].' '.$child['Surname'];
                        $isActive = $ssn == $_SESSION['child'];
                        if($isActive)
                            echo "<li class='nav-item'>
                                <a href='user_parent.php' class='nav-link active sidebar-dropdown-nav-link ajaxLink'>
                                    <span data-feather='user'></span>
                                    <span class='sidebar-link'>$nameAndsurname</span>
                                    <span id='spanSSN' class='sidebar-link'>$ssn</span>
                                </a>
                                </li>";
                        else 
                            echo "<li class='nav-item'>
                                <a href='user_parent.php' class='nav-link sidebar-dropdown-nav-link ajaxLink'>
                                    <span data-feather='user'></span>
                                    <span class='sidebar-link'>$nameAndsurname</span>
                                    <span id='spanSSN' class='sidebar-link'>$ssn</span>
                                </a>
                                </li>";
                        }       
                    ?>
                </ul>
            </li>
        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Operations</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
            <a class="nav-link" href="marks.php" id="marks_dashboard">
                <span data-feather="activity"></span>
                Visualize marks
            </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="topic_visualization.php" id="topic_dashboard">
                    <span data-feather="activity"></span>
                    Visualize assignments
                </a>
            </li>
        </ul>
        </div>   
        <div class="form-inline my-2 my-lg-0">
            <div id="selectedChild" class="btn btn-static"><?php echo $_SESSION['childNameSurname']; ?></div>
        </div>
<?php
}
?>
    </nav>
    </div>
</div>

<script>
    /* Display/hide up/down arrow icon to the left of changeChild */
    $(document).ready(function() {
        $('.sideDropdown').click(function() {
            if( $(".sideDropdown .feather-chevron-up").css('display').toLowerCase() == 'none') {
                $('.sideDropdown .feather-chevron-up').css('display', 'initial');
                $('.sideDropdown .feather-chevron-down').css('display', 'none');
            }
            else {
                $('.sideDropdown .feather-chevron-up').css('display', 'none');
                $('.sideDropdown .feather-chevron-down').css('display', 'initial');
            }
        });
    });

    /* Ajax request to set variable session for child */
    $('.ajaxLink').click(function(event) {
        event.preventDefault();     
        var nameAndSurname = $(this).find('span:eq(0)').text();
        var ssn = $(this).find('span:eq(1)').text();
        var value = nameAndSurname + "|" + ssn;
        $.ajax({
        url: 'changeChild.php',
        type: 'post',
        data: {"childData": value},
        success: function(response) {
            location.reload();
        }
        }); 
    });
</script>