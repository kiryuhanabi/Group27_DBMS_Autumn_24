<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Admin Dashboard</title>
</head>
<body class="admin-page">
    <>
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
                <li><a href="#retailer">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
        <div class="dashboard">
        <h2>Update Batch Information</h2>

        <form id="updateBatchForm" action="admin_farm_batch_update.php" method="POST">
            <div class="form-group">
                <label for="batchBarcode">Batch Barcode:</label>
                <input type="text" id="batchBarcode" name="batchBarcode" required>
            </div>

            <div class="form-group">
                <label for="harvestDate">Harvest Date:</label>
                <input type="date" id="harvestDate" name="harvestDate" required>
            </div>

            <div class="form-group">
                <label for="expireyDate">Expirey Date:</label>
                <input type="date" id="expireyDate" name="expireyDate" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" required>
            </div>

            <div class="form-group">
                <label for="productID">Product ID:</label>
                <input type="text" id="productID" name="productID" required>
            </div>

            <div class="form-group">
                <label for="farmID">Farm ID:</label>
                <input type="text" id="farmID" name="farmID" required>
            </div>

            <button class="btn" type="submit" name="update"><i class="fas fa-sync"></i> Update</button>
        </form>
    </div>
</body>
</html>

<!-- PHP Script (update_batch.php) -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $batchBarcode = $_POST['batchBarcode'];
    $harvestDate = $_POST['harvestDate'];
    $expireyDate = $_POST['expireyDate'];
    $quantity = $_POST['quantity'];
    $productID = $_POST['productID'];
    $farmID = $_POST['farmID'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'crud');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update query
    $sql = "UPDATE tblbatch SET `Harvest Date` = ?, `Expiry Date` = ?, `Quantity` = ?, `Product ID` = ?, `Farm ID` = ? WHERE `Batch Barcode` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisss', $harvestDate, $expireyDate, $quantity, $productID, $farmID, $batchBarcode);

    if ($stmt->execute()) {
        echo "<script>alert('Batch updated successfully.'); window.location.href='admin_farm_batch.php';</script>";
    } else {
        echo "<script>alert('Error updating batch: " . $conn->error . "'); window.location.href='admin_farm_batch.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>