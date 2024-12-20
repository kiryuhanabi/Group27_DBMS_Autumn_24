<?php
// Include the database connection
include('connect.php');

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
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="admin_user.php">User</a></li>
                <li><a href="#farm">Farm</a></li>
                <li><a href="admin_processing_center.php">Processing Center</a></li>
                <li><a href="#storage">Storage</a></li>
                <li><a href="#transport">Transport</a></li>
                <li><a href="#retailer">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h1>User Table</h1>
        
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
                            <a href="admin_user.php?delete_id=' . $row['ID'] . '" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>';
            }
            echo '</tbody>
                </table>';
        } else {
            echo '<p>No data available</p>';
        }

        // Close the connection
        $conn->close();
        ?>
    </main>
</body>
</html>
