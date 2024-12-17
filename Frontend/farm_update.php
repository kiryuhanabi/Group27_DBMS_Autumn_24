<?php
// Include database connection
include 'connect.php';
session_start();

// Initialize variables
$message = "";
$farm_id = "";

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch current farm data for the logged-in user
    $sql = "SELECT `Farm ID`, `Farm Name`, `Street`, `City`, `No. of Fields`
            FROM tblfarm
            WHERE `Farm ID` = (
                SELECT `ID` FROM tblsignup WHERE `ID` = '$user_id' AND `User` = 'farm'
            )";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $farm_data = $result->fetch_assoc();
        $farm_id = $farm_data['Farm ID'];
    } else {
        $message = "No farm data found for this user.";
    }
} else {
    $message = "You must be logged in to update farm information.";
}

// Handle the form submission for updating farm data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $farm_name = $conn->real_escape_string($_POST['farmName']);
    $street = $conn->real_escape_string($_POST['street']);
    $city = $conn->real_escape_string($_POST['city']);
    $num_fields = $conn->real_escape_string($_POST['numFields']);

    // Update query
    $update_sql = "UPDATE tblfarm 
                   SET `Farm Name` = '$farm_name', 
                       `Street` = '$street', 
                       `City` = '$city', 
                       `No. of Fields` = '$num_fields' 
                   WHERE `Farm ID` = '$farm_id'";

    if ($conn->query($update_sql) === TRUE) {
        $message = "Farm information updated successfully!";
    } else {
        $message = "Error updating farm information: " . $conn->error;
    }
}
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
</head>
<body>
    <h1>
        <img src="logo.png" alt="Farm Logo" class="logo-img">
        Agro Farm - Update Information
    </h1>

    <nav class="nav">
        <ul class="ul">
            <li><a href="farm.html">Home</a></li>
            <li><a href="farm_product.html">Product</a></li>
            <li><a href="farm_batch.html">Batch</a></li>
            <li><a href="login.html">Logout</a></li>
        </ul>
    </nav>

    <section class="farm-update-container">
        <h2>Update Farm Information</h2>
        <?php if (!empty($message)): ?>
            <div class="alert">
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>
        <?php if (!empty($farm_data)): ?>
        <form id="farmUpdateForm" method="POST" action="">
            <div class="input-row">
                <label for="farmID">Farm ID:</label>
                <input type="text" id="farmID" name="farmID" value="<?php echo $farm_data['Farm ID']; ?>" readonly>
            </div>

            <div class="input-row">
                <label for="farmName">Farm Name:</label>
                <input type="text" id="farmName" name="farmName" value="<?php echo $farm_data['Farm Name']; ?>" required>
            </div>

            <div class="input-row">
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" value="<?php echo $farm_data['Street']; ?>" required>
            </div>

            <div class="input-row">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo $farm_data['City']; ?>" required>
            </div>

            <div class="input-row">
                <label for="numFields">Number of Fields:</label>
                <input type="number" id="numFields" name="numFields" value="<?php echo $farm_data['No. of Fields']; ?>" min="1" required>
            </div>

            <button type="submit" class="btn">Save Changes</button>
        </form>
        <?php else: ?>
            <p>No farm information available to update.</p>
        <?php endif; ?>
    </section>
</body>
</html>
