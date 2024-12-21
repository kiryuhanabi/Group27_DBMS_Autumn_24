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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Shipment to Retailer</title>
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
            <li><a href="transport_storage.php">Transport to Storage</a></li>
            <li><a href="#">Transport Shipment to Retailer</a></li>
            <li><a href="login.php">Logout</a></li>  
        </ul>
    </nav>

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

</body>
</html>

<?php
$conn->close();
?>
