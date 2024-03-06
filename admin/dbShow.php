<?php 
//   require '../components/connectDB.php';
  require '../admin/dbShowSelectProductOrder.php';
//   $msresults = mysqli_query($connectDB, $_SESSION['query']);     
  
?>
<div class="container my-4">
    <table class="table table-bordered" id="dataTable">
        <thead>
            <tr>
                <th>ReceiptID</th>
                <th>Tel</th>
                <th>ReceiptDate</th>
                <th>CustomerName</th>
                <th>TotalPrice</th>
                <th>Channel</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($msresults)) {
                echo "<tr>";
                echo "<td>{$row['ReceiptID']}</td>";
                echo "<td>{$row['Tel']}</td>";
                echo "<td>{$row['ReceiptDate']}</td>";
                echo "<td>{$row['CustomerName']}</td>";
                echo "<td>{$row['TotalPrice']}</td>";
                echo "<td>{$row['Channel']}</td>";
                echo "<td>{$row['Status']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>