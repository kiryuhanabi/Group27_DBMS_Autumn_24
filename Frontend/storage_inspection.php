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
    $storageID = $_POST['storageID'];
    $maintenanceGrade = $_POST['maintenanceGrade'];
    $pestControlGrade = $_POST['pestControlGrade'];
    $hygieneGrade = $_POST['hygieneGrade'];

    $sql = "INSERT INTO tblstorageinspection (`Date`, `Inspector ID`, `Storage Maintenance Grade`, `Storage ID`, `Pest Control Grade`, `Storage Hygene Grade`)
        VALUES ('$inspectionDate', '$inspectorID', '$maintenanceGrade', '$storageID', '$pestControlGrade', '$hygieneGrade')";

    if ($conn->query($sql) === TRUE) {
        $message = "Inspection added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM tblstorageinspection";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Inspection Dashboard</title>
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
        <h2>Storage Inspection</h2>
        <script src="storage_inspection.js"></script>

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
                        <label for="storageID">Storage ID:</label>
                        <input type="text" id="storageID" name="storageID">
                    </div>

                    <div class="input-row">
                        <label for="inspectorID">Inspector ID:</label>
                        <input type="text" id="inspectorID" name="inspectorID">
                    </div>
                </div>
        
                <div class="right-column">
                    <div class="input-row">
                        <label for="maintenanceGrade">Maintenance Grade:</label>
                        <select id="maintenanceGrade" name="maintenanceGrade">
                            <option value="" disabled>Select Grade</option>
                            <option value="Poor">Poor</option>
                            <option value="Acceptable">Acceptable</option>
                            <option value="Decent">Decent</option>
                            <option value="Perfect">Perfect</option>
                        </select>
                    </div>

                    <div class="input-row">
                        <label for="pestControlGrade">Pest Control Grade:</label>
                        <select id="pestControlGrade" name="pestControlGrade">
                            <option value="" disabled>Select Grade</option>
                            <option value="Poor">Poor</option>
                            <option value="Acceptable">Acceptable</option>
                            <option value="Decent">Decent</option>
                            <option value="Perfect">Perfect</option>
                        </select>
                    </div>

                    <div class="input-row">
                        <label for="hygieneGrade">Hygiene Grade:</label>
                        <select id="hygieneGrade" name="hygieneGrade">
                            <option value="" disabled>Select Grade</option>
                            <option value="Poor">Poor</option>
                            <option value="Acceptable">Acceptable</option>
                            <option value="Decent">Decent</option>
                            <option value="Perfect">Perfect</option>
                        </select>
                    </div>
                </div>
            </div>
            <button class="btn" type="submit"><i class="fa fa-plus" aria-hidden="true"></i>  Add Inspection</button>
        </form>
        </div>

        <div class="table-container">
            <h2>Overview of Inspections</h2>
            <table id="inspectionTable">
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
                <tbody id="inspectionTableBody">
                <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Storage ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Inspector ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Storage Maintenance Grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['Pest Control Grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['Storage Hygene Grade']); ?></td>
                                <td>
                                    <form method="POST" action="storage_inspection_delete.php">
                                        <input type="hidden" name="id" value="<?php echo $row['Storage ID']; ?>">
                                        <button type="submit" name="delete" class="btn"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                    </form>
                                    <form method="GET" action="storage_inspection_update.php">
                                        <input type="hidden" name="id" value="<?php echo $row['Storage ID']; ?>">
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
        </div>    
    </body>
</html>
