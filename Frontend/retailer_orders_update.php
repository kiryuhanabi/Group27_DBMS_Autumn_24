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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link rel="stylesheet" href="retailer_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .update-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .update-form label {
            font-weight: bold;
        }
        .update-form input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .update-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .update-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>
        <img src="logo.png" alt="Retail Logo" class="logo-img">
        Agro Retailer
    </h1>

    <!-- Full-width Navigation bar -->
    <nav class="nav">
        <ul class="ul">
            <li><a href="retailer.php">Home</a></li>
            <li><a href="retailer_orders.php">Orders</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Update Form -->
    <main>
        <section>
            <h2>Update Order</h2>
            <form action="retailer_orders_update.php" method="POST" class="update-form">
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
