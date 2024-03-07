<?php 
  require '../../components/connectDB.php';
  $msquery = "INSERT INTO PRODUCT (ProName, PricePerUnit, CostPerUnit, StockQty, 
                                   Description, ImageSource, Status, Update_Day) 
              VALUES ('{$_POST['proName']}', {$_POST['pricePerUnit']}, {$_POST['costPerUnit']}, {$_POST['stockQty']}, 
                      '{$_POST['description']}', '{$_POST['imageSource']}', '{$_POST['status']}', '{$_POST['update_day']}');";
  $msresults = mysqli_query($connectDB, $msquery);
  mysqli_close($connectDB);
  header("Location: ../ProductList.php");
?>