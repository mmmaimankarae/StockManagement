<?php
require "../components/connectDB.php";
$sql = "SELECT R.RecID AS ReceiptID, C.Tel AS Tel, R.PayTime AS ReceiptDate, 
  CONCAT(C.CusFName, ' ', C.CusLName) AS CustomerName, 
  SUM(RO.Qty * P.PricePerUnit) AS TotalPrice, R.Channel AS Channel, R.Status AS Status
FROM RECEIPT R JOIN RECEIPT_LIST RO ON R.RecID = RO.RecID
JOIN PRODUCT P ON RO.ProID = P.ProID JOIN CUSTOMER C ON R.CusID = C.CusID WHERE R.Status = 'COD' GROUP BY R.RecID";
$msresults = mysqli_query($connectDB, $sql);
?>
<div class="container my-4">
  <button id='export' class='btn btn-secondary btn-sm float-end' style="margin-bottom: 2%">ส่งออกเป็น Excel</button>
  <table class="table" id="dataTable">
    <thead>
      <tr>
        <th class='text-center'><input type="checkbox" id="selectAllCheckbox"></th>
        <th class='text-center'>เลขที่ใบสั่งซื้อ</th>
        <th class='text-center'>เบอร์โทรศัพท์</th>
        <th class='text-center'>วันที่สั่งซื้อ</th>
        <th class='text-center'>ลูกค้า</th>
        <th class='text-center'>ราคา</th>
        <th class='text-center'>การชำระเงิน</th>
        <th class='text-center'>สถานะ</th>
        <th class='text-center'>อัพเดทสถานะ</th>
        <th class='text-center'></th>
      </tr>
    </thead>

    <tbody>
      <?php
      $statusT = array("ชำระเงินแล้ว รอการตรวจสอบ", "รอจัดส่ง", "เก็บเงินปลายทาง รอการจัดส่ง", "จัดส่งสินค้า", "จัดส่งแล้ว รอเงินเข้า", "เสร็จสิ้นแล้ว", "สินค้าถูกส่งคืน", "ยกเลิกคำสั่งซื้อ");
      $status = array("Pending", "Paid", "COD", "Delivered", "DI", "Completed", "Returned", "Cancel");

      while ($row = mysqli_fetch_assoc($msresults)) {
        echo "<tr style='font-size: 90%'>";
        echo "<td class='text-center'><input type='checkbox' class='selectCheckbox'></td>";
        echo "<td class='text-center'>{$row['ReceiptID']}</td>";
        echo "<td class='text-center' id='remove'>{$row['Tel']}</td>";

        $originalDate = $row['ReceiptDate'];
        $newDate = date("Y-m-d h:i", strtotime($originalDate));
        echo "<td class='text-center'>{$newDate}</td>";

        echo "<td class='text-center'>{$row['CustomerName']}</td>";
        echo "<td class='text-center' id='price'>{$row['TotalPrice']}</td>";

        if ($row['Channel'] == "Transfer") echo "<td class='text-center'><img src='../pictures/admin/transfer.png' width='25' alt='โอนเงิน'></td>";
        else echo "<td class='text-center'><img src='../pictures/admin/truck.png' width='25' alt='เก็บเงินปลายทาง'></td>";

        if ($row['Status'] == "Pending") {
          echo "<td class='text-center' id='status'>";
          echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #f4e47c; margin-left: 6%'>";
          echo "<span style='font-size: 80%;'>{$statusT[0]}</span>";
          echo "</div>";
          echo "</td>";

          echo "<td class='text-center align-middle' id='remove'>";
          echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
          echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
          echo "<input type='hidden' name='status' value='{$status[1]}'>";
          echo "<button type='submit' class='btn btn-outline-dark' style='font-size: 80%;'>{$statusT[1]}</button>";
          echo "</form>";
          echo "</td>";
        } elseif ($row['Status'] == "Paid") {
          echo "<td class='text-center' id='status'>";
          echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #a9bcff; margin-left: 6%'>";
          echo "<span style='font-size: 80%;'>{$statusT[1]}</span>";
          echo "</div>";
          echo "</td>";

          echo "<td class='text-center align-middle' id='remove'>";
          echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
          echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
          echo "<input type='hidden' name='status' value='{$status[3]}'>";
          echo "<button type='submit' class='btn btn-outline-dark' style='font-size: 80%;'>{$statusT[3]}</button>";
          echo "</form>";
          echo "</td>";
        } elseif ($row['Status'] == "COD") {
          echo "<td class='text-center' id='status'>";
          echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #c1d3ff; margin-left: 6%'>";
          echo "<span style='font-size: 80%;'>{$statusT[2]}</span>";
          echo "</div>";
          echo "</td>";

          echo "<td class='text-center align-middle' id='remove'>";
          echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
          echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
          echo "<input type='hidden' name='status' value='{$status[4]}'>";
          echo "<button type='submit' class='btn btn-outline-dark' style='font-size: 80%;'>{$statusT[3]}</button>";
          echo "</form>";
          echo "</td>";
        } elseif ($row['Status'] == "Delivered") {
          echo "<td class='text-center' id='status'>";
          echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #a0d2c7; margin-left: 6%'>";
          echo "<span style='font-size: 80%;'>{$statusT[3]}</span>";
          echo "</div>";
          echo "</td>";

          echo "<td class='text-center align-middle' id='remove'>";
          echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
          echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
          echo "<input type='hidden' name='status' value='{$status[5]}'>";
          echo "<button type='submit' class='btn btn-outline-dark' style='font-size: 80%;'>{$statusT[5]}</button>";
          echo "</form>";
          echo "</td>";
        } elseif ($row['Status'] == "DI") {
          echo "<td class='text-center' id='status'>";
          echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #d4bbff; margin-left: 6%'>";
          echo "<span style='font-size: 80%;'>{$statusT[4]}</span>";
          echo "</div>";
          echo "</td>";

          echo "<td class='text-center align-middle' id='remove'>";
          echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
          echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
          echo "<input type='hidden' name='status' value='{$status[5]}'>";
          echo "<button type='submit' class='btn btn-outline-dark' style='font-size: 80%;'>{$statusT[5]}</button>";
          echo "</form>";
          echo "</td>";
        } elseif ($row['Status'] == "Completed") {
          echo "<td class='text-center' id='status'>";
          echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #cec8c8; margin-left: 6%'>";
          echo "<span style='font-size: 80%;'>{$statusT[5]}</span>";
          echo "</div>";
          echo "</td>";

          echo "<td class='text-center align-middle' id='remove'>";
          echo "-";
          echo "</td>";
        } elseif ($row['Status'] == "Returned") {
          echo "<td class='text-center' id='status'>";
          echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #f88861; margin-left: 6%'>";
          echo "<span style='font-size: 80%;'>{$statusT[6]}</span>";
          echo "</div>";
          echo "</td>";

          echo "<td class='text-center align-middle' id='remove'>";
          echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
          // echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
          // echo "<input type='hidden' name='status' value='{$status[3]}'>";
          echo "<button type='button' class='btn btn-outline-danger' style='font-size: 80%;'>ดูรายละเอียด</button>";
          echo "</form>";
          echo "</td>";
        } elseif ($row['Status'] == "Cancel") {
          echo "<td class='text-center' id='status'>";
          echo "<div class='d-flex align-items-center justify-content-center rounded' style='width: 7rem; height: 3rem; background-color: #ed8b8b; margin-left: 6%'>";
          echo "<span style='font-size: 80%;'>{$statusT[7]}</span>";
          echo "</div>";
          echo "</td>";

          echo "<td class='text-center align-middle' id='remove'>";
          echo "<form method='post' action='../admin/back/dbUpdateStatusOrder.php'>";
          // echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
          // echo "<input type='hidden' name='status' value='{$status[3]}'>";
          echo "<button type='button' class='btn btn-outline-danger' style='font-size: 80%;'>ดูรายละเอียด</button>";
          echo "</form>";
          echo "</td>";
        }


        echo "<td class='text-center' id='remove'>";
        echo "<form method='post' action='../frontStore/ExportToPDF.php'>";
        echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
        echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/search-normal.png' width='30'></button>";
        echo "</form>";
        echo "<form method='post' action='../admin/back/ExportToPDF.php'>";
        echo "<input type='hidden' name='recID' value='{$row['ReceiptID']}'>";
        echo "<button type='submit' style='border: none; background: none;'><img src='../pictures/admin/printer.png' width='30'></button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function() {
    /* ถ้ากด id selectAllCheckbox */
    $('#selectAllCheckbox').change(function() {
      $('.selectCheckbox').prop('checked', $(this).prop('checked'));
    });

    $('.selectCheckbox').change(function() {
      if ($('.selectCheckbox:checked').length == $('.selectCheckbox').length) {
        $('#selectAllCheckbox').prop('checked', true);
      } else {
        $('#selectAllCheckbox').prop('checked', false);
      }
    });

    /* export Report */
    $('#export').click(function() {
      /* Header */
      var csvContent = "\uFEFFรายงานการสั่งซื้อ\n\n";
      /* รวมทุกOrder ไม่รวมยกเลิก, เฉพาะโอน, เฉพาะเก็บปลายทาง, โดนยกเลิก หรือ คืนของ */
      let totalOrder = 0.0,
        transfer = 0.0,
        cod = 0.0,
        cancle = 0.0;
      let countOrder = 0,
        countCancle = 0.0;
      /* ส่วนของหัวตาราง */
      var tableData = ",เลขที่ใบเสร็จ,วันที่สั่งซื้อ,ชื่อผู้สั่ง,ราคาทั้งหมด,การชำระเงิน,สถานะ\n";
      var count = 0;
      /* data ในตาราง */
      $('#dataTable tbody tr').each(function() {
        /* อันที่ถูก check */
        if ($(this).find('.selectCheckbox').prop('checked')) {
          var rowData = $(this).find('th,td:not([id^="remove"])').map(function() {
            if ($(this).index() === 6) {
              return $(this).find('img').attr('src') == "../pictures/admin/transfer.png" ? "โอนเงิน" : "เก็บเงินปลายทาง";
            }
            return $(this).text();
          }).get().join(",");
          tableData += rowData + "\n";
          count++;

          /* ส่วนของreport */
          var statusText = $(this).find('td#status span').text().trim();
          if (statusText !== "สินค้าถูกส่งคืน" && statusText !== "ยกเลิกคำสั่งซื้อ") {
            countOrder++;
            totalOrder += parseFloat($(this).find('td#price').text());

            /* โอน หรือ ปลายทาง */
            var channleText = $(this).find('img').attr('src');
            if (channleText == "../pictures/admin/transfer.png") {
              transfer += parseFloat($(this).find('td#price').text());
            } else {
              cod += parseFloat($(this).find('td#price').text());
            }
          } else {
            countCancle++;
            cancle += parseFloat($(this).find('td#price').text());
          }
        }
        /* ถ้าไม่มีอันที่ถูก check เลย */
        if (count === 0) {
          var rowData = $(this).find('th,td:not([id^="remove"])').map(function() {
            if ($(this).index() === 6) {
              return $(this).find('img').attr('src') == "../pictures/admin/transfer.png" ? "โอนเงิน" : "เก็บเงินปลายทาง";
            }
            return $(this).text();
          }).get().join(",");
          tableData += rowData + "\n";

          /* ส่วนของreport */
          var statusText = $(this).find('td#status span').text().trim();
          if (statusText !== "สินค้าถูกส่งคืน" && statusText !== "ยกเลิกคำสั่งซื้อ") {
            countOrder++;
            totalOrder += parseFloat($(this).find('td#price').text());
            /* โอน หรือ ปลายทาง */
            var channleText = $(this).find('img').attr('src');
            if (channleText == "../pictures/admin/transfer.png") {
              transfer += parseFloat($(this).find('td#price').text());
            } else {
              cod += parseFloat($(this).find('td#price').text());
            }
          } else {
            countCancle++;
            cancle += parseFloat($(this).find('td#price').text());
          }
        }
      });
      var summary = "รายการสั่งซื้อทั้งหมด:," + countOrder + ",รายการ,,เป็นจำนวนเงิน:," + totalOrder + ",บาท,(ไม่รวมการยกเลิก หรือ คืนสินค้า)";
      summary += "\nรายการที่ถูกยกเลิก หรือ คืนสินค้า," + countCancle + ",รายการ,,เป็นจำวนเงิน:," + cancle + ",บาท";
      summary += "\nจำนวนเงินที่ต้องได้รับจากการโอน:," + transfer + ",บาท,,จำนวนเงินที่ต้องได้รับจากการเก็บเงินปลายทาง:," + cod + ",บาท\n\n";
      csvContent += summary;
      csvContent += tableData;

      var blob = new Blob([csvContent], {
        type: 'text/csv;charset=utf-8;'
      });
      saveAs(blob, 'Report-Order.csv');
    });
  });
</script>