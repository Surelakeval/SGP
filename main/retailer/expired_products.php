<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodmanagment1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Update Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["id"];
    $discount = $_POST["discount"];
    
    // First update the discount percentage
    $sql = "UPDATE discounted_products SET discount_percentage='$discount' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: expired_products.php"); // Redirect after update
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch Data - Modified query to remove new_price calculation
$sql = "SELECT i.*, d.id as discount_id, d.discount_percentage 
        FROM inventory_table i 
        LEFT JOIN discounted_products d ON i.item_ID = d.item_id 
        WHERE i.expiry_date <= DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY)";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discounted Nearly Expired Products</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: linear-gradient(rgba(138, 197, 149, 0.5), rgba(138, 197, 149, 0.5)), url('https://t3.ftcdn.net/jpg/09/30/89/18/360_F_930891893_uQnRJBGy8yDZ8sRJ5qH15tTsfNxeY7ET.jpg');
            background-size: cover;
            color: black;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
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

        .navbar .menu a:hover {
            background-color: darkgreen;
        }

        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        
        th {
            background-color: #4CAF50;
            color: white;
        }

        .original-price {
            text-decoration: line-through;
            color: red;
        }
        
        .discounted-price {
            font-weight: bold;
            color: green;
        }
        
        .edit-btn {
            background-color: orange;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }
        
        .update-btn {
            background-color: green;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            display: none;
        }
        
        .edit-mode input {
            border: 1px solid #ccc;
            padding: 5px;
            width: 50px;
            text-align: center;
        }
    </style>
    <script>
        function enableEdit(rowId) {
            let row = document.getElementById("row-" + rowId);
            let discountValue = row.querySelector(".discount-value");
            let discountInput = row.querySelector(".discount-input");
            let updateButton = row.querySelector(".update-btn");
            let editButton = row.querySelector(".edit-btn");
            let form = row.querySelector(".update-form");

            // Show input field and hide text
            discountValue.style.display = "none";
            discountInput.style.display = "inline";
            
            // Show Update button & hide Edit button
            editButton.style.display = "none";
            updateButton.style.display = "inline-block";

            // Move the input to the form when editing starts
            discountInput.name = "discount";
            form.appendChild(discountInput);
        }
    </script>
</head>
<body>
<div class="navbar">
    <div class="menu">
        <a href="retailer.html">Home</a>
        <a href="inventory.php">Inventory Dashboard</a>
        <a href="surplus_m.html">Surplus Management</a>
        <a href="expired_products.php">Nearly Expired Products</a>
        <a href="aboutus.html">About Us</a>
        <a href="../main.html">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Discounted Nearly Expired Products</h2>
    <table>
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Unit Type</th>
                <th>Status</th>
                <th>Expiry Date</th>
                <th>Original Price (₹)</th>
                <th>Discount (%)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr id="row-<?php echo $row['discount_id']; ?>">
                    <td><?php echo $row['item_ID']; ?></td>
                    <td><?php echo $row['item_name']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['unit_type']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['expiry_date']; ?></td>
                    <td>₹<?php echo $row['price_per_unit']; ?></td>
                    <td class="discount">
                        <span class="discount-value"><?php echo $row['discount_percentage']; ?>%</span>
                        <input type="number" name="discount" class="discount-input" style="display: none;" min="0" max="100" value="<?php echo $row['discount_percentage']; ?>">
                    </td>
                    <td>
                        <form method="POST" class="update-form">
                            <button type="button" class="edit-btn" onclick="enableEdit(<?php echo $row['discount_id']; ?>)">Edit</button>
                            <button type="submit" class="update-btn" name="update" style="display: none;">Update</button>
                            <input type="hidden" name="id" value="<?php echo $row['discount_id']; ?>">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php $conn->close(); ?>
