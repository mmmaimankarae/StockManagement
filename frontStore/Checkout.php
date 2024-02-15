<?php
session_start();
require '../components/ConnectDB.php';
require '../components/HeaderStore.html';

?>

<!DOCTYPE html>
<html>

<head>
    <title>SMITI Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sarabun&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<style>
    .mt-custom {
        margin-top: 80px;
        margin-left: 80px;
        margin-right: 80px;
    }

    .headbar {
        display: flex;
        justify-content: space-between;
        border-bottom: 3px solid black;
        margin-top: 30px;
    }

    .shopping-cart {
        margin-left: 0px;
        padding-bottom: 10px;
    }

    .input-group {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: sarabun;
        text-align: center;
    }

    table.orderSummary {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        font-family: sarabun;
    }

    th.img {
        width: 280px;
    }

    tr.product:hover {
        background-color: #f5f5f5;
    }
</style>

<?php

echo "<div class='mt-custom'>";
echo "<a href='Cart.php' style='font-family:sarabun; color:green; text-decoration:none;'><b>⬅️ กลับไปยังตะกร้าสินค้า</b></a>";
echo "<div class='headbar'>
    <b class='shopping-cart' style='font-family:sarabun; font-size:30px'>Order Summary</b>
    <b class='item-count' style='font-family:sarabun; font-size:30px'>" . count($_SESSION['cart']) . " Item</b>
    </div>
    ";

echo "<div class='container'>";
echo "<div class='row'>";
echo "<div class='col-md-8' style='margin-right: 20px;'>"; // Add margin to the right side of the left column
displayCartTable($_SESSION['cart'], count($_SESSION['cart']) > 0);
echo "</div>";
echo "<div class='col-md-3'>"; // Reduce the width of the right column to account for the margin
displayOrderSummary($_SESSION['cart']);
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

function displayCartTable($cartItems, $hasItem)
{
    $totalPrice = 0;
    foreach ($cartItems as $cart) {
        $totalPrice += $cart['ProPrice'] * $cart['quantity'];
    }

    echo "<table>";
    if ($hasItem) {
        echo "<tr>";
        echo "<th class='img'></th>";
        echo "<th>Name</th>";
        echo "<th>Price</th>";
        echo "<th>Quantity</th>";
        echo "</tr>";
        foreach ($cartItems as $cart) {
            echo "<tr class='product'>";
            echo "<td class='img'><img src='" . $cart['ProPic'] . "' width='100' height='100'></td>";
            echo "<td>" . $cart['ProName'] . "</td>";
            echo "<td>฿" . $cart['ProPrice'] . "</td>";
            // echo "<td>" . $cart['quantity'] . "</td>";

            echo "<td>";;
            echo "" . $cart['quantity']  . "";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr>";
        echo "<td colspan='6' style='text-align:center; font-size: 30px'><b>ไม่มีสินค้าในตะกร้า</b></td>";
        echo "</tr>";
    }

    echo "</table>";
}

function displayOrderSummary($cartItems)
{
    $totalPrice = 0;
    $discount = 0; // Replace this with your discount calculation
    foreach ($cartItems as $cart) {
        $totalPrice += $cart['ProPrice'] * $cart['quantity'];
    }
    echo "<table class='orderSummary'>";
    echo "<tr>";
    echo "<td style='text-align:left; padding-left: 20px; padding-top: 15px;'>";
    echo "<p><b>Total Price: </b></p>";
    echo "</td>";
    echo "<td style='text-align:right; padding-right: 20px; padding-top: 15px;'>";
    echo "<p>฿" . $totalPrice . "</p>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td style='text-align:left; padding-left: 20px; padding-top: 15px;'>";
    echo "<p><b>Discount:</b></p>";
    echo "</td>";
    echo "<td style='text-align:right; padding-right: 20px; padding-top: 15px;'>";
    echo "<p>฿" . $discount . "</p>";
    echo "</td>";    
    echo "</tr>";
    echo "<tr>";
    echo "<td style='text-align:left; padding-left: 20px; padding-top: 15px;'>";
    echo "<p><b>Final Price:</b></p>";
    echo "</td>";
    echo "<td style='text-align:right; padding-right: 20px; padding-top: 15px;'>";
    echo "<p>฿" . ($totalPrice - $discount) . "</p>";   
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' style='text-align:center;  padding-bottom: 15px;'>";
    echo "<form action='HisrotyInsert.php' method='POST'>";
    echo "<div style='text-align:center; margin-top: 20px'>";
    echo "<a href='HisrotyInsert.php' class='btn btn-success w-75' style='font-family:sarabun; font-size: 20px'>ชำระเงิน</a>";
    echo "</div>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";

    echo "</table>";

}
?>
</html>