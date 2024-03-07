<?php
    require '../components/connectDB.php';
    $msquery = "";
    $index = 0;
    if ($_SESSION['data'] == "update"){
        $start = "UPDATE PRODUCT SET ";
    } elseif ($_SESSION['data'] == "new"){
        $start = "INSERT INTO PRODUCT (ProName, PricePerUnit, CostPerUnit, StockQty,
                  Description, ImageSource, Status, Update_Day) VALUES ('" . $_POST['proName'] . "', 
                  ". $_POST['pricePerUnit'] . ", " . $_POST['costPerUnit'] . ", ".$_POST['stockQty']. 
                  ", '" . $_POST['description'] . "', '". $_POST['imageSource'] . "', '" . $_POST['status'] . "',
                  '".date('Y-m-d h:i:s'). "');";
        $msquery = $start;
        $msresults = mysqli_query($msconnectDB, $msquery);
        mysqli_close($msconnectDB);
        header("Location: ../admin/ProductList.php");
        exit;
    }

    $condition = " WHERE ProID = ";
    $comma = ", ";
    $quote = "'";
    $end = ";";

    $name = "";
    if ($_POST['proName'] != '') {
        $name = "ProName = ";
        if ($index == 0) {
            $name = $name .$quote .$_POST['proName'] .$quote;
        } else {
            $name = $comma .$name .$quote .$_POST['proName'] .$quote;
        }
        $index += 1;
    } 

    $price = "";
    if ($_POST['pricePerUnit'] != '') {
        $price = "PricePerUnit = ";
        if ($index == 0) {
            $price = $price .$_POST['pricePerUnit'];
        } else {
            $price = $comma .$price .$_POST['pricePerUnit'];
        }
        $index += 1;
    } 

    $cost = "";
    if ($_POST['costPerUnit'] != '') {
        $cost = "CostPerUnit = ";
        if ($index == 0) {
            $cost = $cost .$_POST['costPerUnit'];
        } else {
            $cost = $comma .$cost .$_POST['costPerUnit'];
        }
        $index += 1;
    }

    $stock = "";
    if ($_POST['stockQty'] != '') {
        $stock = "StockQty = ";
        if ($index == 0) {
            $stock = $stock .$_POST['stockQty'];
        } else {
            $stock = $comma .$stock .$_POST['stockQty'];
        }
        $index += 1;
    } 

    $des = "";
    if ($_POST['description'] != '') {
        $des = "Description = ";
        if ($index == 0) {
            $des = $des .$quote .$_POST['description'] .$quote;
        } else {
            $des = $comma .$des .$quote .$_POST['description'] .$quote;
        }
        $index += 1;
    } 

    $image = "";
    if ($_POST['imageSource'] != '') {
        $image = "ImageSource = ";
        if ($index == 0) {
            $image = $image .$quote .$_POST['imageSource'] .$quote;
        } else {
            $image = $comma .$image .$quote .$_POST['imageSource'] .$quote;
        }
        $index += 1;
    }

    $status = "";
    if ($_POST['status'] != '') {
        $status = "Status = ";
        if ($index == 0) {
            $status = $status .$quote .$_POST['status'] .$quote;
        } else {
            $status = $comma .$status .$quote .$_POST['status'] .$quote;
        }
        $index += 1;
    }

    $day = "";
    if ($index != 0) {
        $day = "Update_Day = ";
        $day = $comma .$day .$quote .date("Y-m-d h:i:s") .$quote;
        $msquery = $start .$name .$price .$cost .$stock .$des .$image .$status .$day .$condition .$_POST['proID'] .$end;
        $msresults = mysqli_query($msconnectDB, $msquery);
        mysqli_close($msconnectDB);
    }
    header("Location: ../admin/ProductList.php");
?>