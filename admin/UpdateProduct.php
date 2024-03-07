<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.3/dist/xlsx.full.min.js"></script>
  <title>อัปเดทข้อมูลสินค้า</title>
</head>

<body class="p-3" style="margin-top: 6%">
  <?php include "../components/HeaderAdmin.html"; ?>
  <?php
    $msconnect = mysqli_connect("localhost", "root", "", "myStore");
    $msquery = "SELECT * FROM PRODUCT WHERE ProID = " . $_POST['ProID'] . ";";
    $msresults = mysqli_query($msconnect, $msquery);
    $row = mysqli_fetch_array($msresults);
    $status = array("Active", "OutOfStock", "Pending", "Inactive");
    $statusT = array("กำลังขายอยู่", "คลังสินค้าหมด", "รอดำเนินการ", "ยกเลิกการขาย");
    $index = 0;
    if ($row) {
      echo "<form action='../admin/ConfirmUpdateProduct.php' method='post'>";
        echo "<div class='container'>";
          echo "<div class='row'>";
            echo "<div class='col'>";
              echo "<label class='my-2'><img src='" .$row['ImageSource']. "' width='500' height='500' class='img-thumbnail shadow-sm'></label><br>";

              echo "<label class='my-2'>สถานะสินค้า</label><br>";
              foreach ($status as $arr) {
                if ($row['Status'] == $arr) {
                  echo "<input type='radio' class='btn-check' name='status' id='" . $arr . "' value='" . $arr . "' autocomplete='off' checked>";
                  echo "<label class='btn btn-outline-primary mx-2' for='" . $arr . "'>" . $statusT[$index] . "</label>";
                } else {
                  echo "<input type='radio' class='btn-check' name='status' id='" . $arr . "' value='" . $arr . "' autocomplete='off'>";
                  echo "<label class='btn btn-outline-primary mx-2' for='" . $arr . "'>" . $statusT[$index] . "</label>";
                }
                $index += 1;
              }
            echo "</div>";

            echo "<div class='col'>";
              echo "<div class='alert alert-primary' role='alert'><strong>Product ID: </strong>" . $_POST['ProID']; 
                echo "<input type='hidden' name='proID' value='" . $_POST['ProID'] . "'>";
              echo "</div>";

              echo "<div class='mb-3'>";
                echo "<label class='my-2'>ชื่อสินค้า</label>";
                echo "<input type='text' class='form-control' id='proName' name='proName' placeholder='" . $row['ProName'] . "'>";
              echo "</div>";

              echo "<div class='row'>";
                echo "<div class='col'>";
                  echo "<label class='my-2'>ราคาขายต่อหน่วย (บาท/หน่วย)</label>";
                  echo "<input type='text' class='form-control' id='pricePerUnit' name='pricePerUnit' placeholder='" . $row['PricePerUnit'] . "'>";
                echo "</div>";

                echo "<div class='col'>";
                  echo "<label class='my-2'>ต้นทุนต่อหน่วย (บาท/หน่วย)</label>";
                  echo "<input type='text' class='form-control' id='costPerUnit' name='costPerUnit' placeholder='" . $row['CostPerUnit'] . "'>";
                echo "</div>";
              echo "</div>";

              echo "<div class='mb-3 my-3'>";
                echo "<label class='my-2'>คำอธิบายสินค้า</label>";
                echo "<textarea class='form-control' id='description' name='description' rows='3'placeholder='" . $row['Description'] . "'></textarea>";
              echo "</div>";

              echo "<div class='mb-3'>";
                echo "<label class='my-2'>ลิงค์รูปภาพสินค้า</label>";
                echo "<input type='text' class='form-control' id='imageSource' name='imageSource' placeholder='" . $row['ImageSource'] . "'>";
              echo "</div>";

              echo "<div class='mb-3'>";
                echo "<label class='my-2'>จำนวนสินค้า</label>";
                echo "<input type='text' class='form-control' id='stockQty' name='stockQty' placeholder='" . $row['StockQty'] . "'>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
        echo "<div class='d-grid gap-2 col-6 mx-auto my-3'>";
        echo "<button class='btn btn-success' type='submit'>อัปเดทข้อมูลสินค้า</button>";
      echo "</form>";
      echo "<button class='btn btn-danger my-2' type='button'>ลบข้อมูลสินค้า</button>";
      echo "</div>";
    }
    mysqli_close($msconnect);
  ?>
</body>

</html>