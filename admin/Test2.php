<?php
  session_start();
  $_SESSION['Status'] = "Active";
  require '../admin/back/dbAllProduct.php';
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
  <h4 class="text-center"> -- รายการสินค้า --</h4>
  <form method="post" action="../admin/back/dbAllProduct.php">
  <div class="container my-4">
    <div class="row row-cols-2 row-cols-lg-4 g-2 g-lg-3">
      <div class="col text-center">
        <div class="card shadow shadow-sm" id="activeProduct" style="width: 11.5rem; height: 6.5rem">
          <div class="card-body">
            <img src="../pictures/admin/buy.png" width="40">
            <span style="font-size: 150%; margin-left: 5%; display: inline-block; vertical-align: middle;"><?php echo $_SESSION['Active']?></span>
            <p class="my-3">สินค้าที่กำลังขายอยู่</p>
          </div>
        </div>
      </div>

      <div class="col text-center">
        <div class="card shadow shadow-sm" id="outStock" style="width: 11.5rem; height: 6.5rem">
          <div class="card-body">
            <img src="../pictures/admin/sold-out.png" width="40">
            <span style="font-size: 150%; margin-left: 5%; display: inline-block; vertical-align: middle;"><?php echo $_SESSION['OutStock']?></span>
            <p class="my-3">คลังสินค้าหมด</p>
          </div>
        </div>
      </div>

      <div class="col text-center">
        <div class="card shadow shadow-sm" id="pending" style="width: 11.5rem; height: 6.5rem">
          <div class="card-body">
            <img src="../pictures/admin/pending-box.png" width="40">
            <span style="font-size: 150%; margin-left: 5%; display: inline-block; vertical-align: middle;"><?php echo $_SESSION['PendingProduct']?></span>
            <p class="my-3">สินค้ารอลงขาย</p>
          </div>
        </div>
      </div>

      <div class="col text-center">
        <div class="card shadow shadow-sm" id="inactive" style="width: 11.5rem; height: 6.5rem">
          <div class="card-body">
            <img src="../pictures/admin/cancelled.png" width="40">
            <span style="font-size: 150%; margin-left: 5%; display: inline-block; vertical-align: middle;"><?php echo $_SESSION['Inactive']?></span>
            <p class="my-3">ยกเลิกการขาย</p>
          </div>
        </div>
      </div>

    </div>
  </div>

    <div class="row">
      <div class="col" style="margin-left: 5%;">
        <label>ค้นหา</label>
        <input type="text" id="detail" name="detail" class="form-control mx-2 my-1" placeholder="รหัสสินค้า, ชื่อสินค้า">
        <input type="hidden" id="status" name="status">
      </div>

      <div class='col' style="margin-top: 2%">
        <button type="submit" class="btn btn-success" onclick="searchOrders()"><i class='fa-solid fa-magnifying-glass'></i> ค้นหา</button>
      </div>
    </div>

    <input type="hidden" id="manage" name="manage" vale="manage">
  </form>
</body>

<script>
  $(document).ready(function () {
    /* กำหนดตัวเริ่มต้นให้ allOrder */
    $("#activeProduct").addClass("active");

    /* เก็บ id ของตัวที่ถูกคลิก */
    var activeCardId = "activeProduct";
    $(".card").click(function () {
      /* ลบ active ของตัวเก่า */
      $(".card").removeClass("active");
      /* เพิ่ม active ให้ id ตัวใหม่ */
      $(this).addClass("active");
      /* เก็บค่า id ตัวใหม่ */
      activeCardId = $(this).attr("id");

      /* กำหนดค่า status */
      var status;
      switch (activeCardId) {
        case "activeProduct":
          $_SESSION['Status'] = "Active";
          break;
        case "outStock":
          $_SESSION['Status'] = "OutStock";
          break;
        case "inactive":
          $_SESSION['Status'] = "Inactive";
          break;
        case "pending":
          $_SESSION['Status'] = "Pending";
          break;
      }
      /* set ค่า status เพื่อส่งไปพร้อม form */
      $("#status").val(status);
    });
  });
</script>
</html>

<?php
  session_start();
  $msquery = "SELECT ImageSource, ProID, ProName, PricePerUnit, CostPerUnit
              FROM PRODUCT 
              WHERE Status = '" . $_SESSION['Status'] . "' 
              ORDER BY ProID;";
  echo $msquery;
?>