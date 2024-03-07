<?php
require '../components/ConnectDB.php';
require 'Insert_log.php';
session_start();

if (isset($_GET['ProName'])) {
    $ProNameToDelete = $_GET['ProName'];
    $userID = $_SESSION['userID'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['ProName'] == $ProNameToDelete) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    InsertLog($userID, 'Remove product from cart: ' . $ProNameToDelete, 'RemoveFromCart.php');
}

header("Location: Cart.php");
exit;
