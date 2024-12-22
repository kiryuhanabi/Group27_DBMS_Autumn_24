<?php
// Include the database connection
include('connect.php');

// Check if the delete request is made
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete from Center Information Table
    if (strpos($id, 'Center') !== false) {
        $delete_sql = "DELETE FROM tblprocessingcenter WHERE `Center ID` = ?";
    }
    // Delete from IoT Device Reading Table
    elseif (strpos($id, 'pIoT') !== false) {
        $delete_sql = "DELETE FROM tblprocessingiot WHERE `pIoT ID` = ?";
    }
    // Delete from Processing Lot Details Table
    elseif (strpos($id, 'Batch') !== false) {
        $delete_sql = "DELETE FROM tblprocessinglot WHERE `Batch Barcode` = ?";
    }

    // Prepare and execute the delete query
    if (isset($delete_sql)) {
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("s", $id);

        // Execute the delete operation
        if ($delete_stmt->execute()) {
            // Redirect to the same page to refresh the table after deletion
            header("Location: admin_processing_center.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Fetch data for Center Information
$center_sql = "SELECT * FROM tblprocessingcenter";
$center_result = $conn->query($center_sql);

// Fetch data for IoT Device Reading
$iot_sql = "SELECT * FROM tblprocessingiot";
$iot_result = $conn->query($iot_sql);

// Fetch data for Processing Lot Details
$lot_sql = "SELECT * FROM tblprocessinglot";
$lot_result = $conn->query($lot_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Processing Center</title>
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
                        <li><a href="admin_p_center_inspection.php">Processing Center</a></li>
                        <li><a href="admin_storage_inspection.php">Storage</a></li>
                    </ul></li>
                <li>
                <li><a href="admin_storage.php">Storage</a></li>
                <li><a href="#" class="dropdown">Transport</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_transport.php">Transport Home</a></li>
                        <li><a href="admin_transport_center.php">Transport to Processing Center</a></li>
                        <li><a href="admin_Transport_storage.php">Transport to Storage</a></li>
                        <li><a href="admin_transportShipment_to_ratailer.php">Transport Shipmenet to Retailer</a></li>
                    </ul></li>
                 <li><a href="admin_retailer_order.php">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h1>Processing Center</h1>

        <!-- Center Information Table -->
        <h2>Center Information</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Center ID</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $center_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['Center ID']; ?></td>
                    <td><?php echo $row['Type']; ?></td>
                    <td><?php echo $row['Location']; ?></td>
                    <td>
                        <a href="admin_processing_center_edit.php?id=<?php echo $row['Center ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="admin_processing_center.php?id=<?php echo $row['Center ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- IoT Device Reading Table -->
        <h2>IoT Device Reading</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>pIoT ID</th>
                    <th>Center ID</th>
                    <th>Temperature</th>
                    <th>Humidity</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $iot_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['pIoT ID']; ?></td>
                    <td><?php echo $row['Center ID']; ?></td>
                    <td><?php echo $row['Temperature']; ?></td>
                    <td><?php echo $row['Humidity']; ?></td>
                    <td><?php echo $row['Date']; ?></td>
                    <td><?php echo $row['Time']; ?></td>
                    <td>
                        <a href="admin_processing_center_edit.php?id=<?php echo $row['pIoT ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="admin_processing_center.php?id=<?php echo $row['pIoT ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Processing Lot Details Table -->
        <h2>Processing Lot Details</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Batch Barcode</th>
                    <th>Lot Number</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Manufactured Date</th>
                    <th>Expiry Date</th>
                    <th>Transport ID</th>
                    <th>Center ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $lot_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['Batch Barcode']; ?></td>
                    <td><?php echo $row['Lot Number']; ?></td>
                    <td><?php echo $row['Date']; ?></td>
                    <td><?php echo $row['Time']; ?></td>
                    <td><?php echo $row['Manufactured Date']; ?></td>
                    <td><?php echo $row['Expiry Date']; ?></td>
                    <td><?php echo $row['stTransport ID']; ?></td>
                    <td><?php echo $row['Center ID']; ?></td>
                    <td>
                        <a href="admin_processing_center_edit.php?id=<?php echo $row['Batch Barcode']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="admin_processing_center.php?id=<?php echo $row['Batch Barcode']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </main>
</body>
</html>
