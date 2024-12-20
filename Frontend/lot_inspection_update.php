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
    $lotNumber = $_POST['lotNumber'];
    $packageQualityGrade = $_POST['packageQualityGrade'];

    $sql = "UPDATE tbllotinspection SET 
            `Date` = '$inspectionDate',
            `Inspector ID` = '$inspectorID',
            `Lot Number` = '$lotNumber',
            `Package Quality Grade` = '$packageQualityGrade'
            WHERE `Lot Number` = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: lot_inspection.php");
        exit;
    } else {
        $message = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM tbllotinspection WHERE `Lot Number` = $id";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lot Inspection</title>
    <link rel="stylesheet" href="inspection_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
   

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
                    <li><a href="p_inspect.php">Processing</a></li>
                    <li><a href="storage_inspection.php">Storage</a></li>
                </ul>
            </li>
            <li><a href="login.html">Log out</a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <h2>Lot Inspection Dashboard</h2>
        <script src="lot_inspection.js"></script>

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
            <button class="btn" type="submit">Update Inspection</button>
            </form>
        </div>
    </body>
</html>
