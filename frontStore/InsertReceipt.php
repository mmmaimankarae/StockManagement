<?php
session_start();
require '../components/ConnectDB.php';

date_default_timezone_set('Asia/Bangkok');

$userTaxID = $_SESSION['TaxID'];
$HisID = $_SESSION['HisID'];
$RecvID = $_POST['recvID'];
$CustID = $_SESSION['userID'];

$sql = "SELECT * FROM payer WHERE TaxID = '$userTaxID';";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_array($result);

$payDate = date("Y-m-d H:i:s");

$sql = "SELECT `RecID`, `NumID` FROM `receipt_list` ORDER BY `RecID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastRecID = $row['RecID'];
$lastNumID = $row['NumID'];

$number = (int) substr($lastRecID, 1);
$newNumber = $number + 1;

$newRecID = 'R' . $newNumber;

$newNumID = (int) $lastNumID + 1;

$sql = "INSERT INTO `receipt`(`RecID`, `PayTime`, `CusID`, `TaxID`, `RecvID`) VALUES ('$newRecID','$payDate','$CustID','$userTaxID','$RecvID');";
$msresults = mysqli_query($connectDB, $sql);

$sql = "SELECT * FROM `history_list` WHERE `HisID` = '$HisID'";
$result = mysqli_query($connectDB, $sql);

while ($row = mysqli_fetch_array($result)) {
    $ProID = $row['ProID']; 
    $Qty = $row['Qty']; 

    $sql = "INSERT INTO `receipt_list`(`RecID`, `NumID`, `ProID`, `Qty`) VALUES ('$newRecID','$newNumID','$ProID','$Qty')";
    $msresults = mysqli_query($connectDB, $sql);

    $newNumID++;
}

$_SESSION['ReceiptCode'] = $newRecID;
header("Location: ../frontStore/ShowReceipt.php?");
?>