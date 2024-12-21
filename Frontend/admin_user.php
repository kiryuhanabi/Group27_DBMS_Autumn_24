<?php
// Include the database connection
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['user'];

    // SQL query to insert data into tblsignup
    $insert_sql = "INSERT INTO tblsignup (`First Name`, `Last Name`, `Email`, `Password`, `User`) VALUES (?, ?, ?, ?, ?)";

    // Prepare and execute the insert statement
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $password, $userType);

    if ($stmt->execute()) {
        // Redirect to the same page after insertion
        header("Location: admin_user.php");
        exit();
    } else {
        echo "Error adding record: " . $conn->error;
    }
}

// Check if the delete request is made
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // SQL query to delete the record
    $delete_sql = "DELETE FROM tblsignup WHERE ID = ?";
    
    // Prepare and execute the delete statement
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        // Redirect to the same page after deletion
        header("Location: admin_user.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// SQL query to fetch data from tblsignup
$sql = "SELECT * FROM tblsignup";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>User Table</title>
</head>
<body class="admin-page">
    <header>
        <img src="logo.png" alt="Logo" class="logo">
        <nav class="navbar">
            <ul>
                <li><a href="admin_user.php">User</a></li>
                <li><a href="#" class="dropdown">Farm</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_farm.php">Farm Information</a></li>
                        <li><a href="admin_farm_product.php">Farm Product</a></li>
                        <li><a href="admin_farm_batch.php">Farm Batch</a></li>
                    </ul></li>
                <li>
                    <a href="#" class="dropdown">Processing Center</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_center_information.php">Center Information</a></li>
                        <li><a href="admin_iot_reading.php">IoT Device Reading</a></li>
                        <li><a href="admin_processing_lot.php">Processing Lot</a></li>
                    </ul>
                </li>
                <li><a href="#storage">Storage</a></li>
                <li><a href="#transport">Transport</a></li>
                <li><a href="admin_retailer_order.php">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>User Table</h1>

        <!-- User Table Form -->
        <form method="POST" class="user-form">
            <h2>User Table Form</h2>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="user">User:</label>
            <input type="text" id="user" name="user" required>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <!-- User Table -->
        <?php
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>User</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['ID'] . '</td>
                        <td>' . $row['First Name'] . '</td>
                        <td>' . $row['Last Name'] . '</td>
                        <td>' . $row['Email'] . '</td>
                        <td>' . $row['Password'] . '</td>
                        <td>' . $row['User'] . '</td>
                        <td>
                            <a href="admin_user_update.php?id=' . $row['ID'] . '" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin_user.php?delete_id=' . $row['ID'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this?\')">Delete</a>
                        </td>
                    </tr>';
            }
            echo '</tbody>
                </table>';
        } else {
            echo '<p>No data available</p>';
        }

        $conn->close();
        ?>
    </main>
</body>
</html>
