<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "mytest"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inspectionDate = $_POST['inspectionDate'];
    $inspectionID = $_POST['inspectionID'];
    $inspectionType = $_POST['inspectionType'];
    $farmID = $_POST['farmID'];
    $inspectorID = $_POST['inspectorID'];
    $qualityGrade = $_POST['qualityGrade'];

    $sql = "INSERT INTO test (`date`, `iID`, `iType`, `fID`, `insID`, `quality`)
        VALUES ('$inspectionDate', '$inspectionID', '$inspectionType', '$farmID', '$inspectorID', '$qualityGrade')";

    if ($conn->query($sql) === TRUE) {
        $message = "Inspection added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM test";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Inspection Dashboard</title>
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
            <li>
                <a href="#">Inspection Type</a>
                <ul class="dropdown">
                    <li><a href="farm_inspection.html">Farm</a></li>
                    <li><a href="batch_inspection.html">Batch</a></li>
                    <li><a href="lot_inspection.html">Lot</a></li>
                    <li><a href="p_inspect.html">Processing Center</a></li>
                    <li><a href="storage_inspection.html">Storage</a></li>
                </ul>
            </li>
            <li><a href="login.html">Log out</a></li>
            <li><a href="notifications.html"><i class="fa fa-bell" aria-hidden="true"></i></a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <h2>Farm Inspection</h2>
        <script src="batch_inspection.js"></script>
        <div class="inspection-filters">
            <h3>Add New Inspection</h3>
            <form action="" method="POST">
                <div class="form-group">
                    <div class="left-column">
                        <div class="input-row">
                            <label for="inspectionDate">Date:</label>
                            <input type="date" id="inspectionDate" name="inspectionDate" required>
                        </div>
                        <div class="input-row">
                            <label for="inspectionID">Inspection ID:</label>
                            <input type="text" id="inspectionID" name="inspectionID" required>
                        </div>
                        <div class="input-row">
                            <label for="inspectionType">Inspect-Type:</label>
                            <select id="inspectionType" name="inspectionType" required>
                                <option disabled>Select Type</option>
                                <option value="Soil">Soil</option>
                                <option value="Fertilizer">Fertilizer</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>
        
                    <div class="right-column">
                        <div class="input-row">
                            <label for="farmID">Farm ID:</label>
                            <input type="text" id="farmID" name="farmID" required>
                        </div>
                        <div class="input-row">
                            <label for="inspectorID">Inspector ID:</label>
                            <input type="text" id="inspectorID" name="inspectorID" required>
                        </div>
                        <div class="input-row">
                            <label for="qualityGrade">Quality Grade:</label>
                            <select id="qualityGrade" name="qualityGrade" required>
                                <option disabled selected>Select Grade</option>
                                <option value="Poor">Poor</option>
                                <option value="Acceptable">Acceptable</option>
                                <option value="Good">Good</option>
                                <option value="Excellent">Excellent</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn" type="submit"><i class="fa fa-plus" aria-hidden="true"></i> Add Inspection</button>
            </form>
            <p><?php echo $message; ?></p>
        </div>                

        <div class="table-container">
            <table id="inspectionTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Inspection ID</th>
                        <th>Type</th>
                        <th>Farm ID</th>
                        <th>Inspector ID</th>
                        <th>Quality Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="inspectionTableBody">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['iID']); ?></td>
                                <td><?php echo htmlspecialchars($row['iType']); ?></td>
                                <td><?php echo htmlspecialchars($row['fID']); ?></td>
                                <td><?php echo htmlspecialchars($row['insID']); ?></td>
                                <td><?php echo htmlspecialchars($row['quality']); ?></td>
                                <td><button class="btn-delete">Delete</button></td>
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
