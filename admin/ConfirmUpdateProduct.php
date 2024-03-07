<?php
  session_start();
  $_SESSION['proID'] = $_POST['proID'];
  $_SESSION['data'] = "update";
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
    $status = array("Active", "OutStock", "Pending", "Inactive");
    $statusT = array("กำลังขายอยู่", "คลังสินค้าหมด", "รอดำเนินการ", "ยกเลิกการขาย");
    $index = 0;
    if ($row) {
      echo "<form action='../admin/back/dbUpdateProduct.php' method='post'>";
        echo "<div class='container'>";
          echo "<div class='row'>";
            echo "<div class='col'>";
              echo "<input type='hidden' name='proID' value='" . $_POST['proID'] . "'>";

              if ($_POST['imageSource'] == '') {
                echo "<img src='" . $row['ImageSource'] . "' width='500' height='500' class='img-thumbnail shadow-sm'>";
              } else {
                echo "<img src='" . $_POST['imageSource'] . "' width='500' height='500' class='img-thumbnail shadow-sm'>";
                echo "<input type='hidden' name='imageSource' value='" . $_POST['imageSource'] . "'>";
              }
            echo "</div>";

            echo "<div class='col'>";
              echo "<div class='mb-3'>";
                echo "<label class='my-2'>ชื่อสินค้า</label>";
                echo "<div class='col card mx-2'>";
                  if ($_POST['proName'] == '') {
                    echo "<div class='mx-2'>" . $row['ProName']. "</div>";
                  } else {
                    echo "<div class='mx-3 text-danger'>" . $_POST['proName'] . "</div>";
                    echo "<input type='hidden' name='proName' value='" . $_POST['proName'] . "'>";
                  }
                echo "</div>";
                
                echo "<div class='row'>";
                  echo "<div class='col'>";
                    echo "<label class='my-2'>ราคาขายต่อหน่วย (บาท/หน่วย)</label>";
                    echo "<div class='card mx-2'>";
                      if ($_POST['pricePerUnit'] == '') {
                        echo "<div class='mx-2'>" . $row['PricePerUnit']. "</div>";
                      } else {
                        echo "<div class='mx-3 text-danger'>" . $_POST['pricePerUnit'] . "</div>";
                        echo "<input type='hidden' name='pricePerUnit' value='" . $_POST['pricePerUnit'] . "'>";
                      }
                    echo "</div>";
                  echo "</div>";

                  echo "<div class='col'>";
                    echo "<label class='my-2'>ต้นทุนต่อหน่วย (บาท/หน่วย)</label>";
                    echo "<div class='card mx-2'>";
                      if ($_POST['costPerUnit'] == '') {
                        echo "<div class='mx-2'>" . $row['CostPerUnit']. "</div>";
                      } else {
                        echo "<div class='mx-3 text-danger'>" . $_POST['costPerUnit'] . "</div>";
                        echo "<input type='hidden' name='costPerUnit' value='" . $_POST['costPerUnit'] . "'>";
                      }
                    echo "</div>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";

              echo "<div class='mb-3 my-3'>";
                echo "<label class='my-2'>คำอธิบายสินค้า</label>";
                echo "<div class='col card mx-2' style='height: 6rem;'>";
                  if ($_POST['description'] == '') {
                    echo "<div class='mx-2'>" . $row['Description']. "</div>";
                  } else {
                    echo "<div class='mx-3 text-danger'>" . $_POST['description'] . "</div>";
                    echo "<input type='hidden' name='description' value='" . $_POST['description'] . "'>";
                  }
                echo "</div>";
              echo "</div>";

              echo "<div class='mb-3'>";
                echo "<label class='my-2'>จำนวนสินค้า</label>";
                echo "<div class='col card mx-2'>";
                  if ($_POST['stockQty'] == '') {
                    echo "<div class='mx-2'>" . $row['StockQty']. "</div>";
                  } else {
                    echo "<div class='mx-3 text-danger'>" . $_POST['stockQty'] . "</div>";
                    echo "<input type='hidden' name='stockQty' value='" . $_POST['stockQty'] . "'>";
                  }
                echo "</div>";
              echo "</div>";

              echo "<div class='mb-3'>";
              echo "<label class='my-2'>สถานะสินค้า</label><br>";
                echo "<div class='col card mx-2'>";
                foreach ($status as $arr) {
                  if($_POST['status'] == $row['Status']) {
                    if ($row['Status'] == $arr) {
                        echo "<div class='mx-2'>" . $statusT[$index] . "</div>";
                    }
                  } else {
                    if ($_POST['status'] == $arr) {
                        echo "<div class='mx-3 text-danger'>" . $statusT[$index] . "</div>";
                        echo "<input type='hidden' name='status' value='" . $_POST['status'] . "'>";
                    }
                  }
                  $index += 1;
                }
                echo "</div>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
        echo "<div class='d-grid gap-2 d-md-flex mx-5 my-3'>";
          echo "<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#confirm'>ย้อนกลับ</button>";

          echo "<div class='modal fade' id='confirm' tabindex='-1' aria-labelledby='confirmLabel' aria-hidden='true'>";
            echo "<div class='modal-dialog'>";
              echo "<div class='modal-content'>";
                echo "<div class='modal-body'> เมื่อคุณย้อนกลับข้อมูลการแก้ไขจะถูกรีเซ็ตใหม่ทั้งหมด</div>";
                echo "<div class='modal-footer'>";
                  echo "<button type='button' class='btn btn-danger btn-sm' onclick=\"window.location.href='../admin/UpdateProduct.php'\">ตกลง</button>";
                  echo "<button type='button' class='btn btn-success btn-sm' data-bs-dismiss='modal'>ยกเลิก</button>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
          echo "<button class='btn btn-success ms-auto' type='submit'>ยืนยัน</button>";
        echo "</div>";
      echo "</form>";
    }
    mysqli_close($msconnect);
  ?>
</body>

</html>