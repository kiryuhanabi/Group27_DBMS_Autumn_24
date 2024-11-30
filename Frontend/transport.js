document.addEventListener('DOMContentLoaded', () => {
    const shipmentForm = document.getElementById('shipmentForm');
    const shipmentTable = document.getElementById('shipmentTable');
    const storageForm = document.getElementById('storageForm');
    const storageTable = document.getElementById('storageTable');

    if (shipmentForm) {
        shipmentForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${document.getElementById('shTransportID').value}</td>
                <td>${document.getElementById('shTransportDate').value}</td>
                <td>${document.getElementById('cargoType').value}</td>
                <td>${document.getElementById('temperatureRange').value}</td>
                <td>${document.getElementById('loadWeight').value}</td>
            `;
            shipmentTable.querySelector('tbody').appendChild(row);
            shipmentForm.reset();
        });
    }

    if (storageForm) {
        storageForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${document.getElementById('stTransportID').value}</td>
                <td>${document.getElementById('stTransportDate').value}</td>
                <td>${document.getElementById('transportType').value}</td>
                <td>${document.getElementById('stCargoType').value}</td>
                <td>${document.getElementById('stTemperatureRange').value}</td>
                <td>${document.getElementById('stLoadWeight').value}</td>
            `;
            storageTable.querySelector('tbody').appendChild(row);
            storageForm.reset();
        });
    }
});
