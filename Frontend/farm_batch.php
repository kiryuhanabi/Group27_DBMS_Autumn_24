<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Batch</title>
    <link rel="stylesheet" href="inspection_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css" integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        function confirmDelete(barcode) {
            if (confirm("Are you sure you want to delete this batch?")) {
                window.location.href = `farm_batch.php?barcode=${barcode}`;
            }
        }
    </script>
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
            <li><a href="starting_page.php">Logout</a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <h2>Batch</h2>

        <div class="inspection-filters">
            <h3>Create Batch</h3>
            <form id="addBatchForm" action="farm_batch.php" method="POST">
                <div class="form-group">
                    <div class="input-row">
                        <label for="harvestDate">Harvest Date:</label>
                        <input type="date" id="harvestDate" name="harvestDate" required>
                    </div>
                    <div class="input-row">
                        <label for="expireyDate">Expiry Date:</label>
                        <input type="date" id="expireyDate" name="expireyDate" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="productID">Product ID:</label>
                        <input type="text" id="productID" name="productID" required>
                    </div>
                    <div class="input-row">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="farmID">Farm ID:</label>
                        <input type="text" id="farmID" name="farmID" required>
                    </div>
                </div>

                <button class="btn" type="submit"><i class="fa fa-plus" aria-hidden="true"></i> Add Batch</button>
            </form>
        </div>

        <div class="table-container">
            <h2>Batch Overview</h2>
            <table id="batchTable">
                <thead>
                    <tr>
                        <th>Batch Barcode</th>
                        <th>Harvest Date</th>
                        <th>Expiry Date</th>
                        <th>Quantity</th>
                        <th>Product ID</th>
                        <th>Farm ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Connect to the database
                    $conn = new mysqli('localhost', 'root', '', 'crud');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    // Handle adding a new batch
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $harvestDate = $_POST['harvestDate'];
                        $expiryDate = $_POST['expireyDate'];
                        $productID = $_POST['productID'];
                        $quantity = $_POST['quantity'];
                        $farmID = $_POST['farmID'];

                        $sql = "INSERT INTO tblbatch (`Harvest Date`, `Expiry Date`, `Quantity`, `Product ID`, `Farm ID`) 
                                VALUES ('$harvestDate', '$expiryDate', '$quantity', '$productID', '$farmID')";

                        if ($conn->query($sql) === TRUE) {
                            echo "<script>alert('Batch added successfully.'); window.location.href = 'farm_batch.php';</script>";
                        } else {
                            echo "<script>alert('Error adding batch: " . $conn->error . "');</script>";
                        }
                    }


                    $sql = "SELECT * FROM tblbatch";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['Batch Barcode']}</td>
                                <td>{$row['Harvest Date']}</td>
                                <td>{$row['Expiry Date']}</td>
                                <td>{$row['Quantity']}</td>
                                <td>{$row['Product ID']}</td>
                                <td>{$row['Farm ID']}</td>
                                <td>
                                    <a href='farm_batch_update.php?barcode={$row['Batch Barcode']}' class='btn update-btn'>Update</a>
                                    <button onclick=\"confirmDelete('{$row['Batch Barcode']}')\" class='btn delete-btn'>Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'crud');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['barcode'])) {
    $barcode = $conn->real_escape_string($_GET['barcode']);

    // Delete the batch
    $sql = "DELETE FROM tblbatch WHERE `Batch Barcode` = '$barcode'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Batch deleted successfully.'); window.location.href = 'farm_batch.php';</script>";
    } else {
        echo "<script>alert('Error deleting batch: " . $conn->error . "'); window.location.href = 'farm_batch.php';</script>";
    }
}

$conn->close();
?>
