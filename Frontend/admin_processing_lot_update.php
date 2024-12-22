<?php
// Include the database connection
include('connect.php');

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the processing lot data from the database
    $sql = "SELECT * FROM tblprocessinglot WHERE `Lot Number` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $lot = $result->fetch_assoc();
} else {
    echo "No Lot Number provided.";
    exit();
}

// Check if the form has been submitted to update the processing lot data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $batchBarcode = $_POST['batch_barcode'];
    $lotNumber = $_POST['lot_number'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $manufacturedDate = $_POST['manufactured_date'];
    $expiryDate = $_POST['expiry_date'];
    $stTransportID = $_POST['st_transport_id'];
    $centerID = $_POST['center_id'];

    // Update the processing lot data in the database
    $update_sql = "UPDATE tblprocessinglot 
                   SET `Batch Barcode` = ?, `Lot Number` = ?, `Date` = ?, `Time` = ?, `Manufactured Date` = ?, `Expiry Date` = ?, `stTransport ID` = ?, `Center ID` = ? 
                   WHERE `Lot Number` = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssssss", $batchBarcode, $lotNumber, $date, $time, $manufacturedDate, $expiryDate, $stTransportID, $centerID, $id);

    if ($update_stmt->execute()) {
        // Redirect to the processing lot table after updating
        header("Location: admin_processing_lot.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_user_update_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Edit Processing Lot</title>
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
        <h2 class="form-title">Edit Processing Lot</h2>

        <!-- Edit Processing Lot Form -->
        <form method="POST">
            <div class="form-group">
                <label for="batch_barcode">Batch Barcode:</label>
                <input type="text" id="batch_barcode" name="batch_barcode" class="form-control" value="<?php echo $lot['Batch Barcode']; ?>" required>
            </div>
            <div class="form-group">
                <label for="lot_number">Lot Number:</label>
                <input type="text" id="lot_number" name="lot_number" class="form-control" value="<?php echo $lot['Lot Number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" class="form-control" value="<?php echo $lot['Date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" class="form-control" value="<?php echo $lot['Time']; ?>" required>
            </div>
            <div class="form-group">
                <label for="manufactured_date">Manufactured Date:</label>
                <input type="date" id="manufactured_date" name="manufactured_date" class="form-control" value="<?php echo $lot['Manufactured Date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date" class="form-control" value="<?php echo $lot['Expiry Date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="st_transport_id">stTransport ID:</label>
                <input type="text" id="st_transport_id" name="st_transport_id" class="form-control" value="<?php echo $lot['stTransport ID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="center_id">Center ID:</label>
                <input type="text" id="center_id" name="center_id" class="form-control" value="<?php echo $lot['Center ID']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </main>
</body>
</html>
