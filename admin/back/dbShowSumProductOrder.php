<?php
  /* ดึงข้อมูล DB */
  require '../components/connectDB.php';
  /* กำหนดคำสั่ง SQL */
  $msquery = "SELECT SUM(RO.Qty) AS TotalQty, R.Status
              FROM RECEIPT_LIST RO 
              JOIN RECEIPT R ON RO.RecID = R.RecID
              GROUP BY R.Status;";
  /* $stmt = $pdo->prepare("SELECT SUM(RO.Qty) AS TotalQty, R.Status
              FROM RECEIPT_LIST RO 
              JOIN RECEIPT R ON RO.RecID = R.RecID
              GROUP BY R.Status;"); */

  /* EXECUTE SQL COMMAND */
  $msresults = mysqli_query($connectDB, $msquery);
  /* $stmt->execute(); */

  /* กำหนดตัวแปร */
  $qty = 0;
  $qtyPending = 0;
  $qtyPaid = 0; /* Waiting For Delivery */
  $qtyCOD = 0;
  $qtyDelivered = 0;
  $qtyCancel = 0;
  /* FETCH THE DATA */
  while ($row = mysqli_fetch_array($msresults)) {
  /* while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { */

    $qty += $row['TotalQty'];
    switch ($row['Status']) {
        case "Pending":
            $qtyPending = $row['TotalQty'];
            break;
        case "Paid":
            $qtyPaid = $row['TotalQty'];
            break;
        case "COD":
            $qtyCOD = $row['TotalQty'];
            break;
        case "Delivered":
            $qtyDelivered += $row['TotalQty'];
            break;
        case "DI":
            $qtyDelivered += $row['TotalQty'];
            break;
        case "Returned":
            $qtyCancel += $row['TotalQty'];
            break;
        case "Cancel":
            $qtyCancel += $row['TotalQty'];
            break;
    }
  }
  /* ปิด CONNECTION */
  mysqli_close($connectDB);
  /* $pdo = null; */
  /* กำหนด SESSION เพื่อส่งต่อข้อมูล */
  $_SESSION['Qty'] = $qty;
  $_SESSION['Pending'] = $qtyPending;
  $_SESSION['Paid'] = $qtyPaid;
  $_SESSION['COD'] = $qtyCOD;
  $_SESSION['Delivered'] = $qtyDelivered;
  $_SESSION['Cancel'] = $qtyCancel;
?>