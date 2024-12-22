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
                <li><a href="#" class="dropdown">Inspector</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_farm_inspection.php">Farm</a></li>
                        <li><a href="admin_batch_inspection.php">Batch</a></li>
                        <li><a href="admin_lot_inspection.php">Lot</a></li>
                        <li><a href="admin_processing_center_inspection.php">Processing Center</a></li>
                        <li><a href="admin_storage_batch.php">Storage</a></li>
                    </ul></li>
                <li>
                <li><a href="admin_storage.php">Storage</a></li>
                <li><a href="admin_transport.php">Transport</a></li>
                <li><a href="admin_retailer_order.php">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
        <h1>
        <img src="logo.png" alt="Farm Logo" class="logo-img">
        Agro Farm - Update Product
    </h1>

    

    <section class="form-container">
        <h2>Update Product Information</h2>
        <form id="productUpdateForm" method="POST" action="admin_farm_product_update.php">
            <div class="form-group">
                <label for="productId">Product ID:</label>
                <input type="text" id="productId" name="productId" required>
            </div>

            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <input type="text" id="type" name="type" required>
            </div>

            <div class="form-group">
                <label for="bestSeason">Best Season:</label>
                <select id="bestSeason" name="bestSeason" required>
                    <option value="summer">Summer</option>
                    <option value="rainy">Rainy</option>
                    <option value="winter">Winter</option>
                    <option value="spring">Spring</option>
                </select>
            </div>

            <div class="form-group">
                <label for="optimumTemp">Optimum Temperature:</label>
                <input type="text" id="optimumTemp" name="optimumTemp" required>
            </div>

            <div class="form-group">
                <label for="optimumHumidity">Optimum Humidity:</label>
                <input type="text" id="optimumHumidity" name="optimumHumidity" required>
            </div>

            <div class="form-group">
                <label for="nutritionValue">Nutrition Value:</label>
                <input type="text" id="nutritionValue" name="nutritionValue" required>
            </div>

            <div class="button-container">
                <button type="submit" id="updateButton">Update</button>
            </div>
        </form>
    </section>

</body>
</html>

<?php
// update_product.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "crud";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $productId = $conn->real_escape_string($_POST['productId']);
    $productName = $conn->real_escape_string($_POST['productName']);
    $type = $conn->real_escape_string($_POST['type']);
    $bestSeason = $conn->real_escape_string($_POST['bestSeason']);
    $optimumTemp = $conn->real_escape_string($_POST['optimumTemp']);
    $optimumHumidity = $conn->real_escape_string($_POST['optimumHumidity']);
    $nutritionValue = $conn->real_escape_string($_POST['nutritionValue']);

    $sql = "UPDATE tblproduct SET `Product Name` = '$productName', `Type` = '$type', `Best Season` = '$bestSeason', `Optimum Temperature` = '$optimumTemp', `Optimum Humidity` = '$optimumHumidity', `Nutrition Value` = '$nutritionValue' WHERE `Product ID` = '$productId'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'admin_farm_product.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>