const { jsPDF } = window.jspdf;

let selectedRow = null;

window.onload = function() {
    loadInspectionData();
};

/*function addInspection() {
    const date = document.getElementById('inspectionDate').value;
    const inspectorID = document.getElementById('inspectorID').value;
    const lotNumber = document.getElementById('lotNumber').value;
    const packageQualityGrade= document.getElementById('packageQualityGrade').value;

    // Check for empty fields
    if (!date || !lotNumber || !inspectorID || !packageQualityGrade) {
        alert("Please fill in all fields, including at least one certification.");
        return;
    }

    // Create batch inspection object
    const batch_inspection = {
        date,
        inspectionID,
        inspectorID,
        lotNumber,
        packageQualityGrade,
    };

    // Save to localStorage
    let batch_inspectionData = JSON.parse(localStorage.getItem('batch_inspectionData')) || [];
    batch_inspectionData.push(batch_inspection);
    localStorage.setItem('batch_inspectionData', JSON.stringify(batch_inspectionData));

    // Add to table
    addRowToTable(batch_inspection);
    setDefaultValues();
}*/


function setDefaultValues() {
    document.getElementById('inspectionDate').value = setLocalDate();
    document.getElementById('inspectorID').value = "2222181";
    document.getElementById('lotNumber').value = generateRandomID();
    document.getElementById('packageQualityGrade').value = "";
}

function generateRandomID(prefix="", length = 7) {
    const characters = '0123456789';
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

function loadInspectionData() {
    setDefaultValues();
    /*const lot_inspectionData = JSON.parse(localStorage.getItem('lot_inspectionData')) || [];
    lot_inspectionData.forEach(lot_inspection => addRowToTable(lot_inspection));*/
}

function addRowToTable(batch_inspection) {
    const tableBody = document.getElementById('inspectionTableBody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td>${batch_inspection.date}</td>
        <td>${batch_inspection.inspectorID}</td>
        <td>${batch_inspection.lotNumber}</td>
        <td>${batch_inspection.packageQualityGrade}</td>
`;

    row.addEventListener('click', () => {
        if (selectedRow) selectedRow.classList.remove('selected');
        row.classList.add('selected');
        selectedRow = row;
        document.querySelector('.delete-btn').disabled = false;
    });

    tableBody.appendChild(row);
}


