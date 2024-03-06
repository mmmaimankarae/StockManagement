<?php 
  require 'C:\xampp\htdocs\StockManagement\components\connectDB.php';
  $msquery = "UPDATE `RECEIPT` SET `Status` = '{$_POST['status']}' WHERE `RECEIPT`.`RecID` = '{$_POST['recID']}';";
  $msresults = mysqli_query($connectDB, $msquery);

  if ($_POST['status'] == "Paid" or $_POST['status'] == "DI")
    require 'dbUpdateStock.php';
  mysqli_close($connectDB);
  header("Location: ../Test.php");
?>
