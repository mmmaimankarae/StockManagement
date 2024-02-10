<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <title>Document</title>
</head>

<body style="margin-top: 7%">
<?php include "../components/HeaderAdmin.html"; ?>

<?php 
    $totalSales = 0;
    $totalQty = 0;
    $totalOfMonth = 0;
    $msconnect = mysqli_connect("localhost", "root", "", "myStore");
    $msquery = "SELECT P.ProID, P.ProName, SUM(RO.Qty) AS TotalQty, SUM(RO.Qty * P.PricePerUnit) AS TotalSales
                FROM PRODUCT P JOIN RECEIVE_ORDER RO ON P.ProID = RO.ProID GROUP BY P.ProID, P.ProName;";
    $msresults = mysqli_query($msconnect, $msquery);
    while ($row = mysqli_fetch_array($msresults)) {
      $totalSales += $row['TotalSales'];
    }
    mysqli_close($msconnect);
?>
</body>

</html>