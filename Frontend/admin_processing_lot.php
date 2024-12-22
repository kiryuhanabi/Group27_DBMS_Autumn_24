<?php
// Include the database connection
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $batchBarcode = $_POST['batch_barcode'];
    $lotNumber = $_POST['lot_number'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $manufacturedDate = $_POST['manufactured_date'];
    $expiryDate = $_POST['expiry_date'];
    $stTransportID = $_POST['st_transport_id'];
    $centerID = $_POST['center_id'];

    // SQL query to insert data into tblprocessinglot
    $insert_sql = "INSERT INTO tblprocessinglot (`Batch Barcode`, `Lot Number`, `Date`, `Time`, `Manufactured Date`, `Expiry Date`, `stTransport ID`, `Center ID`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and execute the insert statement
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ssssssss", $batchBarcode, $lotNumber, $date, $time, $manufacturedDate, $expiryDate, $stTransportID, $centerID);

    if ($stmt->execute()) {
        // Redirect to the same page after insertion
        header("Location: admin_processing_lot.php");
        exit();
    } else {
        echo "Error adding record: " . $conn->error;
    }
}

// Check if the delete request is made
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // SQL query to delete the record based on Lot Number
    $delete_sql = "DELETE FROM tblprocessinglot WHERE `Lot Number` = ?";

    // Prepare and execute the delete statement
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $delete_id);

    if ($stmt->execute()) {
        // Redirect to the same page after deletion
        header("Location: admin_processing_lot.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// SQL query to fetch data from tblprocessinglot
$sql = "SELECT * FROM tblprocessinglot";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Processing Lot</title>
</head>
<body class="admin-page">
    <header>
        <img src="logo.png" alt="Logo" class="logo">
        <nav class="navbar">
            <ul>
                <li><a href="admin_user.php">User</a></li>
                <li><a href="#" class="dropdown">Farm</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_farm.php">Farm Information</a></li>
                        <li><a href="admin_farm_product.php">Farm Product</a></li>
                        <li><a href="admin_farm_batch.php">Farm Batch</a></li>
                    </ul></li>
                <li>
                    <a href="#" class="dropdown">Processing Center</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_center_information.php">Center Information</a></li>
                        <li><a href="admin_iot_reading.php">IoT Device Reading</a></li>
                        <li><a href="admin_processing_lot.php">Processing Lot</a></li>
                    </ul>
                </li>
                <li><a href="admin_storage.php">Storage</a></li>
                <li><a href="admin_transport.php">Transport</a></li>
                <li><a href="admin_retailer_order.php">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Processing Lot</h1>

        <!-- Processing Lot Form -->
        <form method="POST" class="lot-form">
            <h2>Processing Lot Form</h2>
            <label for="batch_barcode">Batch Barcode:</label>
            <input type="text" id="batch_barcode" name="batch_barcode" required>

            <label for="lot_number">Lot Number:</label>
            <input type="text" id="lot_number" name="lot_number" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <label for="manufactured_date">Manufactured Date:</label>
            <input type="date" id="manufactured_date" name="manufactured_date" required>

            <label for="expiry_date">Expiry Date:</label>
            <input type="date" id="expiry_date" name="expiry_date" required>

            <label for="st_transport_id">stTransport ID:</label>
            <input type="text" id="st_transport_id" name="st_transport_id" required>

            <label for="center_id">Center ID:</label>
            <input type="text" id="center_id" name="center_id" required>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <!-- Processing Lot Table -->
        <?php
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Batch Barcode</th>
                            <th>Lot Number</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Manufactured Date</th>
                            <th>Expiry Date</th>
                            <th>stTransport ID</th>
                            <th>Center ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['Batch Barcode'] . '</td>
                        <td>' . $row['Lot Number'] . '</td>
                        <td>' . $row['Date'] . '</td>
                        <td>' . $row['Time'] . '</td>
                        <td>' . $row['Manufactured Date'] . '</td>
                        <td>' . $row['Expiry Date'] . '</td>
                        <td>' . $row['stTransport ID'] . '</td>
                        <td>' . $row['Center ID'] . '</td>
                        <td>
                            <a href="admin_processing_lot_update.php?id=' . $row['Lot Number'] . '" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin_processing_lot.php?delete_id=' . $row['Lot Number'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this?\')">Delete</a>
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
