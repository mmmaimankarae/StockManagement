<?php
require_once('../vendor/autoload.php');

session_start();
require '../components/ConnectDB.php';

$RecvID = $_SESSION['RecvID'];

$receiptCode = $_SESSION['ReceiptCode'];
$sql = "SELECT r.RecvID, r.RecvFName, r.RecvLName, r.Sex, r.Tel, r.Address, ro.CusID
        FROM receiver r 
        JOIN receiver_list ro ON r.RecvID = '$RecvID' AND r.RecvID = ro.RecvID";

$result = mysqli_query($connectDB, $sql);

$row = mysqli_fetch_assoc($result);
$cusID = $row["CusID"];
$cusAddress = $row['Address'];
$cusFName = $row['RecvFName'];
$cusLName = $row['RecvLName'];
$cusSex = $row['Sex'];
$cusTel = $row['Tel'];

$sql = "SELECT paytime FROM receipt WHERE RecID = '$receiptCode'";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);
$payTime = $row['paytime'];
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

$html = "
<table width='100%'>
<tr style='padding: 10px 0;'>
    <th></th>
    <th></th>
</tr>
<tr style='padding: 10px 0;'>
    <td><h3><b>บริษัท เอสมิติช้อป จำกัด(สำนักงานใหญ่)</b></h3>
    <h5 >999 หมู่ 999 ถ.ฉลองกรุง 9999 แขวงลาดกระบัง</h5>
    <h5 align='left'>เขตลาดกระบัง กรุงเทพมหานคร 10500</h5>
    <h5 align='left'>เลขประจำตัวผู้เสียภาษี 12345678909999</h5>
    <h5 align='left'>โทร. 0123456789 อีเมล smiti@test.com</h5>
    </td>

    <td><h3 align='center'><b>ใบเสร็จรับเงิน/ใบกำกับภาษี</b></h3>
    <h5 align='center'>Receipt/Tax Invoice</h5>
    <h5 align='center'><b>ต้นฉบับ</b></h5>
    </td>
</tr>
<tr style='padding: 10px 0;'>
    <td>
        <h5 align='left'><b>ลูกค้า</b> " . $cusFName . " " . $cusLName . " </h5>
        <h5 align='left'><b>ที่อยู่</b> " . $cusAddress . "</h5>
        <h5 align='left'><b>เลขประจำตัวผู้เสียภาษี</b> 123456789123</h5>
        <h5 align='left'><b>โทร</b> " . $cusTel  . " <b>อีเมล </b> testuser@test.com </h5>
    </td>
    <td>
        <h5 style='margin-left: 150px'><b>เลขที่</b> " . $receiptCode . "</h5>
        <h5 style='margin-left: 150px'><b>วันที่</b> " . $payDate . "</h5>
    </td>
</tr>
</table>

<table class='table table-bordered' style='margin-top:30px;width: 100%;'>
<tr>
    <th style='width: 5%'>ลำดับ</th>
    <th style='width: 40%'>รายการสินค้า</th>
    <th style='width: 10%'>จำนวน</th>
    <th style='width: 15%'>ราคาต่อหน่วย</th>
    <th style='width: 15%'>จำนวนเงิน</th>
</tr>
";
$pdf->writeHTML($html, true, false, true, false, '');


// Output the PDF
$pdf->Output('receipt.pdf', 'I');
