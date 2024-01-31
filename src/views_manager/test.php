<?php
require_once '../classes/database.php';
require_once '../classes/reports.php'; 

$database = new Database();
$db = $database->getConnection();
$reportObj = new Report($db);

// Retrieve staff ID from GET request
$startDate = '2024-01-01'; // example start date
$endDate = '2024-01-31';

$test =  $reportObj->getSalesByBrand($startDate, $endDate);
print_r($test);

   // example end date

// Fetch sales data

?>