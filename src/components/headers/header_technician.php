<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../resources/css/headers.css">


</head>

<body>
    <header class="outer-grid-container">

        <div class="logo-container">
            <a href="../views_tech/technician_home.php"><img src="../../resources/images/logo2.png" alt="logo png"
                    id="logo" height="50px" /></a>
            <p class="name">COMPUTIFY</p>
        </div>


        <div class="container">
            <div id="menu" class="menu">

            </div>
            <div class="content">

                <a href="../views_tech/technician_home.php" class="topnav-item">Home</a>
                
                <a href="../views_tech/dashboard.php" class="topnav-item">Dashboard</a>
                <a href="../views_tech/build_management.php" class="topnav-item">Builds</a>
                <a href="../views_tech/repair_managment.php" class="topnav-item">Repairs</a>
                <a href="../pages/contact_us.php" class="topnav-item"></a>
                <a href="../ultils/logout.php" class="unreg-log">Log Out</a>

                 -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
            
        
    </style>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/header.css">
</head>
<body>
    <header class="outer-grid-container">
        <div class="logo-container">
            <a href="../views_tech/technician_home.php">
                <img src="../../resources/images/logo2.png" alt="logo png" id="logo" height="50px" />
            </a>
            <p class="name">COMPUTIFY</p>
        </div>
        <div class="hamburger" onclick="toggleMenu()">MAIN MENU</div>
        <div class="content" id="navLinks">

            <a href="../views_tech/build_management.php" class="topnav-item">
                <img src="../../resources/images/icons/pc.png" alt="Cart" class="nav-icon">Builds</a>

            <a href="../views_tech/repair_managment.php" class="topnav-item">
                <img src="../../resources/images/icons/tools.png" alt="Repairs" class="nav-icon">Repairs</a>

            <a href="../ultils/logout.php" class="unreg-log">
                <img src="../../resources/images/icons/logout.png" alt="Logout" class="nav-icon">Logout</a>
        </div>
    </header>
    <script src="header.js"></script>
</body>
</html>

<script>

function toggleMenu() {
    var links = document.getElementById("navLinks");
    if (links.style.display === "none") {
        links.style.display = "flex";
    } else {
        links.style.display = "none";
    }
}

</script>