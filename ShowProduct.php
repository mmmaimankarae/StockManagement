<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 3%;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form select {
            padding: 8px;
            font-size: 14px;
        }

        select {
            width: 60px;
        }

        .last-update {
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body style="background-color: #EDF2F6; text: #494953;">

<center>
    <h1>PRODUCT LIST</h1>
    <table border="1">
        <tr>
            <th>PRODUCT</th>
            <th>PRICE</th>
            <th>AMOUNT</th>
        </tr>
        <?php 
            $msconnect = mysqli_connect("localhost", "root", "", "myStore");
            $msquery = "SELECT * FROM PRODUCT WHERE StockQty != 0;";
            $msresults = mysqli_query($msconnect, $msquery);
            $count = 1;
            while ($row = mysqli_fetch_array($msresults)) {
                echo "<tr><td>" .$row['ProName']. "</td>";
                echo "<td>" .$row['PricePerUnit']. "</td>";
                echo "<td><form><select name='" .$count. "' size='1'>";
                echo "<option selected>0";
                if ($row['StockQty'] < 5) {
                    for ($i = 1; $i <= $row['StockQty']; $i++) {
                        echo "<option>" .$i;
                    }
                } else {
                    for ($i = 1; $i <= 5; $i++) {
                        echo "<option>" .$i;
                    }
                }
                echo "</select></form></td></tr>";
                $count += 1;
            }
            echo "</table>";
            echo "<p class='last-update'>Last Update: " .date("d M Y"). "</p>";
            mysqli_close($msconnect);
        ?>
</center>

</body>
</html>
