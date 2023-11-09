<?php

include_once '../utils/dbConnect.php';

$conn = OpenCon();
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];
$mobile1 = $_POST['mobile1'];
$mobile2 = $_POST['mobile2'];
$dob = $_POST['dob'];
$role = $_POST['role'];

// Prepare an insert statement
$login_sql = "INSERT INTO login_details(email, password, role) VALUES (?, ?, ?)";
if ($stmt = mysqli_prepare($conn, $login_sql)) {
    mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_password, $param_role);

    $param_email = $email;
    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
    $param_role = $role;

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}

$get_id = "SELECT id FROM login_details ORDER BY id DESC LIMIT 1";
$staff_id = "";
if ($result = mysqli_query($conn, $get_id)) {

    $row = mysqli_fetch_array($result);

    $staff_id = $row['id'];
}

$insert_sql = "";
if ($role == "technician") {
    $insert_sql = "INSERT INTO technician_details(name, address, mobile_no, alternative_mobile_no, date_of_birth, position, technician_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
} else if ($role == "deliverer") {
    $insert_sql = "INSERT INTO deliverer_details(name, address, mobile_no, alternative_mobile_no, date_of_birth, rank, deliverer_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
} else {
    $insert_sql = "INSERT INTO staff_details(name, address, mobile_no, alternative_mobile_no, date_of_birth, position, staff_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
}

if ($stmt = mysqli_prepare($conn, $insert_sql)) {
    mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_address, $param_mobile, $param_al_mobile_no, $param_dob, $param_position, $param_id);

    $param_name = $name;
    $param_address = $address;
    $param_mobile = $mobile1;
    $param_al_mobile_no = $mobile2;
    $param_dob = $dob;
    $param_position = 0;
    $param_id = $staff_id;
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        echo "New staff created with role $role";
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}
CloseCon($conn);
