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
  <?php
    $msconnect = mysqli_connect("localhost", "root", "", "myStore");
    $msquery = "SELECT * FROM PRODUCT WHERE ProID = " . $_POST['proID'] . ";";
    $msresults = mysqli_query($msconnect, $msquery);
    $row = mysqli_fetch_array($msresults);
    if ($row) {
      echo "<div class='container'>";
        echo "<div class='row'>";
          echo "<div class='col'>";
            echo "<img src='" .$row['ImageSource']. "' width='500' height='500' class='img-thumbnail shadow-sm'>";
            echo "<label class='my-2'>สถานะสินค้า</label><br>";
            echo "<button type='button' class='btn btn-primary mx-2'>กำลังขายอยู่</button>";
            echo "<button type='button' class='btn btn-outline-primary mx-2'>คลังสินค้าหมด</button>";
            echo "<button type='button' class='btn btn-outline-primary mx-2'>รอดำเนินการ</button>";
            echo "<button type='button' class='btn btn-outline-primary mx-2'>ยกเลิกการขาย</button>";
          echo "</div>";
          echo "<div class='col'>";
            echo "<div class='alert alert-primary' role='alert'><strong>Product ID: </strong>" . $_POST['proID']; 
            echo "</div>";
            echo "<div class='mb-3'>";
              echo "<label class='my-2'>ชื่อสินค้า</label>";
              echo "<input type='text' class='form-control' id='proName' placeholder='" . $row['ProName'] . "'>";
            echo "</div>";
            echo "<div class='row'>";
              echo "<div class='col'>";
                echo "<label class='my-2'>ราคาขายต่อหน่วย (บาท/หน่วย)</label>";
                echo "<input type='text' class='form-control' id='proName' placeholder='" . $row['PricePerUnit'] . "'>";
              echo "</div>";
              echo "<div class='col'>";
                echo "<label class='my-2'>ต้นทุนต่อหน่วย (บาท/หน่วย)</label>";
                echo "<input type='text' class='form-control' id='proName' placeholder='" . $row['CostPerUnit'] . "'>";
              echo "</div>";
            echo "</div>";
            echo "<div class='mb-3 my-3'>";
              echo "<label class='my-2'>คำอธิบายสินค้า</label>";
              echo "<textarea class='form-control' id='exampleFormControlTextarea1' rows='3'></textarea>";
            echo "</div>";
            echo "<div class='mb-3'>";
              echo "<label class='my-2'>ลิงค์รูปภาพสินค้า</label>";
              echo "<input type='text' class='form-control' id='proName' placeholder='" . $row['ImageSource'] . "'>";
            echo "</div>";
            echo "<div class='mb-3'>";
              echo "<label class='my-2'>จำนวนสินค้า</label>";
              echo "<input type='text' class='form-control' id='proName' placeholder='" . $row['StockQty'] . "'>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
      echo "<div class='d-grid gap-2 col-6 mx-auto my-3'>";
      echo "<button class='btn btn-success' type='button'>อัปเดทข้อมูลสินค้า</button>";
      echo "<button class='btn btn-danger my-2' type='button'>ลบข้อมูลสินค้า</button>";
      echo "</div>";
    }
    mysqli_close($msconnect);
  ?>
</body>

</html>