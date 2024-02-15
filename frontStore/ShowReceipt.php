<?php
session_start();
require '../components/ConnectDB.php';

$sql = "SELECT r.RecID, r.Period, r.CusID, ro.NumID, ro.ProID, ro.Qty 
        FROM receive r 
        JOIN receive_order ro ON r.RecID = ro.RecID";

$result = mysqli_query($connectDB, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
        th, td {
            text-align: center;
        }
        .left {
            text-align: left;
        }
        .right {
            text-align: right;
        }
        .no-border {
            border-bottom: none !important;
        }
        .logo {
            float: left;
            width: 100px;
            height: auto;
        }
        .button-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container"> 
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $cusID = $row["CusID"];
            $sql = "SELECT * FROM `customer` WHERE `CusID` = '$cusID'";
            $customerResult = mysqli_query($connectDB, $sql);
            $customerRow = mysqli_fetch_assoc($customerResult);
            $cusFName = $customerRow['CusFName'];
            $cusLName = $customerRow['CusLName'];
            $cusAddress = $customerRow['Address'];
            $cusTel = $customerRow['Tel'];

            echo "<img src='../Pictures/logo.png' class='logo'>";
            echo "<h1 style='text-align: right;'><b>Receipt</b></h1>";

            echo "<table class='table'>";
            echo "<tr><td class='left no-border'><b>Ship to</b></td><td class='right no-border'><b>Reciept</b></td></tr>";
            echo "<tbody>";

            echo "<tr><td class='left no-border'>" . $cusFName . " " . $cusLName . "</td><td class='right no-border'><b>Receipt ID: </b>" . $row["RecID"] . "</td></tr>";
            echo "<tr><td class='left no-border'>" . $cusAddress . "</td><td class='right no-border'><b>Period: </b>" . $row["Period"] . "</td></tr>";
            echo "<tr><td class='left no-border'><b>Tel: </b>" . $cusTel . "</td><td class='right no-border'></td></tr>";

            echo "</tbody></table>";

            echo "<table class='table'>";
            echo "<thead class='thead-dark'><tr><th>Quantity</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Amount</th></tr></thead>";
            echo "<tbody>";
            $total = 0;
            do {
                $proID = $row["ProID"];
                $sql = "SELECT * FROM `product` WHERE `ProID` = '$proID'";
                $productResult = mysqli_query($connectDB, $sql);
                $productRow = mysqli_fetch_assoc($productResult);
                $proName = $productRow['ProName'];
                $price = $row['Qty'] * $productRow['PricePerUnit'];

                $amount = $row["Qty"] * $price;
                $total += $amount;

                echo "<tr><td>" . $row["Qty"] . "</td><td>" . $proName . "</td><td>" . $row["Qty"] . "</td><td>฿" . $productRow['PricePerUnit'] . "</td><td>฿" . $price . "</td></tr>";
            } while($row = mysqli_fetch_assoc($result));

            $discount = $total * 0.05; // 5% discount
            $totalAfterDiscount = $total - $discount;
            $vat = $totalAfterDiscount * 0.07; // 7% VAT
            $grandTotal = $totalAfterDiscount + $vat;

            echo "<tr><td colspan='4'><b>Subtotal</b></td><td>฿" . $total . "</td></tr>";
            echo "<tr><td colspan='4'><b>Discount (5%)</b></td><td>฿" . $discount . "</td></tr>";
            echo "<tr><td colspan='4'><b>VAT (7%)</b></td><td>฿" . $vat . "</td></tr>";
            echo "<tr><td colspan='4'><b>Grand Total</b></td><td>฿" . $grandTotal . "</td></tr>";
            echo "</tbody></table>";

            echo "<div class='button-container'>";
            echo "<a href='shop.php' style='margin-right: 20px' class='btn btn-primary'>Back to Shop</a>";
            echo "<a href='export.php' class='btn btn-secondary'>Export to PDF</a>";
            echo "</div>";

            echo "<br>";
            echo "<br>";

        } else {
            echo "No results";
        }
        ?>
    </div>
</body>
</html>

<?php
mysqli_close($connectDB);
?>