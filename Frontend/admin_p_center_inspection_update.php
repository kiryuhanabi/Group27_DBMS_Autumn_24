<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "crud"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$id = $_GET['id'] ?? null;

if ($id === null) {
    die("Record ID is required.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inspectionDate = $_POST['inspectionDate'];
    $inspectorID = $_POST['inspectorID'];
    $centerID = $_POST['centerID'];
    $machineQuality = $_POST['machineQuality'];
    $processingQuality = $_POST['processingQuality'];
    $staffSafetyGrade = $_POST['staffSafetyGrade'];
    $hygieneGrade = $_POST['hygieneGrade'];

    $sql = "UPDATE tblprocessinginspection SET 
                `Date` = '$inspectionDate',
                `Inspector ID` = '$inspectorID',
                `Machine Quality Grade` = '$machineQuality',
                `Center ID` = '$centerID',
                `Processing Quality Grade` = '$processingQuality',
                `Staff Safety Grade` = '$staffSafetyGrade',
                `Center Hygene Grade` = '$hygieneGrade'
            WHERE `Center ID` = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_p_center_inspection.php");
        exit;
    } else {
        $message = "Error updating record: " . $conn->error;
    }
}

$sql = "SELECT * FROM tblprocessinginspection WHERE `Center ID` = $id";
$result = $conn->query($sql);

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
                        <li><a href="admin_p_center_inspection.php">Processing Center</a></li>
                        <li><a href="admin_storage_inspection.php">Storage</a></li>
                    </ul></li>
                <li>
                <li><a href="admin_storage.php">Storage</a></li>
                <li><a href="#" class="dropdown">Transport</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_transport.php">Transport Home</a></li>
                        <li><a href="admin_transport_center.php">Transport to Processing Center</a></li>
                        <li><a href="admin_Transport_storage.php">Transport to Storage</a></li>
                        <li><a href="admin_transportShipment_to_ratailer.php">Transport Shipmenet to Retailer</a></li>
                    </ul></li>
                 <li><a href="admin_retailer_order.php">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>

    <section class="form-container">
        <script src="farm_inspection.js"></script>
        <div class="inspection-filters">
            <h3>Update inspection</h3>
            <form action="" method="POST">
            <div class="form-group">
                <div class="left-column">
                    <div class="input-row">
                        <label for="inspectionDate">Date:</label>
                        <input type="date" id="inspectionDate" name="inspectionDate">
                    </div>

                    <div class="input-row">
                        <label for="centerID">Center ID:</label>
                        <input type="text" id="centerID" name="centerID">
                    </div>

                    <div class="input-row">
                        <label for="inspectorID">Inspector ID:</label>
                        <input type="text" id="inspectorID" name="inspectorID">
                    </div>
                </div>
        
                <div class="right-column">
                    <div class="input-row">
                        <label for="machineQuality">Machine Quality:</label>
                        <select id="machineQuality" name="machineQuality" required>
                            <option disabled selected>Select Grade</option>
                            <option value="Poor">Poor</option>
                            <option value="Acceptable">Acceptable</option>
                            <option value="Decent">Decent</option>
                            <option value="Perfect">Perfect</option>
                        </select>
                    </div>

                    <div class="input-row">
                        <label for="processingQuality">Processing Quality:</label>
                        <select id="processingQuality" name="processingQuality" required>
                            <option disabled selected>Select Grade</option>
                            <option value="Poor">Poor</option>
                            <option value="Acceptable">Acceptable</option>
                            <option value="Decent">Decent</option>
                            <option value="Perfect">Perfect</option>
                        </select>
                    </div>

                    <div class="input-row">
                        <label for="hygieneGrade">Center Hygiene:</label>
                        <select id="hygieneGrade" name="hygieneGrade" required>
                            <option disabled selected>Select Grade</option>
                            <option value="Poor">Poor</option>
                            <option value="Acceptable">Acceptable</option>
                            <option value="Decent">Decent</option>
                            <option value="Perfect">Perfect</option>
                        </select>
                    </div>

                    <div class="input-row">
                        <label for="staffSafetyGrade">Staff Safety Grade:</label>
                        <select id="staffSafetyGrade" name="staffSafetyGrade" required>
                            <option disabled selected>Select Grade</option>
                            <option value="Poor">Poor</option>
                            <option value="Acceptable">Acceptable</option>
                            <option value="Decent">Decent</option>
                            <option value="Perfect">Perfect</option>
                        </select>
                    </div>
                </div>
            </div>
            <button class="btn" id= "addInspectionButton" type="submit">Update Inspection</button>
            </form>
        </div>
    </section>
</body>
</html>