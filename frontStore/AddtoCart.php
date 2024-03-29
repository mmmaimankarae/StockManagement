<?php
require '../components/ConnectDB.php';

session_start();
$productInCart = false;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['ProName']) && isset($_POST['Quantity'])) {
    $ProName = $_POST['ProName'];
    $quantity = $_POST['Quantity'];
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
        $ProPic = $row['ImageSource'];
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
    header("Location: Cart.php");
    exit();
}
