<?php
  require '../components/connectDB.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <title>Document</title>
</head>

<body style="margin-top: 7%">
  <?php include "../components/HeaderAdmin.html"; ?>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4">

      <!-- querry -->
      <?php
        $msquery = "SELECT COUNT(*) AS TotalActiveProducts FROM PRODUCT WHERE Status = 'Active';";
        $msresults = mysqli_query($connectDB, $msquery);
        if ($row = mysqli_fetch_assoc($msresults)) {
          $allPD = $row['TotalActiveProducts'];
        }
      ?>
      <!-- show -->
        <div class="card shadow shadow-sm">
          <div class="card-header text-center" style="background-color: #C68484; color: white;">
          <img src="../pictures/admin/boxes.png" width="30">
            <strong><u> สินค้า</u></strong>
          <img src="../pictures/admin/boxes.png" width="30">
          </div>
          <div class="card-body" style="min-height: 200px;">
            <p class="text-center">ขายสินค้าอยู่ <?php echo $allPD;?> แบบ</p>
            <?php
              $msquery = "SELECT PRODUCT.ImageSource, PRODUCT.ProName, SUM(RECEIPT_LIST.Qty) AS TotalSoldQuantity
                          FROM RECEIPT_LIST
                          INNER JOIN PRODUCT ON RECEIPT_LIST.ProID = PRODUCT.ProID
                          GROUP BY PRODUCT.ProID, PRODUCT.ProName
                          ORDER BY TotalSoldQuantity DESC;";
              $msresults = mysqli_query($connectDB, $msquery);
              while ($row = mysqli_fetch_assoc($msresults)) {
                echo "<p class='my-3'><img src='{$row['ImageSource']}' width='30'>";
                $proName = $row['ProName'];
                $totalSoldQuantity = $row['TotalSoldQuantity'];
                echo " - $proName: $totalSoldQuantity ชิ้น</p>";
              }
            ?>
          </div>
        </div>
      </div>

      <!-- querry -->
      <?php
        $msquery = "SELECT SUM(CASE WHEN RECEIPT.Status IN ('Paid', 'COD', 'Delivered', 'DI', 'Completed') 
                            THEN PRODUCT.PricePerUnit * RECEIPT_LIST.Qty ELSE 0 END) AS TotalSales,
                           SUM(CASE WHEN RECEIPT.Status IN ('Paid', 'Delivered', 'Completed') AND RECEIPT.Channel = 'Transfer' 
                            THEN PRODUCT.PricePerUnit * RECEIPT_LIST.Qty ELSE 0 END) AS Transfer,
                           SUM(CASE WHEN RECEIPT.Status IN ('COD', 'Delivered', 'DI', 'Completed') AND RECEIPT.Channel = 'COD' 
                            THEN PRODUCT.PricePerUnit * RECEIPT_LIST.Qty ELSE 0 END) AS COD
                    FROM RECEIPT
                    JOIN RECEIPT_LIST ON RECEIPT.RecID = RECEIPT_LIST.RecID
                    JOIN PRODUCT ON RECEIPT_LIST.ProID = PRODUCT.ProID;";
        $msresults = mysqli_query($connectDB, $msquery);
      ?>
      <!-- show -->
      <div class="col-lg-4">
        <div class="card shadow shadow-sm">
          <div class="card-header text-center" style="background-color: #11235A; color: white;">
            <img src="../pictures/admin/transfer.png" width="30">
              <strong><u> ยอดขาย</u></strong>
            <img src="../pictures/admin/transfer.png" width="30">
          </div>
          <div class="card-body" style="min-height: 200px;">
          <?php
            while ($row = mysqli_fetch_assoc($msresults)) {
              if ($row['TotalSales']) {
                echo "<p class='my-3'><img src='../pictures/admin/salary.png' width='30'>";
                echo " - ยอดขายทั้งหมด: {$row['TotalSales']} บาท</p>";
              } 
              if ($row['Transfer']) {
                echo "<p class='my-3'><img src='../pictures/admin/transfer.png' width='30'>";
                echo " - ยอดขายจากการโอน: {$row['Transfer']} บาท</p>";
              }
              if ($row['COD']) {
                echo "<p class='my-3'><img src='../pictures/admin/truck.png' width='30'>";
                echo " - ยอดขายจากการเก็บเงินปลายทาง: {$row['COD']} บาท</p>";
              }
            }
          ?>
          </div>
        </div>
      </div>

      <!-- querry -->
      <?php
        $msquery = "SELECT COUNT(*) AS TotalLoginAttempts FROM ACCESS_LOG;";
        $msresults = mysqli_query($connectDB, $msquery);
        if ($row = mysqli_fetch_assoc($msresults)) {
          $count = $row['TotalLoginAttempts'];
        }
      ?>
      <!-- show -->
      <div class="col-lg-4">
        <div class="card shadow shadow-sm">
        <div class="card-header text-center" style="background-color: #5A8F7B; color: white;">
          <img src="../pictures/admin/observation.png" width="30">
            <strong><u> ยอดผู้เข้าชม</u></strong>
          <img src="../pictures/admin/observation.png" width="30">
          </div>
          <div class="card-body" style="min-height: 200px;">
            <p class="text-center">มีผู้เข้าใช้งานเว็บไซต์ <?php echo $count;?> ครั้ง</p>
            <?php
              $msquery = "SELECT CUSTOMER.CusFName, COUNT(*) AS TotalActions 
                          FROM ACCESS_LOG 
                          JOIN CUSTOMER ON ACCESS_LOG.CusID = CUSTOMER.CusID 
                          GROUP BY CUSTOMER.CusFName 
                          ORDER BY TotalActions DESC;";
              $msresults = mysqli_query($connectDB, $msquery);
              while ($row = mysqli_fetch_assoc($msresults)) {
                echo "<p class='my-3'><img src='../pictures/admin/teamwork.png' width='30'>";
                $name = $row['CusFName'];
                $total = $row['TotalActions'];
                echo " - $name: เข้าถึง $total ครั้ง</p>";
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>