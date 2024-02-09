<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
require 'ConnectDB.php';
require 'Header.html';
$showProductNameOrder = [];
$totalPrice = 0;
$orderNo = "OD-1";
$productTotal = count($_SESSION['cart']);
foreach ($_SESSION['cart'] as $item) {
    $showProductNameOrder[] = $item['ProName'];
    $totalPrice += $item['ProPrice'] * $item['quantity'];

    // $sql = "INSERT INTO `history_order`(`HisID`, `NumID`, `ProID`, `Qty`, `Status`) VALUES ('OD-1', 'N1', " . $item['ProID'] .",". $item['quantity'] . ",'onhand')";
    // $result = mysqli_query($connectDB, $sql);
}
// echo "<script>alert('orderInfo Success!');</script>";
// session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMITI Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sarabun&display=swap" rel="stylesheet">
    <style>
        .headbar {
            display: flex;
            justify-content: space-between;
            border-bottom: 5px solid black;
            border-radius: 2px;
            margin-top: 0px;
            margin-left: 450px;
            margin-right: 450px;
        }

        .orderDetail {
            display: flex;
            justify-content: space-between;
            margin-top: 0px;
            margin-left: 450px;
            margin-right: 450px;
        }

        .orderNo {
            margin-right: 0px;
            font-family: sarabun;
            font-size: 20px;
        }

        .orderInfo {
            margin-left: 0px;
            padding-bottom: 10px;
            color: grey;
            font-family: sarabun;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <center>
        <img src="Asset/Thank1.png" />
        <?php
        echo "<div class='headbar'>
            <b class='orderInfo' style='font-family:sarabun; font-size:30px'>Order</b>
            <b class='orderNo' style='font-family:sarabun; font-size:30px'> #" .  $orderNo  . "</b>
        </div>";
        echo "<h1 style='font-family:sarabun;'>ขอบคุณที่ใช้บริการ</h1>";
        echo "<h3 style='font-family:sarabun;'>ได้รับคำสั่งซื้อเรียบร้อยแล้ว</h3>";
        echo "<div class='orderDetail'>
            <b class='orderInfo'>วันที่ทำการสั่งซื้อ</b>
            <b class='orderNo'>วันที่: " . date("d-m-" . date('Y') + 543) . "</b>
            </div>";
        echo "<div class='orderDetail'>
            <b class='orderInfo'>ชื่อนามสกุล</b>
            <b class='orderNo'>Test Customer</b>
            </div>";
        echo "<div class='orderDetail'>
            <b class='orderInfo'>ที่อยู่การจัดส่ง</b>
            <b class='orderNo'>เขตลาดกระบัง, กรุงเทพมหานคร</b>
            </div>";
        echo "<div class='orderDetail'>
            <b class='orderInfo'>จำนวนสินค้า</b>
            <b class='orderNo'>" . $productTotal . " รายการ</b>
            </div>";
        foreach ($showProductNameOrder as $item) {
            echo "<div class='orderDetail'>";
            echo "<b class='orderInfo'></b>";
            echo "<b class='orderNo'>• " . $item . "</b>";
            echo "</div>";
        }
        echo "<div class='orderDetail'>";
            echo "<b class='orderInfo'>ราคาสุทธิ</b>";
            echo "<b class='orderNo'>" . $totalPrice . " บาท</b>";
            echo "</div>";
        echo "<div class='orderDetail'>";
            echo "<b class='orderInfo'>สถานะคำสั่งซื้อ</b>";
            echo "<b class='orderNo'>กำลังตรวจสอบการสั่งซื้อ</b>";
            echo "</div>";
        ?>
        <br>
        <br>
        <a href="Store.php" style="font-family:sarabun; color:red; text-decoration:none; margin-left: 30px; font-size:20px;"><b>🧺 กลับไปหน้าร้านค้า</b></a>
    </center>
    <table>

    </table>
</body>

</html>