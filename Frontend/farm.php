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
            <li><a href="farm.html">Home</a></li>
            <li><a href="farm_product.html">Product</a></li>
            <li><a href="farm_batch.html">Batch</a></li>
            <li><a href="login.html">Logout</a></li>
        </ul>
    </nav>

    <section class="farm-info-container">
        <h2>Farm Information</h2>
        <div id="farmInfo">
            <?php
            // Include the database connection file
            include 'connect.php';
            session_start();

            // Check if the user is logged in and get their user ID
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];

                // SQL query to read farm information for the logged-in user
                $sql = "SELECT `Farm ID`, `Farm Name`, `Street`, `City`, `No. of Fields` 
                        FROM tblfarm 
                        WHERE `Farm ID` = (
                            SELECT `ID` FROM tblsignup WHERE `ID` = '$user_id' AND `User` = 'farm'
                        )";

                $result = $conn->query($sql);

                // Check if a record was found and display the information
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
                        echo "<td>" . $row['Farm ID'] . "</td>";
                        echo "<td>" . $row['Farm Name'] . "</td>";
                        echo "<td>" . $row['Street'] . "</td>";
                        echo "<td>" . $row['City'] . "</td>";
                        echo "<td>" . $row['No. of Fields'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p>No farm information found for your account.</p>";
                }
            } else {
                echo "<p>Please log in to view your farm information.</p>";
            }
            ?>
        </div>
        <button class="btn" onclick="window.location.href='farm_update.html'">Update</button>
    </section>
</body>
</html>
