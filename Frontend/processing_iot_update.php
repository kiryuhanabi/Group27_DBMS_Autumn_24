<?php
// Include database connection
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lotNumber = $_POST['lotNumber'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $manufacturedDate = $_POST['manufacturedDate'];
    $expiryDate = $_POST['expiryDate'];
    $transportID = $_POST['transportID'];
    $centerID = $_POST['centerID'];

    // Update query
    $updateQuery = "UPDATE tblprocessinglot 
                    SET `Date` = '$date', `Time` = '$time', `Manufactured Date` = '$manufacturedDate', 
                        `Expiry Date` = '$expiryDate', `stTransport ID` = '$transportID', `Center ID` = '$centerID' 
                    WHERE `Lot Number` = '$lotNumber'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Lot Number $lotNumber updated successfully.');</script>";
        echo "<script>window.location.href = 'processing_lot.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to update Lot Number $lotNumber.');</script>";
    }
}

// Fetch the lot details for pre-filling the form
if (isset($_GET['lotNumber'])) {
    $lotNumber = $_GET['lotNumber'];
    $fetchQuery = "SELECT * FROM tblprocessinglot WHERE `Lot Number` = '$lotNumber'";
    $result = mysqli_query($conn, $fetchQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $lotDetails = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Lot not found.');</script>";
        echo "<script>window.location.href = 'processing_lot.php';</script>";
    }
} else {
    echo "<script>window.location.href = 'processing_lot.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Processing Lot</title>
    <link rel="stylesheet" href="processing_lot_style.css">
    <link href="logo.png" rel="icon" type="image/png">
</head>
<body>
    <header class="title-header">
        <h1>Update Processing Lot</h1>
    </header>

    <nav class="nav">
        <ul class="ul">
            <li><a href="processing_center.php">Home</a></li>
            <li><a href="processing_inspection.php">Inspection</a></li>
            <li><a href="processing_lot.php">Processing Lot</a></li>
            <li><a href="starting_page.php">Logout</a></li>
        </ul>
    </nav>

    <div class="background-image">
        <section class="lot-container">
            <h2>Update Lot Details</h2>
            <form method="POST" action="">
                <input type="hidden" name="lotNumber" value="<?php echo $lotDetails['Lot Number']; ?>">

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo $lotDetails['Date']; ?>" required>
                <br>

                <label for="time">Time:</label>
                <input type="time" id="time" name="time" value="<?php echo $lotDetails['Time']; ?>" required>
                <br>

                <label for="manufacturedDate">Manufactured Date:</label>
                <input type="date" id="manufacturedDate" name="manufacturedDate" value="<?php echo $lotDetails['Manufactured Date']; ?>" required>
                <br>

                <label for="expiryDate">Expiry Date:</label>
                <input type="date" id="expiryDate" name="expiryDate" value="<?php echo $lotDetails['Expiry Date']; ?>" required>
                <br>

                <label for="transportID">Transport ID:</label>
                <input type="text" id="transportID" name="transportID" value="<?php echo $lotDetails['stTransport ID']; ?>" required>
                <br>

                <label for="centerID">Center ID:</label>
                <input type="text" id="centerID" name="centerID" value="<?php echo $lotDetails['Center ID']; ?>" required>
                <br>

                <button type="submit">Update</button>
            </form>
        </section>
    </div>
</body>
</html>
