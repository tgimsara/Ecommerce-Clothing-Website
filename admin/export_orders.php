<?php
include('db.php'); // Ensure this includes your database connection file

// Connect to your database
$con = mysqli_connect('localhost', 'root', '', 'threaderz_store'); // Update if needed

if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}

$get_items = "SELECT * FROM orders ORDER BY date DESC"; // Ensure you're getting data from the 'orders' table
$run_items = mysqli_query($con, $get_items);

echo "
<div class='cart-table' style='min-height: 150px;'>
    <table>
        <thead style='font-size: larger;'>
            <tr>
                <th>Order ID</th>
                <th>Price</th>
                <th> Quantity</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
";

while ($row_items = mysqli_fetch_array($run_items)) {
    $o_id = $row_items['order_id'];
    $o_qty = $row_items['order_qty'];
    $o_price = $row_items['order_price'];
    $o_date = $row_items['date'];

    echo "
    <tr style='border-bottom: 0.5px solid #ebebeb'>
        <td class='first-row'>$o_id</td>
        <td class='first-row'>$o_price</td>
        <td class='first-row'>$o_qty</td>
        <td class='first-row'>$o_date</td>
    </tr>";
}

echo "
        </tbody>
    </table>
</div>
";
?>
