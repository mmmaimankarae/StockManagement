<?php
  require '../components/connectDB.php';
  $where = "";
  $count = 0;
  if ($_POST['status'] != "") {
    $where = " WHERE Status = '" . $_POST['status'] . "'";
    $count++;
  }

  if ($_POST['detail'] != "") {
    $detail = $_POST['detail'];
    if ($count == 0) $where = "WHERE ";
    else $where .= " AND ";

    if (preg_match("/^[0-9\s]+$/", $detail)) {
        $where .= "ProID = '" . $detail . "'";
    } elseif (preg_match('/\p{Thai}/u', $detail) or preg_match("/^[a-zA-Z\s]+$/", $detail)) {
        $where .= "ProName = '" . $detail . "'";
    }
  }

  $msquery = "SELECT ImageSource, ProID, ProName, PricePerUnit, CostPerUnit, Update_Day
              FROM PRODUCT {$where} 
              ORDER BY ProID;";
  // echo $msquery;
  $msresults = mysqli_query($connectDB, $msquery);
  mysqli_close($connectDB);
?>