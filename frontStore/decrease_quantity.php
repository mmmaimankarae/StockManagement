<?php
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
}

header("Location: Cart.php");
exit;
?>