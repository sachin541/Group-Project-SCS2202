<?php
    include_once '../utils/dbConnect.php';

    $conn = OpenCon();
    
    

            // Your connection code here

            $insert_product = "INSERT INTO products (product_name, description, price, discount, ratings, brand, version, category, image1, image2, image3, image4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $insert_product)) {

                // The bind_param function needs to bind all the form fields to the placeholders in the SQL statement
                mysqli_stmt_bind_param($stmt, "ssdddsdsssss", $product_name, $description, $price, $discount, $ratings, $brand, $version, $category, $image1, $image2, $image3, $image4);

                $product_name = $_POST["product_name"];
                $description = $_POST["description"];
                $price = $_POST["price"];
                $discount = $_POST["discount"];
                $ratings = $_POST["ratings"];
                $brand = $_POST["brand"];
                $version = $_POST["version"];
                $category = $_POST["category"];

                // Handle the file upload for the images and get their content
                $image1 = file_get_contents($_FILES["image1"]["tmp_name"]);
                $image2 = file_get_contents($_FILES["image2"]["tmp_name"]);
                $image3 = file_get_contents($_FILES["image3"]["tmp_name"]);
                $image4 = file_get_contents($_FILES["image4"]["tmp_name"]);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    echo "New product added successfully!";
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                mysqli_stmt_close($stmt);
            }

        

        CloseCon($conn);
    
