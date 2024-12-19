<?php
// Include the database connection file
include('connect.php');

// Initialize variables to hold form data
$centerID = $type = $location = "";

// Check if the form is being submitted for "Add" or "Update"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $centerID = $_POST['centerID'];
    $type = $_POST['type'];
    $location = $_POST['location'];

    // Determine whether to add or update the center information
    if (isset($_POST['add'])) {
        // Add operation (Insert into database)
        $sql = "INSERT INTO tblprocessingcenter (`Center ID`, `Type`, `Location`) 
                VALUES ('$centerID', '$type', '$location')";
        
        if ($conn->query($sql) === TRUE) {
            // Redirect to processing_center.php after successful addition
            header("Location: processing_center.php");
            exit(); // Ensure the script stops after redirect
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        // Update operation (Update the existing record)
        $sql = "UPDATE tblprocessingcenter 
                SET `Type` = '$type', `Location` = '$location' 
                WHERE `Center ID` = '$centerID'";
        
        if ($conn->query($sql) === TRUE) {
            // Redirect to processing_center.php after successful update
            header("Location: processing_center.php");
            exit(); // Ensure the script stops after redirect
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Processing Center</title>
    <link rel="stylesheet" href="processing_update_style.css">
</head>
<body>
    <div class="form-container">
        <h2>Add/Update Center Information</h2>

        <?php
        if (isset($message)) {
            echo "<p>$message</p>"; // Display the success/error message
        }
        ?>

        <form method="POST">
            <label for="centerID">Center ID:</label>
            <input type="text" id="centerID" name="centerID" placeholder="Enter Center ID" required value="<?php echo $centerID; ?>">

            <label for="type">Type:</label>
            <input type="text" id="type" name="type" placeholder="Enter Type" required value="<?php echo $type; ?>">

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" placeholder="Enter Location" required value="<?php echo $location; ?>">

            <div class="btn-container">
                <!-- Add Button -->
                <button type="submit" name="add" class="add-btn">Add</button>

                <!-- Update Button -->
                <button type="submit" name="update" class="update-btn">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
