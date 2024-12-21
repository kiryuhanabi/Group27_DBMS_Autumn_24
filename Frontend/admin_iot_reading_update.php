<?php
// Include the database connection
include('connect.php');

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the IoT data from the database
    $sql = "SELECT * FROM tblprocessingiot WHERE `pIoT ID` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $iot = $result->fetch_assoc();
} else {
    echo "No IoT ID provided.";
    exit();
}

// Check if the form has been submitted to update the IoT data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $center_id = $_POST['center_id'];
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Update the IoT data in the database
    $update_sql = "UPDATE tblprocessingiot SET `Center ID` = ?, `Temperature` = ?, `Humidity` = ?, `Date` = ?, `Time` = ? WHERE `pIoT ID` = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssi", $center_id, $temperature, $humidity, $date, $time, $id);

    if ($update_stmt->execute()) {
        // Redirect to the IoT readings table after updating
        header("Location: admin_iot_reading.php");
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
    <title>Edit IoT Reading</title>
</head>
<body class="admin-page">
    <header>
        <img src="logo.png" alt="Logo" class="logo">
        <nav class="navbar">
            <ul>
                <li><a href="admin_user.php">User</a></li>
                <li><a href="#farm">Farm</a></li>
                <li>
                    <a href="#" class="dropdown">Processing Center</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_center_information.php">Center Information</a></li>
                        <li><a href="admin_iot_reading.php">IoT Device Reading</a></li>
                        <li><a href="admin_processing_lot.php">Processing Lot</a></li>
                    </ul>
                </li>
                <li><a href="#storage">Storage</a></li>
                <li><a href="#transport">Transport</a></li>
                <li><a href="#retailer">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2 class="form-title">Edit IoT Reading</h2>

        <!-- Edit IoT Reading Form -->
        <form method="POST">
            <div class="form-group">
                <label for="center_id">Center ID:</label>
                <input type="text" id="center_id" name="center_id" class="form-control" value="<?php echo $iot['Center ID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="temperature">Temperature:</label>
                <input type="text" id="temperature" name="temperature" class="form-control" value="<?php echo $iot['Temperature']; ?>" required>
            </div>
            <div class="form-group">
                <label for="humidity">Humidity:</label>
                <input type="text" id="humidity" name="humidity" class="form-control" value="<?php echo $iot['Humidity']; ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" class="form-control" value="<?php echo $iot['Date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" class="form-control" value="<?php echo $iot['Time']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </main>
</body>
</html>
