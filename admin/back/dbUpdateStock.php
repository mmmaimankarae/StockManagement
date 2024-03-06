<?php 
  $msquery = "SELECT ProID, Qty FROM RECEIPT_LIST WHERE RecID = '{$_POST['recID']}';";
  $msresults = mysqli_query($connectDB, $msquery);
  while ($row = mysqli_fetch_assoc($msresults)) {
    $msqueryNew = "UPDATE PRODUCT SET StockQty = StockQty - {$row['Qty']} WHERE ProID = {$row['ProID']};";
    $msresultsNew = mysqli_query($connectDB, $msqueryNew);
  }
?>
