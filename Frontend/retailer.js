document.addEventListener('DOMContentLoaded', () => {
    // Data for pie chart
    const productData = {
        labels: ['product1', 'product2', 'product3'],
        datasets: [{
            label: 'amount%',
            data: [50, 30, 20], // Current stock percentages
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
            hoverOffset: 4
        }]
    };

    // Pie chart configuration
    const pieConfig = {
        type: 'pie',
        data: productData,
        options: {
            responsive: true,
            maintainAspectRatio: true, // Ensure it adapts properly
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'Products'
                }
            }
        }
    };

    // Initialize pie chart
    const pieChart = new Chart(
        document.getElementById('pieChart'),
        pieConfig
    );

    // Data for bar chart
    const shipmentData = {
        labels: ['Completed', 'Upcoming'],
        datasets: [{
            label: 'Shipments',
            data: [12, 5], // Completed and upcoming shipment counts
            backgroundColor: ['#4CAF50', '#F44336'],
            borderColor: ['#388E3C', '#D32F2F'],
            borderWidth: 1
        }]
    };

    // Bar chart configuration
    const barConfig = {
        type: 'bar',
        data: shipmentData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Shipments Status'
                }
            }
        }
    };

    // Initialize bar chart
    const barChart = new Chart(
        document.getElementById('barChart'),
        barConfig
    );
});
