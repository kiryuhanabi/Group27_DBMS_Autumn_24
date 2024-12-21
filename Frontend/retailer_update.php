<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer</title>
    <link rel="stylesheet" href="retailer_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #12e28f;
            margin-top: 20px;
        }

        .logo-img {
            vertical-align: middle;
            width: 50px;
            height: 50px;
        }

        .nav {
            background-color: #4CAF50;
            overflow: hidden;
            text-align: center;
        }

        .nav .ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .nav .ul li {
            display: inline;
            margin: 0 15px;
        }

        .nav .ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .retailer-form {
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .retailer-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .retailer-form input, .retailer-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .retailer-form textarea {
            resize: none;
        }

        .form-buttons {
            text-align: center;
        }

        .form-buttons button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-buttons button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>
        <img src="logo.png" alt="Retail Logo" class="logo-img">
        Agro Retailer
    </h1>

    <!-- Full-width Navigation bar -->
    <nav class="nav">
        <ul class="ul">
            <li><a href="retailer.php">Home</a></li>
            <li><a href="retailer_orders.php">Orders</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Retailer Form -->
    <form action="retailer_update.php" method="post" class="retailer-form">
        <label for="retailer-id">Retailer ID:</label>
        <input type="text" id="retailer-id" name="retailer_id" required><br>

        <label for="first-name">First Name:</label>
        <input type="text" id="first-name" name="first_name" required><br>

        <label for="last-name">Last Name:</label>
        <input type="text" id="last-name" name="last_name" required><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required><br>

        <label for="store-name">Store Name:</label>
        <input type="text" id="store-name" name="store_name" required><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" required></textarea><br>

        <!-- Buttons -->
        <div class="form-buttons">
            <button type="submit" name="action" value="add">Add</button>
            <button type="submit" name="action" value="update">Update</button>
        </div>
    </form>
</body>
</html>

<!-- PHP Backend: process_retailer.php -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database credentials
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'crud';

    // Create a connection
    $conn = new mysqli($host, $user, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Retrieve form data
    $retailer_id = $_POST['retailer_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $store_name = $_POST['store_name'];
    $address = $_POST['address'];
    $action = $_POST['action'];

    if ($action === 'add') {
        // Add retailer to the database
        $sql = "INSERT INTO tblretailer (`Retailer ID`, `First Name`, `Last Name`, `Phone`, `Store Name`, `Address`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isssss', $retailer_id, $first_name, $last_name, $phone, $store_name, $address);

        if ($stmt->execute()) {
            echo 'Retailer added successfully.';
        } else {
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } elseif ($action === 'update') {
        // Update retailer in the database
        $sql = "UPDATE tblretailer SET `First Name` = ?, `Last Name` = ?, `Phone` = ?, `Store Name` = ?, `Address` = ? WHERE `Retailer ID` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssi', $first_name, $last_name, $phone, $store_name, $address, $retailer_id);

        if ($stmt->execute()) {
            echo 'Retailer updated successfully.';
        } else {
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>
