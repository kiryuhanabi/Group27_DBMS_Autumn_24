document.addEventListener("DOMContentLoaded", () => {
    loadProducts();
});

let productIdCounter = JSON.parse(localStorage.getItem("lastProductId")) || 1; // Auto-increment Product ID

function addInspection() {
    const productName = document.getElementById("productname").value;
    const type = document.getElementById("type").value;
    const season = document.getElementById("season").value;
    const humidity = document.getElementById("humidity").value;
    const temperature = document.getElementById("inspectorID").value;

    // Validate form fields
    if (!productName || !type || !season || !humidity || !temperature) {
        alert("Please fill in all fields.");
        return;
    }

    const product = {
        id: productIdCounter++,
        name: productName,
        type,
        season,
        humidity,
        temperature
    };

    // Save product to localStorage
    const products = JSON.parse(localStorage.getItem("farmProducts")) || [];
    products.push(product);
    localStorage.setItem("farmProducts", JSON.stringify(products));
    localStorage.setItem("lastProductId", JSON.stringify(productIdCounter)); // Save last ID

    // Add to table
    addRowToTable(product);

    // Reset form
    document.getElementById("addInspectionForm").reset();
}

function loadProducts() {
    const products = JSON.parse(localStorage.getItem("farmProducts")) || [];
    products.forEach(product => addRowToTable(product));
}

function addRowToTable(product) {
    const tableBody = document.getElementById("inspectionTableBody");
    const row = document.createElement("tr");

    row.innerHTML = `
        <td>${product.id}</td>
        <td>${product.name}</td>
        <td>${product.type}</td>
        <td>${product.season}</td>
        <td>${product.temperature}</td>
        <td>${product.humidity}</td>
        <td>
            <button class="action-btn edit" onclick="editProduct(${product.id})">Edit</button>
            <button class="action-btn delete" onclick="deleteProduct(${product.id}, this)">Delete</button>
        </td>
    `;

    tableBody.appendChild(row);
}

function deleteProduct(id, button) {
    // Remove row from table
    const row = button.closest("tr");
    row.remove();

    // Remove product from localStorage
    let products = JSON.parse(localStorage.getItem("farmProducts")) || [];
    products = products.filter(product => product.id !== id);
    localStorage.setItem("farmProducts", JSON.stringify(products));
}

function editProduct(id) {
    const products = JSON.parse(localStorage.getItem("farmProducts")) || [];
    const product = products.find(product => product.id === id);

    if (product) {
        document.getElementById("productname").value = product.name;
        document.getElementById("type").value = product.type;
        document.getElementById("season").value = product.season;
        document.getElementById("humidity").value = product.humidity;
        document.getElementById("inspectorID").value = product.temperature;

        // Delete product while editing
        deleteProduct(id, document.querySelector(`button[action-btn][onclick="editProduct(${id})"]`));
    }
}
