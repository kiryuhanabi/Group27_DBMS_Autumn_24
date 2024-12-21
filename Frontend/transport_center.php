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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Center Transport</title>
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
            <li><a href="transportShipment_to_ratailer.php">Transport Shipment to Retailer</a></li>
            <li><a href="login.php">Logout</a></li>  
        </ul>
    </nav>

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

    
</body>
</html>

<?php
$conn->close();
?>
