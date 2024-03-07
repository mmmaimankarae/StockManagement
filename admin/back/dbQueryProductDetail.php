<?php
  require '../components/connectDB.php';
  $msquery = "SELECT * FROM PRODUCT WHERE ProID = " . $_POST['ProID'] . ";";
  $msresults = mysqli_query($msconnect, $msquery);
  mysqli_close($connectDB);
?>