<?php 
  // session_start();
  // echo $_SESSION['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.3/dist/xlsx.full.min.js"></script>
  <title>Document</title>
</head>

<body class="p-3" style="margin-top: 6%">
  <?php include "../components/HeaderAdmin.html"; ?>
  <h3>ยอดขายทั้งหมด</h3><br>
  <form method="get">
    <div class="row">
      <div class="col">
        <input name="search" class="form-control me-2" type="text" placeholder="Search" aria-label="Search">
      </div>
      <div class="col">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </div>
      <div class="col">

      </div>
    </div>
  </form>
  
  <?php
    $id = isset($_GET['search']) ? $_GET['search'] : "";
    if (is_numeric($id)) {
      echo "<p class='mx-2' style='color: #ff0000;'><small>Search ID: " . $id . "</small></p>";
    } elseif (!empty($id)) {
      echo "<div class='alert alert-danger alert-sm my-2' role='alert'> ไม่พบเลขที่ใบเสร็จที่ท่านต้องการหา โปรดลองอีกครั้ง </div>";
    }
  ?>
  <button id="exportBtn" class="btn btn-success btn-sm">Export to Excel</button>
  <table id="dataTable" class="table table-striped table-bordered" style="margin-top: 2%">
    <thead class="table-primary">
      <tr>
      <th scope="col">เลขที่ใบเสร็จ</th>
      <th scope="col">วันที่ออกใบเสร็จ</th>
      <th scope="col">ราคาทั้งหมด</th>
      <th scope="col">ชื่อผู้สั่ง</th>
      </tr>
    </thead>

    <tbody>
      <?php
      $totalSales = 0;
      $totalQty = 0;
      $totalOfMonth = 0;
      $msconnect = mysqli_connect("localhost", "root", "", "myStore");
      $msquery = "SELECT R.Period AS ReceiptDate, R.RecID AS ReceiptID, SUM(RO.Qty * P.PricePerUnit) AS TotalPrice,
                  CONCAT(C.CusFName, ' ', C.CusLName) AS CustomerName FROM RECEIVE R JOIN RECEIVE_ORDER RO ON R.RecID = RO.RecID
                  JOIN PRODUCT P ON RO.ProID = P.ProID JOIN CUSTOMER C ON R.CusID = C.CusID GROUP BY R.Period, R.RecID, C.CusFName, C.CusLName
                  ORDER BY R.Period ASC;";
      $msresults = mysqli_query($msconnect, $msquery);
      while ($row = mysqli_fetch_array($msresults)) {
        echo "<tr>";
        echo "<th scope='row'>" . $row['ReceiptID'] . "</th>";
        echo "<td>" . date("d M Y", strtotime($row['ReceiptDate'])) . "</td>";
        echo "<td>" . number_format($row['TotalPrice'], 2) . "</td>";
        echo "<td>" . $row['CustomerName'] . "</td>";
        echo "</tr>";
      }
      mysqli_close($msconnect);
      ?>
    </tbody>
  </table>
  <script>
    $(document).ready(function () {
      $("#exportBtn").click(function () {
        exportToExcel();
      });

      function exportToExcel() {
        // Get table HTML
        var table = document.getElementById("dataTable");
        var html = table.outerHTML;

        // Prepare Excel file
        var blob = new Blob([html]);
        saveAs(blob, "tableExport.xlsx");
        debugger;
        TableToExcel.convert(table[0], {
          name: 'tableExport.xlsx',
          sheet: {
            name 's1'
          }
        });
      }
    });
  </script>
</body>

</html>