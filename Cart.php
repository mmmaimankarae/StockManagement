<?php
session_start();
// require 'ConnectDB.php';
require 'Header.html';
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
</head>

<style>
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

    .shopping-cart {
        margin-left: 0px;
        padding-bottom: 10px;
    }

    .CheckoutButton {
        background-color: red;
        color: white;
        border-radius: 10px;
        width: 300px;
        height: 40px;
        border: none;
        text-align: center;
        font-family: sarabun;
    }

    .CheckoutButton:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .material-symbols-outlined:hover {
        color: red;
    }

    table {
        margin-top: 15px;
        margin-left: 80px;
    }

    td {
        padding-left: 80px;
        padding-right: 80px;
    }

    th {
        font-family: sarabun;
    }
</style>

<?php
$productInCart = false;
$BinIconSize = 25;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

echo "<a href='Store.php' style='font-family:sarabun; color:green; text-decoration:none; margin-left: 30px'><b>⬅️ Continue Shopping</b></a>";
echo "<div class='headbar'>
    <b class='shopping-cart' style='font-family:sarabun; font-size:30px'>Shopping Cart</b>
    <b class='item-count' style='font-family:sarabun; font-size:30px'>" . count($_SESSION['cart']) . " Item</b>
    </div>
    ";
if (isset($_POST['ProName']) && isset($_POST['quantity'])) {
    $ProName = $_POST['ProName'];
    $quantity = $_POST['quantity'];

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['ProName'] == $ProName) {
            $item['quantity'] += $quantity;
            $productInCart = true;
            break;
        }
    }

    if (!$productInCart) {
        $sql = "SELECT * FROM product WHERE ProName = '$ProName'";
        $result = mysqli_query($connectDB, $sql);
        $row = mysqli_fetch_array($result);
        $ProID = $row['ProID'];
        $ProPrice = $row['PricePerUnit'];
        $ProPic = $row['Pimage'];
        $ProTotal = $ProPrice * $quantity;
        $cart = array(
            "ProID" => $ProID,
            "ProName" => $ProName,
            "ProPrice" => $ProPrice,
            "ProPic" => $ProPic,
            "quantity" => $quantity,
        );
        array_push($_SESSION['cart'], $cart);
    }
}

if (isset($_GET['delete'])) {
    $ProNameToDelete = $_GET['delete'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['ProName'] == $ProNameToDelete) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    header("Location: Cart.php");
    exit;
}

displayCartTable($_SESSION['cart']);

function displayCartTable($cartItems)
{
    $totalPrice = 0;
    foreach ($cartItems as $cart) {
        $totalPrice += $cart['ProPrice'] * $cart['quantity'];
    }

    echo "<table style='border:0; border-collapse: collapse;'>";
    echo "<tr>";
    echo "<th></th>";
    echo "<th>Product Name</th>";
    echo "<th>Product Price</th>";
    echo "<th>Quantity</th>";
    echo "<th>Total</th>";
    echo "<th></th>";
    echo "</tr>";
    foreach ($cartItems as $cart) {
        echo "<tr>";
        echo "<td><img src='" . $cart['ProPic'] . "' width='100'></td>";
        echo "<td style='font-family:sarabun; '>" . $cart['ProName'] . "</td>";
        echo "<td style='font-family:sarabun; '>" . $cart['ProPrice'] . "</td>";
        // echo "<td style='font-family:sarabun; '>
        //     <span class='material-symbols-outlined' style='font-size: 16px;'>add</span>
        //     <input type='text' style='width:10px; text-align:center; border:0; font-family:sarabun; font-size: 17px;' id='qty' value='" . $cart['quantity'] . "' readonly>
        //     <span class='material-symbols-outlined' style='font-size: 18px;'>remove</span>
        //     </td>";

        echo "<td style='font-family:sarabun;'>";
        echo "<div style='display: flex; align-items: center; justify-content: center;'>";
        echo "<form method='POST' action='increase_quantity.php' style='display: inline;'>";
        echo "<input type='hidden' name='ProName' value='" . $cart['ProName'] . "'>";
        echo "<button type='submit' class='material-symbols-outlined' style='font-size: 16px; border:none; background:none'>add</button>";
        echo "</form>";
        echo "<input type='text' style='width:10px; text-align:center; border:0; font-family:sarabun; font-size: 17px;' id='qty' value='" . $cart['quantity'] . "' readonly>";
        echo "<form method='POST' action='decrease_quantity.php' style='display: inline;'>";
        echo "<input type='hidden' name='ProName' value='" . $cart['ProName'] . "'>";
        echo "<button type='submit' class='material-symbols-outlined' style='font-size: 18px; border:none; background:none'>remove</button>";
        echo "</form>";
        echo "</div>";
        echo "</td>";

        echo "<td style='font-family:sarabun; '>" . $cart['ProPrice'] * $cart['quantity'] . "</td>";
        echo "<td><a href='Cart.php?delete=" . urlencode($cart['ProName']) . "'><img src='Asset/BinIcon.png' width='25'></a></td>";
        echo "</tr>";
    }
    echo "</table><br><br>";
    echo "<div style='background-color:#062639; border-radius: 15px; padding-right: 25px; padding-top: 10px; padding-bottom: 20px; margin-left:80px; margin-right:80px;'>";

    echo "<h2 style='text-align:right; color:white; font-family:sarabun; font-size: 20px;'>Total Price : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $totalPrice - 0 . " Bath</h2>";
    echo "<div style='text-align: right;'>";
    echo "<a href='Checkout.php'>";
    echo  "<button class='CheckoutButton'><b>Check Out</b></button></a>";
    echo "</div>";
    echo "</div>";
}

?>

</html>