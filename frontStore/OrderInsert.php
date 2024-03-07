<?php
session_start();
require '../components/ConnectDB.php';
require 'Insert_log.php';

date_default_timezone_set('Asia/Bangkok');

$customerID = $_SESSION['userID'];
$status = "Ordered";
$updateTime = date("Y-m-d H:i:s");
$payment_Method = $_POST['paymentMethod'];
/*--------------------------------------- ข้อมูลผู้จ่าย ---------------------------------------*/

$payerFirstName = $_POST['payerFname'];
$payerLastName = $_POST['payerLname'];
$payerTelNumber = $_POST['payerTelNumber'];
$payerGender = $_POST['payerGender'];
$payerTaxID = $_POST['payer_TaxID'];
$payerAddr = $_POST['payerAddress'];

/*--------------------------------------- ข้อมูลผู้รับ ---------------------------------------*/

$receiverFirstName = $_POST['receiverFname'];
$receiverLastName = $_POST['receiverLname'];
$receiverTelNumber = $_POST['receiverTelNumber'];
$receiverGender = $_POST['receiverGender'];
$receiverAddr = $_POST['receiverAddress'];

/*--------------------------------------- Insert HISTORY ---------------------------------------*/

// ดึง HisID ล่าสุด
$sql = "SELECT `HisID` FROM `history` ORDER BY CAST(SUBSTRING(`HisID`, 2) AS UNSIGNED) DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastHisID = $row['HisID'];

// หา HisID ล่าสุด
$number = (int) substr($lastHisID, 1);
$newNumber = $number + 1;

// สร้าง HisID ใหม่
$newHisID = 'H' . $newNumber;

//Insert ข้อมูลลงตาราง History
$sql = "INSERT INTO `history`(`HisID`, `UpdateTime`, `CusID`, `Status`) VALUES ('$newHisID','$updateTime','$customerID','$status') ";
$msresults = mysqli_query($connectDB, $sql);

//Insert ข้อมูลลงตาราง History_list
if ($msresults) {
    $numID = 1;
    foreach ($_SESSION['cart'] as $item) {
        $sql = "INSERT INTO `history_list`(`HisID`, `NumID`, `ProID`, `Qty`) VALUES ('$newHisID', '$numID', " . $item['ProID'] . "," . $item['quantity'] . ")";
        $numID++;
        $msresults = mysqli_query($connectDB, $sql);
        if (!$msresults) {
            die('Invalid query: ' . mysqli_error($connectDB));
        }
    }
}

/*--------------------------------------- Insert Payer ---------------------------------------*/

// Insert ข้อมูลลงตาราง Payer
$sql = "INSERT INTO `payer`(`TaxID`, `PayerFName`, `PayerLName`, `Sex`, `Tel`, `Address`) VALUES ('$payerTaxID','$payerFirstName','$payerLastName','$payerGender','$payerTelNumber', '$payerAddr');";
$results = mysqli_query($connectDB, $sql);

// สร้าง Payer-list ใหม่
$sql = "SELECT `NumID` FROM `payer_list` WHERE `CusID` = '$customerID' ORDER BY `NumID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $lastNumID = $row['NumID'];
    $number = (int) $lastNumID;
    $newPayerListNumID = (int) $lastNumID + 1;
} else {
    $newPayerListNumID = 1;
}

// Insert ข้อมูลลงตาราง Payer-list
$sql = "INSERT INTO `payer_list`(`CusID`, `NumID`, `TaxID`) VALUES ('$customerID','$newPayerListNumID','$payerTaxID')";
$msresults = mysqli_query($connectDB, $sql);

/*--------------------------------------- Insert Receiver ---------------------------------------*/

// Insert ข้อมูลลงตาราง Receiver
$sql = "INSERT INTO `receiver`(`RecvID`, `RecvFName`, `RecvLName`, `Sex`, `Tel`, `Address`) VALUES ('','$receiverFirstName','$receiverLastName','$receiverGender','$receiverTelNumber','$receiverAddr')";
$results = mysqli_query($connectDB, $sql);

// ดึง RecvID ล่าสุด
$sql = "SELECT `RecvID` FROM `receiver` ORDER BY `RecvID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastRecvID = $row['RecvID'];

// สร้าง Receiver-list ใหม่
$sql = "SELECT `NumID` FROM `receiver_list` WHERE `CusID` = '$customerID' ORDER BY `NumID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $lastNumID = $row['NumID'];
    $number = (int) $lastNumID;
    $newRecvNumID = (int) $lastNumID + 1;
} else {
    $newRecvNumID = 1;
}

// Insert ข้อมูลลงตาราง Receiver-list
$sql = "INSERT INTO `receiver_list`(`CusID`, `NumID`, `RecvID`) VALUES ('$customerID','$newRecvNumID','$lastRecvID')";
$msresults = mysqli_query($connectDB, $sql);

/*--------------------------------------- Send Session ---------------------------------------*/

$_SESSION['RecvID'] = $lastRecvID;
$_SESSION['HisID'] = $newHisID;
$_SESSION['PayerTaxID'] = $payerTaxID;
$_SESSION['paymentMethod'] = $payment_Method;
$_SESSION['cart'] = array();

InsertLog($customerID, "Order(HIS, PAYER, RECEIVER) Insert: " . $newHisID, "OrderInsert.php");

header("Location: ./ShowConfirmOrder.php");
