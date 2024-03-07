<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.3/dist/xlsx.full.min.js"></script>
    <title>รายการสั่งซื้อ</title>
    <style>
        .card.active {
            background-color: #45474B;
            color: #fff;
        }

        .card.active img {
            filter: brightness(0) invert(1);
        }
    </style>
</head>

<?php
require '../components/connectDB.php';
$CusID = $_POST['customerID'];
$sql = "SELECT CusID, CusFName, CusLName FROM customer WHERE CusID = '$CusID'";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);

?>

<body style="margin-top: 7%">
    <?php include "../components/HeaderAdmin.html"; ?>
    <h4 class="text-center"><?php echo " LOG ID : {$row['CusID']} Name: {$row['CusFName']} {$row['CusLName']}" ?></h4>
    <form method="post" action="../admin/back/dbShowProduct.php">
        <div class="container my-4">
            <div class="row">
                <div class="col text-center">
                    <div class="card shadow shadow-sm mx-auto" id="member" style="width: 11.5rem; height: 6.5rem">
                    <a href="User.php" style="text-decoration: none; color: black;">
                        <div class="card-body">
                            <img src="../pictures/admin/member-card.png" width="40">
                            <span style="font-size: 150%; display: inline-block; vertical-align: middle;"></span>
                            <p class="my-3">สมาชิก</p>
                        </div>
                    </a>
                    </div>
                </div>

                <div class="col text-center">
                    <div class="card shadow shadow-sm mx-auto" id="customer" style="width: 11.5rem; height: 6.5rem">
                        <div class="card-body">
                            <img src="../pictures/admin/new-account.png" width="40">
                            <span style="font-size: 150%; display: inline-block; vertical-align: middle;"></span>
                            <p class="my-3">ลูกค้าทั่วไป</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col" style="margin-left: 5%;">
                <label>ค้นหา</label>
                <input type="text" id="detail" name="detail" class="form-control mx-2 my-1" placeholder="ชื่อสมาชิก, เบอร์โทรศัพท์">
                <input type="hidden" id="status" name="status">
            </div>

            <div class='col' style="margin-top: 2%">
                <button type="submit" class="btn btn-success" onclick="searchOrders()"><i class='fa-solid fa-magnifying-glass'></i> ค้นหา</button>
            </div>
        </div>

        <input type="hidden" id="manage" name="manage" vale="manage">
    </form>

    <div class="container my-4">
        <!-- <button class='btn btn-primary btn-sm float-start' style="margin-bottom: 2%;" onclick="window.location.href='AddProduct.php'">+ สมาชิก</button> -->
        <button id='export' class='btn btn-secondary btn-sm float-end' style="margin-bottom: 2%">ส่งออกเป็น Excel</button>
        <?php
        /* ดึงข้อมูล DB */
        //   var_dump( $_POST['customerID']);
        /* กำหนดคำสั่ง SQL */
        $msquery = "SELECT * FROM access_log
                      WHERE CusID = '$CusID';";
        $msresults = mysqli_query($connectDB, $msquery);
        ?>
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th class='text-center'><input type="checkbox" id="selectAllCheckbox"></th>
                    <th class='text-center'>ลำดับ</th>
                    <th class='text-center'>Action</th>
                    <th class='text-center'>ระยะเวลา</th>
                    <th class='text-center'>IPAddress</th>
                    <th class='text-center'>File_Location</th>
                </tr>
            </thead>

            <tbody>
                <?php

                while ($row = mysqli_fetch_assoc($msresults)) {
                    echo "<tr style='font-size: 90%'>";
                    echo "<td class='text-center'><input type='checkbox' class='selectCheckbox'></td>";
                    echo "<td class='text-center'>{$row['NumID']}</td>";
                    echo "<td class='text-center'>{$row['Action']}</td>";
                    echo "<td class='text-center'>{$row['Period']}</td>";
                    echo "<td class='text-center'>{$row['IPaddr']}</td>";
                    echo "<td class='text-center'>{$row['File_location']}</td>";

                    //   echo "<td class='text-center'>";
                    //     echo "<form method='post' action='UpdateProduct.php'>";
                    //       echo "<input type='hidden' name='ProID' value='{$row['CusID']}'>";
                    //       echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/pen.png' width='30'></button>";
                    //     echo "</form>";
                    //   echo "</td>";

                    //   echo "<td class='text-center'>";
                    //     echo "<form method='post' action='showLogList.php'>";
                    //       echo "<input type='hidden' name='ProID' value='{$row['CusID']}'>";
                    //       echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/search-normal.png' width='30'></button>";
                    //     echo "</form>";
                    //   echo "</td>";

                    //   echo "<td class='text-center'>";
                    //   echo "<form method='get' action='../frontStore/Product_Detail.php'>";
                    //     echo "<input type='hidden' name='id' value='{$row['CusID']}'>";
                    //     echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/trash.png' width='30'></button>";
                    //   echo "</form>";
                    //   echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            /* กำหนดตัวเริ่มต้นให้ allOrder */
            $("#x").addClass("active");

            /* เก็บ id ของตัวที่ถูกคลิก */
            var activeCardId = "member";
            $(".card").click(function() {
                /* ลบ active ของตัวเก่า */
                $(".card").removeClass("active");
                /* เพิ่ม active ให้ id ตัวใหม่ */
                $(this).addClass("active");
                /* เก็บค่า id ตัวใหม่ */
                activeCardId = $(this).attr("id");

                /* กำหนดค่า status */
                var status;
                switch (activeCardId) {
                    case "customer":
                        status = "Active";
                        break;
                    case "outStock":
                        status = "OutStock";
                        break;
                    case "inactive":
                        status = "Inactive";
                        break;
                    case "pending":
                        status = "Pending";
                        break;
                }
                /* set ค่า status เพื่อส่งไปพร้อม form */
                $("#status").val(status);
            });
        });

        $(document).ready(function() {
            /* ถ้ากด id selectAllCheckbox */
            $('#selectAllCheckbox').change(function() {
                $('.selectCheckbox').prop('checked', $(this).prop('checked'));
            });

            $('.selectCheckbox').change(function() {
                if ($('.selectCheckbox:checked').length == $('.selectCheckbox').length) {
                    $('#selectAllCheckbox').prop('checked', true);
                } else {
                    $('#selectAllCheckbox').prop('checked', false);
                }
            });

            /* export Report */
            $('#export').click(function() {
                var csvContent = "\uFEFFเลขที่ใบเสร็จ,วันที่สั่งซื้อ,ชื่อผู้สั่ง,ราคาทั้งหมด,การชำระเงิน,สถานะ\n";
                $('#dataTable tbody tr').each(function() {
                    var rowData = $(this).find('th,td:not([^id="remove"])').map(function() {
                        return $(this).text();
                    }).get().join(",");
                    csvContent += rowData + "\n";
                });
                var blob = new Blob([csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });
                saveAs(blob, 'log_data.csv');
            });
        });
    </script>
</body>

</html>