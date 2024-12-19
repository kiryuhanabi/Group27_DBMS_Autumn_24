<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm</title>
    <link rel="stylesheet" href="farm.css">
    <link href="logo.png" rel="icon" type="image/png">
</head>
<body>
    <h1>
        <img src="logo.png" alt="Farm Logo" class="logo-img">
        Agro Farm
    </h1>

    <nav class="nav">
        <ul class="ul">
            <li><a href="farm.php">Home</a></li>
            <li><a href="farm_product.php">Product</a></li>
            <li><a href="farm_batch.php">Batch</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <section class="farm-info-container">
        <h2>Farm Information</h2>
        <div id="farmInfo">
            <?php
            // Database connection
            $host = "localhost";
            $user = "root";
            $pass = "";
            $db = "crud";

            $conn = new mysqli($host, $user, $pass, $db);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch all farm records from tblfarm
            $sql = "SELECT `Farm ID`, `Farm Name`, `Street`, `City`, `No. of Fields` FROM tblfarm";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='farm-table'>";
                echo "<thead>
                        <tr>
                            <th>Farm ID</th>
                            <th>Farm Name</th>
                            <th>Street</th>
                            <th>City</th>
                            <th>Number of Fields</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Farm ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Farm Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Street']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['City']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['No. of Fields']) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No farm information available in the database.</p>";
            }

            $conn->close();
            ?>
        </div>
        <button class="btn" onclick="window.location.href='farm_update.php'">Update</button>
    </section>
</body>
</html>
