<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bill</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/bill.css" type="text/css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
</head>

<body>
    <div id="new-i" class="modal">
        <div class="modal-content">
            <span class="close" id="close-i">&times;</span>
            <div class="bill-outer-container">
                <div class="bill-inner-1">
                    <h2>Customer Invoice</h2>
                    <form action="new_brand.php" method="POST">
                        <div class="modal-form-group">
                            <label for="item">Item</label>
                            <select type="text" name="item" class="modal-form-control" id="item">
                                <option value="">Select Item</option>
                                <?php
                                include_once '../utils/dbConnect.php';
                                $conn = OpenCon();
                                // Prepare an retrieve statement
                                $sql = "SELECT product_name FROM product";
                                if ($result = mysqli_query($conn, $sql)) {

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo '<option>' . $row['product_name'] . ' </option>';
                                        }
                                    }
                                    CloseCon($conn);
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-form-group">
                            <label for="qty">Quantity</label>
                            <input type="number" name="qty" class="modal-form-control" placeholder="Enter quantity" id="qty" />
                        </div>
                        <div class="modal-form-group">
                            <input type="button" onclick="getItemDetails(0)" name="submit" id="additem" class="modal-submit-btn" value="ADD ITEM" />
                        </div>
                    </form>

                    <!-- <script>
                        const getItemDetails = (clrValue) => {
                            let item = document.getElementById(`item`).value;
                            let qty = document.getElementById(`qty`).value;
                            let itemList = document.getElementById(`itemList`).value;
                            let clearValue = clrValue;

                            if (item.length == 0 || qty.length == 0) {
                                alert("Please select an item and enter a quantity");
                            } else {

                                var formData = new FormData();
                                formData.append("item", item);
                                formData.append("qty", qty);
                                formData.append("itemList", itemList);
                                formData.append("clearValue", clearValue);

                                var req = getXmlHttpRequestObject();
                                if (req) {
                                    req.onreadystatechange = function() {
                                        if (req.readyState == 4) {
                                            if (req.status == 200) {
                                                // alert(req.responseText);
                                                document.getElementById(`productItemTableBody`).innerHTML = req.responseText;
                                                setTimeout(() => {
                                                    getTotalPrice(clearValue);
                                                }, 800);
                                            }
                                        }
                                    };
                                    req.open("POST", "../components/new_brand.php", true);
                                    req.send(formData);
                                }
                            }
                        }

                        const getTotalPrice = (clrValue) => {
                            let itemList = document.getElementById(`itemList`).value;
                            let clearValue = clrValue;

                            var formData = new FormData();
                            formData.append("itemList", itemList);
                            formData.append("clearValue", clearValue);

                            var req = getXmlHttpRequestObject();
                            if (req) {
                                req.onreadystatechange = function() {
                                    if (req.readyState == 4) {
                                        if (req.status == 200) {
                                            document.getElementById(`productPriceBody`).innerHTML = req.responseText;
                                        }
                                    }
                                };
                                req.open("POST", "../components/new_price.php", true);
                                req.send(formData);
                            }
                        }

                        function getXmlHttpRequestObject() {
                            if (window.XMLHttpRequest) {
                                return new XMLHttpRequest();
                            } else if (window.ActiveXObject) {
                                return new ActiveXObject("Microsoft.XMLHTTP");
                            } else {}
                        }
                    </script> -->
                    <div class="table-container" id="productItemTableBody">
                        <table class="item-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>QTY</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <input type="text" id="itemList" value="" hidden>
                    </div>
                </div>
                <div class="bill-inner-2">
                    <div id="productPriceBody">
                        <div class="total-box">
                            <div class="price-item">
                                <span>Total (Rs.) :</span>
                                <span>00.00</span>
                            </div>
                            <div class="price-item">
                                <span>Discount (Rs.) :</span>
                                <span>00.00</span>
                            </div>
                            <div class="price-item net-total">
                                <span>Net Total (Rs.) :</span>
                                <span>00.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="create-btn-box">
                        <div><button class="clear-btn" onclick="clearItems()">CLEAR</button></div>
                        <div><button class="create-btn" onclick="createBill()">CREATE</button></div>
                    </div>
                    <!-- <script>
                        const clearItems = () => {
                            getItemDetails(1);
                        }
                        const createBill = () => {
                            let itemList = document.getElementById(`itemList`).value;

                            var formData = new FormData();
                            formData.append("itemList", itemList);

                            var req = getXmlHttpRequestObject();
                            if (req) {
                                req.onreadystatechange = function() {
                                    if (req.readyState == 4) {
                                        if (req.status == 200) {
                                            alert(req.responseText)
                                        }
                                    }
                                };
                                req.open("POST", "../components/create_bill.php", true);
                                req.send(formData);
                            }
                            document.getElementById('new-i').style.display = 'none';
                        }
                    </script> -->
                </div>
            </div>
        </div>
    </div>

    <script src="../../resources/js/bill.js"></script>
    <script>

    </script>
</body>

</html>