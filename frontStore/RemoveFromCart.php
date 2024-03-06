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

    InsertLog($userID, 'remove from cart product name ' . $ProNameToDelete);
}

header("Location: Cart.php");
exit;
