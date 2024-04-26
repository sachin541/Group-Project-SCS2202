<?php
require_once '../components/headers/main_header.php';
if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'manager' )){
    header('Location: ../views_main/denied.php');
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Grid Layout Example</title>
    <link rel="stylesheet"  href="../../resources/css/css_tech/technician_home.css">
</head>
<div id="cont">
    <div class="grid-container">
        <a href="./staff_center.php" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/manager/staff.png" class="foto" style="width:100%">
            <header>
                <h1>Staff Managment</h1>
            </header>
        </div>
        </a>

        <a href="./reportsMain.php" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/manager/reports.png" class="foto" style="width:100%">
            <header>
                <h1>Reports</h1>
            </header>
        </div>
        </a>
        <a href="linkhere" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/technician/profile.png" class="foto" style="width:100%">
            <header>
                <h1>Profile</h1>
            </header>
        </div>
        </a> 
    </div>
</div>
</html>