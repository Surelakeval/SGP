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
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(rgba(138, 197, 149, 0.5), rgba(138, 197, 149, 0.5)), url('https://img.freepik.com/premium-photo/woman-hand-hold-supermarket-shopping-cart-with-fresh-fruit-vegetable-shelves-grocery-store_293060-6001.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .navbar {
            width: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .navbar .menu {
            display: flex;
            gap: 15px;
        }

        .navbar .menu a {
            text-decoration: none;
            font-size: 18px;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar .menu a:hover { background-color: darkgreen; }

        h1 {
            text-align: center;
            color: white;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .date-block {
            position: absolute;
            top: 80px;
            right: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 15px;
            border-radius: 5px;
            font-size: 18px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: rgba(0,100,0); color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f1f1; }

        .action-btn {
            width: 200px;
            padding: 12px;
            background-color: rgba(0,100,0);
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .action-btn:hover { background-color: #45a049; }
    </style>
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

    <script>
        const datePicker = document.getElementById('date-picker');
        const currentDateSpan = document.getElementById('date-span');

        function updateDate() {
            const selectedDate = datePicker.value;
            currentDateSpan.innerText = selectedDate;
        }

        const currentDate = new Date().toISOString().split('T')[0];
        datePicker.value = currentDate;
        currentDateSpan.innerText = currentDate;

        datePicker.addEventListener('change', updateDate);
    </script>
</body>
</html>

<?php $conn->close(); ?>
