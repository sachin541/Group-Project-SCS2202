<?php

// $builds = [
//     [
//         'build_id' => 32,
//         'customer_id' => 5,
//         'customer_name' => 'Sachin',
//         'contact' => 764320777,
//         'added_timestamp' => '2024-04-27',
//         'technician_assigned_date' => '2024-04-28',
//         'build_start_date' => '2024-04-28',
//         'build_completed_date' => '',
//         'build_collected_date' => '',
//         'components_list_id' => 42,
//         'comments' => '',
//         'amount' => 1807920.00,
//         'technician_id' => 2,
//         'rejected' => '',
//         'rejected_reason' => ''
//     ],
//     [
//         'build_id' => 36,
//         'customer_id' => 5,
//         'customer_name' => 'Sachin',
//         'contact' => 764320777,
//         'added_timestamp' => '2024-04-28',
//         'technician_assigned_date' => '2024-04-28',
//         'build_start_date' => '',
//         'build_completed_date' => '',
//         'build_collected_date' => '',
//         'components_list_id' => 46,
//         'comments' => '',
//         'amount' => 560000.00,
//         'technician_id' => 2,
//         'rejected' => '',
//         'rejected_reason' => ''
//     ]
// ];

// echo 1 <=> 1; // Outputs: 0 (because both are equal)
// echo 1 <=> 2; // Outputs: -1 (because 1 is less than 2)
// echo 2 <=> 1; // Outputs: 1 (because 2 is greater than 1)

//sort buy ID
function sortByBuildId($a, $b) {
    return $a['build_id'] <=> $b['build_id'];
}
usort($builds, 'sortByBuildId');

//sort by Date
function sortByDate($a, $b) {
    $dateA = strtotime($a['added_timestamp']);
    $dateB = strtotime($b['added_timestamp']);

    if ($dateA == $dateB) {
        return 0;
    }
    return ($dateA < $dateB) ? -1 : 1;
}
usort($builds, 'sortByDate');

//sort by Name
function sortByName($a, $b) {
    return strcmp($a['customer_name'], $b['customer_name']);
}
usort($builds, 'sortByName');

// $preferredOrder = ['Rajesh', 'Amit', 'Sachin']; 
// function sortByCustomOrder($a, $b) use ($preferredOrder) {
//     $indexA = array_search($a['customer_name'], $preferredOrder);
//     $indexB = array_search($b['customer_name'], $preferredOrder);

//     if ($indexA === false) $indexA = count($preferredOrder);
//     if ($indexB === false) $indexB = count($preferredOrder);

//     return $indexA <=> $indexB;
// }
// usort($builds, 'sortByCustomOrder');

//sort by array 
$preferredOrder = ['Rajesh', 'Amit', 'Sachin'];

$sortByCustomOrder = function ($a, $b) use ($preferredOrder) {
    $indexA = array_search($a['customer_name'], $preferredOrder);
    $indexB = array_search($b['customer_name'], $preferredOrder);

    if ($indexA === false) $indexA = count($preferredOrder);
    if ($indexB === false) $indexB = count($preferredOrder);

    return $indexA <=> $indexB;
};

usort($builds, $sortByCustomOrder);


$preferredOrder = ['Rajesh', 'Amit', 'Sachin'];

function sortByCustomOrder($a, $b) {
    global $preferredOrder;
    $indexA = array_search($a['customer_name'], $preferredOrder);
    $indexB = array_search($b['customer_name'], $preferredOrder);

    if ($indexA === false) $indexA = count($preferredOrder);
    if ($indexB === false) $indexB = count($preferredOrder);

    return $indexA <=> $indexB;
}

//------------------------------------------------------------------------------

// date time formatiing 
$dateString = '2024-01-02 01:19:51';
$timestamp = strtotime($dateString) + strtotime("+1 Day");

echo date('Y-m-d', $timestamp); // Outputs: 2024-01-02
echo date('d/m/Y H:i:s', $timestamp); // Outputs: 02/01/2024 01:19:51
echo date('l, F j, Y', $timestamp); // Outputs: Wednesday, January 2, 2024

// array_reverse()
?>
