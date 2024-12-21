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
    $lotNumber = $_POST['lotNumber'];
    $packageQualityGrade = $_POST['packageQualityGrade'];

    $sql = "INSERT INTO tbllotinspection (`Date`, `Inspector ID`, `Lot Number`, `Package Quality Grade`)
        VALUES ('$inspectionDate', '$inspectorID', '$lotNumber', '$packageQualityGrade')";

    if ($conn->query($sql) === TRUE) {
        $message = "Inspection added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM tbllotinspection";
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
            <h3>Add New inspection</h3>
            <form action="" method="POST">
            <div class="form-group">
                <div class="left-column">
                    <div class="input-row">
                        <label for="inspectionDate">Date:</label>
                        <input type="date" id="inspectionDate" name="inspectionDate">
                    </div>

                    <div class="input-row">
                        <label for="inspectorID">Inspector ID:</label>
                        <input type="text" id="inspectorID" name="inspectorID">
                    </div>
                </div>
        
                <div class="right-column">
                    <div class="input-row">
                        <label for="lotNumber">Lot Number:</label>
                        <input type="text" id="lotNumber" name="lotNumber">
                    </div>

                    <div class="input-row">
                        <label for="packageQualityGrade">Package Quality:</label>
                            <select id="packageQualityGrade" name="packageQualityGrade" required>
                                <option disabled selected>Select Type</option>
                                <option value="Poor">Poor</option>
                                <option value="Acceptable">Acceptable</option>
                                <option value="Decent">Decent</option>
                                <option value="Perfect">Perfect</option>
                            </select>
                    </div>
                </div>
            </div>
            <button class="btn" type="submit">Add Inspection</button>
            </form>
        </div>

        <div class="table-container">
            <h2>Overview of Inspections</h2>
            <table id="inspectionTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Inspector ID</th>
                        <th>Lot Number</th>
                        <th>Package Quality</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="inspectionTableBody">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Inspector ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Lot Number']); ?></td>
                                <td><?php echo htmlspecialchars($row['Package Quality Grade']); ?></td>
                                <td>
                                    <form method="POST" action="admin_lot_inspection_delete.php">
                                        <input type="hidden" name="id" value="<?php echo $row['Lot Number']; ?>">
                                        <button type="submit" name="delete" class="btn"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                    </form>
                                    <form method="GET" action="admin_lot_inspection_update.php">
                                        <input type="hidden" name="id" value="<?php echo $row['Lot Number']; ?>">
                                        <button type="submit" name="update" class="btn"><i class="fas fa-edit" aria-hidden="true"></i> Update</button>
                                    </form>
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