<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Admin Dashboard</title>
</head>
<body class="admin-page">
    <>
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
                <li><a href="#storage">Storage</a></li>
                <li><a href="#transport">Transport</a></li>
                <li><a href="#retailer">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
        <h1>
        <img src="logo.png" alt="Farm Logo" class="logo-img">
        Agro Farm - Update Product
    </h1>

    <section class="form-container">
    <h2>Farm Inspection</h2>
        <script src="farm_inspection.js"></script>
        <div class="inspection-filters">
            <h3>Add New Inspection</h3>
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
                <button class="btn" type="submit"><i class="fa fa-plus" aria-hidden="true"></i> Add Inspection</button>
            </form>
        </div>        

        <div class="table-container">
            <table id="inspectionTable">
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
                <tbody id="inspectionTableBody">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Inspector ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Farm ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Maintenance Grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['Fertilizer Grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['Soil Quality Grade']); ?></td>
                                <td>
                                    <form method="POST" action="farm_inspection_delete.php">
                                        <input type="hidden" name="id" value="<?php echo $row['Farm ID']; ?>">
                                        <button type="submit" name="delete" class="btn"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                    </form>
                                    <form method="GET" action="farm_inspection_update.php">
                                        <input type="hidden" name="id" value="<?php echo $row['Farm ID']; ?>">
                                        <button type="submit" name="update" class="btn"><i class="fas fa-edit" aria-hidden="true"></i> Update</button>
                                    </form>
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
    </section>
</body>
</html>