<?php
// Connect to the database
$host = "localhost"; // Replace with your host
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$dbname = "crud";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transportType = $_POST['transport_type'];
    $temperatureRange = $_POST['temperature_range'];
    $loadWeight = $_POST['load_weight'];

    // Generate pTransport ID starting from 2210885
    $result = $conn->query("SELECT MAX(`pTransport ID`) AS max_id FROM tblprocessingtransport");
    $row = $result->fetch_assoc();
    $nextId = ($row['max_id'] ?? 2210884) + 1;

    $currentDate = date("Y-m-d");

    $sql = "INSERT INTO tblprocessingtransport (`pTransport ID`, `Date`, `Transport Type`, `Temperature Range`, `Load Weight`) 
            VALUES ($nextId, '$currentDate', '$transportType', '$temperatureRange', '$loadWeight')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the same page to prevent resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit; // Ensure no further code is executed
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all records
$sql = "SELECT * FROM tblprocessingtransport";
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
                        <li><a href="admin_Transport_php.php">Transport to Storage</a></li>
                        <li><a href="admin_transportShipment_to_ratailer.php">Transport Shipmenet to Retailer</a></li>
                    </ul></li>
                 <li><a href="admin_retailer_order.php">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
    <section class="form-container">
        <h2>Add New Transport Record</h2>
        <form method="POST" action="">
            <label for="transport_type">Transport Type:</label>
            <input type="text" id="transport_type" name="transport_type" required>

            <label for="temperature_range">Temperature Range:</label>
            <input type="text" id="temperature_range" name="temperature_range" required>

            <label for="load_weight">Load Weight:</label>
            <input type="number" id="load_weight" name="load_weight" required>

            <button type="submit">Add Record</button>
        </form>
    </section>

    <section class="table-container">
        <h2>Center Transport Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Processing Transport ID</th>
                    <th>Date</th>
                    <th>Transport Type</th>
                    <th>Temperature Range</th>
                    <th>Load Weight</th>
                </tr>
            </thead>
            <tbody id="transport-table">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['pTransport ID']; ?></td>
                        <td><?php echo $row['Date']; ?></td>
                        <td><?php echo $row['Transport Type']; ?></td>
                        <td><?php echo $row['Temperature Range']; ?></td>
                        <td><?php echo $row['Load Weight']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
        
    
        
    </main>
</body>
</html>
