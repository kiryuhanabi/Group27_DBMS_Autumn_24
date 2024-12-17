<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Center</title>
    <link rel="stylesheet" href="processing_style.css">
    <link href="logo.png" rel="icon" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header class="title-header">
        <h1>Processing Center</h1>
    </header>

    <nav class="nav">
        <ul class="ul">
            <li><a href="processing_center.html">Home</a></li>
            <li><a href="processing_inspection.html">Inspection</a></li>
            <li><a href="processing_lot.html">Processing Lot</a></li>
            <li><a href="starting_page.html">Logout</a></li>
        </ul>
    </nav>

    <section class="overview-container">
        <h2>Processing Overview</h2>
        <div class="chart">
            <h3>Processing Lots vs Batches</h3>
            <canvas id="batchChart"></canvas>
        </div>
    </section>

    <script>
        const ctx1 = document.getElementById('batchChart').getContext('2d');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['Batch 1', 'Batch 2', 'Batch 3'],
                datasets: [{
                    data: [5, 3, 8],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                }]
            }
        });
    </script>
</body>
</html>
