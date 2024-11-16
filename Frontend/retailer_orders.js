document.getElementById('orderForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const productId = document.getElementById('productId').value;
    const quantity = document.getElementById('quantity').value;
    const status = document.getElementById('status').value;

    const orderRow = document.createElement('tr');
    orderRow.innerHTML = `
        <td>${productId}</td>
        <td>${quantity}</td>
        <td>${status}</td>
    `;

    document.getElementById('ordersBody').appendChild(orderRow);

    
    this.reset();
});
