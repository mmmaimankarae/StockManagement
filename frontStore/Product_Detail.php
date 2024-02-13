<!DOCTYPE html>
<html>

<head>
    <title>SMiti Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sarabun&display=swap" rel="stylesheet">
    <style>
        .add-to-cart-button {
            background-color: red;
            border: 0px;
            color: white;
            width: 120px;
            height: 40px;
            border-radius: 15px;
            font-family: sarabun;
        }

        .add-to-cart-button:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #number {
            width: 30px;
            text-align: center;
        }
    </style>
    <script>
        function incrementValue() {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) || value < 1 ? 1 : value;
            value++;
            document.getElementById('number').value = value;
        }

        function decrementValue() {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) || value <= 1 ? 1 : value;
            value--;
            document.getElementById('number').value = value < 1 ? 1 : value;
        }

        // function validateForm() {
        //     var value = parseFloat(document.getElementById('number').value);
        //     var alertText = document.getElementById('alertText');
        //     if (isNaN(value) || value < 1) {
        //         alertText.innerHTML = '<b>โปรดใส่เฉพาะตัวเลขมากกว่า 0!</b>';
        //         return false;
        //     } else {
        //         alertText.textContent = '';
        //         return true;
        //     }
        // }
    </script>
</head>

<body>
    <?php
    require('Header.html');
    session_start();
    require('ConnectDB.php');
    $id =  $_GET['id'];
    $sql = "SELECT * FROM product WHERE ProID = " . $id;
    $result = mysqli_query($connectDB, $sql);
    $row = mysqli_fetch_array($result);

    echo "<a href='Store.php'>
        <button style='background-color:#45a049; color:white; border-radius:10px; width: 60px; height: 40px; border: none; text-align:center;'>
        Back
        </button>
        </a>";
    echo "<form method='POST' action='Cart.php'>";
    echo "<center>";
    echo "<h1 style='font-family:sarabun;'>ชื่อสินค้า : " . $row['ProName'] . "</h1>";
    echo "<img src='" . $row['Pimage'] . "' style='width: 200px; height: 200px;'>";
    echo "<p style='font-family:sarabun'><b>ราคา:</b> " . $row['PricePerUnit'] . " บาท</p>";
    echo "<p style='font-family:sarabun'><b>จำนวนคงเหลือ:</b> " . $row['StockQty'] . " ชิ้น</p>";
    echo "<p style='font-family:sarabun'><b>รายละเอียดสินค้า:</b> " . $row['Pdetail'] . "</p>";
    echo '<button type="button" onclick="decrementValue()" value="Decrement Value">-</button>
        <input id="number" type="text" name="quantity" value="1" readonly/>
        <button type="button" onclick="incrementValue()" value="Increment Value">+</button><br>';
    echo "<p id='alertText' style='color:red; font-family:sarabun;' ></p>";
    echo "<button class='add-to-cart-button' type='submit' name='a1' value=" . $row['ProName'] . "><b>Add to Cart</b></button>";
    echo "<input type='hidden' name='ProName' value=" . $row['ProName'] . ">";
    echo "</form>";
    echo "</center>";
    ?>
</body>

</html>

<?php
$connectDB->close();
?>