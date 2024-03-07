<?php
require 'Insert_log.php';

session_start();

if (isset($_POST['ProName'])) {
    $ProName = $_POST['ProName'];

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['ProName'] == $ProName) {
            $item['quantity']++;
            break;
        }
    }

    InsertLog($_SESSION['userID'], 'Increase quantity of product: ' . $ProName . ' to ' . $item['quantity'], 'increase_quantity.php');
}

header("Location: Cart.php");
exit;
?>