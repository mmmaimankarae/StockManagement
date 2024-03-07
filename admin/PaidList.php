<?php
session_start();
require '../admin/back/dbSumOrder.php';
?>
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

<body style="margin-top: 7%">
  <?php include "../components/HeaderAdmin.html"; ?>
  <h4 class="text-center"> -- รายการสั่งซื้อ --</h4>
  <form method="post" action="../admin/back/dbSelectOrder.php">
    <div class="container my-4">
      <div class="row row-cols-2 row-cols-lg-6 g-2 g-lg-3">
        <div class="col text-center">
          <div class="card shadow shadow-sm" id="allOrder" style="width: 11.5rem; height: 6.5rem">
            <!-- <button type="submit" style="width: 100%; height: 100%; padding: 0; border: none; background: none;"> -->
            <a href="OrderList.php" style="text-decoration: none; color: black;">
              <div class="card-body">
                <img src="../pictures/admin/product.png" width="40">
                <span style="font-size: 150%; margin-left: 5%; display: inline-block; vertical-align: middle;"><?php echo $_SESSION['Qty'] ?></span>
                <p class="my-3" style="font-size: 89%;">รายการทั้งหมด</p>
              </div>
            </a>
            <!-- </button> -->
          </div>
        </div>

        <div class="col text-center">
          <div class="card shadow shadow-sm" id="pending" style="width: 11.5rem; height: 6.5rem">
            <!-- <button type="submit" style="width: 100%; height: 100%; padding: 0; border: none; background: none;"> -->
            <a href="PendingList.php" style="text-decoration: none; color: black;">
              <div class="card-body">
                <img src="../pictures/admin/salary.png" width="40">
                <span style="font-size: 150%; margin-left: 5%; display: inline-block; vertical-align: middle;"><?php echo $_SESSION['Pending'] ?></span>
                <p class="my-3" style="font-size: 89%;">ชำระเงินแล้ว รอตรวจสอบ</p>
              </div>
              <!-- </button> -->
          </div>
          </a>
        </div>

        <div class="col text-center">
          <div class="card shadow shadow-sm" id="paid" style="width: 11.5rem; height: 6.5rem">
            <!-- <button type="submit" style="width: 100%; height: 100%; padding: 0; border: none; background: none;"> -->
            <div class="card-body">
              <img src="../pictures/admin/express-delivery.png" width="40">
              <span style="font-size: 150%; margin-left: 5%; display: inline-block; vertical-align: middle;"><?php echo $_SESSION['Paid'] ?></span>
              <p class="my-3" style="font-size: 89%;">รอจัดส่ง</p>
            </div>
            <!-- </button> -->
          </div>
        </div>

        <div class="col text-center">
          <div class="card shadow shadow-sm" id="cod" style="width: 11.5rem; height: 6.5rem">
            <!-- <button type="submit" style="width: 100%; height: 100%; padding: 0; border: none; background: none;"> -->
            <a href="CODList.php" style="text-decoration: none; color: black;">
              <div class="card-body">
                <img src="../pictures/admin/search.png" width="40">
                <span style="font-size: 150%; margin-left: 5%; display: inline-block; vertical-align: middle;"><?php echo $_SESSION['COD'] ?></span>
                <p class="my-3" style="font-size: 89%;">เก็บเงินปลายทาง รอจัดส่ง</p>
              </div>
              <!-- </button> -->
            </a>
          </div>
        </div>

        <div class="col text-center">
          <div class="card shadow shadow-sm" id="delivered" style="width: 11.5rem; height: 6.5rem">
            <!-- <button type="submit" style="width: 100%; height: 100%; padding: 0; border: none; background: none;"> -->
            <a href="DeliveredList.php" style="text-decoration: none; color: black;">
              <div class="card-body">
                <img src="../pictures/admin/truck.png" width="40">
                <span style="font-size: 150%; margin-left: 5%; display: inline-block; vertical-align: middle;"><?php echo $_SESSION['Delivered'] ?></span>
                <p class="my-3" style="font-size: 89%;">จัดส่งแล้ว</p>
              </div>
              <!-- </button> -->
            </a>
          </div>
        </div>

        <div class="col text-center">
          <div class="card shadow shadow-sm" id="cancel" style="width: 11.5rem; height: 6.5rem">
            <!-- <button type="submit" style="width: 100%; height: 100%; padding: 0; border: none; background: none;"> -->
            <a href="CancelList.php" style="text-decoration: none; color: black;">
              <div class="card-body">
                <img src="../pictures/admin/cancelled.png" width="40">
                <span style="font-size: 150%; margin-left: 5%; display: inline-block; vertical-align: middle;"><?php echo $_SESSION['Cancel'] ?></span>
                <p class="my-3" style="font-size: 89%;">ยกเลิกคำสั่งซื้อ</p>
              </div>
              <!-- </button> -->
            </a>
          </div>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col" style="margin-left: 5%">
        <label>ค้นหา</label>
        <input type="text" id="detail" name="detail" class="form-control mx-2 my-1" placeholder="เลขที่ใบสั่งซื้อ, ชื่อลูกค้า, หมายเลขโทรศัพท์">
      </div>

      <div class='col'>
        <label for="from">ช่วงวันที่</label>
        <?php include "../components/DatePickerRange.html"; ?>
        <input type="hidden" id="startDate" name="startDate">
        <input type="hidden" id="status" name="status">
        <input type="hidden" id="endDate" name="endDate">
      </div>

      <div class='col' style="margin-top: 2%">
        <button type="submit" class="btn btn-success" onclick="searchOrders()"><i class='fa-solid fa-magnifying-glass'></i> ค้นหา</button>
      </div>
    </div>

    <input type="hidden" id="manage" name="manage" vale="manage">
  </form>
  <?php include "ShowPaidList.php" ?>
</body>

<script>
  $(document).ready(function() {
    /* กำหนดตัวเริ่มต้นให้ allOrder */
    $("#paid").addClass("active");

    /* เก็บ id ของตัวที่ถูกคลิก */
    var activeCardId = "allOrder";
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
        case "allOrder":
          break;
        case "pending":
          status = "Pending";
          break;
        case "paid":
          status = "Paid";
          break;
        case "cod":
          status = "COD";
          break;
        case "delivered":
          status = "Delivered";
          break;
        case "cancel":
          status = "Cancel";
          break;
      }
      /* set ค่า status เพื่อส่งไปพร้อม form */
      $("#status").val(status);
    });
  });

  function searchOrders() {
    var fromDate = $("#from").val();
    var toDate = $("#to").val();
    var currentDate = new Date();
    var endDate = currentDate.toLocaleDateString('en-GB');
    $("#startDate").val(fromDate);
    if (toDate == "" && fromDate != "") $("#endDate").val(endDate);
    else $("#endDate").val(toDate);
  }
</script>

</html>