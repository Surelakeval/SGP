<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodmanagment1";

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the data from the form
    $item_ID = $_POST['item_ID'];
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $unit_type = $_POST['unit_type'];
    $expiry_date = $_POST['expiry_date']; // Assuming this is in a valid format
    $formatted_date = date('Y-m-d', strtotime($expiry_date)); // Format date as YYYY-MM-DD
    $price_per_unit = $_POST['price_per_unit'];
    // $status = $_POST['status'];
    $status = "undecided";

    // Prepare and bind the SQL statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO inventory_table (item_ID, item_name, category, quantity, unit_type, expiry_date, status, price_per_unit) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiissi", $item_ID, $item_name, $category, $quantity, $unit_type, $formatted_date, $status, $price_per_unit);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "Item added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection after form submission
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory Item</title>
   <link rel="stylesheet" href="inventory_table.css">

</head>
<link rel="stylesheet" href="../css/style.css">
<body>
<div class="navbar">
        <div class="menu">
            <a href="main.html">Home</a>
            <a href="surplus_m.html">Surplus Management</a>
            <a href="expired_products.php">Expired Products</a>
            <a href="aboutus.html">About Us</a>
            <a href="login.html">Login</a>
        </div>
    </div>
<div class="container">
<div>
<h2>Add Inventory Item</h2>

<!-- Inventory form to submit data -->
<form action="" method="POST">

    <!-- Change item_ID input type to text -->
    <label for="item_ID">Item ID:</label>
    <input type="text" id="item_ID" name="item_ID" required>

    <label for="item_name">Item Name:</label>
    <input type="text" id="item_name" name="item_name" required>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" required>

    <label for="quantity">Quantity:</label>
    <input type="int" id="quantity" name="quantity" required>

    <label for="unit_type">Unit Type:</label>
    <input type="text" id="unit_type" name="unit_type" required>

    <label for="expiry_date">Expiry Date:</label>
    <input type="date" id="expiry_date" name="expiry_date">

    <!-- <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Fresh">Fresh</option>
        <option value="Near expiry">Near expiry</option>
        <option value="expire">expire</option>
    </select><br><br> -->

    <label for="price_per_unit">Price per Unit ($):</label>
    <input type="int" id="price_per_unit" name="price_per_unit" required><br><br>

    <button type="submit" name="submit">Add Item</button>
</form>
</div>

</body>
</html>