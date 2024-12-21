<?php 
// Include the database connection
include('connect.php');

// Fetch data for Center Information
$center_sql = "SELECT * FROM tblprocessingcenter";
$center_result = $conn->query($center_sql);

// Fetch the count of records in the table to check if it’s the last center
$center_count_sql = "SELECT COUNT(*) AS center_count FROM tblprocessingcenter";
$result_count = $conn->query($center_count_sql);
$row_count = $result_count->fetch_assoc();
$center_count = $row_count['center_count']; // Get the number of centers

// Delete for tblprocessingcenter
if (isset($_GET['delete_center_id'])) {
    $delete_id = $_GET['delete_center_id'];

    // Allow delete even if it's the last processing center
    $delete_sql = "DELETE FROM tblprocessingcenter WHERE `Center ID` = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $delete_id);

    if ($stmt->execute()) {
        header("Location: admin_center_information.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Processing Center</title>
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
                        <li><a href="admin_ioT_reading.php">IoT Device Reading</a></li>
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
        <h1>Processing Center</h1>

        <!-- Center Information Table -->
        <h2>Center Information</h2>
        <?php if ($center_result && $center_result->num_rows > 0) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Center ID</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $center_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['Center ID']; ?></td>
                        <td><?php echo $row['Type']; ?></td>
                        <td><?php echo $row['Location']; ?></td>
                        <td>
                            <!-- Edit button for the existing entry -->
                            <a href="admin_center_information_update.php?id=<?php echo $row['Center ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            
                            <!-- Delete button for the existing entry -->
                            <a href="admin_center_information.php?delete_center_id=<?php echo $row['Center ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No Data. <a href="admin_center_information_add.php" class="btn btn-primary">Add?</a></p>
        <?php } ?>
    </main>
</body>
</html>
