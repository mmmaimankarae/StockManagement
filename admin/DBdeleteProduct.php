<?php
$msquery = "UPDATE PRODUCT SET Status = 'Inactive' WHERE ProID = " . $_POST['proID'] . ";";
$msconnect = mysqli_connect("localhost", "root", "", "myStore");
$msresults = mysqli_query($msconnect, $msquery);
mysqli_close($msconnect);
header("Location: ../admin/AllProduct.php");
exit;
?>