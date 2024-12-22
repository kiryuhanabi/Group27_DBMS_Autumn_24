<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: white;
            color: black;
            padding: 10px 20px;
            border-bottom: 2px solid #4CAF50;
            display: flex;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.8em;
            display: flex;
            align-items: center;
        }

        .logo-img {
            height: 40px;
            margin-right: 10px;
        }

        .nav {
            background-color: #90EE90; /* Light green */
            overflow: hidden;
        }

        .nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        .nav ul li {
            margin: 0 10px;
        }

        .nav ul li a {
            display: block;
            color: black;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .nav ul li a:hover {
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }

        .dashboard {
            padding: 20px;
        }

        .transport-filters {
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .form-group .input-row {
            margin-bottom: 10px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        .action-buttons button {
            margin-right: 5px;
        }
    </style>
</head>
<body>
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
            echo "<script>alert('Order deleted successfully!'); window.location.href='retailer_orders.php';</script>";
        } else {
            echo "<script>alert('Failed to delete order.');</script>";
        }
        $stmt->close();
    }

    // Fetch all orders
    $orders = $conn->query("SELECT `Order ID`, `Retailer ID`, `Product Name`, `Quantity`, `Date` FROM tblorder");
    ?>

    <header>
        <h1>
            <img src="logo.png" alt="Retail Logo" class="logo-img">
            Retail Orders
        </h1>
    </header>
    <div class="dashboard">
        <nav class="nav">
            <ul class="ul">
                <li><a href="retailer.php">Home</a></li>
                <li><a href="retailer_orders.php">Orders</a></li>
                <li><a href="starting_page.php">Logout</a></li>
            </ul>
        </nav>

        <h2>Order</h2>
        <p>Order with necessary Information</p>

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
                                <a href="retailer_orders_update.php?order_id=<?= $row['Order ID'] ?>">
                                    <button class="btn">Update</button>
                                </a>
                                <a href="retailer_orders.php?delete_order_id=<?= $row['Order ID'] ?>" onclick="return confirm('Are you sure you want to delete this order?');">
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
