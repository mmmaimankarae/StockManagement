<?php 
  require '../admin/back/dbShowProduct.php';
?>

<table class="table" id="dataTable">
  <thead>
    <tr>
      <th class='text-center'><input type="checkbox" id="selectAllCheckbox"></th>
      <th class='text-center'>สินค้า</th>
      <th class='text-center'>รหัสสินค้า</th>
      <th class='text-center'>ชื้อสินค้า</th>
      <th class='text-center'>ราคาขาย</th>
      <th class='text-center'>ราคาต้นทุน</th>
      <th class='text-center'>วันที่แก้ไขล่าสุด</th>
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
          echo "<td class='text-center'><img src='{$row['ImageSource']}' width='60' height='60' class='img-thumbnail shadow-sm'></td>";
          echo "<td class='text-center'>{$row['ProID']}</td>";
          echo "<td class='text-center'>{$row['ProName']}</td>";
          echo "<td class='text-center'>{$row['PricePerUnit']}</td>";
          echo "<td class='text-center'>{$row['CostPerUnit']}</td>";
          
          $originalDate = $row['Update_Day'];
          $newDate = date("Y-m-d h:i", strtotime($originalDate));
          echo "<td class='text-center'>{$newDate}</td>";

          echo "<td class='text-center'>";
            echo "<form method='post' action='../frontStore/ExportToPDF.php'>";
              echo "<input type='hidden' name='recID' value='{$row['ProID']}'>";
              echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/pen.png' width='30'></button>";
            echo "</form>";
            
            echo "<form method='get' action='../frontStore/Product_Detail.php'>";
              echo "<input type='hidden' name='id' value='{$row['ProID']}'>";
              echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/observation.png' width='30'></button>";
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


<script>
  $(document).ready(function () {
    /* ถ้ากด id selectAllCheckbox */
    $('#selectAllCheckbox').change(function () {
      $('.selectCheckbox').prop('checked', $(this).prop('checked'));
    });

    $('.selectCheckbox').change(function () {
      if ($('.selectCheckbox:checked').length == $('.selectCheckbox').length) {
        $('#selectAllCheckbox').prop('checked', true);
      } else {
        $('#selectAllCheckbox').prop('checked', false);
      }
    });

    /* export Report */
    $('#export').click(function () {
        var csvContent = "\uFEFFเลขที่ใบเสร็จ,วันที่สั่งซื้อ,ชื่อผู้สั่ง,ราคาทั้งหมด,การชำระเงิน,สถานะ\n";
        $('#dataTable tbody tr').each(function () {
          var rowData = $(this).find('th,td:not([^id="remove"])').map(function () {
            return $(this).text();
          }).get().join(",");
          csvContent += rowData + "\n";
        });
        var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        saveAs(blob, 'sales_data.csv');
      });
  });
</script>