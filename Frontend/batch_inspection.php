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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inspectionDate = $_POST['inspectionDate'];
    $batchBarcode = $_POST['batchBarcode'];
    $inspectorID = $_POST['inspectorID'];
    $unAffectedQuality = $_POST['unAffectedQuality'];
    $certification = $_POST['certification'];

    $sql = "INSERT INTO tblbatchinspection (`Date`, `Inspector ID`, `Batch Barcode`, `Unaffected Quality Grade`, `Certification`)
        VALUES ('$inspectionDate', '$inspectorID', '$batchBarcode', '$unAffectedQuality', '$certification')";

    $sql_cer = "INSERT INTO tblbatchcertification (`Batch Barcode`,`Certification`) VALUES ('$batchBarcode','$certification')";
    $result_cer = $conn->query($sql_cer);
    
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch Inspection Dashboard</title>
    <link rel="stylesheet" href="inspection_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css" integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <h1>
            <img src="logo.png" alt="Agro Logo" class="logo-img"> Agro
        </h1>
    </header>

    <nav class="nav">
        <ul>
            <li><a href="inspector.php">Home</a></li>
            <li>
                <a href="#">Inspection Type</a>
                <ul class="dropdown">
                    <li><a href="farm_inspection.php">Farm</a></li>
                    <li><a href="batch_inspection.php">Batch</a></li>
                    <li><a href="lot_inspection.php">Lot</a></li>
                    <li><a href="p_inspect.php">Processing Center</a></li>
                    <li><a href="storage_inspection.php">Storage</a></li>
                </ul>
            </li>
            <li><a href="login.html">Log out</a></li>
            <li><a href="notifications.html"><i class="fa fa-bell" aria-hidden="true"></i></a></li>
        </ul>

    </nav>

    <div class="dashboard">
        <h2>Batch Inspection</h2>
        <script src="batch_inspection.js"></script>

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
                                    <form method="POST" action="batch_inspection_delete.php">
                                        <input type="hidden" name="id" value="<?php echo $row['Batch Barcode']; ?>">
                                        <button type="submit" name="delete" class="btn"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                    </form>
                                    <form method="GET" action="batch_inspection_update.php">
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
    </body>
</html>
