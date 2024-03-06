<?php
    $connectDB = mysqli_connect("localhost", "root", "", "mystore");
    
    /* SQL แบบป้องกัน INJECTION = เชื่อมต่อ DB โดยใช้ PDO (PHP Data Object)*/ 
    /*
    $host = "localhost";
    $dbname = "mystore";
    $username = "root";
    $password = "";
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("ไม่สามารถเชื่อมต่อกับฐานข้อมูล: " . $e->getMessage());
    }
    */
?>