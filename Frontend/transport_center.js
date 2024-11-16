document.addEventListener('DOMContentLoaded', () => {
    const shipments = [
        { transportId: 'T001', centerId: 'C102', batchId: 'B503', temperature: -18, status: 'In Transit' },
        { transportId: 'T002', centerId: 'C208', batchId: 'B604', temperature: -20, status: 'Delivered' },
        { transportId: 'T003', centerId: 'C305', batchId: 'B709', temperature: -16, status: 'Pending' }
    ];

    loadShipments(shipments);
});

function loadShipments(shipments) {
    const tableBody = document.getElementById('transport-table');

    shipments.forEach((shipment) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${shipment.transportId}</td>
            <td>${shipment.centerId}</td>
            <td>${shipment.batchId}</td>
            <td>${shipment.temperature}°C</td>
            <td>${shipment.status}</td>
        `;
        tableBody.appendChild(row);


        if (shipment.temperature > -17) {
            row.style.backgroundColor = '#f8d7da'; 
        }
    });
}
