<?php
require '../components/ConnectDB.php';

function InsertLog($userID, $insertType, $fileLocation)
{
    global $connectDB;

    $userIP = get_client_ip();

    if ($userIP == "::1") {
        $userIP = "127.0.0.1";
    }

    $sql = "SELECT `NumID` FROM `access_log` WHERE `CusID` = '$userID' ORDER BY `NumID` DESC LIMIT 1";
    $result = mysqli_query($connectDB, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $NumID = $row['NumID'];
        $NumID += 1;
    } else {
        $NumID = 1;
    }

    $sql = "INSERT INTO `access_log`(`CusID`, `NumID`, `Action`, `Period`, `IPaddr`, `File_location`) VALUES ('$userID','$NumID', '$insertType', NOW(), '$userIP', '$fileLocation')";
    $result = mysqli_query($connectDB, $sql);

    return "Log inserted successfully";
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

if (isset($_POST['userID']) && isset($_POST['insertType']) && isset($_POST['fileLocation'])) {
    echo InsertLog($_POST['userID'], $_POST['insertType'], $_POST['fileLocation']);

    echo "Log inserted successfully";
}
