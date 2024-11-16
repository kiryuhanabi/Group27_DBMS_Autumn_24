


function loadShipments() {
    const shipmentsBody = document.getElementById('shipmentsBody');
    shipments.forEach((shipment) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${shipment.shipmentId}</td>
            <td>${shipment.product}</td>
            <td>${shipment.current} / ${shipment.capacity}</td>
        `;
        shipmentsBody.appendChild(row);

        if (shipment.current / shipment.capacity < 0.2) {
            sendNotification(shipment);
        }
    });
}


function sendNotification(shipment) {
    const notificationMessage = `⚠️ Low stock alert: ${shipment.product} (Shipment ID: ${shipment.shipmentId}) is below 20% capacity.`;
    alert(notificationMessage); 
}


document.addEventListener('DOMContentLoaded', loadShipments);
