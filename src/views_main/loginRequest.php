<!DOCTYPE html>
<html lang="en">
<?php require_once '../components/headers/main_header.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            
            
        }

        .cont{
            display: flex; 
            flex-wrap: wrap;
            margin-top: 10vh;
            border: 10px solid #f9f9f9;
            box-shadow: 10px;
        }
        .main-section{
            background-color: rgb(216, 216, 216);
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            
        }

        .main-section > a{
            text-decoration: none;
            padding: 10px;
            background-color: black;
            color: white;
            font-size: 18px;
            font-weight: bold;
            min-width: 100px;
            text-align: center;
            margin: 10px;
            border-radius: 20px;
        }

        a:hover{
            background-color: red;
        }
        h1{
            border-bottom: 2px solid lightgrey;
        }

        h2{
            display: flex;
            text-align: justify;
            padding: 10px;
        }

        .services {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap; /* In case you need them to wrap on smaller screens */
        }

        .service-box {
            width: 23%; /* Slightly less than 25% to allow for margin */
            margin: 1%; /* Spacing between boxes */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: adds a subtle shadow */
            background-color: #f9f9f9; /* Light grey background */
            border-radius: 10px; /* Rounded corners */
            overflow: hidden; /* Ensures the image does not bleed outside the border-radius */
        }

        .service-box img {
            width: 100%;
            height: auto;
            display: block; /* Removes any extra space below the image */
        }

        .pic{
            max-width: 40vh;
        }
    </style>
</head>

<body>
    

    <div class="cont">
    <section>
        <img class="pic" src="../../resources/images/loginrequest.jpg" alt="">
    </section>
    <section class="main-section">
        <h1>Login/Register</h1>
        <h2>Please Log in to access our Services, or Register a new user account</h2>
        <a href="./login.php" class="login">Login</a>
        <a href="./reg.php" class="login">Register</a>
    </section>
    </div>


</body>
</html>

