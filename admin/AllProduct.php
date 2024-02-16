<?php 
  // session_start();
  // if ($_SESSION['update'] == ok) {
  //   echo "<div class='toast' role='alert' aria-live='assertive' aria-atomic='true'>";
  //     echo "<div class='toast-header'>";
  //       echo "<img src='...' class='rounded me-2' alt='...'>";
  //       echo "<strong class='me-auto'>Bootstrap</strong>";
  //       echo "<small>11 mins ago</small>";
  //       echo "<button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>";
  //     echo "</div>";
  //     echo "<div class='toast-body'>";
  //       echo "Hello, world! This is a toast message.";
  //     echo "</div>";
  //   echo "</div>";
  // }
  session_start();
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
  <button id="exportBtn" class="btn btn-success btn-sm float-end mx-2 my-3" onclick="window.location.href='../admin/AddProduct.php'">เพิ่มสินค้าใหม่</button>
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
        $proID = $row['ProID'];
        if ($row['Status'] == "OutOfStock") {
          echo "<tr class='table-danger'>";
            echo "<th scope='row' class='text-center'>" . $row['ProID'] . "</th>";
            echo "<td>" . $row['ProName'] . "</td>";
            echo "<td class='text-center'>" . $row['PricePerUnit'] . "</td>";
            echo "<td class='text-center'>" . $row['CostPerUnit'] . "</td>";
            echo "<td class='text-center'>" . $row['StockQty'] . "</td>";
            echo "<td class='text-center'>";
              echo "<form action='../admin/UpdateProduct.php' method='post'>";
                echo "<input type='hidden' name='proID' value='" . $row['ProID'] . "'>";
                echo "<button type='submit' class='btn btn-primary btn-circle'><i class='fa-solid fa-pen-to-square'></i></button>";
              echo "</form>";
            echo "</td>";
            echo "<td class='text-center'>";
            echo "<button type='button' class='btn btn-danger btn-circle' data-bs-toggle='modal' data-bs-target='#deleteModal" . $proID . "'><i class='fa-solid fa-trash'></i></button>";
            echo "<div class='modal fade' id='deleteModal" . $proID . "' tabindex='-1' aria-labelledby='deleteLabel' aria-hidden='true'>";
                echo "<div class='modal-dialog'>";
                  echo "<div class='modal-content'>";
                    echo "<div class='modal-body'> คุณแน่ใจว่าจะลบสินค้าตัวนี้?</div>";
                    echo "<form id='deleteForm" . $proID . "' action='../admin/DeleteProduct.php' method='post'>";
                      echo "<input type='hidden' name='proID' id='proIDToDelete' value='" . $row['ProID'] . "'>";
                      echo "<button type='submit' class='btn btn-danger btn-sm mx-2'>ตกลง</button>";
                      echo "<button type='button' class='btn btn-success btn-sm' data-bs-dismiss='modal'>ยกเลิก</button>";
                    echo "</form>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";
            echo "</td>";
          echo "</tr>";
        } elseif ($row['Status'] == "Pending") {
          echo "<tr class='table-warning'>";
            echo "<th scope='row' class='text-center'>" . $row['ProID'] . "</th>";
            //echo "<p><small>" . date("d/m/y", strtotime($row['Update_Day'])) . "</small></p></th>";
            echo "<td>" . $row['ProName'] . "</td>";
            echo "<td class='text-center'>" . $row['PricePerUnit'] . "</td>";
            echo "<td class='text-center'>" . $row['CostPerUnit'] . "</td>";
            echo "<td class='text-center'>" . $row['StockQty'] . "</td>";
            echo "<td class='text-center'>";
              echo "<form action='../admin/UpdateProduct.php' method='post'>";
                echo "<input type='hidden' name='proID' value='" . $row['ProID'] . "'>";
                echo "<button type='submit' class='btn btn-primary btn-circle'><i class='fa-solid fa-pen-to-square'></i></button>";
              echo "</form>";
            echo "</td>";
            echo "<td class='text-center'>";
            echo "<button type='button' class='btn btn-danger btn-circle' data-bs-toggle='modal' data-bs-target='#deleteModal" . $proID . "'><i class='fa-solid fa-trash'></i></button>";
            echo "<div class='modal fade' id='deleteModal" . $proID . "' tabindex='-1' aria-labelledby='deleteLabel' aria-hidden='true'>";
                echo "<div class='modal-dialog'>";
                  echo "<div class='modal-content'>";
                    echo "<div class='modal-body'> คุณแน่ใจว่าจะลบสินค้าตัวนี้?</div>";
                    echo "<form id='deleteForm" . $proID . "' action='../admin/DeleteProduct.php' method='post'>";
                      echo "<input type='hidden' name='proID' id='proIDToDelete' value='" . $row['ProID'] . "'>";
                      echo "<button type='submit' class='btn btn-danger btn-sm mx-2'>ตกลง</button>";
                      echo "<button type='button' class='btn btn-success btn-sm' data-bs-dismiss='modal'>ยกเลิก</button>";
                    echo "</form>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";
            echo "</td>";
          echo "</tr>";
        } elseif ($row['Status'] == "Active") {
          echo "<tr>";
          echo "<th scope='row' class='text-center'>" . $row['ProID'] . "</th>";
            echo "<td>" . $row['ProName'] . "</td>";
            echo "<td class='text-center'>" . $row['PricePerUnit'] . "</td>";
            echo "<td class='text-center'>" . $row['CostPerUnit'] . "</td>";
            echo "<td class='text-center'>" . $row['StockQty'] . "</td>";
            echo "<td class='text-center'>";
              echo "<form action='../admin/UpdateProduct.php' method='post'>";
                echo "<input type='hidden' name='proID' value='" . $row['ProID'] . "'>";
                echo "<button type='submit' class='btn btn-primary btn-circle'><i class='fa-solid fa-pen-to-square'></i></button>";
              echo "</form>";
            echo "</td>";
            echo "<td class='text-center'>";
            echo "<button type='button' class='btn btn-danger btn-circle' data-bs-toggle='modal' data-bs-target='#deleteModal" . $proID . "'><i class='fa-solid fa-trash'></i></button>";
              echo "<div class='modal fade' id='deleteModal" . $proID . "' tabindex='-1' aria-labelledby='deleteLabel' aria-hidden='true'>";
                echo "<div class='modal-dialog'>";
                  echo "<div class='modal-content'>";
                    echo "<div class='modal-body'> คุณแน่ใจว่าจะลบสินค้าตัวนี้?</div>";
                    echo "<div class='modal-footer'>";
                      echo "<form id='deleteForm" . $proID . "' action='../admin/DeleteProduct.php' method='post'>";
                        echo "<input type='hidden' name='proID' id='proIDToDelete' value='" . $row['ProID'] . "'>";
                        echo "<button type='submit' class='btn btn-danger btn-sm mx-2'>ตกลง</button>";
                        echo "<button type='button' class='btn btn-success btn-sm' data-bs-dismiss='modal'>ยกเลิก</button>";
                      echo "</form>";
                    echo "</div>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";
            echo "</td>";
          echo "</tr>";
        }
      }
      mysqli_close($msconnect);
      ?>
    </tbody>
  </table>
</body>

</html>