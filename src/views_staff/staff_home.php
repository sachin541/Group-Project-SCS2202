<!-- Template Top -->
<?php require_once '../templates/main_top.php'; ?>

<!-- Stylesheets -->
<link rel="stylesheet" href="../../resources/css/css_tech/technician_home.css">

</head>

<body>

    <!-- Header -->
    <?php require_once '../templates/main_header.php'; ?>

    <div id="cont">
        <div class="grid-container">
            <a href="./product_list.php" class="card">
                <div class="card">
                    <img src="../../resources/images/homePagImages/staff/product_center.png" class="foto"
                        style="width:100%">
                    <header>
                        <h1>Products</h1>
                    </header>
                </div>
            </a>

            <a href="./add_product.php" class="card">
                <div class="card">
                    <img src="../../resources/images/homePagImages/staff/add_product.png" class="foto"
                        style="width:100%">
                    <header>
                        <h1>Add Product</h1>
                    </header>
                </div>
            </a>
            <a href="linkhere" class="card">
                <div class="card">
                    <img src="../../resources/images/homePagImages/technician/profile.png" class="foto"
                        style="width:100%">
                    <header>
                        <h1>Profile</h1>
                    </header>
                </div>
            </a>

        </div>
    </div>

    <!-- Footer -->
    <?php require_once '../templates/main_footer.php'; ?>

    <!-- Template Bottom -->
    <?php require_once '../templates/main_bottom.php'; ?>