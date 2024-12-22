<?php
// Include the database connection
include('connect.php');

// Check if the delete request is made
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete from Center Information Table
    if (strpos($id, 'Farm ID') !== false) {
        $delete_sql = "DELETE FROM tblfarminspection WHERE `Farm ID` = $id";
    }
    // Delete from IoT Device Reading Table
    elseif (strpos($id, 'Batch Barcode') !== false) {
        $delete_sql = "DELETE FROM tblbatchinspection WHERE `Batch Barcode` = $id";
    }
    // Delete from IoT Device Reading Table
    elseif (strpos($id, 'Lot Number') !== false) {
        $delete_sql = "DELETE FROM tbllotinspection WHERE `Lot Number` = $id";
    }
    // Delete from Processing Lot Details Table
    elseif (strpos($id, 'Center ID') !== false) {
        $delete_sql = "DELETE FROM tblprocessinginspection WHERE `Center ID` = $id";
    }
    elseif (strpos($id, 'Storage ID') !== false) {
        $delete_sql = "DELETE FROM tblstorageinspection WHERE `Storage ID` = $id";
    }

    // Prepare and execute the delete query
    if (isset($delete_sql)) {
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("s", $id);

        // Execute the delete operation
        if ($delete_stmt->execute()) {
            // Redirect to the same page to refresh the table after deletion
            header("Location: admin_inspector.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Fetch data for Farm Inspection
$farm_sql = "SELECT * FROM tblfarminspection";
$farm_result = $conn->query($farm_sql);

// Fetch data for IoT Device Reading
$batch_sql = "SELECT * FROM tblbatchinspection";
$batch_result = $conn->query($batch_sql);

// Fetch data for Lot Inspections
$lot_sql = "SELECT * FROM tbllotinspection";
$lot_result = $conn->query($lot_sql);

// Fetch data for Processing Center Inspections
$processing_center_sql = "SELECT * FROM tblprocessinginspection";
$processing_center_result = $conn->query($processing_center_sql);

// Fetch data for Storage Inspections
$storage_sql = "SELECT * FROM tblstorageinspection";
$storage_result = $conn->query($storage_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Inspector</title>
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
    </header> 

    <main>
        <!-- Farm Inspections Table -->
        <h2>Farm Inspections</h2>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Inspector ID</th>
                        <th>Farm ID</th>
                        <th>Maintenance Grade</th>
                        <th>Fertilizer Grade</th>
                        <th>Soil Quality Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($farm_result->num_rows > 0): ?>
                        <?php while ($row = $farm_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Inspector ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Farm ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Maintenance Grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['Fertilizer Grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['Soil Quality Grade']); ?></td>
                                <td>
                                <a href="admin_inspector_edit.php?id=<?php echo $row['Farm ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="admin_inspector.php?id=<?php echo $row['Farm ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        <!-- Batch Inspections Table -->
        <h2>Batch Inspections</h2>
        <table class="table table-bordered">
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
                <tbody>
                    <?php if ($batch_result->num_rows > 0): ?>
                        <?php while ($row = $batch_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Inspector ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Batch Barcode']); ?></td>
                                <td><?php echo htmlspecialchars($row['Unaffected Quality Grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['Certification']); ?></td>
                                <td>
                                <a href="admin_inspector_edit.php?id=<?php echo $row['Batch Barcode']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="admin_inspector.php?id=<?php echo $row['Batch Barcode']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
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

            <h2>Lot Inspections</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Inspector ID</th>
                        <th>Lot Number</th>
                        <th>Package Quality</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($lot_result->num_rows > 0): ?>
                        <?php while ($row = $lot_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Inspector ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Lot Number']); ?></td>
                                <td><?php echo htmlspecialchars($row['Package Quality Grade']); ?></td>
                                <td>
                                <a href="admin_inspector_edit.php?id=<?php echo $row['Lot Number']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="admin_inspector.php?id=<?php echo $row['Lot Number']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
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

            <h2>Processing Center Inspections</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Center ID</th>
                        <th>Inspector ID</th>
                        <th>Machine Quality</th>
                        <th>Processing Quality</th>
                        <th>Hygiene Quality</th>
                        <th>Staff Safety Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($processing_center_result->num_rows > 0): ?>
                    <?php while ($row = $processing_center_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['Center ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Inspector ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Machine Quality Grade']); ?></td>
                            <td><?php echo htmlspecialchars($row['Processing Quality Grade']); ?></td>
                            <td><?php echo htmlspecialchars($row['Center Hygene Grade']); ?></td>
                            <td><?php echo htmlspecialchars($row['Staff Safety Grade']); ?></td>
                            <td>
                                <a href="admin_inspector_edit.php?id=<?php echo $row['Center ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="admin_inspector.php?id=<?php echo $row['Center ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No records found</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <h2>Storage Inspections</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Storage ID</th>
                        <th>Inspector ID</th>
                        <th>Maintenance Grade</th>
                        <th>Pest Control Grade</th>
                        <th>Hygiene Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($storage_result->num_rows > 0): ?>
                        <?php while ($row = $storage_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Storage ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Inspector ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Storage Maintenance Grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['Pest Control Grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['Storage Hygene Grade']); ?></td>
                                <td>
                                <a href="admin_inspector_edit.php?id=<?php echo $row['Storage ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="admin_inspector.php?id=<?php echo $row['Storage ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                            </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </div>
</body>
</html>