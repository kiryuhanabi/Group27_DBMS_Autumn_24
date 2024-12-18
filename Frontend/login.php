<?php
// Start session
session_start();

// Include database connection
include 'connect.php';

// Check if user ID is passed via session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Initialize feedback variable
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login_id = $conn->real_escape_string($_POST['id']);
    $password = $conn->real_escape_string($_POST['password']);
    $user_type = $conn->real_escape_string($_POST['user_type']);

    // Fetch the user's record
    $sql = "SELECT `ID`, `Password` FROM tblsignup WHERE `ID` = '$login_id' AND `User` = '$user_type'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Direct password comparison (plain-text)
        if ($password === $row['Password']) {
            // Redirect to user-specific page
            $redirect_pages = [
                'inspector' => 'inspector.php',
                'processing_center' => 'processing_center.php',
                'transport' => 'transport.php',
                'storage' => 'storage.php',
                'retailer' => 'retailer.php',
                'farm' => 'farm.php',
            ];

            if (array_key_exists($user_type, $redirect_pages)) {
                header("Location: " . $redirect_pages[$user_type]);
                exit();
            }
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "Invalid ID or user type!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Login</title>
</head>
<body class="login-page">
    <div class="login-container">
        <img src="logo.png" alt="Logo" class="img-fluid mb-2" style="max-width: 100%; height: auto;">
        <h1>Login</h1>
        <?php if ($user_id): ?>
            <p>Your User ID is: <strong><?php echo $user_id; ?></strong></p>
        <?php endif; ?>
        <form id="loginForm" method="POST" action="">
            <input type="text" name="id" class="form-control mb-3" placeholder="User ID" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <select id="userType" name="user_type" class="form-control mb-4" required>
                <option value="" disabled selected>Select User Type</option>
                <option value="inspector">Inspector</option>
                <option value="processing_center">Processing Center</option>
                <option value="transport">Transport</option>
                <option value="storage">Storage</option>
                <option value="retailer">Retailer</option>
                <option value="farm">Farm</option>
            </select>
            <button type="submit" class="btn btn-primary button">Sign in</button>
        </form>

        <!-- Display Feedback Message -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-danger mt-4" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
