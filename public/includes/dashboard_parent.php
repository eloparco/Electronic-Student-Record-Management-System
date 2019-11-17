<div class="container-fluid">
    <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
            <a class="nav-link active" href="#">
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
            <span>Visualize</span>
            
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
            <a class="nav-link" href="marks.php" id="marks_dashboard">
                <span data-feather="file-text"></span>
                Marks
            </a>
            </li>
        </ul>
<?php
}
?>
        </div>
    </nav>
    </div>
</div>