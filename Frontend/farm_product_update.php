<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Update Product</title>
    <link rel="stylesheet" href="farm.css">
    <link href="logo.png" rel="icon" type="image/png">
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
        }
        .button-container button:hover {
            background-color: #45a049;
        }
        .nav {
            background-color: #333;
            overflow: hidden;
        }
        .nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .nav ul li {
            flex: 1;
        }
        .nav ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .nav ul li a:hover {
            background-color: #111;
        }
    </style>
</head>
<body>
    <h1>
        <img src="logo.png" alt="Farm Logo" class="logo-img">
        Agro Farm - Update Product
    </h1>

    <nav class="nav">
        <ul>
            <li><a href="farm.php">Home</a></li>
            <li><a href="farm_product.php">Product</a></li>
            <li><a href="farm_batch.php">Batch</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <section class="form-container">
        <h2>Update Product Information</h2>
        <form id="productUpdateForm" method="POST" action="farm_product_update.php">
            <div class="form-group">
                <label for="productId">Product ID:</label>
                <input type="text" id="productId" name="productId" required>
            </div>

            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <input type="text" id="type" name="type" required>
            </div>

            <div class="form-group">
                <label for="bestSeason">Best Season:</label>
                <select id="bestSeason" name="bestSeason" required>
                    <option value="summer">Summer</option>
                    <option value="rainy">Rainy</option>
                    <option value="winter">Winter</option>
                    <option value="spring">Spring</option>
                </select>
            </div>

            <div class="form-group">
                <label for="optimumTemp">Optimum Temperature:</label>
                <input type="text" id="optimumTemp" name="optimumTemp" required>
            </div>

            <div class="form-group">
                <label for="optimumHumidity">Optimum Humidity:</label>
                <input type="text" id="optimumHumidity" name="optimumHumidity" required>
            </div>

            <div class="form-group">
                <label for="nutritionValue">Nutrition Value:</label>
                <input type="text" id="nutritionValue" name="nutritionValue" required>
            </div>

            <div class="button-container">
                <button type="submit" id="updateButton">Update</button>
            </div>
        </form>
    </section>

</body>
</html>

<?php
// update_product.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "crud";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $productId = $conn->real_escape_string($_POST['productId']);
    $productName = $conn->real_escape_string($_POST['productName']);
    $type = $conn->real_escape_string($_POST['type']);
    $bestSeason = $conn->real_escape_string($_POST['bestSeason']);
    $optimumTemp = $conn->real_escape_string($_POST['optimumTemp']);
    $optimumHumidity = $conn->real_escape_string($_POST['optimumHumidity']);
    $nutritionValue = $conn->real_escape_string($_POST['nutritionValue']);

    $sql = "UPDATE tblproduct SET `Product Name` = '$productName', `Type` = '$type', `Best Season` = '$bestSeason', `Optimum Temperature` = '$optimumTemp', `Optimum Humidity` = '$optimumHumidity', `Nutrition Value` = '$nutritionValue' WHERE `Product ID` = '$productId'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'farm_product.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
