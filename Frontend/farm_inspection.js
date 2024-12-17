const { jsPDF } = window.jspdf;

let selectedRow = null;

window.onload = function() {
    loadInspectionData();
};

function saveTableData() {
    const tableBody = document.getElementById("inspectionTableBody");
    const rows = tableBody.querySelectorAll("tr");
    const data = [];

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        data.push({
            date: cells[0].textContent,
            inspectorID: cells[1].textContent,
            farmID: cells[2].textContent,
            maintenanceGrade: cells[3].textContent,
            fertilizerGrade: cells[4].textContent,
            soilQualityGrade: cells[5].textContent
        });
    });

    localStorage.setItem("inspectionData", JSON.stringify(data));
}

// Function to load data from localStorage
function loadTableData() {
    const tableBody = document.getElementById("inspectionTableBody");
    const data = JSON.parse(localStorage.getItem("inspectionData")) || [];

    tableBody.innerHTML = ""; // Clear existing rows
    data.forEach(rowData => {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${rowData.date}</td>
            <td>${rowData.inspectorID}</td>
            <td>${rowData.farmID}</td>
            <td>${rowData.maintenanceGrade}</td>
            <td>${rowData.fertilizerGrade}</td>
            <td>${rowData.soilQualityGrade}</td>
        `;

        tableBody.appendChild(row);
    });
}

// Save data to localStorage
    saveTableData();

function generateRandomID(prefix="", length = 6) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let result = prefix;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return result;
}

function setLocalDate () {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-based
    const dd = String(today.getDate()).padStart(2, '0');

    const formattedDate = `${yyyy}-${mm}-${dd}`;
    return formattedDate;
}

function setDefaultValues() {
    document.getElementById('inspectionDate').value = setLocalDate(); 
    document.getElementById('inspectorID').value = "2222181";
    document.getElementById('farmID').value = "";
    document.getElementById('maintenanceGrade').value = "";
    document.getElementById('fertilizerGrade').value = "";
    document.getElementById('soilQualityGrade').value = "";
}

function loadInspectionData() {
    document.getElementById('inspectionDate').value = setLocalDate(); 
    document.getElementById('inspectorID').value = "2222181";
    document.getElementById('farmID').value = "";
    document.getElementById('maintenanceGrade').value = "";
    document.getElementById('fertilizerGrade').value = "";
    document.getElementById('soilQualityGrade').value = "";
    /*const farm_inspectionData = JSON.parse(localStorage.getItem('farm_inspectionData')) || [];
    farm_inspectionData.forEach(farm_inspection => addRowToTable(farm_inspection));*/
}

function addRowToTable(farm_inspection) {
    const tableBody = document.getElementById('inspectionTableBody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td>${farm_inspection.date}</td>
        <td>${farm_inspection.inspectorID}</td>
        <td>${farm_inspection.farmID}</td>
        <td>${farm_inspection.maintenanceGrade}</td>
        <td>${farm_inspection.fertilizerGrade}</td>
        <td>${farm_inspection.soilQualityGrade}</td>
    `;

    row.addEventListener('click', () => {
        if (selectedRow) selectedRow.classList.remove('selected');
        row.classList.add('selected');
        selectedRow = row;
        document.querySelector('.delete-btn').disabled = false;
    });

    tableBody.appendChild(row);
}