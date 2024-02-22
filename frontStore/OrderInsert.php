<?php
session_start();
require '../components/ConnectDB.php';

date_default_timezone_set('Asia/Bangkok');

$customerID = $_SESSION['userID'];
$status = "Pending";
$updateTime = date("Y-m-d H:i:s");

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$telNumber = $_POST['telNumber'];
$gender = $_POST['gender'];
$receiverAddr = $_POST['recieverAddress'];

// ดึง HisID ล่าสุด
$sql = "SELECT `HisID` FROM `history` ORDER BY `HisID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastHisID = $row['HisID'];

$number = (int) substr($lastHisID, 1);
$newNumber = $number + 1;

// สร้าง HisID ใหม่
$newHisID = 'H' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

// ดึง NumID ล่าสุด
$sql = "SELECT `NumID` FROM `history_list` ORDER BY `NumID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastNumID = $row['NumID'];

// สร้าง NumID ใหม่
$newNumID = (int) $lastNumID + 1;

$sql = "INSERT INTO `history`(`HisID`, `UpdateTime`, `CusID`, `Status`) VALUES ('$newHisID','$updateTime','$customerID','$status') ";
$msresults = mysqli_query($connectDB, $sql);

if ($msresults) {
    foreach ($_SESSION['cart'] as $item) {
        $sql = "INSERT INTO `history_list`(`HisID`, `NumID`, `ProID`, `Qty`) VALUES ('$newHisID', '$newNumID', " . $item['ProID'] . "," . $item['quantity'] . ")";
        $newNumID++;
        $msresults = mysqli_query($connectDB, $sql);
        if (!$msresults) {
            die('Invalid query: ' . mysqli_error($connectDB));
        }
    }

}

// สร้าง Payer ใหม่
$sql = "SELECT `taxid` FROM `payer` ORDER BY `taxid` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastTaxID = $row['taxid'];

$number = (int) substr($lastTaxID, 1);
$newNumber = $number + 1;

$newTaxID = 'T' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
$sql = "INSERT INTO `payer`(`TaxID`, `PayerFName`, `PayerLName`, `Sex`, `Tel`) VALUES ('$newTaxID','$firstName','$lastName','$gender','$telNumber');";
$results = mysqli_query($connectDB, $sql);

// สร้าง Payer-list ใหม่
$sql = "SELECT `NumID` FROM `payer_list` ORDER BY `NumID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastNumID = $row['NumID'];

$number = (int) $lastNumID;
$newPayerListNumID = (int) $lastNumID + 1;

$sql = "INSERT INTO `payer_list`(`CusID`, `NumID`, `TaxID`) VALUES ('$customerID','$newPayerListNumID','$newTaxID')";
$msresults = mysqli_query($connectDB, $sql);

// สร้าง Receiver ใหม่
$sql = "INSERT INTO `receiver`(`RecvID`, `RecvFName`, `RecvLName`, `Sex`, `Tel`, `Address`) VALUES ('','$firstName','$lastName','$gender','$telNumber','$receiverAddr')";
$results = mysqli_query($connectDB, $sql);

$sql = "SELECT `RecvID` FROM `receiver` ORDER BY `RecvID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastRecvID = $row['RecvID'];

// สร้าง Receiver-list ใหม่
$sql = "SELECT `NumID` FROM `receiver_list` ORDER BY `NumID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastNumID = $row['NumID'];

$number = (int) $lastNumID;
$newRecvNumID = (int) $lastNumID + 1;

$sql = "INSERT INTO `receiver_list`(`CusID`, `RecvID`, `NumID`) VALUES ('$customerID','$lastRecvID','$newRecvNumID')";
$msresults = mysqli_query($connectDB, $sql);

$_SESSION['RecvID'] = $lastRecvID;
$_SESSION['HisID'] = $newHisID;
$_SESSION['Fname'] = $firstName;
$_SESSION['Lname'] = $lastName;
$_SESSION['TaxID'] = $newTaxID;
$_SESSION['cart'] = array();


header("Location: ./ShowConfirmOrder.php");
