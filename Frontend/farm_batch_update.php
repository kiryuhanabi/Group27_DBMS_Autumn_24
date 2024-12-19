<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Batch</title>
    <link rel="stylesheet" href="inspection_style.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css" integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 1em;
            text-align: center;
        }

        .logo-img {
            width: 50px;
            vertical-align: middle;
        }

        .nav {
            background-color: #333;
        }

        .nav .ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        .nav .ul li {
            padding: 14px 20px;
        }

        .nav .ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .nav .ul li a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        .dashboard {
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .btn {
            display: block;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>
            <img src="logo.png" alt="Agro Logo" class="logo-img"> Agro
        </h1>
    </header>

    <nav class="nav">
        <ul class="ul">
            <li><a href="farm.php">Home</a></li>
            <li><a href="farm_product.php">Product</a></li>
            <li><a href="farm_batch.php">Batch</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <h2>Update Batch Information</h2>

        <form id="updateBatchForm" action="farm_batch_update.php" method="POST">
            <div class="form-group">
                <label for="batchBarcode">Batch Barcode:</label>
                <input type="text" id="batchBarcode" name="batchBarcode" required>
            </div>

            <div class="form-group">
                <label for="harvestDate">Harvest Date:</label>
                <input type="date" id="harvestDate" name="harvestDate" required>
            </div>

            <div class="form-group">
                <label for="expireyDate">Expirey Date:</label>
                <input type="date" id="expireyDate" name="expireyDate" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" required>
            </div>

            <div class="form-group">
                <label for="productID">Product ID:</label>
                <input type="text" id="productID" name="productID" required>
            </div>

            <div class="form-group">
                <label for="farmID">Farm ID:</label>
                <input type="text" id="farmID" name="farmID" required>
            </div>

            <button class="btn" type="submit" name="update"><i class="fas fa-sync"></i> Update</button>
        </form>
    </div>
</body>
</html>

<!-- PHP Script (update_batch.php) -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $batchBarcode = $_POST['batchBarcode'];
    $harvestDate = $_POST['harvestDate'];
    $expireyDate = $_POST['expireyDate'];
    $quantity = $_POST['quantity'];
    $productID = $_POST['productID'];
    $farmID = $_POST['farmID'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'crud');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update query
    $sql = "UPDATE tblbatch SET `Harvest Date` = ?, `Expirey Date` = ?, `Quantity` = ?, `Product ID` = ?, `Farm ID` = ? WHERE `Batch Barcode` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisss', $harvestDate, $expireyDate, $quantity, $productID, $farmID, $batchBarcode);

    if ($stmt->execute()) {
        echo "<script>alert('Batch updated successfully.'); window.location.href='farm_batch.php';</script>";
    } else {
        echo "<script>alert('Error updating batch: " . $conn->error . "'); window.location.href='farm_batch.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
