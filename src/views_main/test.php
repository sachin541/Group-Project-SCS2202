<?php require_once '../components/headers/main_header.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page Layout</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/test.css">
</head>
<body>

<div class="flex-container">
    <!-- Row with Large Box -->
    <div class="row" style="height: 70vh;">
        <div class="box large-box hero-box">
        <div class="hero-text">
            <h1 class="hero-title">Power Up Your Setup</h1>
            <p class="hero-subtitle">Explore the finest in PC hardware. Gear up for excellence.</p>
            <a href="#products" class="hero-cta">Shop Now</a>
        </div>
        </div>
    </div>
    
    <!-- Row with Large Box -->
    <div class="row" style="height: 60vh; background-color: #e74c3c;">
        <div class="box large-box">Large Box 2</div>
    </div>
    
    <!-- Row with Small Boxes, each having a unique color -->
    <div class="row" style="height: 80vh;">
        <div class="box small-box" style="background-color: #2ecc71;">Small Box 1</div>
        <div class="box small-box" style="background-color: #f1c40f;">Small Box 2</div>
    </div>
    
    <!-- Another Row with Small Boxes, each having a unique color -->
    <div class="row" style="height: 80vh;">
        <div class="box small-box" style="background-color: #1abc9c;">Small Box 3</div>
        <div class="box small-box" style="background-color: #9b59b6;">Small Box 4</div>
    </div>

    <div class="row" style="height: 40vh; background-color: #3498db;">
        <div class="box large-box">Large Box 1</div>
    </div>
    
    <!-- More rows can be added as needed, adjusting the inline styles for height and background color -->
</div>

</body>
</html>



