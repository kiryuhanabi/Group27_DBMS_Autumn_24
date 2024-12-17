<?php
// Include database connection
include 'connect.php';

// Initialize feedback variable
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $user_type = $conn->real_escape_string($_POST['user_type']);

    // Insert data into the 'log' table
    $sql = "INSERT INTO log (`First Name`, `Last Name`, `ID`, `User`)
            VALUES ('$first_name', '$last_name', '$user_id', '$user_type')";
            

    if ($conn->query($sql) === TRUE) {
        $message = "Sign-Up successful!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Sign Up</title>
</head>
<body class="login-page">
    <div class="login-container">
        <img src="logo.png" alt="Logo" class="img-fluid mb-2" style="max-width: 100%; height: auto;">
        <h1>Sign Up</h1>
        <form id="signupForm" method="POST" action="">
            <input type="text" name="first_name" class="form-control mb-3" placeholder="First Name" required>
            <input type="text" name="last_name" class="form-control mb-3" placeholder="Last Name" required>
            <input type="text" name="user_id" class="form-control mb-3" placeholder="ID" required>
            <select id="userType" name="user_type" class="form-control mb-4" required>
                <option value="" disabled selected>Select User Type</option>
                <option value="inspector">Inspector</option>
                <option value="processing_center">Processing Center</option>
                <option value="transport">Transport</option>
                <option value="storage">Storage</option>
                <option value="retailer">Retailer</option>
            </select>
            <button type="submit" class="btn btn-primary button">Sign Up</button>
        </form>

        <!-- Display Feedback Message -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-info mt-4" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
