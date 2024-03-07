<?php
require_once('../vendor/autoload.php');

session_start();
require '../components/ConnectDB.php';
require 'Insert_log.php';

if (empty($_POST["recID"])) {
    $receiptCode = $_SESSION['ReceiptCode'];
    // unset($_SESSION['ReceiptCode']);
    $sql = "SELECT RecvID FROM receipt WHERE RecID = '$receiptCode'";
    $result = mysqli_query($connectDB, $sql);
    $row = mysqli_fetch_assoc($result);
    $RecvID = $row['RecvID'];
} else {
    $receiptCode = $_POST["recID"];
    $sql = "SELECT RecvID FROM receipt WHERE RecID = '$receiptCode'";
    $result = mysqli_query($connectDB, $sql);
    $row = mysqli_fetch_assoc($result);
    $RecvID = $row['RecvID'];
}

InsertLog($_SESSION['userID'], "Export to PDF: " . $receiptCode, "ExportToPDF.php");

$sql = "SELECT TaxID FROM receipt WHERE RecID = '$receiptCode'";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$payerTaxID = $row['TaxID'];

$sql = "SELECT r.RecID, r.PayTime, r.CusID, r.RecvID, p.PayerFName, p.PayerLName, p.Sex, p.Tel, p.Address
        FROM receipt r 
        JOIN payer p ON r.RecID = '$receiptCode' AND p.TaxID = '$payerTaxID'";
$result = mysqli_query($connectDB, $sql);

$row = mysqli_fetch_assoc($result);
$payerID = $row["CusID"];
$payerAddress = $row['Address'];
$payerFName = $row['PayerFName'];
$payerLName = $row['PayerLName'];
$payerSex = $row['Sex'];
$payerTel = $row['Tel'];

$payTime = $row['PayTime'];
$payDate = date('Y-m-d', strtotime($payTime));



// Create a new TCPDF object
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Disable automatic header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set the font to 'sarabun'
$pdf->SetFont('sarabun', '', 12);

// Add a page
$pdf->AddPage();

$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(true, 20);

$pdf->Image('../Pictures/logo.png', 20, 10, 30, 25);

$pdf->SetXY(20, 30);

$pdf->Cell(60, 10, 'บริษัท เอสมิติช้อป จำกัด(สำนักงานใหญ่)', 0, 0, 'L');

$pdf->SetXY(130, 30);

$pdf->SetFont('sarabun', '', 15);

$pdf->Cell(60, 10, 'ใบเสร็จรับเงิน/ใบกำกับภาษี', 0, 1, 'R');

$pdf->SetFont('sarabun', '', 9);

$pdf->SetXY(20, 35);

$pdf->Cell(60, 10, '999 หมู่ 999 ถ.ฉลองกรุง 9999 แขวงลาดกระบัง', 0, 0, 'L');

$pdf->SetXY(130, 35);

$pdf->Cell(60, 10, 'Receipt/Tax Invoice', 0, 0, 'C');

$pdf->SetXY(20, 40);

$pdf->Cell(60, 10, 'เขตลาดกระบัง กรุงเทพมหานคร 10500', 0, 0, 'L');

$pdf->SetXY(130, 40);

$pdf->Cell(60, 10, 'ต้นฉบับ', 0, 0, 'C');

$pdf->SetXY(20, 45);

$pdf->Cell(60, 10, 'เลขประจำตัวผู้เสียภาษี 12345678909999', 0, 1, 'L');

$pdf->SetXY(20, 50);

$pdf->Cell(60, 10, 'โทร. 0123456789 อีเมล smiti@test.com', 0, 0, 'L');

$pdf->SetFont('sarabun', '', 10);

$pdf->SetXY(20, 60);

$pdf->Cell(60, 10, "ลูกค้า: ", 0, 0, 'L');

$pdf->SetFont('sarabun', '', 9);

$pdf->SetXY(30, 60);

$pdf->Cell(60, 10, "" . $payerFName . " " . $payerLName . "", 0, 0, 'L');

$pdf->SetFont('sarabun', '', 10);

$pdf->SetXY(130, 60);

$pdf->Cell(60, 10, "เลขที่: ", 0, 0, 'L');

$pdf->SetFont('sarabun', '', 9);

$pdf->SetXY(140, 60);

$pdf->Cell(60, 10, "" . $receiptCode . "", 0, 0, 'L');

$pdf->SetFont('sarabun', '', 10);

$pdf->SetXY(20, 65);

$pdf->Cell(60, 10, "ที่อยู่: ", 0, 0, 'L');

$pdf->SetXY(30, 65);

$pdf->Cell(60, 10, "" . $payerAddress . "", 0, 0, 'L');

$pdf->SetFont('sarabun', '', 10);

$pdf->SetXY(130, 65);

$pdf->Cell(60, 10, "วันที่: ", 0, 0, 'L');

$pdf->SetFont('sarabun', '', 9);

$pdf->SetXY(140, 65);

$pdf->Cell(60, 10, "" . $payDate . "", 0, 0, 'L');

$pdf->SetFont('sarabun', '', 10);

$pdf->SetXY(20, 70);

$pdf->Cell(60, 10, "เลขประจำตัวผู้เสียภาษี: ", 0, 0, 'L');

$pdf->SetXY(55, 70);

$pdf->Cell(60, 10, "123456789123", 0, 0, 'L');

$pdf->SetFont('sarabun', '', 10);

$pdf->SetXY(20, 75);

$pdf->Cell(60, 10, "โทร: ", 0, 0, 'L');

$pdf->SetXY(30, 75);

$pdf->Cell(60, 10, "" . $payerTel  . "", 0, 0, 'L');

$pdf->SetFont('sarabun', '', 10);

$pdf->SetXY(55, 75);

$pdf->Cell(60, 10, "อีเมล: ", 0, 0, 'L');

$pdf->SetXY(65, 75);

$pdf->Cell(60, 10, "testuser@test.com", 0, 1, 'L');

$pdf->Cell(170, 10, "", 'T', 1, 'L');

$sql = "SELECT r.NumID, r.ProID, r.Qty, p.ProName, p.PricePerUnit 
FROM receipt_list r 
JOIN product p ON r.ProID = p.ProID 
WHERE r.RecID = '$receiptCode'";
$result = mysqli_query($connectDB, $sql);

$orderProducts = array();
while ($orderProductRow = mysqli_fetch_array($result)) {
    $orderProducts[] = $orderProductRow;
}

$totalPrice = 0;
$id = 1;

$html = "
<table style='width: 100%;'>
<tr>
    <th style='width: 5%'>ลำดับ</th>
    <th style='width: 40%'>รายการสินค้า</th>
    <th style='width: 10%'>จำนวน</th>
    <th style='width: 15%'>ราคาต่อหน่วย</th>
    <th style='width: 15%'>จำนวนเงิน</th>
</tr>";

foreach ($orderProducts as $orderProductRow) {
    $productName = $orderProductRow['ProName'];
    $qty = $orderProductRow['Qty'];
    $pricePerUnit = $orderProductRow['PricePerUnit'];
    $total = $orderProductRow['PricePerUnit'] * $orderProductRow['Qty'];

    $html .= "<tr>
    <td style='padding-top: 50px'>" . $id . "</td>
    <td style='padding-top: 50px'>" . $productName . "</td>
    <td style='padding-top: 50px'>" . $qty . "</td>
    <td style='padding-top: 50px'>฿" . $pricePerUnit . "</td>
    <td style='padding-top: 50px'>" . $total . " บาท</td>
    </tr>";

    $totalPrice += $orderProductRow['PricePerUnit'] * $orderProductRow['Qty'];
    $id++;
}

$html .= "</table>";

$vat = $totalPrice * 0.07;
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Cell(170, 10, "", 'T', 1, 'L');

$pdf->Cell(0, 10, 'หมายเหตุ', 0, 0, 'L');
$pdf->Cell(0, 10, 'ส่วนลด 0 บาท', 0, 1, 'R');

$totalPriceFormat = number_format($totalPrice, 2);

$pdf->Cell(0, 10, 'รวมเป็นเงิน ' . $totalPriceFormat . ' บาท', 0, 1, 'R');
$pdf->Cell(0, 10, 'ภาษีมูลค่าเพิ่ม 7% ' . $vat . ' บาท', 0, 1, 'R');
$pdf->Cell(0, 10, 'ผู้รับเงิน บริษัท เอสมิติช้อป จำกัด(สำนักงานใหญ่)', 0, 0, 'L');

$totalPrice += $vat;
$totalPriceFormat = number_format($totalPrice, 2);

$pdf->Cell(0, 10, 'จำนวนเงินทั้งสิ้น ' . $totalPriceFormat . ' บาท', 0, 1, 'R');


// Output the PDF
$pdf->Output('receipt.pdf', 'I');


// $html = "
// <table style='width: 100%'>
// <tr style='padding: 10px 0;'>
//     <td>
//     <h3><b>บริษัท เอสมิติช้อป จำกัด(สำนักงานใหญ่)</b></h3>
//     <h5>999 หมู่ 999 ถ.ฉลองกรุง 9999 แขวงลาดกระบัง</h5>
//     <h5 style='text-align:left;'>เขตลาดกระบัง กรุงเทพมหานคร 10500</h5>
//     <h5 style='text-align:left;'>เลขประจำตัวผู้เสียภาษี 12345678909999</h5>
//     <h5 style='text-align:left;'>โทร. 0123456789 อีเมล smiti@test.com</h5>
//     </td>

//     <td>
//     <h3 style='text-align:center;'><b>ใบเสร็จรับเงิน/ใบกำกับภาษี</b></h3>
//     <h5 style='text-align:center;'>Receipt/Tax Invoice</h5>
//     <h5 style='text-align:center;'><b>ต้นฉบับ</b></h5>
//     </td>
// </tr>
// <tr style='padding: 10px 0;'>
//     <td>
//         <h5 align='left'><b>ลูกค้า</b> " . $payerFName . " " . $payerLName . " </h5>
//         <h5 align='left'><b>ที่อยู่</b> " . $cusAddress . "</h5>
//         <h5 align='left'><b>เลขประจำตัวผู้เสียภาษี</b> 123456789123</h5>
//         <h5 align='left'><b>โทร</b> " . $cusTel  . " <b>อีเมล </b> testuser@test.com </h5>
//     </td>
//     <td>
//         <h5 style='margin-left: 150px'><b>เลขที่</b> " . $receiptCode . "</h5>
//         <h5 style='margin-left: 150px'><b>วันที่</b> " . $payDate . "</h5>
//     </td>
// </tr>
// </table>

// <div style='height: 50px;'></div>";

// $pdf->writeHTML($html, true, false, true, false, '');  

// $sql = "SELECT r.NumID, r.ProID, r.Qty, p.ProName, p.PricePerUnit 
// FROM receipt_list r 
// JOIN product p ON r.ProID = p.ProID 
// WHERE r.RecID = '$receiptCode'";
// $result = mysqli_query($connectDB, $sql);

// $totalPrice = 0;
// $id = 1;

// while ($orderProductRow = mysqli_fetch_array($result)) {
//     $productName = $orderProductRow['ProName'];
//     $qty = $orderProductRow['Qty'];
//     $pricePerUnit = $orderProductRow['PricePerUnit'];
//     $total = $orderProductRow['PricePerUnit'] * $orderProductRow['Qty'];

//     $html = "
//     <td>" . $id . "</td>
//     <td>" . $productName . "</td>
//     <td>" . $qty . "</td>
//     <td>฿" . $pricePerUnit . "</td>
//     <td>" . $total . "บาท</td>
//     </tr>";

//     $totalPrice += $orderProductRow['PricePerUnit'] * $orderProductRow['Qty'];
//     $id++;
//     $pdf->writeHTML($html, true, false, true, false, '');
// }

// $html = "</table>";
// $pdf->writeHTML($html, true, false, true, false, '');