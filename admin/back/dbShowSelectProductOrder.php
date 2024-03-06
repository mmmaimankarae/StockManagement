<?php
  require '../components/connectDB.php';
  $where = " ";
  $groupOrder = " GROUP BY R.RecID
                 ORDER BY CAST(SUBSTRING(R.RecID, 2) AS SIGNED),  R.RecID;";
  $count = 0;
  if (isset($_POST['status'])) {
    $where = "WHERE R.Status = '" . $_POST['status'] . "'";
    $count++;
  }

  if (isset($_POST['detail'])) {
    $detail = $_POST['detail'];
    if ($count == 0) $where = "WHERE ";
    else $where .= " AND ";

    if (preg_match("/^0[0-9]{9}$/", $detail)) {
        $where .= "C.Tel = '" . $detail . "'";
    } elseif (preg_match("/^[0-9\s]+$/", $detail)) {
        $where .= "R.RecID = 'R" . $detail . "'";
    } elseif (preg_match("/^[R0-9\s]+$/", $detail)) {
        $where .= "R.RecID = '" . $detail . "'";
    } elseif (preg_match('/\p{Thai}/u', $detail) or preg_match("/^[a-zA-Z\s]+$/", $detail)) {
        $where .= "C.CusFName = '" . $detail . "' OR C.CusLName = '" . $detail . "'";
    }
  }

  if (isset($_POST['startDate'])) {
    if ($count == 0) $where = "WHERE ";
    else $where .= " AND ";

    $where .= "R.PayTime >= STR_TO_DATE('" . $_POST['startDate'] . "', '%d/%m/%Y') AND
               R.PayTime <= DATE_ADD(STR_TO_DATE('"  . $_POST['endDate'] ."', '%d/%m/%Y'), INTERVAL 1 DAY)";
  }
  
  $msquery = "SELECT R.RecID AS ReceiptID, C.Tel AS Tel, R.PayTime AS ReceiptDate, 
                     CONCAT(C.CusFName, ' ', C.CusLName) AS CustomerName, 
                     SUM(RO.Qty * P.PricePerUnit) AS TotalPrice, R.Channel AS Channel, R.Status AS Status
              FROM RECEIPT R JOIN RECEIPT_LIST RO ON R.RecID = RO.RecID
              JOIN PRODUCT P ON RO.ProID = P.ProID JOIN CUSTOMER C ON R.CusID = C.CusID "
              . $where . $groupOrder;
  $msresults = mysqli_query($connectDB, $msquery);
  mysqli_close($connectDB);
?>