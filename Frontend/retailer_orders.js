const { jsPDF } = window.jspdf;

let selectedRow = null;

// Load existing order data when the page loads
window.onload = function () {
    loadOrderData();
};

// Add a new order entry
function addTransport() {
    const date = document.getElementById('Date').value;
    const orderID = document.getElementById('orderID').value;
    const productName = document.getElementById('name').value;
    const quantity = document.getElementById('Quantity').value;

    // Validate input fields
    if (!date || !orderID || !productName || !quantity) {
        alert("Please fill in all fields.");
        return;
    }

    // Create order object
    const order = { date, orderID, productName, quantity };

    // Save to local storage
    let orderData = JSON.parse(localStorage.getItem('orderData')) || [];
    orderData.push(order);
    localStorage.setItem('orderData', JSON.stringify(orderData));

    // Add to table
    addRowToTable(order);

    // Clear input fields after submission
    document.getElementById('Date').value = "";
    document.getElementById('orderID').value = "";
    document.getElementById('name').value = "";
    document.getElementById('Quantity').value = "";
}

// Load order data from local storage and populate the table
function loadOrderData() {
    const orderData = JSON.parse(localStorage.getItem('orderData')) || [];
    orderData.forEach(order => addRowToTable(order));
}

// Add a row to the order table
function addRowToTable(order) {
    const tableBody = document.getElementById('transportTableBody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td>${order.date}</td>
        <td>${order.orderID}</td>
        <td>${order.productName}</td>
        <td>${order.quantity}</td>
    `;

    // Add a click listener to the row for selection
    row.addEventListener('click', () => {
        if (selectedRow) selectedRow.classList.remove('selected');
        row.classList.add('selected');
        selectedRow = row;
        document.querySelector('.delete-btn').disabled = false;
    });

    tableBody.appendChild(row);
}

// Delete the selected order row
function deleteSelectedRow() {
    if (!selectedRow) {
        alert("Please select an order row to delete.");
        return;
    }

    const orderID = selectedRow.cells[1].innerText; // Get the Order ID
    selectedRow.remove();
    selectedRow = null;
    document.querySelector('.delete-btn').disabled = true;

    // Update local storage
    let orderData = JSON.parse(localStorage.getItem('orderData')) || [];
    orderData = orderData.filter(order => order.orderID !== orderID);
    localStorage.setItem('orderData', JSON.stringify(orderData));
}

// Generate a PDF for the selected order row
function printRow(button) {
    const row = button.closest('tr');
    const rowData = Array.from(row.cells).map(cell => cell.innerText);

    const doc = new jsPDF();
    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.text("Order Details", 10, 10);
    doc.setFontSize(12);
    doc.text(`Date: ${rowData[0]}`, 10, 20);
    doc.text(`Order ID: ${rowData[1]}`, 10, 30);
    doc.text(`Product Name: ${rowData[2]}`, 10, 40);
    doc.text(`Quantity: ${rowData[3]}`, 10, 50);

    doc.save(`Order_${rowData[1]}.pdf`);
}
