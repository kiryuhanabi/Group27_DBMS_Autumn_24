<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "crud"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle product deletion if the 'id' parameter is passed
if (isset($_GET['delete_id'])) {
    $deleteId = $conn->real_escape_string($_GET['delete_id']);
    $deleteSql = "DELETE FROM tblproduct WHERE `Product ID` = '$deleteId'";

    if ($conn->query($deleteSql) === TRUE) {
        $message = "Product deleted successfully!";
    } else {
        $message = "Error deleting product: " . $conn->error;
    }
}

// Handle product addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $conn->real_escape_string($_POST['productname']);
    $type = $conn->real_escape_string($_POST['type']);
    $season = $conn->real_escape_string($_POST['season']);
    $humidity = $conn->real_escape_string($_POST['humidity']);
    $temperature = $conn->real_escape_string($_POST['temperature']);
    $nutritionValue = $conn->real_escape_string($_POST['nutritionValue']);

    $sql = "INSERT INTO tblproduct (`Product Name`, `Type`, `Best Season`, `Optimum Temperature`, `Optimum Humidity`, `Nutrition Value`)
            VALUES ('$productName', '$type', '$season', '$temperature', '$humidity', '$nutritionValue')";

    if ($conn->query($sql) === TRUE) {
        $message = "Product added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch all products for display in the table
$sql = "SELECT `Product ID`, `Product Name`, `Type`, `Best Season`, `Optimum Temperature`, `Optimum Humidity`, `Nutrition Value` FROM tblproduct";
$result = $conn->query($sql);
$conn->close();
?>
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
        <div class="dashboard">
        <h2>Product</h2>

        <div class="inspection-filters">
            <h3>Add New Product</h3>
            <form action="" method="POST">
                <div class="form-group">
                    <div class="left-column">
                        <div class="input-row">
                            <label for="productname">Product Name:</label>
                            <input type="text" id="productname" name="productname" required>
                        </div>
                        <div class="input-row">
                            <label for="type">Type:</label>
                            <input type="text" id="type" name="type" required>
                        </div>
                        <div class="input-row">
                            <label for="season">Best Season:</label>
                            <select id="season" name="season" required>
                                <option value="summer">Summer</option>
                                <option value="rainy">Rainy</option>
                                <option value="winter">Winter</option>
                                <option value="spring">Spring</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="right-column">
                        <div class="input-row">
                            <label for="humidity">Optimum Humidity:</label>
                            <input type="text" id="humidity" name="humidity" required>
                        </div>
                        <div class="input-row">
                            <label for="temperature">Optimum Temperature:</label>
                            <input type="text" id="temperature" name="temperature" required>
                        </div>
                        <div class="input-row">
                            <label for="nutritionValue">Nutrition Value:</label>
                            <input type="text" id="nutritionValue" name="nutritionValue" required>
                        </div>
                    </div>
                </div>         
                <button class="btn" type="submit"><i class="fa fa-plus" aria-hidden="true"></i> Add Product</button>
            </form>
        </div>        

        <div class="table-container">
            <h2>Overview of Products</h2>
            <table id="productTable">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Type</th>
                        <th>Best Season</th>
                        <th>Optimum Temperature</th>
                        <th>Optimum Humidity</th>
                        <th>Nutrition Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Product ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Product Name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Type']); ?></td>
                                <td><?php echo htmlspecialchars($row['Best Season']); ?></td>
                                <td><?php echo htmlspecialchars($row['Optimum Temperature']); ?></td>
                                <td><?php echo htmlspecialchars($row['Optimum Humidity']); ?></td>
                                <td><?php echo htmlspecialchars($row['Nutrition Value']); ?></td>
                                <td>
                                    <button onclick="window.location.href='admin_farm_product_update.php?id=<?php echo $row['Product ID']; ?>'">Edit</button>
                                    <button onclick="if(confirm('Are you sure you want to delete this product?')) window.location.href='?delete_id=<?php echo $row['Product ID']; ?>';">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>