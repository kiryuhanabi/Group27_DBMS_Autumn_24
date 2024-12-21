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


$sql_farm = "SELECT * FROM tblfarm";
$result_farm = $conn->query($sql_farm);

$sql_batch = "SELECT * FROM tblbatch";
$result_batch = $conn->query($sql_batch);

/*$sql_lot = "SELECT * FROM tbllot";
$result_lot = $conn->query($sql_lot);*/

$sql_processing = "SELECT * FROM tblprocessingcenter";
$result_processing = $conn->query($sql_processing);

$sql_storage = "SELECT * FROM tblstorage";
$result_storage = $conn->query($sql_storage);

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="inspector_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css" integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <h1>
        <img src="logo.png" alt="Agro Logo" class="logo-img">
        Agro
    </h1>
    <nav class="nav">
        <ul class="ul">
            <li><a href="inspector.html">Home</a></li>
            <li>
                <a href="#">Inspection Type</a>
                <ul class="dropdown">
                    <li><a href="farm_inspection.php">Farm</a></li>
                    <li><a href="batch_inspection.php">Batch</a></li>
                    <li><a href="lot_inspection.php">Lot</a></li>
                    <li><a href="p_inspect.php">Processing Center</a></li>
                    <li><a href="storage_inspection.php">Storage</a></li>
                </ul>
            </li>
            <li><a href="login.html">Log out</a></li>
        </ul>
    </nav>

    <section class="chart-container">
        <h2>Inspection Results</h2>
        <div class="chart">
            <canvas id="inspectionChart"></canvas>
        </div>
    </section>

    <h2>Registered Farms</h2>

    <div class="table-container">
        <table id="inspectionTable">
            <thead>
                <tr>
                    <th>Farm ID</th>
                    <th>Farm Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="inspectionTableBody">
                <?php if ($result_farm->num_rows > 0): ?>
                    <?php while ($row = $result_farm->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Farm ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Farm Name']); ?></td>
                            <td>
                            <td>
                                <form method="POST" action="farm_inspection.php">
                                    <input type="hidden" name="id" value="<?php echo $row['Farm ID']; ?>">
                                    <button type="submit" name="inspect" class="btn"><i class="fa fa-check" aria-hidden="true"></i> Inspect</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div> 

    <h2>Registered Batch</h2>
    <div class="table-container">
        <table id="inspectionTable">
            <thead>
                <tr>
                    <th>Batch Barcode</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="inspectionTableBody">
                <?php if ($result_batch->num_rows > 0): ?>
                    <?php while ($row = $result_batch->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['Batch Barcode']); ?></td>
                            <td>
                                <form method="POST" action="batch_inspection.php">
                                    <input type="hidden" name="id" value="<?php echo $row['Batch Barcode']; ?>">
                                    <button type="submit" name="inspect" class="btn"><i class="fa fa-check" aria-hidden="true"></i> Inspect</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div> 
    
    <h2>Registered Processing Centers</h2>
    <div class="table-container">
        <table id="inspectionTable">
            <thead>
                <tr>
                    <th>Center ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="inspectionTableBody">
                <?php if ($result_processing->num_rows > 0): ?>
                    <?php while ($row = $result_processing->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Center ID']); ?></td>
                            <td>
                                <form method="POST" action="p_inspect.php">
                                    <input type="hidden" name="id" value="<?php echo $row['Center ID']; ?>">
                                    <button type="submit" name="inspect" class="btn"><i class="fa fa-check" aria-hidden="true"></i> Inspect</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <h2>Registered Storage</h2>
    <div class="table-container">
        <table id="inspectionTable">
            <thead>
                <tr>
                    <th>Storage ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="inspectionTableBody">
                <?php if ($result_storage->num_rows > 0): ?>
                    <?php while ($row = $result_storage->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['sTorage ID']); ?></td>
                            <td>
                                <form method="POST" action="storage_inspection.php">
                                    <input type="hidden" name="id" value="<?php echo $row['Storage ID']; ?>">
                                    <button type="submit" name="inspect" class="btn"><i class="fa fa-check" aria-hidden="true"></i> Inspect</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        const ctx = document.getElementById('inspectionChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Acceptable', 'Decent', 'Perfect', 'Poor'],
                datasets: [{
                    data: [20, 15, 10, 5],
                    backgroundColor: ['#4CAF50', '#FFC107', '#2196F3', '#F44336']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
