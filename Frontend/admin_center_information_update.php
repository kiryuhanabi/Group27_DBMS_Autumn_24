<?php
// Include the database connection
include('connect.php');

// Check if the center ID is passed via GET
if (isset($_GET['id'])) {
    $center_id = $_GET['id'];

    // Fetch the current data for the center
    $select_sql = "SELECT `Center ID`, `Type`, `Location` FROM tblprocessingcenter WHERE `Center ID` = ?";
    $select_stmt = $conn->prepare($select_sql);
    $select_stmt->bind_param("s", $center_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();

    // If the center exists, fetch the data
    if ($result->num_rows > 0) {
        $center = $result->fetch_assoc();
    } else {
        echo "Center not found!";
        exit();
    }
} else {
    echo "No center ID provided!";
    exit();
}

// Check if the form is submitted to update the center
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated values from the form
    $new_type = $_POST['type'];
    $new_location = $_POST['location'];

    // Update the processing center information
    $update_sql = "UPDATE tblprocessingcenter SET `Type` = ?, `Location` = ? WHERE `Center ID` = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sss", $new_type, $new_location, $center_id);

    if ($update_stmt->execute()) {
        // Redirect to the center information page after successful update
        header("Location: admin_center_information.php");
        exit();
    } else {
        echo "Error updating center: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_user_update_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Update Processing Center</title>
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
        <h1>Update Processing Center</h1>
        <form action="admin_center_information_update.php?id=<?php echo $center_id; ?>" method="POST">
            <div class="form-group">
                <label for="center_id">Center ID:</label>
                <input type="text" id="center_id" name="center_id" class="form-control" value="<?php echo $center['Center ID']; ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <input type="text" id="type" name="type" class="form-control" value="<?php echo $center['Type']; ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control" value="<?php echo $center['Location']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Center</button>
        </form>
    </main>
</body>
</html>
