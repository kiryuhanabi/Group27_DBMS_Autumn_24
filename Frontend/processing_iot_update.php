<?php
// Include the database connection file
include('connect.php');

// Initialize variables to hold form data
$iot_id = $center_id = $temperature = $humidity = $time = $date = "";

// Check if the form is being submitted for "Update"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $iot_id = $_POST['iot_id'];
    $center_id = $_POST['center_id'];
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $time = $_POST['time'];
    $date = $_POST['date'];

    // Update operation (Update the existing record)
    $sql = "UPDATE tblprocessingiot 
            SET `Center ID` = '$center_id', `Temperature` = '$temperature', `Humidity` = '$humidity', `Time` = '$time', `Date` = '$date' 
            WHERE `pIoT ID` = '$iot_id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to processing_center.php after successful update
        header("Location: processing_center.php");
        exit(); // Ensure the script stops after redirect
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update IoT Processing Data</title>
    <link rel="stylesheet" href="processing_iot_update_style.css">
</head>
<body>
    <header>
        <h1><img src="logo.png" alt="Logo" class="logo-img">IoT Processing Center</h1>
    </header>
    <nav>
        <ul class="ul">
            <li><a href="home.php">Home</a></li>
            <li><a href="view_data.php">View Data</a></li>
            <li><a href="processing_iot_update.php">Update Data</a></li>
        </ul>
    </nav>
    <div class="iot-update-container">
        <h2>Update IoT Processing Data</h2>

        <?php
        if (isset($message)) {
            echo "<p>$message</p>"; // Display the success/error message
        }
        ?>

        <form method="POST">
            <div>
                <label for="iot_id">pIoT ID:</label>
                <input type="text" id="iot_id" name="iot_id" placeholder="Enter IoT ID" required value="<?php echo $iot_id; ?>">
            </div>

            <div>
                <label for="center_id">Center ID:</label>
                <input type="text" id="center_id" name="center_id" placeholder="Enter Center ID" required value="<?php echo $center_id; ?>">
            </div>

            <div>
                <label for="temperature">Temperature:</label>
                <input type="number" id="temperature" name="temperature" placeholder="Enter Temperature" step="0.01" required value="<?php echo $temperature; ?>">
            </div>

            <div>
                <label for="humidity">Humidity:</label>
                <input type="number" id="humidity" name="humidity" placeholder="Enter Humidity" step="0.01" required value="<?php echo $humidity; ?>">
            </div>

            <div>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required value="<?php echo $time; ?>">
            </div>

            <div>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required value="<?php echo $date; ?>">
            </div>

            <div class="btn-container">
                <!-- Update Button -->
                <button type="submit" name="update" class="update-btn">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
