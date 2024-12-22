<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <title>Admin Dashboard</title>
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
                <li><a href="#" class="dropdown">Inspector</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_farm_inspection.php">Farm</a></li>
                        <li><a href="admin_batch_inspection.php">Batch</a></li>
                        <li><a href="admin_lot_inspection.php">Lot</a></li>
                        <li><a href="admin_p_center_inspection.php">Processing Center</a></li>
                        <li><a href="admin_storage_inspection.php">Storage</a></li>
                    </ul></li>
                <li>
                <li><a href="admin_storage.php">Storage</a></li>
                <li><a href="#" class="dropdown">Transport</a>
                    <ul class="dropdown-content">
                        <li><a href="admin_transport.php">Transport Home</a></li>
                        <li><a href="admin_transport_center.php">Transport to Processing Center</a></li>
                        <li><a href="admin_Transport_storage.php">Transport to Storage</a></li>
                        <li><a href="admin_transportShipment_to_ratailer.php">Transport Shipmenet to Retailer</a></li>
                    </ul></li>
                 <li><a href="admin_retailer_order.php">Retailer</a></li>
                <li><a href="starting_page.php" class="btn-logout">Log Out</a></li>
            </ul>
        </nav>
        <h2>Order</h2>
        <p>Order with necessary Information</p>
        <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'crud');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_order'])) {
        $retailerID = $_POST['retailerID'];
        $productName = $_POST['name'];
        $quantity = $_POST['Quantity'];
        $date = $_POST['Date'];

        if (!empty($retailerID) && !empty($productName) && !empty($quantity) && !empty($date)) {
            $stmt = $conn->prepare("INSERT INTO tblorder (`Retailer ID`, `Product Name`, `Quantity`, `Date`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssis', $retailerID, $productName, $quantity, $date);

            if ($stmt->execute()) {
                echo "<script>alert('Order added successfully!');</script>";
            } else {
                echo "<script>alert('Failed to add order.');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Please fill in all fields.');</script>";
        }
    }

    // Handle deletion
    if (isset($_GET['delete_order_id'])) {
        $orderID = $_GET['delete_order_id'];

        $stmt = $conn->prepare("DELETE FROM tblorder WHERE `Order ID` = ?");
        $stmt->bind_param('i', $orderID);

        if ($stmt->execute()) {
            echo "<script>alert('Order deleted successfully!'); window.location.href='admin_retailer_order.php';</script>";
        } else {
            echo "<script>alert('Failed to delete order.');</script>";
        }
        $stmt->close();
    }

    // Fetch all orders
    $orders = $conn->query("SELECT `Order ID`, `Retailer ID`, `Product Name`, `Quantity`, `Date` FROM tblorder");
    ?>

        <div class="transport-filters">
            <h3>Add new order</h3>
            <form method="POST">
                <div class="form-group">
                    <div class="input-row">
                        <label for="retailerID">Retailer ID:</label>
                        <input type="text" id="retailerID" name="retailerID">
                    </div>
                    <div class="input-row">
                        <label for="name">Product Name:</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <div class="input-row">
                        <label for="Quantity">Quantity:</label>
                        <input type="number" id="Quantity" name="Quantity" placeholder="amount in kg">
                    </div>
                    <div class="input-row">
                        <label for="Date">Date:</label>
                        <input type="date" id="Date" name="Date">
                    </div>
                </div>
                <button type="submit" name="add_order" class="btn">Add order</button>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Retailer ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $orders->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['Order ID'] ?></td>
                            <td><?= $row['Retailer ID'] ?></td>
                            <td><?= $row['Product Name'] ?></td>
                            <td><?= $row['Quantity'] ?></td>
                            <td><?= $row['Date'] ?></td>
                            <td class="action-buttons">
                                <a href="admin_retailer_order_update.php?order_id=<?= $row['Order ID'] ?>">
                                    <button class="btn">Update</button>
                                </a>
                                <a href="admin_retailer_order.php?delete_order_id=<?= $row['Order ID'] ?>" onclick="return confirm('Are you sure you want to delete this order?');">
                                    <button class="btn">Delete</button>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    


    <?php $conn->close(); ?>
</body>
</html>