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
    $storageType = $_POST['storage_type'];
    $transportType = $_POST['transport_type'];
    $loadWeight = $_POST['load_weight'];
    $temperatureRange = $_POST['temperature_range'];

    // Generate stTransport ID starting from 2211508
    $resultTransport = $conn->query("SELECT MAX(`stTransport ID`) AS max_id FROM tblstoragetransport");
    $rowTransport = $resultTransport->fetch_assoc();
    $nextTransportId = ($rowTransport['max_id'] ?? 2211507) + 1;

    // Generate Storage ID starting from 2122885
    $resultStorage = $conn->query("SELECT MAX(`Storage ID`) AS max_id FROM tblstoragetransport");
    $rowStorage = $resultStorage->fetch_assoc();
    $nextStorageId = ($rowStorage['max_id'] ?? 2122884) + 1;

    $currentDate = date("Y-m-d");

    $sql = "INSERT INTO tblstoragetransport (`stTransport ID`, `Storage ID`, `Storage Type`, `Date`, `Transport Type`, `Load Weight`, `Temperature Range`) 
            VALUES ($nextTransportId, $nextStorageId, '$storageType', '$currentDate', '$transportType', '$loadWeight', '$temperatureRange')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to avoid duplicate submissions
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all records
$sql = "SELECT * FROM tblstoragetransport";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport to Storage</title>
    <link rel="stylesheet" href="transport_center.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="logo.png" rel="icon" type="image/png">
</head>
<body>
    <h1>
        <img src="logo.png" alt="Transport Logo" class="logo-img">
        Agro Center Transport
    </h1>
    <nav class="nav">
        <ul class="ul">
            <li><a href="transport.php">Home</a></li>
            <li><a href="transport_center.php">Transport to Processing Center</a></li>
            <li><a href="#">Transport to Storage</a></li>
            <li><a href="transportShipment_to_ratailer.php">Transport Shipment to Retailer</a></li>
            <li><a href="login.php">Logout</a></li>  
        </ul>
    </nav>
    <h2>Storage Transport</h2>

    <div class="form-container">
        <form method="POST" action="">
            <h3>Enter Storage Transport Details</h3>

            <label for="storageType">Storage Type:</label>
            <input type="text" id="storageType" name="storage_type" required>

            <label for="transportType">Transport Type:</label>
            <input type="text" id="transportType" name="transport_type" required>

            <label for="temperatureRange">Temperature Range:</label>
            <input type="text" id="temperatureRange" name="temperature_range" required>

            <label for="loadWeight">Load Weight (kg):</label>
            <input type="number" id="loadWeight" name="load_weight" required>

            <button type="submit">Submit</button>
        </form>
    </div>

    <div class="table-container">
        <h3>Data Entries</h3>
        <table id="storageTable" class="boxed-table">
            <thead>
                <tr>
                    <th>Transport ID</th>
                    <th>Storage ID</th>
                    <th>Storage Type</th>
                    <th>Transport Date</th>
                    <th>Transport Type</th>
                    <th>Load Weight</th>
                    <th>Temperature Range</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['stTransport ID']; ?></td>
                        <td><?php echo $row['Storage ID']; ?></td>
                        <td><?php echo $row['Storage Type']; ?></td>
                        <td><?php echo $row['Date']; ?></td>
                        <td><?php echo $row['Transport Type']; ?></td>
                        <td><?php echo $row['Load Weight']; ?></td>
                        <td><?php echo $row['Temperature Range']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
