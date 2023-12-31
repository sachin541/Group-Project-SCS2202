<?php

include_once '../utils/dbConnect.php';
$conn = OpenCon();
$itemList = $_POST['itemList'];
$clearValue = $_POST['clearValue'];

$total = 0;
$discount = 0;
$netTotal = 0;

if ($clearValue == 0) {
    $itemListArray = json_decode($itemList, true);


    if (is_array($itemListArray) && count($itemListArray) > 0) {
        foreach ($itemListArray as $itemSelect) {
            $itemSelectArray = json_decode($itemSelect, true);
            $total = $total + $itemSelectArray['total'];
        }
    }

    $netTotal = $total - $discount;
}


?>

<div class="total-box">
    <div class="price-item">
        <span>Total (Rs.) :</span>
        <?php
        if ($clearValue == 0) { ?>
            <span> <?php echo number_format($total, 2, '.', ',') ?> </span>
        <?php
        } else { ?>
            <span>00.00</span>
        <?php
        } ?>
    </div>
    <div class="price-item">
        <span>Discount (Rs.) :</span>
        <?php
        if ($clearValue == 0) { ?>
            <span> <?php echo number_format($discount, 2, '.', ',') ?> </span>
        <?php
        } else { ?>
            <span>00.00</span>
        <?php
        } ?>
    </div>
    <div class="price-item net-total">
        <span>Net Total (Rs.) :</span>
        <?php
        if ($clearValue == 0) { ?>
            <span> <?php echo number_format($netTotal, 2, '.', ',') ?> </span>
        <?php
        } else { ?>
            <span>00.00</span>
        <?php
        } ?>
    </div>
</div>