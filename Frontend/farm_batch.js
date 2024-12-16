document.addEventListener("DOMContentLoaded", () => {
    loadBatches();
});

let batchIdCounter = JSON.parse(localStorage.getItem("lastBatchId")) || 1;

// Add a new batch
function addInspection(event) {
    event.preventDefault(); // Prevent form submission

    const productId = document.getElementById("productID").value;
    const productName = document.getElementById("name").value;
    const harvestDate = document.getElementById("harvestDate").value;
    const expiryDate = document.getElementById("exipreyDate").value;

    // Validate inputs
    if (!productId || !productName || !harvestDate || !expiryDate) {
        alert("Please fill in all fields.");
        return;
    }

    // Generate a unique Batch ID
    const batchId = `BATCH-${batchIdCounter++}`;

    // Create a batch object
    const batch = {
        productId,
        productName,
        batchId,
        harvestDate,
        expiryDate,
    };

    // Save the batch to localStorage
    const batches = JSON.parse(localStorage.getItem("farmBatches")) || [];
    batches.push(batch);
    localStorage.setItem("farmBatches", JSON.stringify(batches));
    localStorage.setItem("lastBatchId", JSON.stringify(batchIdCounter)); // Save the last Batch ID

    // Add the batch to the table
    addRowToTable(batch);

    // Reset the form
    document.getElementById("addInspectionForm").reset();
}

// Load batches from localStorage
function loadBatches() {
    const batches = JSON.parse(localStorage.getItem("farmBatches")) || [];
    batches.forEach(batch => addRowToTable(batch));
}

// Add a batch to the table
function addRowToTable(batch) {
    const tableBody = document.getElementById("inspectionTableBody");
    const row = document.createElement("tr");

    row.innerHTML = `
        <td>${batch.productId}</td>
        <td>${batch.productName}</td>
        <td>${batch.batchId}</td>
        <td>${batch.harvestDate}</td>
        <td>${batch.expiryDate}</td>
        <td>
            <button class="action-btn delete" onclick="deleteBatch('${batch.batchId}', this)">Delete</button>
        </td>
    `;

    tableBody.appendChild(row);
}

// Delete a batch from the table
function deleteBatch(batchId, button) {
    // Remove the row from the table
    const row = button.closest("tr");
    row.remove();

    // Remove the batch from localStorage
    let batches = JSON.parse(localStorage.getItem("farmBatches")) || [];
    batches = batches.filter(batch => batch.batchId !== batchId);
    localStorage.setItem("farmBatches", JSON.stringify(batches));
}
