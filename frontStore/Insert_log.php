<?php
require '../components/ConnectDB.php';

function InsertLog($userID, $insertType)
{
    global $connectDB;

    $sql = "SELECT `NumID` FROM `access_log` WHERE `CusID` = '$userID' ORDER BY `NumID` DESC LIMIT 1";
    $result = mysqli_query($connectDB, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $NumID = $row['NumID'];
        $NumID += 1;
    } else {
        $NumID = 1;
    }

    $sql = "INSERT INTO `access_log`(`CusID`, `NumID`, `Action`, `Period`) VALUES ('$userID','$NumID', '$insertType', NOW())";
    $result = mysqli_query($connectDB, $sql);

    return "Log inserted successfully";
}

if (isset($_POST['userID']) && isset($_POST['insertType'])) {
    echo InsertLog($_POST['userID'], $_POST['insertType']);

    echo "Log inserted successfully";
}
