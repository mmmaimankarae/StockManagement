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
        <input name="search" class="form-control me-2" input type="number" min='0' placeholder="Search" aria-label="Search">
      </div>
      <div class="col">
        <button class="btn btn-outline-success" type="submit">กรองผลลัพธ์</button>
        <button class="btn btn-outline-success mx-2" type="submit">ยกเลิกการกรอง</button>
      </div>
      <div class="col">

      </div>
    </div>
  </form>

  <table id="dataTable" class="table table-striped table-bordered" style="margin-top: 2%">
    <thead class="table-primary">
      <tr>
      <th scope="col" class='text-center'>เลขที่ใบเสร็จ</th>
      <th scope="col" class='text-center'>วันที่ออกใบเสร็จ</th>
      <th scope="col" class='text-center'>ราคาทั้งหมด</th>
      <th scope="col" class='text-center'>ชื่อผู้สั่ง</th>
      <th scope="col" class='text-center'>ดูรายละเอียด</th>
      </tr>
    </thead>

    <tbody>
      <?php
      $totalSales = 0;
      $totalQty = 0;
      $totalOfMonth = 0;
      $msconnect = mysqli_connect("localhost", "root", "", "myStore");
      $start = "SELECT R.Period AS ReceiptDate, R.RecID AS ReceiptID, SUM(RO.Qty * P.PricePerUnit) AS TotalPrice,
                CONCAT(C.CusFName, ' ', C.CusLName) AS CustomerName FROM RECEIVE R JOIN RECEIVE_ORDER RO ON R.RecID = RO.RecID
                JOIN PRODUCT P ON RO.ProID = P.ProID JOIN CUSTOMER C ON R.CusID = C.CusID ";
      $medial = "";
      $id = isset($_GET['search']) ? $_GET['search'] : "";
      if ($id != ''){
        echo "<p class='mx-2' style='color: #ff0000;'><small>Search ID: " . $id . "</small></p>";
        $medial = "WHERE R.RecID = " . $id;
      }
      echo "<button id='exportBtn' class='btn btn-success btn-sm float-end mx-2 my-3'>Export to Excel</button>";
      $end = " GROUP BY R.Period, R.RecID, C.CusFName, C.CusLName ORDER BY R.Period ASC;";
      $msquery = $start .$medial .$end;
      $msresults = mysqli_query($msconnect, $msquery);
      while ($row = mysqli_fetch_array($msresults)) {
        echo "<tr>";
        echo "<th scope='row' class='text-center'>" . $row['ReceiptID'] . "</th>";
        echo "<td class='text-center'>" . date("d M Y", strtotime($row['ReceiptDate'])) . "</td>";
        echo "<td class='text-center'>" . $row['TotalPrice'] . "</td>";
        echo "<td class='text-center'>" . $row['CustomerName'] . "</td>";
        echo "<td class='text-center'>";
        echo "<form action='../admin/UpdateProduct.php' method='post'>";
            echo "<input type='hidden' name='proID' value='" . $row['ProID'] . "'>";
            echo "<button type='submit' class='btn btn-primary btn-circle'><i class='fa-solid fa-magnifying-glass'></i></button>";
          echo "</form>";
        echo "</td>";
        echo "</tr>";
      }
      mysqli_close($msconnect);
    ?>
    </tbody>
  </table>
  <script>
    $(document).ready(function () {
      $('#exportBtn').click(function () {
        var csvContent = "\uFEFFเลขที่ใบเสร็จ,วันที่ออกใบเสร็จ,ราคาทั้งหมด,ชื่อผู้สั่ง\n";
        $('#dataTable tbody tr').each(function () {
          var rowData = $(this).find('th,td').map(function () {
            return $(this).text();
          }).get().join(",");
          csvContent += rowData + "\n";
        });
        var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        saveAs(blob, 'sales_data.csv');
      });
    });
  </script>
</body>

</html>