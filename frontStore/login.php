<?php 
    $msconnect = mysqli_connect("localhost", "root", "", "myStore");
    $userName = $_POST['username'];
    $password = $_POST['password'];
    $msquery = "SELECT * FROM CUSTOMER_ACCOUNT WHERE UserName = '$userName' AND Password = '$password';";
    $msresults = mysqli_query($msconnect, $msquery);
    if ($row = mysqli_fetch_array($msresults)) {
        if ($userName == 'admin') {
            header("Location: ./admin/DashBoard.php");
        }
        else { 
            header("Location: ./Store.php");
        }
    } else {
        include('./test.html');
        echo "<div style='color: #ff0000; margin-top: 25%; position: absolute;'><br><h4>username หรือ password กรุณากรอกใหม่อีกครั้ง</h4> </div>";
    }
    mysqli_close($msconnect);
?>