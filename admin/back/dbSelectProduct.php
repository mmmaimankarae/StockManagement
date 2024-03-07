<?php
  require '../components/connectDB.php';
  $where = "Active";
  $condition = "";
  if (isset($_POST['status']) && !empty($_POST['status'])) {
    $where = $_POST['status'];
  }

  if (isset($_POST['detail']) && !empty($_POST['detail'])) {
    $detail = $_POST['detail'];
    $condition .= " AND ";

    if (preg_match("/^[0-9\s]+$/", $detail)) {
        $condition .= "ProID = '" . $detail . "'";
    } elseif (preg_match('/\p{Thai}/u', $detail) or preg_match("/^[a-zA-Z\s]+$/", $detail)) {
        $condition .= "ProName = '" . $detail . "'";
    }
  }

  $msquery = "SELECT ImageSource, ProID, ProName, PricePerUnit, CostPerUnit, Update_Day
              FROM PRODUCT WHERE Status = '{$where}' {$condition}
              ORDER BY ProID;";
  // echo $msquery;
  $msresults = mysqli_query($connectDB, $msquery);
  mysqli_close($connectDB);
?>