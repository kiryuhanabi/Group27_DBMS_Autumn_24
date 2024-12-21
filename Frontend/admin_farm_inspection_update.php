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
    $maintenanceGrade = $_POST['maintenanceGrade'];
    $farmID = $_POST['farmID'];
    $fertilizerGrade = $_POST['fertilizerGrade'];
    $soilQualityGrade = $_POST['soilQualityGrade'];

    $sql = "UPDATE tblfarminspection SET 
                `Date` = '$inspectionDate',
                `Inspector ID` = '$inspectorID',
                `Maintenance Grade` = '$maintenanceGrade',
                `Farm ID` = '$farmID',
                `Fertilizer Grade` = '$fertilizerGrade',
                `Soil Quality Grade` = '$soilQualityGrade'
            WHERE `Farm ID` = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_farm_inspection.php");
        exit;
    } else {
        $message = "Error updating record: " . $conn->error;
    }
}

// Fetch the current record details
$sql = "SELECT * FROM tblfarminspection WHERE `Farm ID` = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Record not found.");
}

$row = $result->fetch_assoc();
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
                    </ul>
                </li>
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
                    </ul>
                </li>
                <li><a href="#storage">Storage</a></li>
                <li><a href="#transport">Transport</a></li>
                <li><a href="#retailer">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>

    <section class="form-container">
        <script src="farm_inspection.js"></script>
        <div class="inspection-filters">
            <h3>Update Inspection</h3>
            <form accept="" method="POST">
                <div class="form-group">
                    <div class="left-column">
                        <div class="input-row">
                            <label for="inspectionDate">Date:</label>
                            <input type="date" id="inspectionDate" name="inspectionDate" required>
                        </div>

                        <div class="input-row">
                            <label for="farmID">Farm ID:</label>
                            <input type="text" id="farmID" name="farmID" required>
                        </div>
        
                        <div class="input-row">
                            <label for="inspectorID">Inspector ID:</label>
                            <input type="text" id="inspectorID" name="inspectorID" required>
                        </div>
                    </div>
            
                    <div class="right-column">
                        <div class="input-row">
                            <label for="maintenanceGrade">Maintenace Grade:</label>
                            <select id="maintenanceGrade" name="maintenanceGrade" required>
                                <option disabled selected>Select Type</option>
                                <option value="Poor">Poor</option>
                                <option value="Acceptable">Acceptable</option>
                                <option value="Decent">Decent</option>
                                <option value="Perfect">Perfect</option>
                            </select>
                        </div>

                        <div class="input-row">
                            <label for="fertilizerGrade">Fertilizer Grade:</label>
                            <select id="fertilizerGrade" name="fertilizerGrade" required>
                                <option disabled selected>Select Type</option>
                                <option value="Poor">Poor</option>
                                <option value="Acceptable">Acceptable</option>
                                <option value="Decent">Decent</option>
                                <option value="Perfect">Perfect</option>
                            </select>
                        </div>   
                        <div class="input-row">
                            <label for="soilQualityGrade">Soil Quality Grade:</label>
                            <select id="soilQualityGrade" name="soilQualityGrade" required>
                                <option disabled selected>Select Type</option>
                                <option value="Poor">Poor</option>
                                <option value="Acceptable">Acceptable</option>
                                <option value="Decent">Decent</option>
                                <option value="Perfect">Perfect</option>
                            </select>
                        </div>     
                    </div>
                </div>         
                <button class="btn" type="submit"><i class="fa fa-plus" aria-hidden="true"></i> Update Inspection</button>
            </form>
        </div>        
    </section>
</body>
</html>