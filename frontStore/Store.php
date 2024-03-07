<?php
session_start();
require '../components/ConnectDB.php';
require '../components/HeaderStore.html';
require 'Insert_log.php';

if (!isset($_SESSION['userType'])) {
    $_SESSION['userType'] = "guest";
    $_SESSION['userID'] = "1";
}

$userID = $_SESSION['userID'];

InsertLog($userID, 'Access store', 'Store.php');

$sql = "SELECT * FROM product;";
$result = mysqli_query($connectDB, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>SMITI Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootsxtrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sarabun&display=swap" rel="stylesheet">

    <style>
        /* .custom-card .card {
            width: 250px;
        } */

        .custom-card .card {
            width: px;
            height: 280px;
            /* margin: 10px; */
        }

        .custom-card .card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            width: 80%;
            height: 170px;
            object-fit: contain;
            padding: 20px;
            display: inline-block;
        }

        .card {
            text-align: center;
        }

        .custom-card {
            text-align: center;
        }
    </style>
</head>


<body style="padding-top: 80px">
    <!-- <center> -->
    <div class='row row-cols-1 row-cols-md-4 g-4' style="margin-left: 80px; margin-right: 80px;">
        <?php

        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $index = $row["ProID"];
                echo "<div class='col custom-card'>";
                echo "<div class='card h-100'>";
                echo '<a href="Product_Detail.php?id=' . $row["ProID"] . '" style="text-decoration: none; color: inherit;">';
                echo "<img src='" . $row["ImageSource"] . "' class='card-img-top' alt='Img Product'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title' style='font-family:sarabun'><b>ชื่อสินค้า: " . $row["ProName"] . "</b></h5>";
                echo "<p class='card-text' style='font-family:sarabun'>" . $row["Description"] . "</p>";
                echo "<h6 class='card-text' style='font-family:sarabun'>฿" . $row["PricePerUnit"] . "</h6>";
                echo "</div>";
                echo "<div class='card-footer'>";
                echo "<small class='text-body-secondary' style='font-family: sarabun;'><u>รายละเอียดสินค้า</u></small>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
    <!-- </center> -->
</body>

</html>

<?php
$connectDB->close();
?>