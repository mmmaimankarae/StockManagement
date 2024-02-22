<?php
$msquery = "UPDATE RECEIPT SET Status = 'Shipped' WHERE RecID = '" . $_POST['recID'] . "';";
$msconnect = mysqli_connect("localhost", "root", "", "myStore");
$msresults = mysqli_query($msconnect, $msquery);
mysqli_close($msconnect);
header("Location: ../admin/NewOrder.php");
exit;
?>