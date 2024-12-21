<?php
// Include the database connection
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $centerID = $_POST['center_id'];
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // SQL query to insert data into tbliot
    $insert_sql = "INSERT INTO tblprocessingiot (`Center ID`, `Temperature`, `Humidity`, `Date`, `Time`) VALUES (?, ?, ?, ?, ?)";

    // Prepare and execute the insert statement
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sssss", $centerID, $temperature, $humidity, $date, $time);

    if ($stmt->execute()) {
        // Redirect to the same page after insertion
        header("Location: admin_iot_reading.php");
        exit();
    } else {
        echo "Error adding record: " . $conn->error;
    }
}

// Check if the delete request is made
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // SQL query to delete the record
    $delete_sql = "DELETE FROM tblprocessingiot WHERE `pIoT ID` = ?";

    // Prepare and execute the delete statement
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        // Redirect to the same page after deletion
        header("Location: admin_iot_reading.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// SQL query to fetch data from tbliot
$sql = "SELECT * FROM tblprocessingiot";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>IoT Device Reading</title>
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
        <h1>IoT Device Reading</h1>

        <!-- IoT Device Reading Form -->
        <form method="POST" class="iot-form">
            <h2>IoT Device Reading Form</h2>
            <label for="center_id">Center ID:</label>
            <input type="text" id="center_id" name="center_id" required>

            <label for="temperature">Temperature:</label>
            <input type="text" id="temperature" name="temperature" required>

            <label for="humidity">Humidity:</label>
            <input type="text" id="humidity" name="humidity" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <!-- IoT Device Reading Table -->
        <?php
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>IoT ID</th>
                            <th>Center ID</th>
                            <th>Temperature</th>
                            <th>Humidity</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['pIoT ID'] . '</td>
                        <td>' . $row['Center ID'] . '</td>
                        <td>' . $row['Temperature'] . '</td>
                        <td>' . $row['Humidity'] . '</td>
                        <td>' . $row['Date'] . '</td>
                        <td>' . $row['Time'] . '</td>
                        <td>
                            <a href="admin_iot_reading_update.php?id=' . $row['pIoT ID'] . '" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin_iot_reading.php?delete_id=' . $row['pIoT ID'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this?\')">Delete</a>
                        </td>
                    </tr>';
            }
            echo '</tbody>
                </table>';
        } else {
            echo '<p>No data available</p>';
        }

        $conn->close();
        ?>
    </main>
</body>
</html>
