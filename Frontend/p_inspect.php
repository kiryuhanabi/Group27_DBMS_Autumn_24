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
    $centerID = $_POST['centerID'];
    $machineQuality = $_POST['machineQuality'];
    $processingQuality = $_POST['processingQuality'];
    $staffSafetyGrade = $_POST['staffSafetyGrade'];
    $hygieneGrade = $_POST['hygieneGrade'];

    $sql = "INSERT INTO tblprocessinginspection (`Date`, `Inspector ID`, `Machine Quality Grade`, `Center ID`, `Processing Quality Grade`, `Center Hygene Grade`, `Staff Safety Grade`)
        VALUES ('$inspectionDate', '$inspectorID', '$machineQuality', '$centerID', '$processingQuality', '$hygieneGrade', '$staffSafetyGrade')";

    if ($conn->query($sql) === TRUE) {
        $message = "Inspection added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM tblprocessinginspection";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Center Inspection Dashboard</title>
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
            <li><a href="inspector.html">Home</a></li>
            <li><a href="#">Inspection Type</a>
                <ul class="dropdown">
                    <li><a href="farm_inspection.php">Farm</a></li>
                    <li><a href="batch_inspection.html">Batch</a></li>
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
        <h2>Processing-Center Inspection</h2>
        <script src="p_inspect.js"></script>

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
            <button class="btn" id= "addInspectionButton" type="submit">Add Inspection</button>
            </form>
        </div>

        <div class="table-container">
            <h2>Overview of Inspections</h2>
            <table id="inspectionTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Center ID</th>
                        <th>Inspector ID</th>
                        <th>Machine Quality</th>
                        <th>Processing Quality</th>
                        <th>Hygiene Quality</th>
                        <th>Staff Safety Grade</th>
                    </tr>
                </thead>
                <tbody id="inspectionTableBody">
                    <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['Center ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Inspector ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Machine Quality Grade']); ?></td>
                            <td><?php echo htmlspecialchars($row['Processing Quality Grade']); ?></td>
                            <td><?php echo htmlspecialchars($row['Center Hygene Grade']); ?></td>
                            <td><?php echo htmlspecialchars($row['Staff Safety Grade']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No records found</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>    
    </body>
</html>
