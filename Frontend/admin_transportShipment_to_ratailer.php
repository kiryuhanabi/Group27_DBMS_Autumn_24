<?php
// Connect to the database
$host = "localhost"; // Replace with your host
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$dbname = "crud"; // Replace with your database name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shTransportType = $_POST['sh_transport_type'];
    $transportType = $_POST['transport_type'];
    $temperatureRange = $_POST['temperature_range'];

    // Generate shTransport ID starting from 2218585
    $resultShTransport = $conn->query("SELECT MAX(`shTransport ID`) AS max_id FROM tblshipmenttransport");
    $rowShTransport = $resultShTransport->fetch_assoc();
    $nextShTransportId = ($rowShTransport['max_id'] ?? 2218584) + 1;

    // Generate Storage ID starting from 2122885
    $resultStorage = $conn->query("SELECT MAX(`Storage ID`) AS max_id FROM tblshipmenttransport");
    $rowStorage = $resultStorage->fetch_assoc();
    $nextStorageId = ($rowStorage['max_id'] ?? 2122884) + 1;

    $currentDate = date("Y-m-d");

    $sql = "INSERT INTO tblshipmenttransport (`shTransport ID`, `shTransport Type`, `Transport Type`, `Temperature Range`, `Storage ID`) 
            VALUES ($nextShTransportId, '$shTransportType', '$transportType', '$temperatureRange', $nextStorageId)";

    if ($conn->query($sql) === TRUE) {
        // Redirect to avoid duplicate submissions
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
// Fetch all records
$sql = "SELECT * FROM tblshipmenttransport";
$result = $conn->query($sql);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Admin Transport Dashboard</title>
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
    <section class="form-section">
        <h2>Enter Shipment Transport Details</h2>
        <form method="POST" action="">
            <label for="shTransportType">Shipment Transport Type:</label>
            <input type="text" id="shTransportType" name="sh_transport_type" required>

            <label for="transportType">Transport Type:</label>
            <input type="text" id="transportType" name="transport_type" required>

            <label for="temperatureRange">Temperature Range:</label>
            <input type="text" id="temperatureRange" name="temperature_range" required>

            <button type="submit">Submit</button>
        </form>
    </section>

    <section class="table-section">
        <h2>Shipment Transport Table</h2>
        <table>
            <thead>
                <tr>
                    <th>Shipment ID</th>
                    <th>Shipment Transport Type</th>
                    <th>Transport Type</th>
                    <th>Temperature Range</th>
                    <th>Storage ID</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['shTransport ID']; ?></td>
                        <td><?php echo $row['shTransport Type']; ?></td>
                        <td><?php echo $row['Transport Type']; ?></td>
                        <td><?php echo $row['Temperature Range']; ?></td>
                        <td><?php echo $row['Storage ID']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
        
    
        
    </main>
</body>
</html>
