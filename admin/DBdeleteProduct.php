<?php
  require '../components/connectDB.php';
  $msquery = "UPDATE PRODUCT SET Status = 'Inactive' WHERE ProID = " . $_POST['proID'] . ";";
  $msresults = mysqli_query($msconnectDB, $msquery);
  mysqli_close($msconnectDB);
  header("Location: ../admin/ProductList.php");
  exit;
?>