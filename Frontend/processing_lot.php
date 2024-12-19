<?php
// Include the database connection file
include('connect.php');

// Delete Lot Logic
if (isset($_GET['delete'])) {
    $lotNumber = intval($_GET['delete']); // Get the Lot Number to delete
    $deleteQuery = "DELETE FROM tblprocessinglot WHERE `Lot Number` = $lotNumber";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Lot Number $lotNumber deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error: Unable to delete Lot Number $lotNumber.');</script>";
    }
    echo "<script>window.location.href = 'processing_lot.php';</script>"; // Refresh page
}

// Create Lot Logic (Insert into tblprocessinglot)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createLot'])) {
    // Retrieve form data
    $batchBarcode = $_POST['batchBarcode'];
    $quantity = intval($_POST['quantity']);
    $lotQuantity = intval($_POST['lotQuantity']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $manufacturedDate = $_POST['manufacturedDate'];
    $expiryDate = $_POST['expiryDate'];
    $transportID = $_POST['transportID'];
    $centerID = $_POST['centerID'];

    // Validate that quantity is divisible by lot quantity
    if ($quantity % $lotQuantity !== 0) {
        echo "<script>alert('Quantity must be divisible by Lot Quantity.');</script>";
    } else {
        // Calculate number of rows to insert
        $numRows = $quantity / $lotQuantity;

        // Insert multiple rows into the tblprocessinglot table
        for ($i = 0; $i < $numRows; $i++) {
            $query = "INSERT INTO tblprocessinglot (`Batch Barcode`, `Date`, `Time`, `Manufactured Date`, `Expiry Date`, `stTransport ID`, `Center ID`)
                      VALUES ('$batchBarcode', '$date', '$time', '$manufacturedDate', '$expiryDate', '$transportID', '$centerID')";
            if (!mysqli_query($conn, $query)) {
                echo "<script>alert('Error: Unable to insert record.');</script>";
                break;
            }
        }
        // Notify user of successful creation
        echo "<script>alert('$numRows lots created successfully.');</script>";
        echo "<script>window.location.href = 'processing_lot.php';</script>"; // Refresh page
    }
}

// Fetch and display rows from tblprocessinglot
$query = "SELECT * FROM tblprocessinglot ORDER BY `Lot Number` ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Lot</title>
    <link rel="stylesheet" href="processing_lot_style.css">
    <link href="logo.png" rel="icon" type="image/png">
</head>
<body>
    <header class="title-header">
        <h1>Processing Lot</h1>
    </header>

    <nav class="nav">
        <ul class="ul">
            <li><a href="processing_center.php">Home</a></li>
            <li><a href="processing_inspection.html">Inspection</a></li>
            <li><a href="processing_lot.php">Processing Lot</a></li>
            <li><a href="starting_page.html">Logout</a></li>
        </ul>
    </nav>

    <div class="background">
        <section class="lot-container">
            <h2>Processing Lot Details</h2>
            <h3>Lot Creation</h3>
            <form method="POST" action="">
                <label for="batchBarcode">Batch Barcode:</label>
                <input type="text" id="batchBarcode" name="batchBarcode" required>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="lotQuantity">Lot Quantity:</label>
                <input type="number" id="lotQuantity" name="lotQuantity" required>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>

                <label for="manufacturedDate">Manufactured Date:</label>
                <input type="date" id="manufacturedDate" name="manufacturedDate" required>

                <label for="expiryDate">Expiry Date:</label>
                <input type="date" id="expiryDate" name="expiryDate" required>

                <label for="transportID">Transport ID:</label>
                <input type="text" id="transportID" name="transportID" required>

                <label for="centerID">Center ID:</label>
                <input type="text" id="centerID" name="centerID" required>

                <button type="submit" name="createLot">Create Lot</button>
            </form>

            <!-- Table displaying entries from tblprocessinglot -->
            <h3>Processing Lot Records</h3>
            <table>
    <thead>
        <tr>
            <th>Batch Barcode</th>
            <th>Lot Number</th>
            <th>Date</th>
            <th>Time</th>
            <th>Manufactured Date</th>
            <th>Expiry Date</th>
            <th>Transport ID</th>
            <th>Center ID</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['Batch Barcode']}</td>
                        <td>{$row['Lot Number']}</td>
                        <td>{$row['Date']}</td>
                        <td>{$row['Time']}</td>
                        <td>{$row['Manufactured Date']}</td>
                        <td>{$row['Expiry Date']}</td>
                        <td>{$row['stTransport ID']}</td>
                        <td>{$row['Center ID']}</td>
                        <td>
                            <a href='processing_lot_update.php?lotNumber={$row['Lot Number']}' class='edit-btn'>Edit</a>
                            <a href='processing_lot.php?delete={$row['Lot Number']}' onclick='return confirm(\"Are you sure you want to delete this lot?\");' class='delete-btn'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>
