<?php
session_start();

if (isset($_GET['ProName'])) {
    $ProNameToDelete = $_GET['ProName'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['ProName'] == $ProNameToDelete) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
}

header("Location: Cart.php");
exit;
?>