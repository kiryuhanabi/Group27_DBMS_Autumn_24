<?php
$servername = "localhost"; 
$username = "root";       
$password = "";            
$dbname = "crud"; 

$conn = new mysqli($servername, $username, $password, $dbname);

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
    $batchBarcode = $_POST['batchBarcode'];
    $inspectorID = $_POST['inspectorID'];
    $unAffectedQuality = $_POST['unAffectedQuality'];
    $affectedBatchQuantity = $_POST['affectedBatchQuantity'];
    $certification = $_POST['certification'];

    $sql = "UPDATE tblbatchinspection SET 
            `Date`= '$inspectionDate',
            `Inspector ID`= '$inspectorID',
            `Batch Barcode`= '$batchBarcode',
            `Unaffected Quality Grade`= '$unAffectedQuality',
            `Certification`= '$certification'
            WHERE `Batch Barcode` = $id";

    $sql_cer = "UPDATE tblbatchcertification SET
                `Certification`= '$certification'
                WHERE `Batch Barcode`= $id";
    $result_cer = $conn->query($sql_cer);

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_batch_inspection.php");
        exit;
    } else {
        $message = "Error updating record: " . $conn->error;
    }

}

$sql = "SELECT * FROM tblbatchinspection WHERE `Batch Barcode` = $id";
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
                <li><a href="admin_transport.php">Transport</a></li>
                <li><a href="admin_retailer_order.php">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>

    <section class="form-container">
        <script src="batch_inspection.js"></script>
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
        
            <button class="btn" id="addInspectionButton" type="submit"><i class="fa fa-plus" aria-hidden="true"></i>  Update Inspection</button>
            </form>
        </div>
    </section>
</body>
</html>