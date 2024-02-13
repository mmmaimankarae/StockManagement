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
  <h3>
    <center>สินค้าทั้งหมด</center>
  </h3><br>

  <form method="GET">
    <div class="row mx-5">
      <div class="col form-check">
        <input class="form-check-input" type="checkbox" name="statusFilter[]" value="Active">
        <label class="form-check-label" for="activeFilter"> กำลังขายอยู่ </label>
      </div>
      <div class="col form-check">
        <input class="form-check-input" type="checkbox" name="statusFilter[]" value="OutOfStock">
        <label class="form-check-label" for="outFilter"> คลังสินค้าหมด </label>
      </div>
      <div class="col form-check">
        <input class="form-check-input" type="checkbox" name="statusFilter[]" value="Pending">
        <label class="form-check-label" for="pendingFilter"> รอดำเนินการ </label>
      </div>
      <div class="col">
        <button class="btn btn-outline-success btn-sm" type="submit">กรองผลลัพธ์</button>
      </div>
    </div>
  </form>

  <?php
    $statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : array();
    $filterCount = count($statusFilter);
    if ($filterCount == 3) {
      $msquery = "SELECT ProID, ProName, PricePerUnit, CostPerUnit, StockQty, Update_Day, Status FROM PRODUCT 
                  WHERE Status <> 'Inactive' ORDER BY Status, ProID;";
    } elseif ($filterCount == 2) {
      $msquery = "SELECT ProID, ProName, PricePerUnit, CostPerUnit, StockQty, Update_Day, Status FROM PRODUCT 
                  WHERE Status = '" .$statusFilter[0]. "' OR Status = '" .$statusFilter[1]. "' ORDER BY Status, ProID;";
      echo "<div class='alert alert-primary alert-sm my-3 mx-5' role='alert'>" .$statusFilter[0]. ", " .$statusFilter[1]. "</div>";
    } elseif ($filterCount == 1) {
      $msquery = "SELECT ProID, ProName, PricePerUnit, CostPerUnit, StockQty, Update_Day, Status FROM PRODUCT 
                  WHERE Status = '" .$statusFilter[0]. "' ORDER BY Status, ProID;";
      echo "<div class='alert alert-primary alert-sm my-3 mx-5' role='alert'>" .$statusFilter[0]. "</div>";
    } elseif ($filterCount == 0) {
      $msquery = "SELECT ProID, ProName, PricePerUnit, CostPerUnit, StockQty, Update_Day, Status FROM PRODUCT 
                  WHERE Status <> 'Inactive' ORDER BY Status, ProID;";
    }
  ?>
  <button id="exportBtn" class="btn btn-success btn-sm float-end mx-2 my-3">Export to Excel</button>
  <table id="dataTable" class="table table-striped table-bordered" style="margin-top: 2%">
    <thead class="table-primary">
      <tr class='text-center'>
        <th scope="col">รหัสสินค้า</th>
        <th scope="col">ชื่อสินค้า</th>
        <th scope="col">ราคาขายต่อหน่วย</th>
        <th scope="col">ต้นทุนต่อหน่วย</th>
        <th scope="col">จำนวนสินค้าในคลัง</th>
        <th scope="col">แก้ไขสินค้า</th>
        <th scope="col">ลบสินค้า</th>
      </tr>
    </thead>

    <tbody>
      <?php
      $totalSales = 0;
      $totalQty = 0;
      $totalOfMonth = 0;
      $msconnect = mysqli_connect("localhost", "root", "", "myStore");
      $msresults = mysqli_query($msconnect, $msquery);
      while ($row = mysqli_fetch_array($msresults)) {
        if ($row['Status'] == "OutOfStock") {
          echo "<tr class='table-danger'>";
          echo "<th scope='row' class='text-center'>" . $row['ProID'] . "</th>";
          echo "<td>" . $row['ProName'] . "</td>";
          echo "<td class='text-center'>" . $row['PricePerUnit'] . "</td>";
          echo "<td class='text-center'>" . $row['CostPerUnit'] . "</td>";
          echo "<td class='text-center'>" . $row['StockQty'] . "</td>";
          echo "<td class='text-center'><a href='../admin/AddProduct.php' class='btn btn-primary btn-circle'><i class='fa-solid fa-pen-to-square'></i></a></td>";
          echo "<td class='text-center'><button type='button' class='btn btn-danger btn-circle'><i class='fa-solid fa-trash'></i></button></td>";
          echo "</tr>";
        } elseif ($row['Status'] == "Pending") {
          echo "<tr class='table-warning'>";
          echo "<th scope='row' class='text-center'>" . $row['ProID']. "</th>";
          //echo "<p><small>" . date("d/m/y", strtotime($row['Update_Day'])) . "</small></p></th>";
          echo "<td>" . $row['ProName'] . "</td>";
          echo "<td class='text-center'>" . $row['PricePerUnit'] . "</td>";
          echo "<td class='text-center'>" . $row['CostPerUnit'] . "</td>";
          echo "<td class='text-center'>" . $row['StockQty'] . "</td>";
          echo "<td class='text-center'><a href='../admin/AddProduct.php' class='btn btn-primary btn-circle'><i class='fa-solid fa-pen-to-square'></i></a></td>";
          echo "<td class='text-center'><button type='button' class='btn btn-danger btn-circle'><i class='fa-solid fa-trash'></i></button></td>";
          echo "</tr>";
        } else {
          echo "<tr>";
          echo "<th scope='row' class='text-center'>" . $row['ProID']. "</th>";
          echo "<td>" . $row['ProName'] . "</td>";
          echo "<td class='text-center'>" . $row['PricePerUnit'] . "</td>";
          echo "<td class='text-center'>" . $row['CostPerUnit'] . "</td>";
          echo "<td class='text-center'>" . $row['StockQty'] . "</td>";
          echo "<td class='text-center'><a href='../admin/AddProduct.php' class='btn btn-primary btn-circle'><i class='fa-solid fa-pen-to-square'></i></a></td>";
          echo "<td class='text-center'><button type='button' class='btn btn-danger btn-circle'><i class='fa-solid fa-trash'></i></button></td>";
          echo "</tr>";
        }
      }
      mysqli_close($msconnect);
      ?>
    </tbody>
  </table>
</body>

</html>