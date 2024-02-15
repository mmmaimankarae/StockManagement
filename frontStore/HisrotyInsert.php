<?php
session_start();
require '../components/ConnectDB.php';

date_default_timezone_set('Asia/Bangkok');
$customerID = $_SESSION['CusID'];
$status = "Pending";
$period = date("Y-m-d H:i:s");

// ดึง HisID ล่าสุด
$sql = "SELECT `HisID` FROM `history` ORDER BY `HisID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastHisID = $row['HisID'];

// แยกตัวเลขออกจาก HisID แล้วเพิ่มค่าขึ้น 1
$number = (int) substr($lastHisID, 3);
$newNumber = $number + 1;

// สร้าง HisID ใหม่
$newHisID = 'OD-' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

// ดึง NumID ล่าสุด
$sql = "SELECT `NumID` FROM `history_order` ORDER BY `NumID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastNumID = $row['NumID'];

// แยกตัวเลขออกจาก NumID แล้วเพิ่มค่าขึ้น 1
$number = (int) substr($lastNumID, 1);
$newNumber = $number + 1;

// สร้าง NumID ใหม่
$newNumID = 'N' . str_pad($newNumber, 1, '0', STR_PAD_LEFT);

$sql = "INSERT INTO `history`(`HisID`, `Period`, `CusID`, `Status`) VALUES ('$newHisID','$period','$customerID','$status') ";
$msresults = mysqli_query($connectDB, $sql);

if ($msresults) {
    foreach ($_SESSION['cart'] as $item) {
        $sql = "INSERT INTO `history_order`(`HisID`, `NumID`, `ProID`, `Qty`) VALUES ('$newHisID', '$newNumID', " . $item['ProID'] . "," . $item['quantity'] . ")";
        $msresults = mysqli_query($connectDB, $sql);
        if (!$msresults) {
            die('Invalid query: ' . mysqli_error($connectDB));
        }
    }

    $_SESSION['cart'] = array();
    $_SESSION['HisID'] = $newHisID;
}

header("Location: ./ShowConfirmOrder.php");
?>