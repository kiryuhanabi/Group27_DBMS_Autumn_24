<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "crud";

// Connect to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $farmID = $_POST['farmID'];
    $farmName = $_POST['farmName'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $numFields = $_POST['numFields'];

    if (isset($_POST['add'])) {
        // Add new farm information
        $stmt = $conn->prepare("INSERT INTO tblfarm (`Farm ID`, `Farm Name`, `Street`, `City`, `No. of Fields`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $farmID, $farmName, $street, $city, $numFields);

        if ($stmt->execute()) {
            $message = "Farm added successfully!";
        } else {
            $message = "Error adding farm: " . $conn->error;
        }
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Update existing farm information
        $stmt = $conn->prepare("UPDATE tblfarm SET `Farm Name` = ?, `Street` = ?, `City` = ?, `No. of Fields` = ? WHERE `Farm ID` = ?");
        $stmt->bind_param("sssii", $farmName, $street, $city, $numFields, $farmID);

        if ($stmt->execute()) {
            $message = "Farm updated successfully!";
        } else {
            $message = "Error updating farm: " . $conn->error;
        }
        $stmt->close();
    }

    // Redirect back to the form with a success or error message
    header("Location: farm_update.php?message=" . urlencode($message));
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Farm</title>
    <link rel="stylesheet" href="farm.css">
    <link href="logo.png" rel="icon" type="image/png">
    <style>
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .button-container .btn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>
        <img src="logo.png" alt="Farm Logo" class="logo-img">
        Agro Farm - Add/Update Information
    </h1>

    <nav class="nav">
        <ul class="ul">
            <li><a href="farm.php">Home</a></li>
            <li><a href="farm_product.php">Product</a></li>
            <li><a href="farm_batch.php">Batch</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <section class="farm-update-container">
        <h2>Add/Update Farm Information</h2>
        
        <!-- Display dynamic message -->
        <?php if (isset($_GET['message'])): ?>
            <div id="message" class="alert">
                <p><?php echo htmlspecialchars($_GET['message']); ?></p>
            </div>
        <?php endif; ?>

        <!-- Form for adding/updating farm information -->
        <form action="farm_update.php" method="POST">
            <div class="input-row">
                <label for="farmID">Farm ID:</label>
                <input type="number" id="farmID" name="farmID" required>
            </div>

            <div class="input-row">
                <label for="farmName">Farm Name:</label>
                <input type="text" id="farmName" name="farmName" required>
            </div>

            <div class="input-row">
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" required>
            </div>

            <div class="input-row">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
            </div>

            <div class="input-row">
                <label for="numFields">Number of Fields:</label>
                <input type="number" id="numFields" name="numFields" min="1" required>
            </div>

            <!-- Buttons -->
            <div class="button-container">
                <button type="submit" name="add" class="btn">Add Farm</button>
                <button type="submit" name="update" class="btn">Update Farm</button>
            </div>
        </form>
    </section>
</body>
</html>
