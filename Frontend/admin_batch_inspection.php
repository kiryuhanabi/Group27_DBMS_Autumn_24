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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inspectionDate = $_POST['inspectionDate'];
    $inspectorID = $_POST['inspectorID'];
    $maintenanceGrade = $_POST['maintenanceGrade'];
    $farmID = $_POST['farmID'];
    $fertilizerGrade = $_POST['fertilizerGrade'];
    $soilQualityGrade = $_POST['soilQualityGrade'];

    $sql = "INSERT INTO tblfarminspection (`Date`, `Inspector ID`, `Maintenance Grade`, `Farm ID`, `Fertilizer Grade`, `Soil Quality Grade`)
        VALUES ('$inspectionDate', '$inspectorID', '$maintenanceGrade', '$farmID', '$fertilizerGrade', '$soilQualityGrade')";

    if ($conn->query($sql) === TRUE) {
        $message = "Inspection added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM tblbatchinspection";
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
                <li>
                    <a href="#" class="dropdown">Inspector</a>
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
        <script src="batch_inspection.js"></script>
        <div class="inspection-filters">
            <h3>Create New inspection</h3>
            <form action="" method="POST">
            <div class="form-group">
                <div class="left-column">
                    <div class="input-row">
                        <label for="inspectionDate">Date:</label>
                        <input type="date" id="inspectionDate" name="inspectionDate">
                    </div>
                    <div class="input-row">
                        <label for="batchBarcode">Batch Barcode:</label>
                        <input type="text" id="batchBarcode" name="batchBarcode">
                    </div>

                    <div class="input-row">
                        <label for="inspectorID">Inspector ID:</label>
                        <input type="text" id="inspectorID" name="inspectorID">
                    </div>
                    
                </div>
        
                <div class="right-column">
                <div class="input-row">
                        <label for="unAffectedQuality">Unaffected Batch Quality:</label>
                        <select id="unAffectedQuality" name="unAffectedQuality" required>
                            <option disabled selected>Select Type</option>
                            <option value="Poor">Poor</option>
                            <option value="Acceptable">Acceptable</option>
                            <option value="Decent">Decent</option>
                            <option value="Perfect">Perfect</option>
                        </select>
                    </div>

                    <div class="input-row">
                        <label for="certification">Certification:</label>
                        <input type="text" id="certification" name="certification">
                    </div>
                </div>
            </div>
        
            <button class="btn" id="addInspectionButton" type="submit"><i class="fa fa-plus" aria-hidden="true"></i>  Add Inspection</button>
            </form>
        </div>

        <div class="table-container">
            <table id="inspectionTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Batch Barcode</th>
                        <th>Inspector ID</th>
                        <th>Unaffected Batch Quality</th>
                        <th>Certification</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="inspectionTableBody">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Inspector ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Batch Barcode']); ?></td>
                                <td><?php echo htmlspecialchars($row['Unaffected Quality Grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['Certification']); ?></td>
                                <td>
                                    <form method="POST" action="admin_batch_inspection_delete.php">
                                        <input type="hidden" name="id" value="<?php echo $row['Batch Barcode']; ?>">
                                        <button type="submit" name="delete" class="btn"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                    </form>
                                    <form method="GET" action="admin_batch_inspection_update.php">
                                        <input type="hidden" name="id" value="<?php echo $row['Batch Barcode']; ?>">
                                        <button type="submit" name="update" class="btn"><i class="fas fa-edit" aria-hidden="true"></i> Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>