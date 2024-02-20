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
                FROM PRODUCT P JOIN RECEIPT_LIST RO ON P.ProID = RO.ProID GROUP BY P.ProID, P.ProName;";
    $msresults = mysqli_query($msconnect, $msquery);
    while ($row = mysqli_fetch_array($msresults)) {
      $totalSales += $row['TotalSales'];
    }

    $msquery = "SELECT P.ProID, P.ProName, SUM(RO.Qty) AS TotalQty, SUM(RO.Qty * P.PricePerUnit) AS TotalSales
                FROM PRODUCT P JOIN RECEIPT_LIST RO ON P.ProID = RO.ProID JOIN RECEIPT R ON RO.RecID = R.RecID
                WHERE YEAR(R.PayTime) = YEAR(CURRENT_DATE) AND MONTH(R.PayTime) = MONTH(CURRENT_DATE) GROUP BY P.ProID, P.ProName;";
    $msresults = mysqli_query($msconnect, $msquery);
    while ($row = mysqli_fetch_array($msresults)) {
      $totalOfMonth += $row['TotalSales'];
      $totalQty += $row['TotalQty'];
    }
    mysqli_close($msconnect);

    session_start();
    $_SESSION['total'] = $totalSales;
?>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card shadow shadow-sm" style="width: 30rem;">
          <div class="card-body">
            <img src="../pictures/boxes.png" class="rounded float-end ml-3" width="90">
            <h6 class="card-title"><strong>ยอดขายทั้งหมด</strong></h6>
            <h5 class="card-subtitle my-2 text-danger">฿
              <?php echo $totalSales?>
            </h5>
            <div class="text-center">
              <a href="../admin/Summary.php" class="btn btn-danger btn-sm" tabindex="-1" role="button"
                aria-disabled="true">ดูยอดขาย</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-auto">
        <div class="card shadow shadow-sm" style="width: 18rem;">
          <div class="card-body">
            <img src="../pictures/transaction.png" class="rounded float-start" width="20">
            <h6 class="card-title"><strong>ยอดขายใหม่</strong></h6>
            <div class="text-center">
              <h5 class="card-subtitle my-2">฿
                <?php echo $totalOfMonth?>
              </h5>
              <button type="button" class="btn btn-success btn-sm">ยอดขายเดือนนี้</button>
            </div>
          </div>
        </div>
      </div>

      <div class="col col-lg-3">
        <div class="card shadow shadow-sm" style="width: 18rem;">
          <div class="card-body">
            <img src="../pictures/logo.png" class="rounded float-start" width="20">
            <h6 class="card-title"><strong>ยอดสินค้า</strong></h6>
            <div class="text-center">
              <h5 class="card-subtitle my-2">
                <?php echo $totalQty?> ชิ้น
              </h5>
              <button type="button" class="btn btn-success btn-sm">ยอดขายเดือนนี้</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>