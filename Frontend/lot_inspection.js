const { jsPDF } = window.jspdf;

let selectedRow = null;

window.onload = function() {
    loadInspectionData();
};

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
    document.getElementById('lotNumber').value = "";
    document.getElementById('packageQualityGrade').value = "";
}

function loadInspectionData() {
    document.getElementById('inspectionDate').value = setLocalDate(); 
    document.getElementById('inspectorID').value = "2222181";
    document.getElementById('lotNumber').value = "";
    document.getElementById('packageQualityGrade').value = "";
}
