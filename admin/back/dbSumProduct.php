<?php
  /* ดึงข้อมูล DB */
  require '../components/connectDB.php';
  /* กำหนดคำสั่ง SQL */
  $msquery = "SELECT COUNT(ProID) AS QtyProduct, Status 
              FROM PRODUCT
              GROUP BY Status;";
  /* $stmt = $pdo->prepare("SELECT COUNT(ProID) AS QtyProduct, Status 
                            FROM PRODUCT
                            GROUP BY Status;"); */

  /* EXECUTE SQL COMMAND */
  $msresults = mysqli_query($connectDB, $msquery);
  /* $stmt->execute(); */

  /* กำหนดตัวแปร */
  $qtyActive = 0;
  $qtyInactive = 0; /* Waiting For Delivery */
  $qtyPendingProduct = 0;
  $qtyOutStock = 0;
  /* FETCH THE DATA */
  while ($row = mysqli_fetch_array($msresults)) {
  /* while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { */
    switch ($row['Status']) {
      case "Active":
          $qtyActive = $row['QtyProduct'];
          break;
      case "Inactive":
          $qtyInactive = $row['QtyProduct'];
          break;
      case "Pending":
          $qtyPendingProduct = $row['QtyProduct'];
          break;
      case "OutStock":
          $qtyOutStock = $row['QtyProduct'];
          break;
    }
  }
  /* ปิด CONNECTION */
  mysqli_close($connectDB);
  /* $pdo = null; */
  /* กำหนด SESSION เพื่อส่งต่อข้อมูล */
  $_SESSION['Active'] = $qtyActive;
  $_SESSION['Inactive'] = $qtyInactive;
  $_SESSION['PendingProduct'] = $qtyPendingProduct;
  $_SESSION['OutStock'] = $qtyOutStock;
?>