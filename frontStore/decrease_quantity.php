<?php
require 'Insert_log.php';

session_start();

if (isset($_POST['ProName'])) {
    $ProName = $_POST['ProName'];

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['ProName'] == $ProName) {
            $item['quantity']--;
            if ($item['quantity'] < 1) {
                $item['quantity'] = 1;
            }
            break;
        }
    }

    InsertLog($_SESSION['userID'], 'decrease quantity of product name ' . $ProName . ' to ' . $item['quantity'], 'decrease_quantity.php');
}

header("Location: Cart.php");
exit;
?>