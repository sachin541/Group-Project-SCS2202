<?php
require_once '../components/headers/main_header.php';

if($_SESSION['role'] != 'technician'){
    header('Location: ../views_main/denied.php');
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Grid Layout Example</title>
    <link rel="stylesheet"  href="../../resources/css/css_tech/tech_home_new.css">
</head>
<div id="cont">
    <div class="grid-container">
        <a href="./repair_managment.php" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/technician/pc_repairs.png" class="foto" style="width:100%">
            <header>
                <h1>PC Repairs</h1>
            </header>
        </div>
        </a>

        <a href="./build_management.php" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/technician/pc_build.png" class="foto" style="width:100%">
            <header>
                <h1>PC Builds</h1>
            </header>
        </div>
        </a>
        <!-- <a href="linkhere" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/technician/profile.png" class="foto" style="width:100%">
            <header>
                <h1>Profile</h1>
            </header>
        </div>
        </a>  -->

        
    </div>
</div>
</html>