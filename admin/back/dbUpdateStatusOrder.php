<?php 
  require 'C:\xampp\htdocs\StockManagement\components\connectDB.php';
  $msquery = "UPDATE `RECEIPT` SET `Status` = '{$_POST['status']}' WHERE `RECEIPT`.`RecID` = '{$_POST['recID']}';";
  $msresults = mysqli_query($connectDB, $msquery);
  mysqli_close($connectDB);
  header("Location: ../Test.php");
?>
