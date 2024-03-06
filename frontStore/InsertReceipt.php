<?php
session_start();
require '../components/ConnectDB.php';

date_default_timezone_set('Asia/Bangkok');

$RecvID = $_POST['recvID'];

$payerTaxID = $_SESSION['PayerTaxID'];
$HisID = $_SESSION['HisID'];
$CustID = $_SESSION['userID'];
$paymethod = $_SESSION['paymentMethod'];
$Status = "COD";

$sql = "SELECT * FROM payer WHERE TaxID = '$payerTaxID';";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_array($result);

$payDate = date("Y-m-d H:i:s");

$sql = "SELECT `RecID`, `NumID` FROM `receipt_list` ORDER BY CAST(SUBSTRING(`RecID`, 2) AS UNSIGNED) DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$lastRecID = $row['RecID'];

$number = (int) substr($lastRecID, 1);
$newNumber = $number + 1;

$newRecID = 'R' . $newNumber;

$sql = "INSERT INTO `receipt`(`RecID`, `PayTime`, `CusID`, `TaxID`, `RecvID`, `Status`, `Channel`) VALUES ('$newRecID','$payDate','$CustID','$payerTaxID','$RecvID', '$Status', '$paymethod');";
$msresults = mysqli_query($connectDB, $sql);

$sql = "SELECT * FROM `history_list` WHERE `HisID` = '$HisID'";
$result = mysqli_query($connectDB, $sql);
$newNumID = 1;
while ($row = mysqli_fetch_array($result)) {
    $ProID = $row['ProID']; 
    $Qty = $row['Qty']; 

    $sql = "INSERT INTO `receipt_list`(`RecID`, `NumID`, `ProID`, `Qty`) VALUES ('$newRecID','$newNumID','$ProID','$Qty')";
    $msresults = mysqli_query($connectDB, $sql);

    $newNumID++;
}

$_SESSION['ReceiptCode'] = $newRecID;
header("Location: ./ShowReceipt.php");
?>