<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <script>
        function confirmDelete(barcode) {
            if (confirm("Are you sure you want to delete this batch?")) {
                window.location.href = `admin_farm_batch.php?barcode=${barcode}`;
            }
        }
    </script>
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
        <h2>Batch</h2>

        <div class="inspection-filters">
            <h3>Create Batch</h3>
            <form id="addBatchForm" action="admin_farm_batch.php" method="POST">
                <div class="form-group">
                    <div class="input-row">
                        <label for="harvestDate">Harvest Date:</label>
                        <input type="date" id="harvestDate" name="harvestDate" required>
                    </div>
                    <div class="input-row">
                        <label for="expireyDate">Expiry Date:</label>
                        <input type="date" id="expireyDate" name="expireyDate" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="productID">Product ID:</label>
                        <input type="text" id="productID" name="productID" required>
                    </div>
                    <div class="input-row">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="farmID">Farm ID:</label>
                        <input type="text" id="farmID" name="farmID" required>
                    </div>
                </div>

                <button class="btn" type="submit"><i class="fa fa-plus" aria-hidden="true"></i> Add Batch</button>
            </form>
        </div>

        <div class="table-container">
            <h2>Batch Overview</h2>
            <table id="batchTable">
                <thead>
                    <tr>
                        <th>Batch Barcode</th>
                        <th>Harvest Date</th>
                        <th>Expiry Date</th>
                        <th>Quantity</th>
                        <th>Product ID</th>
                        <th>Farm ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Connect to the database
                    $conn = new mysqli('localhost', 'root', '', 'crud');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    // Handle adding a new batch
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $harvestDate = $_POST['harvestDate'];
                        $expiryDate = $_POST['expireyDate'];
                        $productID = $_POST['productID'];
                        $quantity = $_POST['quantity'];
                        $farmID = $_POST['farmID'];

                        $sql = "INSERT INTO tblbatch (`Harvest Date`, `Expiry Date`, `Quantity`, `Product ID`, `Farm ID`) 
                                VALUES ('$harvestDate', '$expiryDate', '$quantity', '$productID', '$farmID')";

                        if ($conn->query($sql) === TRUE) {
                            echo "<script>alert('Batch added successfully.'); window.location.href = 'admin_farm_batch.php';</script>";
                        } else {
                            echo "<script>alert('Error adding batch: " . $conn->error . "');</script>";
                        }
                    }


                    $sql = "SELECT * FROM tblbatch";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['Batch Barcode']}</td>
                                <td>{$row['Harvest Date']}</td>
                                <td>{$row['Expiry Date']}</td>
                                <td>{$row['Quantity']}</td>
                                <td>{$row['Product ID']}</td>
                                <td>{$row['Farm ID']}</td>
                                <td>
                                    <a href='admin_farm_batch_update.php?barcode={$row['Batch Barcode']}' class='btn update-btn'>Update</a>
                                    <button onclick=\"confirmDelete('{$row['Batch Barcode']}')\" class='btn delete-btn'>Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'crud');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['barcode'])) {
    $barcode = $conn->real_escape_string($_GET['barcode']);

    // Delete the batch
    $sql = "DELETE FROM tblbatch WHERE `Batch Barcode` = '$barcode'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Batch deleted successfully.'); window.location.href = 'admin_farm_batch.php';</script>";
    } else {
        echo "<script>alert('Error deleting batch: " . $conn->error . "'); window.location.href = 'admin_farm_batch.php';</script>";
    }
}

$conn->close();
?>