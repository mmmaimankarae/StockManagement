<?php
session_start();
require '../components/ConnectDB.php';
include "../components/HeaderStore.html";

$prodID = $_GET['id'];
$userID = $_SESSION['userID'];


// -------------------------------------- Insert Access Log --------------------------------------
$sql = "SELECT `NumID` FROM `access_log` WHERE `CusID` = '$userID' ORDER BY `NumID` DESC LIMIT 1";
$result = mysqli_query($connectDB, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
  $NumID = $row['NumID'];
  $NumID += 1;
} else {
  $NumID = 1;
}

$sql = "INSERT INTO `access_log`(`CusID`, `NumID`, `Action`, `Period`) VALUES ('$userID','$NumID', 'access product detail id $prodID', NOW())";
$result = mysqli_query($connectDB, $sql);

// -------------------------------------- Insert Access Log --------------------------------------

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sarabun&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.3/dist/xlsx.full.min.js"></script>
  <title>SMITI Shop:Product Detail</title>
</head>

<style>
  .product-quantity-input {
    width: 10%;
  }
</style>

<body class="p-3" style="margin-top: 6%">
  <?php
  echo "<a href='Store.php' class='backButton' style='margin-left: 7%;font-family:sarabun;  color:green; text-decoration:none;'><b>⬅️ กลับไปหน้าร้านค้า</b></a>";
  $msquery = "SELECT * FROM PRODUCT WHERE ProID = " . $prodID . ";";
  $msresults = mysqli_query($connectDB, $msquery);
  $row = mysqli_fetch_array($msresults);
  if ($row) {
    echo "<form id='add-to-cart-form' action='AddtoCart.php' method='POST'>";
    echo "<div class='container'>";
    echo "<div class='row'>";
    echo "<div class='col'>";
    echo "<img src='" . $row['ImageSource'] . "' width='500' height='500' class='img-thumbnail shadow-sm'>";
    echo "</div>";
    echo "<div class='col'>";
    echo "<div class='mb-3'>";
    echo "<label class='my-2'><b style='font-family:sarabun; font-size: 20px;'>ชื่อสินค้า</b></label>";
    echo "<h4 style='font-size: 20px; font-family:sarabun;'> " . $row['ProName'] . "</h4>";
    echo "</div>";

    echo "<div class='mb-3 my-3'>";
    echo "<label class='my-2'><b style='font-family:sarabun; font-size: 20px;'>คำอธิบายสินค้า</b></label>";
    echo "<p style='font-size: 20px; font-family:sarabun;'> " . $row['Description'] . "</p>";
    echo "</div>";

    echo "<div class='row'>";
    echo "<div class='col'>";
    echo "<label class='my-2' style='font-family:sarabun; font-size: 20px;'><b>ราคาขายต่อหน่วย (บาท/หน่วย)</b></label>";
    echo "<h4 style='font-size: 20px; font-family:sarabun;'>฿" . $row['PricePerUnit'] . "</h4>";
    echo "</div>";
    echo "</div>";

    echo "<div class='row g-3 align-items-center'>";
    echo "<div class='row-auto'>";
    echo "<label class='my-2' style='font-family:sarabun; font-size: 20px;'><b>จำนวนสินค้าที่ต้องการ</b></label>";
    echo "</div>";
    echo "<div class='col-auto'>";
    echo "<input type='number' id='Quantity' name='Quantity' class='form-control' value='1' min='1' max='" . $row['StockQty'] . "'>";
    echo "</div>";
    echo "<div class='col-auto'>";
    echo "<span id='StockQty' class='form-text' style='font-family:sarabun;'>";
    echo "จำนวนสินค้าคงเหลือ " . $row['StockQty'] . " หน่วย";
    echo "</span>";
    echo "</div>";
    echo "</div>";

    echo "<div class='row mt-5' style='text-align:center;'>";
    echo "<div class='col'>";
    echo "<input type='hidden' name='ProName' value='" . $row['ProName'] . "'>";
    // echo "<button class='btn btn-success me-5' type='submit'><i class='fas fa-shopping-cart'></i> เพิ่มสินค้าลงตะกร้า</button>";
    echo "<button class='btn btn-success me-5' type='button' onclick='insertLog()'><i class='fas fa-shopping-cart'></i> เพิ่มสินค้าลงตะกร้า</button>";

    echo "</div>";
    echo "</div>";


    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</form>";
  }
  mysqli_close($connectDB);
  ?>

  <script>
    function insertLog() {

      var quantity = parseInt(document.getElementById('Quantity').value);
      var stockQty = parseInt('<?php echo $row['StockQty']; ?>');

      if (quantity > stockQty) {
        alert('จำนวนสินค้าที่คุณเลือกมากกว่าจำนวนสินค้าในสต็อก');
        return;
      }

      $.ajax({
        type: "POST",
        url: "Insert_log.php", // URL of the PHP file that will insert the log
        data: {
          userID: '<?php echo $userID; ?>',
          insertType: 'add to cart product id <?php echo $prodID; ?>'
        },
        success: function(data) {
          document.getElementById('add-to-cart-form').submit();
        }
      });
    }
  </script>

</body>

</html>