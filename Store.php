<?php
require 'ConnectDB.php';

// Create a SQL query
$sql = "SELECT * FROM product;";

// Execute the query
$result = mysqli_query($connectDB, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>SMiti Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sarabun&display=swap" rel="stylesheet">

    <style>
        .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* Change this line */
            grid-auto-rows: minmax(200px, auto);
            gap: 10px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 15px;
            padding: 10px;
            box-sizing: border-box;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }

        .product-card:hover {
            border: 1px solid #062639;
        }

        .product-card img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>
    <?php require 'Header.html'; ?>
    <div class="container">
        <?php
        // Check if there are results
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = mysqli_fetch_array($result)) {
                $index = $row["ProID"];
                echo '<a href="Product_Detail.php?id=' . $row["ProID"] . '" style="text-decoration: none; color: inherit;">';
                echo '<div class="product-card">';
                echo '<img src="' . $row["Pimage"] . '">';
                echo "<h2 style='font-family:Roboto;'>" . $row["ProName"] . "</h2>";
                // echo '<h2>' . $row["StockQty"] . '</h2>';
                echo "<p style='font-family:sarabun'>฿" . $row["PricePerUnit"] . "</p>";
                echo "<u style='font-family:sarabun;'>รายละเอียดสินค้า</u>";
                echo '</div>';
            }
        } else {
            echo "0 results";
        }
        ?>
    </div>

</body>

</html>

<?php
$connectDB->close();
?>