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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Home</title>
    <link rel="stylesheet" href="transport_center.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>
    <h1>Transport Home</h1>
    <form method="POST" action="">
        <label for="comingFrom">Coming From:</label>
        <input type="text" id="comingFrom" name="comingFrom" required><br>

        <label for="presentLocation">Present Location:</label>
        <input type="text" id="presentLocation" name="presentLocation" placeholder="e.g., Mohakhali, Dhaka" required><br>

        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required><br>

        <label for="itemType">Item Type:</label>
        <input type="text" id="itemType" name="itemType" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Existing Transport Trucking Data</h2>
    <table>
        <thead>
            <tr>
                <th>Transport ID</th>
                <th>Coming From</th>
                <th>Present Location</th>
                <th>Destination</th>
                <th>Item Type</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultTrucking->num_rows > 0): ?>
                <?php while ($row = $resultTrucking->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['TransportID']; ?></td>
                        <td><?php echo $row['ComingFrom']; ?></td>
                        <td><?php echo $row['PresentLocation']; ?></td>
                        <td><?php echo $row['Destination']; ?></td>
                        <td><?php echo $row['ItemType']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="map" style="height: 500px; width: 100%;"></div>

    <script>
    // Set map center using the default coordinates from PHP
    const map = L.map('map').setView([<?php echo $defaultLat; ?>, <?php echo $defaultLng; ?>], 13);

    // Add the tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add markers from database
    <?php
    $resultTrucking->data_seek(0); // Reset pointer to loop through again
    while ($row = $resultTrucking->fetch_assoc()): 
        // Check if PresentLocation has a valid format
        $coords = explode(',', $row['PresentLocation']);
        if (count($coords) === 2): 
            $lat = trim($coords[0]);
            $lng = trim($coords[1]);
    ?>
        // Debugging: Log the TransportID and coordinates to the console
        console.log("Adding marker for TransportID: <?php echo $row['TransportID']; ?>, Coordinates: <?php echo $lat; ?>, <?php echo $lng; ?>");

        // Validate if the coordinates are numeric before creating marker
        if (!isNaN(<?php echo $lat; ?>) && !isNaN(<?php echo $lng; ?>)) {
            const marker = L.marker([<?php echo $lat; ?>, <?php echo $lng; ?>]).addTo(map);
            marker.bindPopup(`
                <strong>Transport ID:</strong> <?php echo $row['TransportID']; ?><br>
                <strong>Coming From:</strong> <?php echo $row['ComingFrom']; ?><br>
                <strong>Destination:</strong> <?php echo $row['Destination']; ?><br>
                <strong>Item Type:</strong> <?php echo $row['ItemType']; ?><br>
            `);
        } else {
            console.log("Invalid coordinates for TransportID: <?php echo $row['TransportID']; ?>, Coordinates: <?php echo $lat; ?>, <?php echo $lng; ?>");
        }
    <?php 
        else:
            // Log if coordinates are invalid
            echo "console.log('Invalid coordinates for TransportID: " . $row['TransportID'] . "');";
        endif;
    endwhile; 
    ?>
</script>



</body>
</html>

<?php
$conn->close();
?>
