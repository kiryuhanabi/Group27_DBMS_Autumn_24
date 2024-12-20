<?php
// Include the database connection
include('connect.php');

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the user data from the database
    $sql = "SELECT * FROM tblsignup WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    echo "No user ID provided.";
    exit();
}

// Check if the form has been submitted to update the user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_role = $_POST['user'];

    // Update the user data in the database
    $update_sql = "UPDATE tblsignup SET `First Name` = ?, `Last Name` = ?, Email = ?, Password = ?, User = ? WHERE ID = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssi", $first_name, $last_name, $email, $password, $user_role, $id);
    
    if ($update_stmt->execute()) {
        // Redirect to the user table after updating
        header("Location: admin_user.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_user_update_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Edit User</title>
</head>
<body class="admin-page">
    <header>
        <img src="logo.png" alt="Logo" class="logo">
        <nav class="navbar">
            <ul>
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="admin_user.php">User</a></li>
                <li><a href="#farm">Farm</a></li>
                <li><a href="#processing">Processing Center</a></li>
                <li><a href="#storage">Storage</a></li>
                <li><a href="#transport">Transport</a></li>
                <li><a href="#retailer">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2 class="form-title">Edit User</h2>

        <!-- Edit User Form -->
        <form method="POST">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $user['First Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $user['Last Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $user['Email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo $user['Password']; ?>" required>
            </div>
            <div class="form-group">
                <label for="user">Role:</label>
                <input type="text" id="user" name="user" class="form-control" value="<?php echo $user['User']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </main>
</body>
</html>
