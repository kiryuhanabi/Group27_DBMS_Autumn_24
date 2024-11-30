document.getElementById('orderForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const productId = document.getElementById('productId').value;
    const quantity = document.getElementById('quantity').value;

    // Default shipment status
    const status = "Incomplete";

    // Create a new row for the table
    const orderRow = document.createElement('tr');
    orderRow.innerHTML = `
        <td>${productId}</td>
        <td>${quantity}</td>
        <td>${status}</td>
    `;

    // Append the new row to the orders table body
    document.getElementById('ordersBody').appendChild(orderRow);

    // Reset the form fields after submission
    this.reset();
});
