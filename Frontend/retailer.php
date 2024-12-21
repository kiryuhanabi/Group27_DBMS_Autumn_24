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
        .shipments-table {
            background-color: white;
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        .shipments-table th, .shipments-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .shipments-table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .shipments-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .retailer-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .retailer-info-table th, .retailer-info-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .retailer-info-table th {
            background-color: #f2f2f2;
        }

        .btn {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
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

    <section class="retailer-info-container">
        <h2>Retailer Information</h2>
        <table class="retailer-info-table">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'crud');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM tblretailer LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<tr><td><strong>Retailer ID</strong></td><td>" . $row['Retailer ID'] . "</td></tr>";
                    echo "<tr><td><strong>First Name</strong></td><td>" . $row['First Name'] . "</td></tr>";
                    echo "<tr><td><strong>Last Name</strong></td><td>" . $row['Last Name'] . "</td></tr>";
                    echo "<tr><td><strong>Phone</strong></td><td>" . $row['Phone'] . "</td></tr>";
                    echo "<tr><td><strong>Store Name</strong></td><td>" . $row['Store Name'] . "</td></tr>";
                    echo "<tr><td><strong>Address</strong></td><td>" . $row['Address'] . "</td></tr>";
                } else {
                    echo "<tr><td colspan='2'>No data available</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <button type="button" class="btn" onclick="location.href='retailer_update.php'">Update</button>
    </section>

    <!-- Shipments from Storage Table -->
    <section class="shipments-container">
        <h2>Shipments from Storage</h2>
        <table class="shipments-table">
            <thead>
                <tr>
                    <th>Shipment ID</th>
                    <th>Transport ID</th>
                    <th>Retailer ID</th>
                    <th>Shipment Date</th>
                    <th>Shipment Quantity</th>
                    <th>Operating Temperature</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'crud');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM tblshipment";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Shipment ID'] . "</td>";
                        echo "<td>" . $row['shTransport ID'] . "</td>";
                        echo "<td>" . $row['Retailer ID'] . "</td>";
                        echo "<td>" . $row['Shipment Date'] . "</td>";
                        echo "<td>" . $row['Shipment Quantity'] . "</td>";
                        echo "<td>" . $row['Operating Temperature'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No data available</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </section>

</body>
</html>
