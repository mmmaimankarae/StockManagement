<?php
require 'Insert_log.php';
session_start();
$msconnect = mysqli_connect("localhost", "root", "", "myStore");
$userName = $_POST['username'];
$password = $_POST['password'];
$msquery = "SELECT * FROM CUSTOMER_ACCOUNT WHERE UserName = '$userName' AND Password = '$password';";
$msresults = mysqli_query($msconnect, $msquery);
if ($row = mysqli_fetch_array($msresults)) {
    if ($userName == 'admin') {
        $_SESSION['userID'] = $row['CusID'];
        InsertLog($row['CusID'], "Admin login", "login.php");
        header("Location: ../admin/DashBoard.php");
    } else {
        $_SESSION['userID'] = $row['CusID'];
        $_SESSION['userType'] = "member";
        InsertLog($row['CusID'], "User Login: " . $userName . "", "login.php");
        header("Location: ./Store.php");
    }
} else {
    // include('./test.html');
    InsertLog(1, "User Login: " . $userName . " failed", "login.php");
    header('Location: ./loginTest.html');
}
mysqli_close($msconnect);