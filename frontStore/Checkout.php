<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sarabun&display=swap" rel="stylesheet">
    <title>SMITI Shop</title>
    <style>
        .container {
            display: flex;
            justify-content: space-between;

        }

        .left {
            margin-left: 80px;
        }

        .left table {
            margin-top: 20px;
            border-spacing: 80px 30px;
            /* border: 1px solid black; */
        }

        .left th {
            font-family: sarabun;
            margin-left: 50px;

        }

        .left td {
            font-family: sarabun;
            /* background-color: red; */
            text-align: center;
            vertical-align: middle;
        }

        .right {
            margin-right: 80px;
        }

        .right table {
            margin-top: 20px;
            border-spacing: 65px 30px;
            border-radius: 5px;
            overflow: hidden;
            /* border: 1px solid black; */
            margin-right: 70px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 360px;
        }

        .right th {
            font-family: sarabun;
            margin-left: 50px;
        }

        .right td {
            font-family: sarabun;
        }

        .right input[type="submit"] {
            font-family: sarabun;
            background-color: red;
            border: none;
            width: 100%;
            height: 40px;
            border-radius: 15px;
            font-size: 15px;
            color: white;
        }
        .right input[type="submit"]:hover {
            box-shadow: 0 5 100px rgba(0, 0, 0, 0.5);
        }

        .headbar {
            display: flex;
            justify-content: space-between;
            border-bottom: 3px solid black;
            margin-top: 30px;
            margin-left: 80px;
            margin-right: 80px;
        }

        .item-count {
            margin-right: 0px;
        }

        .order-summary {
            margin-left: 0px;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    require('Header.html');
    require('ConnectDB.php');

    $totalPrice = 0;
    $discount = 0.0;

    echo "<a href='Cart.php' style='font-family:sarabun; color:green; text-decoration:none; margin-left: 30px'><b>⬅️ Back to Shopping Cart</b></a>";
    echo "<div class='headbar'>
    <b class='order-summary' style='font-family:sarabun; font-size:30px'>Order Summary</b>
    <b class='item-count' style='font-family:sarabun; font-size:30px'>" . count($_SESSION['cart']) . " Item</b>
    </div>";

    echo "<div class='container'>";

    echo "<div class='left'>";
    echo "<form method='POST' action='Checkout.php'>";
    echo "<table style=''>";
    echo "<tr><th></th><th>ProductName</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";

    foreach ($_SESSION['cart'] as $item) {
        echo "<tr>";
        echo "<td><img src='" . $item['ProPic'] . "' width='100'></td>";
        echo "<td>" . $item['ProName'] . "</td>";
        echo "<td>" . $item['quantity'] . "</td>";
        echo "<td>" . $item['ProPrice'] . "</td>";
        echo "<td>" . $item['ProPrice'] * $item['quantity'] . "</td>";
        echo "</tr>";

        $totalPrice += $item['ProPrice'] * $item['quantity'];
    }
    echo "</table>";
    echo "</form>";
    echo "</div>";

    $discountAmount = $totalPrice * $discount;
    $finalPrice = $totalPrice - $discountAmount;

    echo "<div class='right' style=''>";
    echo "<table style=''>";
    echo "<tr><td><b>Total (". count($_SESSION['cart']) . " item)</b></td><td>" . $totalPrice . "</td></tr>";
    echo "<tr><td><b>Discount</b></td><td>" . $discountAmount . "</td></tr>";
    echo "<tr><td><b>Final Price</b></td><td>" . $finalPrice . "</td></tr>";
    echo "<form method='POST' action='AddOrder.php'>";
    echo "<tr><td colspan='2' style='text-align:center;'><input type='submit' value='Order Now' style='font-weight: bold;'></td></tr>";
    echo "</form>";
    echo "</table>";

    echo "</div>";
    echo "</div>";

    echo "</div>";
    ?>

</body>

</html>