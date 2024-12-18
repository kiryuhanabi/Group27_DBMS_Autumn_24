const { jsPDF } = window.jspdf;

let selectedRow = null;

window.onload = function() {
    loadInspectionData();
};


function generateRandomID(prefix="", length = 7) {
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
    document.getElementById('centerID').value = "";
    document.getElementById('inspectorID').value = "2222181";
    document.getElementById('machineQuality').value = "Select Grade";
    document.getElementById('processingQuality').value = "Select Grade";
    document.getElementById('staffSafetyGrade').value = "Select Grade";
    document.getElementById('hygieneGrade').value = "Select Grade";
}

function loadInspectionData() {
    setDefaultValues();
}


