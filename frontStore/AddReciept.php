<?php
session_start();
require '../components/ConnectDB.php';

date_default_timezone_set('Asia/Bangkok');
$customerID = $_SESSION['CusID'];
$status = "Pending";
$period = date("Y-m-d H:i:s");

$id = $_SESSION['HisID'];
$sql = "SELECT * FROM `history` WHERE `HisID` = '$id'";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$customerID = $row['CusID'];
$period = $row['Period'];

$sql = "INSERT INTO `receive`(`RecID`, `Period`, `CusID`) VALUES ('$id','$period','$customerID') ";
$msresults = mysqli_query($connectDB, $sql);

if ($msresults) {
    $sql = "SELECT `NumID`, `ProID`, `Qty` FROM `history_order` WHERE `HisID` = '$id'";
    $result = mysqli_query($connectDB, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $proID = $row['ProID'];
        $qty = $row['Qty'];

        $sql = "SELECT MAX(`NumID`) AS `MaxNumID` FROM `receive_order`";
        $maxNumIDResult = mysqli_query($connectDB, $sql);
        $maxNumIDRow = mysqli_fetch_assoc($maxNumIDResult);
        $maxNumID = $maxNumIDRow['MaxNumID'];

        $numID = $maxNumID + 1;

        $sql = "INSERT INTO `receive_order`(`RecID`, `NumID`, `ProID`, `Qty`) VALUES ('$id', '$numID', '$proID', '$qty')";
        $msresults = mysqli_query($connectDB, $sql);
        if (!$msresults) {
            die('Invalid query: ' . mysqli_error($connectDB));
        }
    }
}

header("Location: ./ShowReceipt.php");
?>