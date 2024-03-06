<?php 
  require '../admin/back/dbShowProduct.php';
?>
<div class="container my-4">
<button id='export' class='btn btn-secondary btn-sm float-end' style="margin-bottom: 2%">ส่งออกเป็น Excel</button>
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

            // echo "<td class='text-center'>{$row['CustomerName']}</td>";
            // echo "<td class='text-center'>{$row['TotalPrice']}</td>";

            // if ($row['Channel'] == "Transfer") echo "<td class='text-center'><img src='../pictures/admin/transfer.png' width='25'></td>";
            // else echo "<td class='text-center'><img src='../pictures/admin/truck.png' width='25'></td>";

            // if ($row['Status'] == "Pending") {
            //   echo "<td class='text-center'>";
            //     echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #f4e47c; margin-left: 6%'>";
            //       echo "<span style='font-size: 80%;'>{$statusT[0]}</span>";
            //     echo "</div>";
            //   echo "</td>";
                                    
            //   echo "<td class='text-center align-middle'>";
            //     echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
            //       echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
            //       echo "<input type='hidden' name='status' value='{$status[1]}'>";
            //       echo "<button type='submit' class='btn btn-outline-dark' style='font-size: 80%;'>{$statusT[1]}</button>";
            //     echo "</form>";
            //   echo "</td>";                    
            // } 
            
            // elseif ($row['Status'] == "Paid") {
            //     echo "<td class='text-center'>";
            //       echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #a9bcff; margin-left: 6%'>";
            //         echo "<span style='font-size: 80%;'>{$statusT[1]}</span>";
            //       echo "</div>";
            //     echo "</td>";
                                      
            //     echo "<td class='text-center align-middle'>";
            //       echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
            //         echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
            //         echo "<input type='hidden' name='status' value='{$status[3]}'>";
            //        echo "<button type='submit' class='btn btn-outline-dark' style='font-size: 80%;'>{$statusT[3]}</button>";
            //       echo "</form>";
            //     echo "</td>";                    
            // } 
            
            // elseif ($row['Status'] == "COD") {
            //     echo "<td class='text-center'>";
            //       echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #c1d3ff; margin-left: 6%'>";
            //         echo "<span style='font-size: 80%;'>{$statusT[2]}</span>";
            //       echo "</div>";
            //     echo "</td>";
                                      
            //     echo "<td class='text-center align-middle'>";
            //       echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
            //         echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
            //         echo "<input type='hidden' name='status' value='{$status[4]}'>";
            //         echo "<button type='submit' class='btn btn-outline-dark' style='font-size: 80%;'>{$statusT[3]}</button>";
            //       echo "</form>";
            //     echo "</td>";                    
            // } 
            
            // elseif ($row['Status'] == "Delivered") {
            //     echo "<td class='text-center'>";
            //       echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #a0d2c7; margin-left: 6%'>";
            //         echo "<span style='font-size: 80%;'>{$statusT[3]}</span>";
            //       echo "</div>";
            //     echo "</td>";
                                      
            //     echo "<td class='text-center align-middle'>";
            //       echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
            //         echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
            //         echo "<input type='hidden' name='status' value='{$status[5]}'>";
            //         echo "<button type='submit' class='btn btn-outline-dark' style='font-size: 80%;'>{$statusT[5]}</button>";
            //       echo "</form>";
            //     echo "</td>";                    
            // } 
            
            // elseif ($row['Status'] == "DI") {
            //     echo "<td class='text-center'>";
            //       echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #d4bbff; margin-left: 6%'>";
            //         echo "<span style='font-size: 80%;'>{$statusT[4]}</span>";
            //       echo "</div>";
            //     echo "</td>";
                                      
            //     echo "<td class='text-center align-middle'>";
            //       echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
            //         echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
            //         echo "<input type='hidden' name='status' value='{$status[5]}'>";
            //        echo "<button type='submit' class='btn btn-outline-dark' style='font-size: 80%;'>{$statusT[5]}</button>";
            //       echo "</form>";
            //     echo "</td>";                    
            // } 
            
            // elseif ($row['Status'] == "Completed") {
            //     echo "<td class='text-center'>";
            //       echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #cec8c8; margin-left: 6%'>";
            //         echo "<span style='font-size: 80%;'>{$statusT[5]}</span>";
            //       echo "</div>";
            //     echo "</td>";
                                      
            //     echo "<td class='text-center align-middle'>";
            //       echo "-";
            //     echo "</td>";                    
            // } 
            
            // elseif ($row['Status'] == "Returned") {
            //     echo "<td class='text-center'>";
            //       echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #f88861; margin-left: 6%'>";
            //         echo "<span style='font-size: 80%;'>{$statusT[6]}</span>";
            //       echo "</div>";
            //     echo "</td>";
                                      
            //     echo "<td class='text-center align-middle'>";
            //       echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
            //         // echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
            //         // echo "<input type='hidden' name='status' value='{$status[3]}'>";
            //         echo "<button type='button' class='btn btn-outline-danger' style='font-size: 80%;'>ดูรายละเอียด</button>";
            //       echo "</form>";
            //     echo "</td>";                    
            // } 
            
            // elseif ($row['Status'] == "Cancel") {
            //     echo "<td class='text-center'>";
            //       echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #ed8b8b; margin-left: 6%'>";
            //         echo "<span style='font-size: 80%;'>{$statusT[7]}</span>";
            //       echo "</div>";
            //     echo "</td>";
                                      
            //     echo "<td class='text-center align-middle'>";
            //       echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
            //         // echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
            //         // echo "<input type='hidden' name='status' value='{$status[3]}'>";
            //        echo "<button type='button' class='btn btn-outline-danger' style='font-size: 80%;'>ดูรายละเอียด</button>";
            //       echo "</form>";
            //     echo "</td>";                    
            // }


            echo "<td class='text-center'>";
              echo "<form method='post' action='../frontStore/ExportToPDF.php'>";
                echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
                echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/pen.png' width='30'></button>";
              echo "</form>";
              echo "<form method='post' action='../frontStore/ExportToPDF.php'>";
                echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
                echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/observation.png' width='30'></button>";
              echo "</form>";
            echo "</td>";
          echo "</tr>";
        }
      ?>
        </tbody>
    </table>
</div>

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