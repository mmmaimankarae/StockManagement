<?php
session_start();
require "../components/connectDB.php";
require "../components/HeaderStore.html";
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sarabun&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Order Summary Update</title>
    <style>
        .container {
            display: flex;
            background-color: red;
            flex-direction: column;
            margin-top: 80px;
        }

        .section1 {
            flex: 1;
            background-color: yellow;
        }

        .section2 {
            flex: 1;
            /* background-color: green; */
            display: flex;
            flex-direction: row;
            margin-top: 30px;
            border-bottom: 4px solid black;
        }

        .section3 {
            flex: 1;
            background-color: purple;
            display: flex;
            flex-direction: row;
            margin-top: 30px;
        }

        .orderSummary {
            flex: 1;
            background-color: pink;
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .item {
            flex: 1;
            background-color: lime;
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
        }

        .orderSummaryBox {
            flex: 1;
            background-color: lime;
            display: flex;
            flex-direction: row;
        }

        .orderSummaryBox p {
            font-family: sarabun;
            font-size: 20px;
        }

        .informationForm {
            flex: 2;
            background-color: lime;
            display: flex;
            flex-direction: row;
            margin-right: 30px;
        }

        .informationForm p {
            font-family: sarabun;
            font-size: 20px;
            margin: 0;
            padding: 0;
        }

        .informationForm input {
            font-family: sarabun;
            font-size: 20px;
            width: 100%;
            height: 75%;
            margin: 0;
            padding: 0;
            border-radius: 5px;
            border: 2px solid #C1C1C1;
        }

        .informationForm input:focus {
            border: 2px solid blue;
        }

        .informationForm input::placeholder {
            padding-left: 10px;
        }

        .backButton {
            font-family: sarabun;
            font-size: 15px;
            border-radius: 5px;
            background-color: #5AB71A;
            color: white;
            border: 0px;
            width: 150px;
            height: 40px;
        }

        .backButton:hover {
            box-shadow: 0 0 5px 0 #C1C1C1;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="section1">
            <button class="backButton">กลับไปหน้าร้านค้า</button>
        </div>
        <div class="section2">
            <div class="orderSummary">
                <p style="font-family: sarabun; font-size:30px;"><b>OrderSummary</b></p>
            </div>
            <div class="item">
                <p style="font-family: sarabun; font-size:30px;"><b>Item</b></p>
            </div>
        </div>
        <div class="section3">
            <div class="informationForm">
                <div style="flex: 1; background-color:aqua; margin-right:25px;">
                    <p><b>ชื่อ</b></p>
                    <input type="text" style="font-size: 15px" placeholder="กรุณากรอกชื่อจริง"></input>
                </div>
                <div style="flex: 1; background-color:brown;">
                    <p>test2</p>
                </div>
            </div>
            <div class="orderSummaryBox">

            </div>
        </div>
    </div>

</body>

</html>