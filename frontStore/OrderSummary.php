<?php
session_start();
require '../components/ConnectDB.php';
require '../components/HeaderStore.html';

$userID = $_SESSION['userID'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>SMITI Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sarabun&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<style>
    .mt-custom {
        margin-top: 80px;
        margin-left: 80px;
        margin-right: 80px;
    }

    .mt-custom textarea {
        width: 100%;
        height: 15%;
        resize: none;
    }

    .headbar {
        display: flex;
        justify-content: space-between;
        border-bottom: 3px solid black;
        margin-top: 30px;
    }

    .shopping-cart {
        margin-left: 0px;
        padding-bottom: 10px;
    }

    .input-group {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        font-family: sarabun;
        text-align: center;
    }

    table.orderSummary {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        font-family: sarabun;
    }

    th.img {
        width: 280px;
    }

    tr.product:hover {
        background-color: #f5f5f5;
    }

    textarea {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 30px;
        font-family: sarabun;
    }

    input {
        font-family: sarabun;
    }

    .form-label {
        font-family: sarabun;
    }

    .form-check {
        border: 1px solid #f5f5f5;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 40px;
        margin-bottom: 10px;
        border-radius: 5px;
        font-family: sarabun;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .fas {
        font-size: 20px;
        margin-right: 10px;
    }

    .far {
        font-size: 20px;
        margin-right: 10px;
    }

    #firstName::placeholder {
        font-family: sarabun;
    }

    #lastName::placeholder {
        font-family: sarabun;
    }

    #telNumber::placeholder {
        font-family: sarabun;
    }

    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap");

    .container {

        height: 100vh;
    }

    .progresses {
        display: flex;
        align-items: center;
    }

    .line {

        width: 120px;
        height: 6px;
        background: #63d19e;
    }

    .steps {

        display: flex;
        background-color: #63d19e;
        color: #fff;
        font-size: 14px;
        width: 40px;
        height: 40px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .my-custom-hr {
        border-top: 2px solid #000000;
    }
</style>

<body>

    <?php


    echo "<div class='mt-custom'>";
    echo "<a href='Cart.php' style='font-family:sarabun; color:green; text-decoration:none;'><b>⬅️ กลับไปยังตะกร้าสินค้า</b></a>";
    echo "<div class='headbar'>
    <b class='shopping-cart' style='font-family:sarabun; font-size:30px'>Order Summary</b>
    <b class='item-count' style='font-family:sarabun; font-size:30px'>" . count($_SESSION['cart']) . " Item</b>
    </div>
    ";
    echo "<form id='to-payment' action='OrderInsert.php' method='POST'>";
    echo "<div class='container'>";
    echo "<div class='row'>";

    if ($_SESSION['userType'] == 'member') {
        displayMemberCartTable($_SESSION['cart'], count($_SESSION['cart']) > 0);
    } else if ($_SESSION['userType'] == 'guest') {
        displayGuestCartTable($_SESSION['cart'], count($_SESSION['cart']) > 0);
    }

    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</form>";

    function displayGuestCartTable($cartItems, $hasItem)
    {
        $totalPrice = 0;
        foreach ($cartItems as $cart) {
            $totalPrice += $cart['ProPrice'] * $cart['quantity'];
        }

        echo "<div class='col-md-8' style='margin-right: 20px;'>";

        echo "<div class='row' style='margin-top: 15px'>";

        echo "<div class'row'>";
        echo "<label style='font-size: 20px;' class='form-label'><b>ข้อมูลผู้ส่ง</b></label>";
        echo "</div>";

        echo "<div class='col'>";
        echo "<label for='payerFirstName' class='form-label'><b>ชื่อ</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกชื่อจริง' id='payerFname' name='payerFname' required>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<label for='payerLastName' class='form-label'><b>นามสกุล</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกนามสกุล' id='payerLname' name='payerLname' required>";
        echo "</div>";
        echo "</div>";

        echo "<div class='row' style='margin-top: 15px'>";
        echo "<div class='col'>";
        echo "<label for='payerTelNumber' class='form-label'><b>เบอร์โทรศัพท์</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกเบอร์โทร' id='payerTelNumber' name='payerTelNumber' required>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<label for='payerGender' class='form-label'><b>เพศ</b></label>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='payerGender' id='male' value='M' required>";
        echo "<label class='form-check-label' for='M' style='font-family: sarabun; margin-left: 10px'>ชาย</label>";
        echo "</div>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='payerGender' id='female' value='F' required>";
        echo "<label class='form-check-label' for='F' style='font-family: sarabun; margin-left: 10px'>หญิง</label>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        echo "<label for='payer_TaxID' style='margin-top: 15px;' class='form-label'><b>เลขประจำตัวผู้เสียภาษี</b></label>";
        echo "<input type='text' class='form-control' id='payer_TaxID' name='payer_TaxID' placeholder='กรุณากรอกเลขประจำตัวผู้เสียภาษี'>";

        echo "<label for='payerAddr' style='margin-top: 15px;' class='form-label'><b>ที่อยู่ผู้ส่ง</b></label>";
        echo "<input type='text' class='form-control' id='payerAddress' name='payerAddress' placeholder='กรุณากรอกที่อยู่ผู้ส่ง'>";

        echo "<hr class='my-custom-hr'>";

        echo "<div class'row'>";
        echo "<label style='font-size: 20px;' class='form-label'><b>ข้อมูลผู้รับ</b></label>";
        echo "</div>";

        echo "<div class='row' style='margin-top: 15px'>";
        echo "<div class='col'>";
        echo "<label for='receiverFirstName' class='form-label'><b>ชื่อ</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกชื่อจริง' id='receiverFname' name='receiverFname' required>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<label for='receiverLastName' class='form-label'><b>นามสกุล</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกนามสกุล' id='receiverLname' name='receiverLname' required>";
        echo "</div>";
        echo "</div>";

        echo "<div class='row' style=''>";
        echo "<div class='col'>";
        echo "<label for='receiverTelNumber' class='form-label'><b>เบอร์โทรศัพท์</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกเบอร์โทร' id='receiverTelNumber' name='receiverTelNumber' required>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<label for='receiverGender' class='form-label'><b>เพศ</b></label>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='receiverGender' id='male' value='M' required>";
        echo "<label class='form-check-label' for='M' style='font-family: sarabun; margin-left: 10px'>ชาย</label>";
        echo "</div>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='receiverGender' id='female' value='F' required>";
        echo "<label class='form-check-label' for='F' style='font-family: sarabun; margin-left: 10px'>หญิง</label>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        echo "<label for='receiverAddr' style='margin-top: 15px;' class='form-label'><b>ที่อยู่ผู้ส่ง</b></label>";
        echo "<input type='text' class='form-control' id='receiverAddress' name='receiverAddress' placeholder='กรุณากรอกที่อยู่ผู้รับ'>";

        echo "<hr class='my-custom-hr'>";

        echo "<div class'row'>";
        echo "<label for='paymentMethod' style='font-size:20px' class='form-label'><b>ช่องทางการชำระเงิน</b></label>";
        echo "<div class='form-check'>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='paymentMethod' id='creditCard' value='Creditcard' required>";
        echo "<label class='form-check-label' for='creditCard'>Credit Card</label>";
        echo "</div>";
        echo "<i class='far fa-credit-card'></i>";
        echo "</div>";

        echo "<div class='form-check'>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='paymentMethod' id='debitCard' value='debitCard' required>";
        echo "<label class='form-check-label' for='debitCard'>โอนผ่านช่องทางธนาคาร</label>";
        echo "</div>";
        echo "<i class='fas fa-university'></i>";
        echo "</div>";

        echo "<div class='form-check'>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='paymentMethod' id='COD' value='COD' required>";
        echo "<label class='form-check-label' for='COD'>ชำระเงินปลายทาง</label>";
        echo "</div>";
        echo "<i class='fas fa-shipping-fast'></i>";
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<label for='itemList' style='margin-top: 15px;' class='form-label'><b>รายการสินค้า</b></label>";
        echo "</div>";

        echo "<table>";
        if ($hasItem) {
            echo "<tr>";
            echo "<th class='img'></th>";
            echo "<th>Name</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "</tr>";
            foreach ($cartItems as $cart) {
                echo "<tr class='product'>";
                echo "<td class='img'><img src='" . $cart['ProPic'] . "' width='100' height='100'></td>";
                echo "<td>" . $cart['ProName'] . "</td>";
                echo "<td>฿" . $cart['ProPrice'] . "</td>";
                // echo "<td>" . $cart['quantity'] . "</td>";

                echo "<td>";;
                echo "" . $cart['quantity']  . "";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr>";
            echo "<td colspan='6' style='text-align:center; font-size: 30px'><b>ไม่มีสินค้าในตะกร้า</b></td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
        echo "<div class='col-md-3'>";
        displayOrderSummary($_SESSION['cart']);
        echo "</div>";
    }

    function displayMemberCartTable($cartItems, $hasItem)
    {
        require '../components/ConnectDB.php';
        $totalPrice = 0;
        foreach ($cartItems as $cart) {
            $totalPrice += $cart['ProPrice'] * $cart['quantity'];
        }

        $sql = "SELECT * FROM customer WHERE CusID = " . $_SESSION['userID'];
        $result = mysqli_query($connectDB, $sql);
        $row = mysqli_fetch_array($result);


        echo "<div class='col-md-8' style='margin-right: 20px;'>";

        echo "<div class='row' style='margin-top: 15px'>";

        echo "<div class'row'>";
        echo "<label style='font-size: 20px;' class='form-label'><b>ข้อมูลผู้ส่ง</b></label>";
        echo "</div>";

        echo "<div class='col'>";
        echo "<label for='payerFirstName' class='form-label'><b>ชื่อ</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกชื่อจริง' id='payerFname' name='payerFname' value='" . $row['CusFName'] . "' required>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<label for='payerLastName' class='form-label'><b>นามสกุล</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกนามสกุล' id='payerLname' name='payerLname' value='" . $row['CusLName'] . "' required>";
        echo "</div>";
        echo "</div>";

        echo "<div class='row' style='margin-top: 15px'>";
        echo "<div class='col'>";
        echo "<label for='payerTelNumber' class='form-label'><b>เบอร์โทรศัพท์</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกเบอร์โทร' id='payerTelNumber' name='payerTelNumber' value='" . $row['Tel'] . "' required>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<label for='payerGender' class='form-label'><b>เพศ</b></label>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='payerGender' id='male' value='M' " . ($row['Sex'] == 'M' ? 'checked' : '') . "  required>";
        echo "<label class='form-check-label' for='M' style='font-family: sarabun; margin-left: 10px'>ชาย</label>";
        echo "</div>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='payerGender' id='female' value='F' value='F' " . ($row['Sex'] == 'F' ? 'checked' : '') . " required>";
        echo "<label class='form-check-label' for='F' style='font-family: sarabun; margin-left: 10px'>หญิง</label>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        echo "<label for='payer_TaxID' style='margin-top: 15px;' class='form-label'><b>เลขประจำตัวผู้เสียภาษี</b></label>";
        echo "<input type='text' class='form-control' id='payer_TaxID' name='payer_TaxID' placeholder='กรุณากรอกเลขประจำตัวผู้เสียภาษี'>";

        echo "<label for='payerAddr' style='margin-top: 15px;' class='form-label'><b>ที่อยู่ผู้ส่ง</b></label>";
        echo "<input type='text' class='form-control' id='payerAddr' name='payerAddress' placeholder='กรุณากรอกที่อยู่ผู้ส่ง' value='" . $row['Address'] . "'>";

        echo "<hr class='my-custom-hr'>";

        echo "<div class'row'>";
        echo "<label style='font-size: 20px;' class='form-label'><b>ข้อมูลผู้รับ</b></label>";
        echo "</div>";

        echo "<div class='row' style=''>";
        echo "<div class='col'>";
        echo "<label for='receiverFirstName' class='form-label'><b>ชื่อ</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกชื่อจริง' id='receiverFname' name='receiverFname' required>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<label for='receiverLastName' class='form-label'><b>นามสกุล</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกนามสกุล' id='receiverLname' name='receiverLname' required>";
        echo "</div>";
        echo "</div>";

        echo "<div class='row' style='margin-top: 15px'>";
        echo "<div class='col'>";
        echo "<label for='receiverTelNumber' class='form-label'><b>เบอร์โทรศัพท์</b></label>";
        echo "<input type='text' class='form-control' placeholder='กรุณากรอกเบอร์โทร' id='receiverTelNumber' name='receiverTelNumber' required>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<label for='receiverGender' class='form-label'><b>เพศ</b></label>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='receiverGender' id='male' value='M' required>";
        echo "<label class='form-check-label' for='M' style='font-family: sarabun; margin-left: 10px'>ชาย</label>";
        echo "</div>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='receiverGender' id='female' value='F' required>";
        echo "<label class='form-check-label' for='F' style='font-family: sarabun; margin-left: 10px'>หญิง</label>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        echo "<label for='receiverAddr' style='margin-top: 15px;' class='form-label'><b>ที่อยู่ผู้รับ</b></label>";
        echo "<input type='text' class='form-control' id='receiverAddress' name='receiverAddress' placeholder='กรุณากรอกที่อยู่ผู้รับ'>";

        echo "<hr class='my-custom-hr'>";

        echo "<div class'row'>";
        echo "<label for='paymentMethod' style='font-size:20px' class='form-label'><b>ช่องทางการชำระเงิน</b></label>";
        echo "<div class='form-check'>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='paymentMethod' id='creditCard' value='Creditcard' required>";
        echo "<label class='form-check-label' for='creditCard'>Credit Card</label>";
        echo "</div>";
        echo "<i class='far fa-credit-card'></i>";
        echo "</div>";

        echo "<div class='form-check'>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='paymentMethod' id='debitCard' value='debitCard' required>";
        echo "<label class='form-check-label' for='debitCard'>โอนผ่านช่องทางธนาคาร</label>";
        echo "</div>";
        echo "<i class='fas fa-university'></i>";
        echo "</div>";

        echo "<div class='form-check'>";
        echo "<div>";
        echo "<input class='form-check-input' type='radio' name='paymentMethod' id='COD' value='COD' required>";
        echo "<label class='form-check-label' for='COD'>ชำระเงินปลายทาง</label>";
        echo "</div>";
        echo "<i class='fas fa-shipping-fast'></i>";
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<label for='itemList' style='margin-top: 15px;' class='form-label'><b>รายการสินค้า</b></label>";
        echo "</div>";

        echo "<table>";
        if ($hasItem) {
            echo "<tr>";
            echo "<th class='img'></th>";
            echo "<th>Name</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "</tr>";
            foreach ($cartItems as $cart) {
                echo "<tr class='product'>";
                echo "<td class='img'><img src='" . $cart['ProPic'] . "' width='100' height='100'></td>";
                echo "<td>" . $cart['ProName'] . "</td>";
                echo "<td>฿" . $cart['ProPrice'] . "</td>";
                // echo "<td>" . $cart['quantity'] . "</td>";

                echo "<td>";;
                echo "" . $cart['quantity']  . "";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr>";
            echo "<td colspan='6' style='text-align:center; font-size: 30px'><b>ไม่มีสินค้าในตะกร้า</b></td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
        echo "<div class='col-md-3'>";
        displayOrderSummary($_SESSION['cart']);
        echo "</div>";
    }

    function displayOrderSummary($cartItems,)
    {
        $totalPrice = 0;
        $discount = 0; // Replace this with your discount calculation
        foreach ($cartItems as $cart) {
            $totalPrice += $cart['ProPrice'] * $cart['quantity'];
        }

        echo "<table class='orderSummary'>";
        echo "<tr>";
        echo "<td style='text-align:left; padding-left: 20px; padding-top: 15px;'>";
        echo "<p><b>Total Price: </b></p>";
        echo "</td>";
        echo "<td style='text-align:right; padding-right: 20px; padding-top: 15px;'>";
        echo "<p>฿" . $totalPrice . "</p>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td style='text-align:left; padding-left: 20px; padding-top: 15px;'>";
        echo "<p><b>Discount:</b></p>";
        echo "</td>";

        $totalPrice -= $discount;
        echo "<td style='text-align:right; padding-right: 20px; padding-top: 15px;'>";
        echo "<p>฿" . $discount . "</p>";
        echo "</td>";

        echo "</tr>";
        echo "<tr>";
        echo "<td style='text-align:left; padding-left: 20px; padding-top: 15px;'>";
        echo "<p><b>Vat(7%):</b></p>";
        echo "</td>";

        $vat = $totalPrice * 0.07;
        echo "<td style='text-align:right; padding-right: 20px; padding-top: 15px;'>";
        echo "<p>฿" . $vat . "</p>";
        echo "</td>";

        echo "</tr>";
        echo "<tr>";
        echo "<td style='text-align:left; padding-left: 20px; padding-top: 15px;'>";
        echo "<p><b>Final Price:</b></p>";
        echo "</td>";

        $totalPrice += $vat;
        echo "<td style='text-align:right; padding-right: 20px; padding-top: 15px;'>";
        echo "<p>฿" . ($totalPrice - $discount) . "</p>";
        echo "</td>";

        echo "</tr>";

        echo "<tr>";
        echo "<td colspan='2' style='text-align:center;  padding-bottom: 15px;'>";


        echo "<div style='text-align:center; margin-top: 20px'>";
        echo "<button type='button' class='btn btn-success w-75' style='font-family:sarabun; font-size: 20px' onclick='insertLog()'>ชำระเงิน</button>";
        // echo "<button type='submit' class='btn btn-success w-75' style='font-family:sarabun; font-size: 20px' >ชำระเงิน</button>";
        echo "</td>";
        echo "</tr>";

        echo "</table>";
        
    }
    ?>

<script>
    function insertLog() {
        $.ajax({
        type: "POST",
        url: "Insert_log.php", // URL of the PHP file that will insert the log
        data: {
          userID: '<?php echo $userID; ?>',
          insertType: 'Access confirm order',
          fileLocation: 'OrderSummary.php'
        },
        success: function(data) {
          document.getElementById('to-payment').submit();
        }
      });
    }
</script>

</body>

</html>