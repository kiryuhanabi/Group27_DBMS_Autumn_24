// script.js

// Sample inspection data
const inspections = [
    { id: 101, farmName: "Green Valley", product: "Tomatoes", date: "2024-11-05", status: "Completed" },
    { id: 102, farmName: "Sunrise Farm", product: "Lettuce", date: "2024-11-10", status: "Pending" },
    { id: 103, farmName: "Harvest Hills", product: "Carrots", date: "2024-11-15", status: "In Progress" },
    { id: 104, farmName: "Blue Sky Farms", product: "Peppers", date: "2024-11-20", status: "Completed" }
];

// Function to populate the table with inspection data
function populateTable() {
    const tableBody = document.getElementById("inspectionTableBody");

    inspections.forEach(inspection => {
        const row = document.createElement("tr");
        
        row.innerHTML = `
            <td>${inspection.id}</td>
            <td>${inspection.farmName}</td>
            <td>${inspection.product}</td>
            <td>${inspection.date}</td>
            <td>${inspection.status}</td>
        `;

        tableBody.appendChild(row);
    });
}

// Call the function to populate the table when the page loads
window.onload = populateTable;
