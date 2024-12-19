<?php
// Include the database connection file
include('connect.php');

// Initialize a variable to store the query result for center information
$centerInfo = "";

// Correct SQL query to fetch the center information
$sql = "SELECT `Center ID`, `Type`, `Location` FROM tblprocessingcenter LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the data if available
    while ($row = $result->fetch_assoc()) {
        $centerId = $row['Center ID'];
        $type = $row['Type'];
        $location = $row['Location'];

        // Store the information to display
        $centerInfo = "<p><strong>Center ID:</strong> $centerId</p>
                       <p><strong>Type:</strong> $type</p>
                       <p><strong>Location:</strong> $location</p>";
    }
} else {
    // If no data, show "No Center Information"
    $centerInfo = "<p>No Center information found for your account.</p>";
}

// Handle delete operation
if (isset($_GET['delete'])) {
    $pIoTID = $_GET['delete']; // Get the IoT ID to be deleted

    // Correct SQL query to delete the record
    $sql = "DELETE FROM tblprocessingiot WHERE `pIoT ID` = '$pIoTID'";

    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully!";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
}

// Initialize variables for the IoT device form
$centerIdInput = $temperature = $humidity = $date = $time = "";
$message = "";

// Handle form submission for creating a new IoT device reading
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $centerIdInput = $_POST['centerId'];
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Correct SQL query to insert the IoT device reading into the tblprocessingiot table
    $sql = "INSERT INTO tblprocessingiot (`Center ID`, `Temperature`, `Humidity`, `Date`, `Time`) 
            VALUES ('$centerIdInput', '$temperature', '$humidity', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        $message = "New IoT Device Reading added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all IoT device readings from the tblprocessingiot table (Read operation)
$iotReadings = "";
$sql = "SELECT `pIoT ID`, `Center ID`, `Temperature`, `Humidity`, `Date`, `Time` FROM tblprocessingiot";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch and display all the rows
    while ($row = $result->fetch_assoc()) {
        $iotReadings .= "<tr>
                            <td>" . $row['pIoT ID'] . "</td>
                            <td>" . $row['Center ID'] . "</td>
                            <td>" . $row['Temperature'] . "°C</td>
                            <td>" . $row['Humidity'] . "%</td>
                            <td>" . $row['Date'] . "</td>
                            <td>" . $row['Time'] . "</td>
                            <td><a href='processing_iot_update.php?iotId=" . $row['pIoT ID'] . "' class='btn'>Edit</a></td>
                            <td><a href='?delete=" . $row['pIoT ID'] . "' class='btn'>Delete</a></td>
                          </tr>";
    }
} else {
    $iotReadings = "<tr><td colspan='8'>No IoT device readings found</td></tr>";
}

// Fetch all batch details from the tblbatch table (Read operation for Batch Details)
$batchDetails = "";
$sql = "SELECT `Batch Barcode`, `Harvest Date`, `Expiry Date`, `Quantity`, `Product ID`, `Farm ID` FROM tblbatch";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch and display all the rows for batch details
    while ($row = $result->fetch_assoc()) {
        $batchDetails .= "<tr>
                            <td>" . $row['Batch Barcode'] . "</td>
                            <td>" . $row['Harvest Date'] . "</td>
                            <td>" . $row['Expiry Date'] . "</td>
                            <td>" . $row['Quantity'] . "</td>
                            <td>" . $row['Product ID'] . "</td>
                            <td>" . $row['Farm ID'] . "</td>
                            <td><button class='convert-btn' onclick=\"window.location.href='processing_lot.php'\">Convert to Lot</button></td>
                          </tr>";
    }
} else {
    $batchDetails = "<tr><td colspan='7'>No Batch details found</td></tr>";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Center</title>
    <link rel="stylesheet" href="processing_style.css">
    <link href="logo.png" rel="icon" type="image/png">
</head>
<body>
    <header class="header">
        <h1>
            <img src="logo.png" alt="Processing Center Logo" class="logo-img">
            Processing Center
        </h1>
    </header>

    <nav class="nav">
        <ul class="ul">
            <li><a href="processing_center.php">Home</a></li>
            <li><a href="processing_inspection.html">Inspection</a></li>
            <li><a href="processing_lot.php">Processing Lot</a></li>
            <li><a href="starting_page.html">Logout</a></li>
        </ul>
    </nav>

    <!-- Center Information Section -->
    <section class="center-info-container">
        <h2>Center Information</h2>
        <div id="centerInfo">
            <!-- Display the PHP fetched center info -->
            <?php echo $centerInfo; ?>
        </div>
        <button class="btn" onclick="window.location.href='processing_update.php'">Add/Update</button>
    </section>

    <!-- IoT Device Reading Section -->
    <section class="iot-reading-container">
        <h2>IoT Device Reading</h2>

        <!-- Show success or error message for IoT Device Reading creation -->
        <?php if (isset($message) && $message != "") { echo "<p>$message</p>"; } ?>

        <!-- Add IoT Device Form -->
        <form id="addIotDeviceForm" method="POST" action="">
            <div>
                <label for="centerId">Center ID:</label>
                <input type="text" id="centerId" name="centerId" required>
            </div>
            <div>
                <label for="temperature">Temperature:</label>
                <input type="number" id="temperature" name="temperature" step="0.1" required>
            </div>
            <div>
                <label for="humidity">Humidity:</label>
                <input type="number" id="humidity" name="humidity" step="0.1" required>
            </div>
            <div>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <button class="btn" type="submit">Add</button>
        </form>

        <!-- IoT Device Reading Table -->
        <table border="1" cellspacing="0" cellpadding="10" class="center-table">
            <thead>
                <tr>
                    <th>IoT ID</th>
                    <th>Center ID</th>
                    <th>Temperature</th>
                    <th>Humidity</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic rows fetched from the database -->
                <?php echo $iotReadings; ?>
            </tbody>
        </table>
    </section>

    <!-- Batch Details Section -->
    <section class="batch-info-container">
        <h2>Batch Details</h2>
        <table border="1" cellspacing="0" cellpadding="10">
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
                <!-- Dynamic rows fetched from the database -->
                <?php echo $batchDetails; ?>
            </tbody>
        </table>
    </section>
</body>
</html>
