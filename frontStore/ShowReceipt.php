<?php
session_start();
require '../components/ConnectDB.php';
require 'Insert_log.php';

$userID = $_SESSION['userID'];
$RecvID = $_SESSION['RecvID'];
$receiptCode = $_SESSION['ReceiptCode'];
$payerTaxID = $_SESSION['PayerTaxID'];

InsertLog($userID, "Show Receipt: " . $receiptCode, "ShowReceipt.php");

$sql = "SELECT r.RecID, r.PayTime, r.CusID, r.RecvID, p.PayerFName, p.PayerLName, p.Sex, p.Tel, p.Address
        FROM receipt r 
        JOIN payer p ON r.RecID = '$receiptCode' AND p.TaxID = '$payerTaxID'";

$result = mysqli_query($connectDB, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Receipt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sarabun&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: sarabun;
            ;
        }

        th,
        td {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .no-border {
            border-bottom: none !important;
        }

        .logo {
            float: left;
            width: 100px;
            height: auto;
        }

        .button-container {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $payerAddress = $row['Address'];
            $payerFName = $row['PayerFName'];
            $payerLName = $row['PayerLName'];
            $payerSex = $row['Sex'];
            $payerTel = $row['Tel'];

            $payTime = $row['PayTime'];
            $payDate = date('Y-m-d', strtotime($payTime));

            echo "<div style='margin: 15px;'>";

            echo "<div class='d-flex justify-content-between' style=''>";
            echo "<div class='d-flex flex-column flex-grow-1 me-3 justify-content-left' style=''>";
            echo "<img src='../pictures/logo.png' class='logo'>";
            echo "<h5 class='text-start'><b>บริษัท เอสมิติช้อป จำกัด(สำนักงานใหญ่)</b></h5>";
            echo "<h6 class='text-start'>999 หมู่ 999 ถ.ฉลองกรุง 9999 แขวงลาดกระบัง</h6>";
            echo "<h6 class='text-start'>เขตลาดกระบัง กรุงเทพมหานคร 10500</h6>";
            echo "<h6 class='text-start'>เลขประจำตัวผู้เสียภาษี 12345678909999</h6>";
            echo "<h6 class='text-start'>โทร. 0123456789 อีเมล smiti@test.com</h6>";
            echo "</div>";

            echo "<div class='d-flex flex-column flex-grow-1 ms-3 justify-content-center align-items-center' style=''>";
            echo "<h3 class='text-center recepDetail'><b>ใบเสร็จรับเงิน/ใบกำกับภาษี</b></h3>";
            echo "<h5 class='text-center recepDetail'>Receipt/Tax Invoice</h5>";
            echo "<h5 class='text-center recepDetail'><b>ต้นฉบับ</b></h5>";
            echo "</div>";
            echo "</div>";

            /* --------------------------------------------------------------------------------------------------- */

            echo "<div class='d-flex justify-content-between' style='margin-top: 15px'>";
            echo "<div class='d-flex flex-column flex-grow-1 me-3 justify-content-left' style=''>";
            echo "<h8 class='text-start'><b>ลูกค้า</b> " . $payerFName . " " . $payerLName . " </h8>";
            echo "<h8 class='text-start'><b>ที่อยู่</b> " . $payerAddress . "</h8>";
            echo "<h8 class='text-start'><b>เลขประจำตัวผู้เสียภาษี</b> 123456789123</h8>";
            echo "<h8 class='text-start'><b>โทร</b> " . $payerTel  . " <b>อีเมล </b> testuser@test.com </h8>";
            echo "</div>";

            echo "<div class='d-flex flex-column flex-grow-1 ms-3 ' >";
            echo "<h8 class='text-start' style='margin-left: 150px'><b>เลขที่</b> " . $receiptCode . "</h8>";
            echo "<h8 class='text-start' style='margin-left: 150px'><b>วันที่</b> " . $payDate . "</h8>";
            echo "</div>";
            echo "</div>";

            /* --------------------------------------------------------------------------------------------------- */

            echo "<div class='d-flex justify-content-center' style='margin-top: 15px;'>";
            echo "<table class='table table-bordered' style='width: 100%;'>";
            echo "<tr>";
            echo "<th style='width: 5%'>ลำดับ</th>";
            echo "<th style='width: 40%'>รายการสินค้า</th>";
            echo "<th style='width: 10%'>จำนวน</th>";
            echo "<th style='width: 15%'>ราคาต่อหน่วย</th>";
            echo "<th style='width: 15%'>จำนวนเงิน</th>";
            echo "</tr>";

            $sql = "SELECT r.NumID, r.ProID, r.Qty, p.ProName, p.PricePerUnit 
                    FROM receipt_list r 
                    JOIN product p ON r.ProID = p.ProID 
                    WHERE r.RecID = '$receiptCode'";
            $result = mysqli_query($connectDB, $sql);

            $totalPrice = 0;
            $i = 1;

            while ($orderProductRow = mysqli_fetch_array($result)) {
                $productTotalPrice = $orderProductRow['PricePerUnit'] * $orderProductRow['Qty'];
                $productTotalPrice = number_format($productTotalPrice, 2);

                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $orderProductRow['ProName'] . "</td>";
                echo "<td>" . $orderProductRow['Qty'] . "</td>";
                echo "<td>฿" . $orderProductRow['PricePerUnit'] . "</td>";
                echo "<td>" . $productTotalPrice . " บาท</td>";
                $totalPrice += $orderProductRow['PricePerUnit'] * $orderProductRow['Qty'];
                echo "</tr>";
                $i++;
            }

            echo "</table>";
            echo "</div>";

            /* --------------------------------------------------------------------------------------------------- */

            $vat = $totalPrice * 0.07;
            $totalPriceFormat = number_format($totalPrice, 2);

            echo "<div class='d-flex justify-content-between' style='margin-top: 15px'>";
            echo "<div class='d-flex flex-column flex-grow-1 me-3' style=''>";
            echo "<h8 class='text-start' style='justify-content: left;'><b>หมายเหตุ</b> </h8>";
            echo "<h8 class='text-start' style='justify-content: flex-end; margin-top: 130px;'><b>ผู้รับเงิน บริษัท เอสมิติช้อป จำกัด(สำนักงานใหญ่)</b> </h8>";
            echo "</div>";

            echo "<div class='d-flex flex-column flex-grow-1 ms-3 ' >";
            echo "<table class='table table-borderless'>";
            echo "<tr><td><b>ส่วนลด</b></td><td>0</td><td> บาท</td></tr>";
            echo "<tr><td><b>รวมเป็นเงิน</b></td><td>" . $totalPriceFormat . "</td><td> บาท</td></tr>";

            $vatFormat = number_format($vat, 2);

            echo "<tr><td><b>ภาษีมูลค่าเพิ่ม 7%</b></td><td>" . $vatFormat . "</td><td> บาท</td></tr>";

            $totalPrice += $vat;
            $totalPriceFormat = number_format($totalPrice, 2);
            echo "<tr><td><b>จำนวนเงินทั้งสิ้น</b></td><td>" . $totalPriceFormat . "</td><td> บาท</td></tr>";
            echo "</table>";
            echo "</div>";
            echo "</div>";

            echo "</div>";
            echo "</div>";
        }

        echo "<div class='d-flex justify-content-center' style='margin-top: 15px;'>";
        echo "<a href='Store.php' class='btn btn-danger' style='font-family:sarabun; margin-right: 10px; font-size:20px;'><b>🧺 กลับไปหน้าร้านค้า</b></a>";
        echo "<a href='ExportToPDF.php' target='_blank' class='btn btn-primary' style='font-family:sarabun; margin-left: 10px; font-size:20px;'><i class='fas fa-file-pdf'></i> <b>PDF FILE</b></a>";        // echo "<button class='btn btn-success me-5' type='button' onclick='insertLog()'><i class='fas fa-file-pdf'></i> <b>PDF FILE</b></button>";
        echo "</div>";
        ?>
        <br>
    </div>

    <!-- <script>
        function insertLog() {
            // Call Insert Log function using AJAX
            $.ajax({
                type: "POST",
                url: "Insert_log.php", // URL of the PHP file that will insert the log
                data: {
                    userID: '<?php //echo $userID; ?>',
                    insertType: 'Export to PDF Receipt: <?php //echo $receiptCode; ?>',
                    fileLocation: 'ShowReceipt.php'
                },
                success: function(data) {
                    console.log(data);
                    window.location.href = "OrderSummary.php";
                }
            });
        }
    </script> -->

</body>

</html>

<?php
mysqli_close($connectDB);
?>