<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "crud";

// Connect to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $farmID = $_POST['farmID'];
    $farmName = $_POST['farmName'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $numFields = $_POST['numFields'];

    if (isset($_POST['add'])) {
        // Add new farm information
        $stmt = $conn->prepare("INSERT INTO tblfarm (`Farm ID`, `Farm Name`, `Street`, `City`, `No. of Fields`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $farmID, $farmName, $street, $city, $numFields);

        if ($stmt->execute()) {
            $message = "Farm added successfully!";
        } else {
            $message = "Error adding farm: " . $conn->error;
        }
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Update existing farm information
        $stmt = $conn->prepare("UPDATE tblfarm SET `Farm Name` = ?, `Street` = ?, `City` = ?, `No. of Fields` = ? WHERE `Farm ID` = ?");
        $stmt->bind_param("sssii", $farmName, $street, $city, $numFields, $farmID);

        if ($stmt->execute()) {
            $message = "Farm updated successfully!";
        } else {
            $message = "Error updating farm: " . $conn->error;
        }
        $stmt->close();
    }

    // Redirect back to the form with a success or error message
    header("Location: farm_update.php?message=" . urlencode($message));
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Admin Dashboard</title>
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
                <li><a href="#" class="dropdown">Inspector</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_farm_inspection.php">Farm</a></li>
                        <li><a href="admin_batch_inspection.php">Batch</a></li>
                        <li><a href="admin_lot_inspection.php">Lot</a></li>
                        <li><a href="admin_processing_center_inspection.php">Processing Center</a></li>
                        <li><a href="admin_storage_batch.php">Storage</a></li>
                    </ul></li>
                <li>
                <li><a href="admin_storage.php">Storage</a></li>
                <li><a href="admin_transport.php">Transport</a></li>
                <li><a href="admin_retailer_order.php">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>

    <section class="farm-update-container">
        <h2>Add/Update Farm Information</h2>
        
        <!-- Display dynamic message -->
        <?php if (isset($_GET['message'])): ?>
            <div id="message" class="alert">
                <p><?php echo htmlspecialchars($_GET['message']); ?></p>
            </div>
        <?php endif; ?>

        <!-- Form for adding/updating farm information -->
        <form action="farm_update.php" method="POST">
            <div class="input-row">
                <label for="farmID">Farm ID:</label>
                <input type="number" id="farmID" name="farmID" required>
            </div>

            <div class="input-row">
                <label for="farmName">Farm Name:</label>
                <input type="text" id="farmName" name="farmName" required>
            </div>

            <div class="input-row">
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" required>
            </div>

            <div class="input-row">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
            </div>

            <div class="input-row">
                <label for="numFields">Number of Fields:</label>
                <input type="number" id="numFields" name="numFields" min="1" required>
            </div>

            <!-- Buttons -->
            <div class="button-container">
                <button type="submit" name="add" class="btn">Add Farm</button>
                <button type="submit" name="update" class="btn">Update Farm</button>
            </div>
        </form>
    </section>
</body>
</html>
