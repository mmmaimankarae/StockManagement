<?php
  require '../components/connectDB.php';
  $msquery = "UPDATE PRODUCT SET Status = 'Inactive', StockQty = 0, Update_Day = NOW() WHERE ProID = " . $_POST['ProID'] . ";";
  // echo $msquery;
  $msresults = mysqli_query($msconnectDB, $msquery);
  mysqli_close($msconnectDB);
  header("Location: ../admin/ProductList.php");
  exit;
?>