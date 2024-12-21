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
        header("Location: farm_inspection.php");
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
                <button class="btn" type="submit"><i class="fa fa-refresh" aria-hidden="true"></i>Update Inspection</button>
            </form>
        </div>
        <?php if ($message): ?>
            <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
