<?php

include_once '../utils/dbConnect.php';
$conn = OpenCon();
$item = $_POST['item'];
$qty = $_POST['qty'];
$itemList = $_POST['itemList'];
$clearValue = $_POST['clearValue'];

if ($clearValue == 0) {
    $itemListArray = json_decode($itemList, true);


    $itemListNew = array();

    if (is_array($itemListArray) && count($itemListArray) > 0) {
        foreach ($itemListArray as $itemSelect) {
            array_push($itemListNew, $itemSelect);
        }
    }

    $sql1 = "SELECT * FROM product WHERE product_name = '$item'";
    $result = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($result);

    $unitPrice = $row1['price'];
    $total = $unitPrice * $qty;


    $newItem = array(
        'item' => $item,
        'qty' => $qty,
        'unitPrice' => $unitPrice,
        'total' => $total
    );

    $newItemJSON = json_encode($newItem);

    array_push($itemListNew, $newItemJSON);
}
?>

<table class="item-table">
    <thead>
        <tr>
            <th>Item</th>
            <th>QTY</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <?php
    if ($clearValue == 0) { ?>
        <tbody>
            <?php

            for ($i = 0; $i < count($itemListNew); $i++) {

                $itemListNewDecodedData = json_decode($itemListNew[$i], true);
            ?>

                <tr>
                    <td><?php echo $itemListNewDecodedData['item'] ?></td>
                    <td style="right"><?php echo $itemListNewDecodedData['qty'] ?></td>
                    <td style="right"><?php echo number_format($itemListNewDecodedData['unitPrice'], 2, '.', ',') ?></td>
                    <td style="right"><?php echo number_format($itemListNewDecodedData['total'], 2, '.', ',') ?></td>
                </tr>

            <?php

            }

            ?>
        </tbody>
    <?php
    } else { ?>
        <tbody>

        </tbody>
    <?php
    } ?>

</table>

<input type="text" id="itemList" value="<?php echo htmlspecialchars(json_encode($itemListNew)); ?>" hidden>

<?php
