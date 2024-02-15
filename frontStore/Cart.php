<?php
session_start();
require '../components/ConnectDB.php';
require '../components/HeaderStore.html';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
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

    .backButton:hover {
        color: red;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: sarabun;
        text-align: center;
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
echo "<a href='Store.php' class='backButton' style='font-family:sarabun; color:green; text-decoration:none;'><b>⬅️ กลับไปหน้าร้านค้า</b></a>";
echo "<div class='headbar'>
    <b class='shopping-cart' style='font-family:sarabun; font-size:30px'>Shopping Cart</b>
    <b class='item-count' style='font-family:sarabun; font-size:30px'>" . count($_SESSION['cart']) . " Item</b>
    </div>
    ";

displayCartTable($_SESSION['cart'], count($_SESSION['cart']) > 0);
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
        echo "<th>Total</th>";
        echo "<th></th>";
        echo "</tr>";
        foreach ($cartItems as $cart) {
            echo "<tr class='product'>";
            echo "<td class='img'><img src='" . $cart['ProPic'] . "' width='100' height='100'></td>";
            echo "<td>" . $cart['ProName'] . "</td>";
            echo "<td>฿" . $cart['ProPrice'] . "</td>";
            // echo "<td>" . $cart['quantity'] . "</td>";

            echo "<td>";;
            echo "<div class='input-group mb-3 w-20'>";

            echo "<form action='decrease_quantity.php' method='POST'>";
            echo "<input type='hidden' name='ProName' value='" . $cart['ProName'] . "'>";
            echo "<input type='hidden' name='ProPrice' value='" . $cart['quantity'] . "'>";
            echo "<button class='btn btn-outline-secondary' type='submit' id='button-addon1' onclick='decreaseQuantity()'>-</button>";
            echo "</form>";

            echo "<input type='text' id='quantity' style='border: 10px; text-align:center; width: 50px;' size='1' placeholder='' min='1' aria-label='Example text with button addon' aria-describedby='button-addon1' value='" . $cart['quantity'] . "' readonly>";

            echo "<form action='increase_quantity.php' method='POST'>";
            echo "<input type='hidden' name='ProName' value='" . $cart['ProName'] . "'>";
            echo "<input type='hidden' name='ProPrice' value='" . $cart['quantity'] . "'>";
            echo "<button class='btn btn-outline-secondary' type='submit' id='button-addon2' onclick='increaseQuantity()'>+</button>";
            echo "</form>";

            echo "</div>";
            echo "</td>";

            echo "<td>฿" . $cart['ProPrice'] * $cart['quantity'] . "</td>";
            echo "<td><a href='RemoveFromCart.php?ProName=" . $cart['ProName'] . "'><span class='material-symbols-outlined' style='color: red;'>
            delete
            </span></a></td>";
            echo "</tr>";
        }
        echo "<tr>";
        echo "<td colspan='6' style='text-align:right; font-size: 20px'><b>Total: ฿" . $totalPrice . "</b></td>";
        echo "</tr>";
    } else {
        echo "<tr>";
        echo "<td colspan='6' style='text-align:center; font-size: 30px'><b>ไม่มีสินค้าในตะกร้า</b></td>";
        echo "</tr>";
    }

    echo "</table>";
    if ($hasItem) {
        echo "<form action='Checkout.php' method='POST'>";
        echo "<div style='text-align:right; margin-top: 20px'>";
        echo "<a href='Checkout.php' class='btn btn-success' style='font-family:sarabun; font-size: 20px; width: 15%;'>สั่งซื้อ</a>";
        echo "</div>";
        echo "</form>";
    } else {
        echo "<div style='text-align:center; margin-top: 20px'>";
        echo "<a href='Store.php' class='btn btn-success' style='font-family:sarabun; font-size: 20px' >Go Shopping</a>";
        echo "</div>";
    }
}

?>

</html>