<!DOCTYPE html>
<html lang="en">

<head>
    <title>Item Category Content</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        #itemList {
            list-style: none;
            padding: 0;
        }

        #itemList li {
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgb(95, 89, 89);
            color: white;
            margin: 5px;
        }

        #itemList li:hover {
            background-color: #e74d3cd0;
        }

        #itemList li.selected {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>

<body>
    <ul id="itemList">

        <?php

        if (isset($_GET['id'])) {
            $buttonId = $_GET['id'];

            switch ($buttonId) {
                case "processor":

                    echo '<li data-value="Item 1">Intel Core i3-12100F</li>
                            <li data-value="Item 1">Intel Core i5 13500</li>
                            <li data-value="Item 1">Intel Core i5 13600KF</li>
                            <li data-value="Item 1">Intel Core i7 13700K</li>
                            <li data-value="Item 1">Intel Core i7 13450K</li>
                        ';

                    break;
                case "ram":
                    echo '<li data-value="Item 1">NETAC BASIC 8GB DDR4 3200MHZ C16 DESKTOP</li>
                            <li data-value="Item 1">DDR4 MEMORY - TEAM 4GB ELITE PLUS 2666MHZ</li>
                            <li data-value="Item 1">NETAC BASIC 4GB DDR4 2666MHZ C19 DESKTOP</li>
                            <li data-value="Item 1">DDR4 MEMORY - TRANSCEND 4GB 2666MHZ DESKTOP</li>
                            <li data-value="Item 1">DDR4 MEMORY - TEAM 8GB ELITE PLUS 2666MHZ</li>
                        ';
                    break;
                case "hdd":
                    echo '<li data-value="Item 1">Hard Disk Seagate 10tb Nas Ironwolf</li>
                            <li data-value="Item 1">Hard Disk Seagate 1tb Barracuda</li>
                            <li data-value="Item 1">Hard Disk Seagate 1tb Sv35 Skyhawk</li>
                            <li data-value="Item 1">Hard Disk Toshiba 1tb Sata 7200rpm</li>
                            <li data-value="Item 1">Hard Disk Wd 2tb Sata Purple</li>
                        ';
                    break;
                case "ssd":
                    echo '<li data-value="Item 1">Ssd Adata 120gb Su650 Sata</li>
                            <li data-value="Item 1">Ssd Kingston 1tb Nv2 M.2 Nvme</li>
                            <li data-value="Item 1">Ssd Kingston 480gb M.2 A400</li>
                            <li data-value="Item 1">Ssd Lexar 1tb M.2 Nvme Nm620</li>
                            <li data-value="Item 1">Ssd Lexar 256gb M.2 Nvme Nm620</li>
                        ';
                    break;
                case "gpu":
                    echo '<li data-value="Item 1">ASUS ROG STRIX GEFORCE RTX 4060 8GB GDDR6X OC GRAPHICS CARD</li>
                            <li data-value="Item 1">MSI GEFORCE RTX 3080 TI GAMING X TRIO 12GB GDDR6X GRAPHICS CARD</li>
                            <li data-value="Item 1">MSI GEFORCE RTX 3080 TI VENTUS 3X 12GB OC GDDR6X GRAPHICS CARD</li>
                            <li data-value="Item 1">MSI GEFORCE GTX 1650 D6 VENTUS XS V1 4GB GDDR6X GRAPHICS CARD</li>
                            <li data-value="Item 1">MSI RADEON RX 550 AERO ITX 4GB GDDR5 OC GRAPHICS CARD</li>
                        ';
                    break;
                case "monitor":
                    echo '<li data-value="Item 1">DAHUA DHI-LM19-A200 19.5 MONITOR</li>
                            <li data-value="Item 1">ASUS VZ27EHE 27 FULL HD MONITOR</li>
                            <li data-value="Item 1">MONITOR - ABANS M215TN 21.5 MONITOR</li>
                            <li data-value="Item 1">ACER K202HQL 19.5 MONITOR</li>
                            <li data-value="Item 1">SAMSUNG F24T450FQE 24 FULL HD MONITOR</li>
                        ';
                    break;
                case "cpu-box":
                    echo '<li data-value="Item 1">COOLER MASTER MASTERBOX MB520 ARGB CASE</li>
                            <li data-value="Item 1">ASUS GT301 TUF MID-TOWER ARGB GAMING CASE</li>
                            <li data-value="Item 1">ASUS TUF GT501 GREY RGB MID-TOWER ATX GAMING CASE</li>
                            <li data-value="Item 1">COOLER MASTER MASTERBOX K501L MID-TOWER CASE</li>
                            <li data-value="Item 1">CORSAIR 5000D TEMPERED GLASS MID-TOWER ATX CASE – WHITE</li>
                        ';
                    break;
                case "board":
                    echo '<li data-value="Item 1">MSI PRO B760M-A (WIFI) DDR5 MOTHERBOARD</li>
                            <li data-value="Item 1">MSI PRO H610M-E DDR4 MOTHERBOARD</li>
                            <li data-value="Item 1">ASUS TUF GT501 GREY RGB MID-TOWER ATX GAMING CASE</li>
                            <li data-value="Item 1">ASUS PRIME Z690 P WI-FI DDR5 MOTHERBOARD</li>
                            <li data-value="Item 1">MSI A520M-A PRO MOTHERBOARD</li>
                        ';
                    break;
                case "fan":
                    echo '<li data-value="Item 1">Casing Fan -15 LED Red Blue Green 120mm for PC case fan 120mm 12v 1200RPM</li>
                            <li data-value="Item 1">12v Dc cooling Fan 2inch|3inch|3 1|2inch dc brushless fan</li>
                            <li data-value="Item 1">AIGO DARKFLASH TWISTER DX-120 ARGB 120mm LIQUID CPU COOLER</li>
                            <li data-value="Item 1">1155/1150 INTEL ORIGINAL COPEER CPU COOLER</li>
                            <li data-value="Item 1">COOLER MASTER HYPER 212X</li>
                        ';
                    break;
                default:
                    echo "<script>alert('Invalid ID');</script>";
            }
        } else {
            echo "No button ID specified.";
        }
        ?>
    </ul>
</body>

</html>