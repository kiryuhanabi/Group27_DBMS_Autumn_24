const { jsPDF } = window.jspdf;

let selectedRow = null;

window.onload = function() {
    loadTransportData();
};

function addTransport() {
    const date = document.getElementById('transportDate').value;
    const transportID = document.getElementById('transportID').value;
    const transportType = document.getElementById('transportType').value;
    const cargoType = document.getElementById('cargoType').value;
    const temperatureRange = document.getElementById('temperatureRange').value;
    const loadWeight = document.getElementById('loadWeight').value;

<<<<<<< HEAD:Frontend/shipment_Creat.js
document.addEventListener('click', (e) => {
  if (!messageDropdown.contains(e.target) && e.target !== messageIcon) {
    messageDropdown.classList.remove('active');
  }
});



const notificationIcon = document.getElementById('notification-icon');
const notificationDropdown = document.getElementById('notification-dropdown');
notificationIcon.addEventListener('click', (e) => {
  e.stopPropagation();
  notificationDropdown.classList.toggle('active');
});

document.addEventListener('click', (e) => {
  if (!notificationDropdown.contains(e.target) && e.target !== notificationIcon) {
    notificationDropdown.classList.remove('active');
  }
});



const userIcon = document.getElementById("user-icon");
const userDropdown = document.getElementById("user-dropdown");
const customizeProfileBtn = document.getElementById("customize-profile-btn");
const customizeModal = document.getElementById("customize-modal");
const saveBtn = document.getElementById("save-btn");
const cancelBtn = document.getElementById("cancel-btn");
const signOutBtn = document.getElementById("sign-out-btn");

const nameInput = document.getElementById("name-input");
const emailInput = document.getElementById("email-input");
const userName = document.getElementById("user-name");
const userEmail = document.getElementById("user-email");
const userInitial = document.getElementById("user-initial");

function saveToLocalStorage(name, email) {
  localStorage.setItem("userName", name);
  localStorage.setItem("userEmail", email);
}

function loadFromLocalStorage() {
  const storedName = localStorage.getItem("userName");
  const storedEmail = localStorage.getItem("userEmail");

  if (storedName) {
    userName.textContent = storedName;
    userInitial.textContent = storedName.charAt(0).toUpperCase();
    nameInput.value = storedName;
  }
  if (storedEmail) {
    userEmail.textContent = storedEmail;
    emailInput.value = storedEmail; 
  }
}

userIcon.addEventListener("click", (e) => {
  e.stopPropagation();
  userDropdown.classList.toggle("active");
});

document.addEventListener("click", (e) => {
  if (!userDropdown.contains(e.target) && e.target !== userIcon) {
    userDropdown.classList.remove("active");
  }
});

customizeProfileBtn.addEventListener("click", () => {
  customizeModal.style.display = "flex";
});

cancelBtn.addEventListener("click", () => {
  customizeModal.style.display = "none";
});

saveBtn.addEventListener("click", () => {
  const updatedName = nameInput.value.trim();
  const updatedEmail = emailInput.value.trim();

  if (updatedName) {
    userName.textContent = updatedName;
    userInitial.textContent = updatedName.charAt(0).toUpperCase();
  }

  if (updatedEmail) {
    userEmail.textContent = updatedEmail;
  }


  saveToLocalStorage(updatedName, updatedEmail);

  customizeModal.style.display = "none";
});

signOutBtn.addEventListener("click", () => {

  localStorage.clear();
  window.location.href = "login.html";
});


document.addEventListener("DOMContentLoaded", loadFromLocalStorage);






document.addEventListener('DOMContentLoaded', () => {
  loadTableData();

  document.getElementById('searchInput').addEventListener('input', filterTable);
});

function filterTable() {
  const query = document.getElementById('searchInput').value.trim().toLowerCase();
  const tableBody = document.getElementById('transportTableBody');
  const rows = Array.from(tableBody.getElementsByTagName('tr'));

  rows.forEach(row => {
      const shtransportID = row.cells[1].innerText.toLowerCase();
      const transportType = row.cells[2].innerText.toLowerCase();

      if (shtransportID.includes(query) || transportType.includes(query)) {
          row.style.display = '';
      } else {
          row.style.display = 'none';
      }
  });
}





let editRowIndex = null;

let shtransportIDCounter = localStorage.getItem('shtransportIDCounter') 
    ? parseInt(localStorage.getItem('shtransportIDCounter')) 
    : 1;

let shipmentIDCounter = localStorage.getItem('shipmentIDCounter') 
    ? parseInt(localStorage.getItem('shipmentIDCounter')) 
    : 1;

let retailerIDCounter = localStorage.getItem('retailerIDCounter') 
    ? parseInt(localStorage.getItem('retailerIDCounter')) 
    : 1;

document.addEventListener('DOMContentLoaded', loadTableData);

function addUpdateTransport() {
    const transportType = document.getElementById('transportType').value.trim();
    const cargoType = document.getElementById('cargoType').value.trim();
    const temperatureRange = document.getElementById('temperatureRange').value.trim();
    const quantity = document.getElementById('quantity').value.trim();

    if (!transportType || !cargoType || !temperatureRange || !quantity) {
=======
    if (!date || !transportID || !cargoType || !temperatureRange || !loadWeight) {
>>>>>>> 9d5fb3fef309186e0f29edb53f166c08de79d465:Frontend/shipment_transport.js
        alert("Please fill in all fields.");
        return;
    }

<<<<<<< HEAD:Frontend/shipment_Creat.js
    const stransports = JSON.parse(localStorage.getItem('stransports')) || [];
    let transportDate, shtransportID, shipmentID, retailerID;

    if (editRowIndex === null) {
        // New Entry
        transportDate = new Date().toISOString().split('T')[0];
        shtransportID = `sht${String(shtransportIDCounter).padStart(6, '0')}`;
        shipmentID = `s${String(shipmentIDCounter).padStart(6, '0')}`;
        retailerID = `r${String(retailerIDCounter).padStart(6, '0')}`;

        stransports.push({
            transportDate,
            shtransportID,
            shipmentID,
            retailerID,
            transportType,
            cargoType,
            temperatureRange,
            quantity
        });

        // Increment counters
        shtransportIDCounter++;
        shipmentIDCounter++;
        retailerIDCounter++;

        // Update localStorage counters
        localStorage.setItem('shtransportIDCounter', shtransportIDCounter);
        localStorage.setItem('shipmentIDCounter', shipmentIDCounter);
        localStorage.setItem('retailerIDCounter', retailerIDCounter);
    } else {
        // Editing existing row
        const existingTransport = stransports[editRowIndex];
        transportDate = existingTransport.transportDate;
        shtransportID = existingTransport.shtransportID;
        shipmentID = existingTransport.shipmentID;
        retailerID = existingTransport.retailerID;

        stransports[editRowIndex] = {
            transportDate,
            shtransportID,
            shipmentID,
            retailerID,
            transportType,
            cargoType,
            temperatureRange,
            quantity
        };

        editRowIndex = null;
=======
    const transport = { date, transportID, transportType, cargoType, temperatureRange, loadWeight };

    let transportData = JSON.parse(localStorage.getItem('shipmentTransportData')) || [];
    transportData.push(transport);
    localStorage.setItem('shipmentTransportData', JSON.stringify(transportData));

    addRowToTable(transport);

    document.getElementById('transportDate').value = "";
    document.getElementById('transportID').value = "";
    document.getElementById('transportType').value = "";
    document.getElementById('cargoType').value = "";
    document.getElementById('temperatureRange').value = "";
    document.getElementById('loadWeight').value = "";
}

function loadTransportData() {
    const transportData = JSON.parse(localStorage.getItem('shipmentTransportData')) || [];
    transportData.forEach(transport => addRowToTable(transport));
}

function addRowToTable(transport) {
    const tableBody = document.getElementById('transportTableBody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td>${transport.date}</td>
        <td>${transport.transportID}</td>
        <td>${transport.transportType}</td>
        <td>${transport.cargoType}</td>
        <td>${transport.temperatureRange}</td>
        <td>${transport.loadWeight}</td>
        <td><button class="btn" onclick="printRow(this)">Print</button></td>
    `;

    row.addEventListener('click', () => {
        if (selectedRow) selectedRow.classList.remove('selected');
        row.classList.add('selected');
        selectedRow = row;
        document.querySelector('.delete-btn').disabled = false;
    });

    tableBody.appendChild(row);
}

function deleteSelectedRow() {
    if (!selectedRow) {
        alert("To delete the transport history, please select the correct transport row.");
        return;
>>>>>>> 9d5fb3fef309186e0f29edb53f166c08de79d465:Frontend/shipment_transport.js
    }
    const transportID = selectedRow.cells[1].innerText;
    selectedRow.remove();
    selectedRow = null;
    document.querySelector('.delete-btn').disabled = true;

<<<<<<< HEAD:Frontend/shipment_Creat.js
    localStorage.setItem('stransports', JSON.stringify(stransports));
    updateTable();
    clearInputs();
}

function loadTableData() {
    updateTable();
}

function updateTable() {
    const tableBody = document.getElementById('transportTableBody');
    tableBody.innerHTML = '';
    const stransports = JSON.parse(localStorage.getItem('stransports')) || [];

    stransports.forEach((transport, index) => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${transport.transportDate}</td>
            <td>${transport.shipmentID}</td>
            <td>${transport.shtransportID}</td>
            <td>${transport.transportType}</td>
            <td>${transport.retailerID}</td>
            <td>${transport.cargoType}</td>
            <td>${transport.temperatureRange}</td>
            <td>${transport.quantity}</td>
            <td class="actions">
                <button onclick="viewDetails(this)">View</button>
                <button onclick="editTransport(this)">Edit</button>
                <button onclick="deleteTransport(this)">Delete</button>
                <button onclick="sendToTransport(${index})">Send to Transport</button>
                
            </td>
        `;

        tableBody.appendChild(row);
    });
}




function sendToTransport(index) {
  const stransports = JSON.parse(localStorage.getItem('stransports')) || [];
  const transportToSend = stransports[index];

  if (!transportToSend) {
      alert("Unable to send transport data. Item not found.");
      return;
  }

  // Retrieve or initialize transport shipments in localStorage
  const transportShipments = JSON.parse(localStorage.getItem('transportShipments')) || [];

  // Add the selected transport data to the new storage
  transportShipments.push(transportToSend);

  // Save back to localStorage
  localStorage.setItem('transportShipments', JSON.stringify(transportShipments));

  alert("Transport data sent successfully!");
}




function editTransport(button) {
    const row = button.parentNode.parentNode;
    editRowIndex = row.rowIndex - 1;

    const stransports = JSON.parse(localStorage.getItem('stransports')) || [];
    const transport = stransports[editRowIndex];

    document.getElementById('transportType').value = transport.transportType;
    document.getElementById('cargoType').value = transport.cargoType;
    document.getElementById('temperatureRange').value = transport.temperatureRange;
    document.getElementById('quantity').value = transport.quantity;
}

function deleteTransport(button) {
    const row = button.parentNode.parentNode;
    const rowIndex = row.rowIndex - 1;

    let stransports = JSON.parse(localStorage.getItem('stransports')) || [];
    stransports.splice(rowIndex, 1);
    localStorage.setItem('stransports', JSON.stringify(stransports));

    updateTable();
}

function clearInputs() {
    document.getElementById('transportType').value = '';
    document.getElementById('cargoType').value = '';
    document.getElementById('temperatureRange').value = '';
    document.getElementById('quantity').value = '';
}



function viewDetails(button) {
=======
    let transportData = JSON.parse(localStorage.getItem('shipmentTransportData')) || [];
    transportData = transportData.filter(transport => transport.transportID !== transportID);
    localStorage.setItem('shipmentTransportData', JSON.stringify(transportData));
}


function printRow(button) {
>>>>>>> 9d5fb3fef309186e0f29edb53f166c08de79d465:Frontend/shipment_transport.js
    const row = button.closest('tr');
    const rowData = Array.from(row.cells).slice(0, -1).map(cell => cell.innerText);

    const doc = new jsPDF();
    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");

    const logoBase64 = 'data:image/png;base64,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';

    doc.addImage(logoBase64, 'PNG', 85, 10, 40, 40); 

    doc.setFontSize(24);
    doc.setTextColor(0, 128, 0);
    doc.text("Agro", 105, 53, { align: "center" });
    
    doc.setTextColor(0, 0, 0);
    doc.setFontSize(18);
    doc.text("Shipment Document", 105, 63, { align: "center" });

    doc.setFontSize(12);
    doc.setFont("helvetica", "normal");
    doc.text(`Date: ${rowData[0]}`, 20, 80);
    doc.text(`Shipment ID: ${rowData[1]}`, 20, 90);
    doc.text(`Shipment Transport ID: ${rowData[2]}`, 20, 100);
    doc.text(`Transport Type: ${rowData[3]}`, 20, 110);
    doc.text(`Retailer ID: ${rowData[4]}`, 20, 120);
    doc.text(`Cargo Type: ${rowData[5]}`, 20, 130);
    doc.text(`Operating Temperature: ${rowData[6]}`, 20, 140);
    doc.text(`Quantity: ${rowData[7]} kg`, 20, 150);

    doc.text("Signature:", 20, 160);
    doc.line(40, 160, 100, 160); 

    doc.save("Shipment Details.pdf");
}
