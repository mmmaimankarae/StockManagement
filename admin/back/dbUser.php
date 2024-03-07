<?php
  /* ดึงข้อมูล DB */
  require '../components/connectDB.php';
  /* กำหนดคำสั่ง SQL */
  $msquery = "SELECT * FROM CUSTOMER
              WHERE CusID <> '1' AND CusID <> '2';";
  /* $stmt = $pdo->prepare("SELECT * FROM CUSTOMER
                            WHERE CusID <> '1' AND CusID <> '2';"); */

  /* EXECUTE SQL COMMAND */
  $msresults = mysqli_query($connectDB, $msquery);
  /* $stmt->execute(); */

//   /* ปิด CONNECTION */
//   mysqli_close($connectDB);
?>
<table class="table" id="dataTable">
  <thead>
    <tr>
      <th class='text-center'><input type="checkbox" id="selectAllCheckbox"></th>
      <th class='text-center'>ชื่อ</th>
      <th class='text-center'>นามสกุล</th>
      <th class='text-center'>เพศ</th>
      <th class='text-center'>เบอร์โทรศัพ์</th>
      <th class='text-center'>ที่อยู่</th>
      <th class='text-center'></th>
      <th class='text-center'></th>
      <th class='text-center'></th>
    </tr>
  </thead>

  <tbody>
    <?php
      $statusT = array("ชำระเงินแล้ว\nรอการตรวจสอบ", "รอจัดส่ง", "เก็บเงินปลายทาง รอการจัดส่ง", "จัดส่งสินค้า", "จัดส่งแล้ว รอเงินเข้า", "เสร็จสิ้นแล้ว", "สินค้าถูกส่งคืน", "ยกเลิกคำสั่งซื้อ");
      $status = array("Pending", "Paid", "COD", "Delivered", "DI", "Completed", "Returned", "Cancel");

      while ($row = mysqli_fetch_assoc($msresults)) {
        echo "<tr style='font-size: 90%'>";
          echo "<td class='text-center'><input type='checkbox' class='selectCheckbox'></td>";
          echo "<td class='text-center'>{$row['CusFName']}</td>";
          echo "<td class='text-center'>{$row['CusLName']}</td>";
          echo "<td class='text-center'>{$row['Sex']}</td>";
          echo "<td class='text-center'>{$row['Tel']}</td>";
          echo "<td class='text-center'>{$row['Address']}</td>";

          echo "<td class='text-center'>";
            echo "<form method='post' action='UpdateProduct.php'>";
              echo "<input type='hidden' name='ProID' value='{$row['ProID']}'>";
              echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/pen.png' width='30'></button>";
            echo "</form>";
          echo "</td>";

          echo "<td class='text-center'>";
            echo "<form method='post' action='UpdateProduct.php'>";
              echo "<input type='hidden' name='ProID' value='{$row['ProID']}'>";
              echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/search-normal.png' width='30'></button>";
            echo "</form>";
          echo "</td>";

          echo "<td class='text-center'>";
          echo "<form method='get' action='../frontStore/Product_Detail.php'>";
            echo "<input type='hidden' name='id' value='{$row['ProID']}'>";
            echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/trash.png' width='30'></button>";
          echo "</form>";
          echo "</td>";
        echo "</tr>";
      }
    ?>
  </tbody>
</table>