<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "crud";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch first PresentLocation for map center
$sqlFirstLocation = "SELECT PresentLocation FROM tbltransporttrucking LIMIT 1";
$resultFirstLocation = $conn->query($sqlFirstLocation);

// Default coordinates (if no data is found)
$defaultLat = 23.8103;
$defaultLng = 90.4125;

if ($resultFirstLocation && $resultFirstLocation->num_rows > 0) {
    $row = $resultFirstLocation->fetch_assoc();
    $coords = explode(',', $row['PresentLocation']);
    if (count($coords) === 2) {
        $defaultLat = trim($coords[0]);
        $defaultLng = trim($coords[1]);
    }
}

// Fetch data from tbltransportoitdevice
$sqlIOT = "SELECT `shTransport ID`, `tIoT ID` FROM tbltransportoitdevice";
$resultIOT = $conn->query($sqlIOT);

// Fetch data from Transport Trucking table
$sqlTrucking = "SELECT `TransportID`, `ComingFrom`, `PresentLocation`, `Destination`, `ItemType` FROM tbltransporttrucking";
$resultTrucking = $conn->query($sqlTrucking);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comingFrom = $_POST['comingFrom'];
    $presentLocation = $_POST['presentLocation'];
    $destination = $_POST['destination'];
    $itemType = $_POST['itemType'];

    $sqlInsert = "INSERT INTO tbltransporttrucking (`ComingFrom`, `PresentLocation`, `Destination`, `ItemType`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bind_param("ssss", $comingFrom, $presentLocation, $destination, $itemType);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
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
        <h1>Welcome to the Transport Admin Dashboard</h1>
        <div class="tableFields" >
    <h2>IOT Device Information</h2>
    <table>
        <thead>
            <tr>
                <th>Shipment Transport ID</th>
                <th>Transport IoT ID</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultIOT->num_rows > 0): ?>
                <?php while ($row = $resultIOT->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['shTransport ID']; ?></td>
                        <td><?php echo $row['tIoT ID']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
            </div>
        
    
        
    </main>
</body>
</html>
