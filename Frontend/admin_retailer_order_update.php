<?php
// Include the database connection file
include('connect.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order-id'];
    $retailer_id = $_POST['retailer-id'];
    $product_name = $_POST['product-name'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];

    // Prepare the update SQL query with backticks for columns with spaces
    $sql = "UPDATE tblorder SET `Retailer ID` = ?, `Product Name` = ?, `Quantity` = ?, `Date` = ? WHERE `Order ID` = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssiss", $retailer_id, $product_name, $quantity, $date, $order_id);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Order updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating order.');</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Admin Dashboard</title>
</head>
<body class="admin-page">
    <header>
        <img src="logo.png" alt="Logo" class="logo">
        <nav class="navbar">
            <ul>
                <li><a href="admin_user.php">User</a></li>
                <li><a href="#" class="dropdown">Farm</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_farm.php">Farm Information</a></li>
                        <li><a href="admin_farm_product.php">Farm Product</a></li>
                        <li><a href="admin_farm_batch.php">Farm Batch</a></li>
                    </ul></li>
                <li>
                    <a href="#" class="dropdown">Processing Center</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_center_information.php">Center Information</a></li>
                        <li><a href="admin_iot_reading.php">IoT Device Reading</a></li>
                        <li><a href="admin_processing_lot.php">Processing Lot</a></li>
                    </ul>
                </li>
                <li><a href="#storage">Storage</a></li>
                <li><a href="#transport">Transport</a></li>
                <li><a href="admin_retailer.php">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
        <main>
        <section>
            <h2>Update Order</h2>
            <form action="admin_retailer_order_update.php" method="POST" class="update-form">
                <label for="order-id">Order ID:</label>
                <input type="text" id="order-id" name="order-id" required>

                <label for="retailer-id">Retailer ID:</label>
                <input type="text" id="retailer-id" name="retailer-id" required>

                <label for="product-name">Product Name:</label>
                <input type="text" id="product-name" name="product-name" required>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" required>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <button type="submit" class="update-btn">Update</button>
            </form>
        </section>
    </main>
</body>
</html>