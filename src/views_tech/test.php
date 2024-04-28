<?php 

require_once '../classes/build.php';
require_once '../ultils/sendEmail.php';

$database = new Database();
$db = $database->getConnection();
$build = new Build($db);

$r= $build->getEmail(12); 
// echo $build ; 
print_r($r);