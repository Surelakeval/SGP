<?php
$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "foodmanagment1"; // Change to your actual DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch inventory data
$sql = "SELECT * FROM inventory_table";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Table</title>
    <link rel="stylesheet" href="inventory.css">
</head>
<body>
    <div class="navbar">
        <div class="menu">
            <a href="retailer.html">Home</a>
            <a href="retailer.html">Inventory Dashboard</a>
            <a href="surplus_m.html">Surplus Management</a>
            <a href="expired_products.php">Near-Expiry Products</a>
            <a href="aboutus.html">About Us</a>
            <a href="../main.html">Logout</a>
        </div>
    </div>

    <h1>Inventory Table</h1>

    <!-- Date Block -->
    <div class="date-block">
        <label for="date-picker">Select Date: </label>
        <input type="date" id="date-picker" name="date-picker" value="<?php echo date('Y-m-d'); ?>" />
        <div id="current-date">
            <strong>Current Date: </strong> <span id="date-span"></span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Unit Type</th>
                <th>Expiry Date</th>
                <th>Status</th>
                <th>Price/Unit (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['item_ID']; ?></td>
                    <td><?php echo $row['item_name']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['unit_type']; ?></td>
                    <td><?php echo $row['expiry_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['price_per_unit']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <button class="action-btn">
        <a href="inventory_table.php" style="color: white; text-decoration: none;">Add/Update Inventory</a>
    </button>

    <script src="inventory.js"> </script>
</body>
</html>

<?php $conn->close(); ?>
