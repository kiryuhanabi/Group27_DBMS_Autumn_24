<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Inspection</title>
    <link rel="stylesheet" href="processing_inspection_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header class="title-header">
        <h1>Processing Inspection</h1>
    </header>

    <nav class="nav">
        <ul class="ul">
            <li><a href="processing_center.html">Home</a></li>
            <li><a href="processing_inspection.html">Inspection</a></li>
            <li><a href="processing_lot.html">Processing Lot</a></li>
            <li><a href="starting_page.html">Logout</a></li>
        </ul>
    </nav>

    <div class="background-image">
        <section class="inspection-container">
            <h2>Inspection Results</h2>
            <div class="chart">
                <canvas id="inspectionChart"></canvas>
            </div>
        </section>
    </div>

    <?php

    include('connect.php');
    // Initialize array to store grade counts
    $grades = ['Acceptable', 'Decent', 'Perfect', 'Poor'];
    $gradeCounts = [0, 0, 0, 0];

    // Fetch data from the database
    $query = "SELECT PackageQualityGrade, COUNT(*) AS count FROM tbllotinspection GROUP BY PackageQualityGrade";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $index = array_search($row['PackageQualityGrade'], $grades);
            if ($index !== false) {
                $gradeCounts[$index] = $row['count'];
            }
        }
    }

    mysqli_close($conn); // Close database connection
    ?>

    <script>
        // PHP data passed to JavaScript
        const gradeCounts = <?php echo json_encode($gradeCounts); ?>;

        const ctx2 = document.getElementById('inspectionChart').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Acceptable', 'Decent', 'Perfect', 'Poor'],
                datasets: [{
                    data: gradeCounts,
                    backgroundColor: ['#4CAF50', '#FFC107', '#2196F3', '#F44336']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white',
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        bodyColor: 'white',
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: 'white',
                    }
                }
            }
        });
    </script>
</body>
</html>
