<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "crud"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the input to prevent SQL injection
    $productName = $conn->real_escape_string($_POST['productname']);
    $type = $conn->real_escape_string($_POST['type']);
    $season = $conn->real_escape_string($_POST['season']);
    $humidity = $conn->real_escape_string($_POST['humidity']);
    $temperature = $conn->real_escape_string($_POST['temperature']);
    $nutritionValue = $conn->real_escape_string($_POST['nutritionValue']);

    // Adjust column names to include backticks for names with spaces
    $sql = "INSERT INTO tblproduct (`Product Name`, `Type`, `Best Season`, `Optimum Temperature`, `Optimum Humidity`, `Nutrition Value`)
            VALUES ('$productName', '$type', '$season', '$temperature', '$humidity', '$nutritionValue')";

    if ($conn->query($sql) === TRUE) {
        $message = "Product added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch all products for display in the table
$sql = "SELECT `Product ID`, `Product Name`, `Type`, `Best Season`, `Optimum Temperature`, `Optimum Humidity`, `Nutrition Value` FROM tblproduct";
$result = $conn->query($sql);

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Product</title>
    <link rel="stylesheet" href="farm_product.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css" integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <h1>
            <img src="logo.png" alt="Agro Logo" class="logo-img"> Agro
        </h1>
    </header>

    <nav class="nav">
        <ul class="ul">
            <li><a href="farm.html">Home</a></li>
            <li><a href="farm_product.php">Product</a></li>
            <li><a href="farm_batch.html">Batch</a></li>
            <li><a href="login.html">Logout</a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <h2>Product</h2>

        <div class="inspection-filters">
            <h3>Add New Product</h3>
            <form action="" method="POST">
                <div class="form-group">
                    <div class="left-column">
                        <div class="input-row">
                            <label for="productname">Product Name:</label>
                            <input type="text" id="productname" name="productname" required>
                        </div>
                        <div class="input-row">
                            <label for="type">Type:</label>
                            <input type="text" id="type" name="type" required>
                        </div>
                        <div class="input-row">
                            <label for="season">Best Season:</label>
                            <select id="season" name="season" required>
                                <option value="summer">Summer</option>
                                <option value="rainy">Rainy</option>
                                <option value="winter">Winter</option>
                                <option value="spring">Spring</option>
                            </select>
                        </div>
                    </div>
            
                    <div class="right-column">
                        <div class="input-row">
                            <label for="humidity">Optimum Humidity:</label>
                            <input type="text" id="humidity" name="humidity" required>
                        </div>
                        <div class="input-row">
                            <label for="temperature">Optimum Temperature:</label>
                            <input type="text" id="temperature" name="temperature" required>
                        </div>
                        <div class="input-row">
                            <label for="nutritionValue">Nutrition Value:</label>
                            <input type="text" id="nutritionValue" name="nutritionValue" required>
                        </div>
                    </div>
                </div>         
                <button class="btn" type="submit"><i class="fa fa-plus" aria-hidden="true"></i> Add Product</button>
            </form>
        </div>        

        <div class="table-container">
            <h2>Overview of Products</h2>
            <table id="productTable">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Type</th>
                        <th>Best Season</th>
                        <th>Optimum Temperature</th>
                        <th>Optimum Humidity</th>
                        <th>Nutrition Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Product ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Product Name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Type']); ?></td>
                                <td><?php echo htmlspecialchars($row['Best Season']); ?></td>
                                <td><?php echo htmlspecialchars($row['Optimum Temperature']); ?></td>
                                <td><?php echo htmlspecialchars($row['Optimum Humidity']); ?></td>
                                <td><?php echo htmlspecialchars($row['Nutrition Value']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

