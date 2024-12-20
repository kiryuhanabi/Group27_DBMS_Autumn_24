const messageIcon = document.getElementById('message-icon');
const messageDropdown = document.getElementById('message-dropdown');

messageIcon.addEventListener('click', (e) => {
  e.stopPropagation();
  messageDropdown.classList.toggle('active');
});

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









function updateT_products() {
  setTimeout(() => {
    const simulatedT_products = Math.floor(Math.random() * 5 + 169);
    document.getElementById('t_products').textContent = `${simulatedT_products}`;
  }, 3000); 

  setTimeout(updateT_products, 7000);
}

updateT_products();


function updateS_Capacity() {
  setTimeout(() => {
    const simulatedTemp = Math.floor(Math.random() * 5 + 86);
    document.getElementById('s_Capacity').textContent = `${simulatedTemp}%`;
  }, 2000); 

  setTimeout(updateS_Capacity, 10000);
}

updateS_Capacity();


function updateTemperature() {
  setTimeout(() => {
    const simulatedTemp = (Math.random() * 5 + 18).toFixed(1);
    document.getElementById('temperature').textContent = `${simulatedTemp}°C`;
  }, 3000); 

  setTimeout(updateTemperature, 9000);
}

updateTemperature();


function updateHumidity() {
  setTimeout(() => {
    const simulatedHumidity = Math.floor(Math.random() * 5 + 81);
    document.getElementById('humidity').textContent = `${simulatedHumidity}`;
  }, 1000.3); 

  setTimeout(updateHumidity, 10000);
}

updateHumidity();





window.addEventListener('scroll', function() {
  const infoSection = document.querySelector('.realtime-info');
  const sectionPosition = infoSection.getBoundingClientRect().top;
  const screenPosition = window.innerHeight / 1.5;

  if (sectionPosition < screenPosition) {
      infoSection.classList.add('appear');
  }
});


const chartOptions = {
  responsive: true,
  maintainAspectRatio: true, 
  plugins: {
      legend: {
          display: true,
          position: 'top'
      }
  },
  layout: {
      padding: 10 
  }
};

// Storage Transport Chart
new Chart(document.getElementById('storageTransportChart'), {
  type: 'bar',
  data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr'],
      datasets: [{
          label: 'Storage Transport',
          data: [10, 20, 15, 25],
          backgroundColor: '#4CAF50',
      }]
  },
  options: chartOptions
});

// Shipment Transport Chart
new Chart(document.getElementById('shipmentTransportChart'), {
  type: 'line',
  data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr'],
      datasets: [{
          label: 'Shipment Transport',
          data: [5, 15, 10, 20],
          borderColor: '#ff6b6b',
          fill: false
      }]
  },
  options: chartOptions
});

// Revenue Chart
new Chart(document.getElementById('revenueChart'), {
  type: 'pie',
  data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr'],
      datasets: [{
          data: [500, 800, 600, 1200],
          backgroundColor: ['#4CAF50', '#34495e', '#ff6b6b', '#3498db']
      }]
  },
  options: chartOptions
});

// Cost Chart
new Chart(document.getElementById('costChart'), {
  type: 'doughnut',
  data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr'],
      datasets: [{
          data: [300, 400, 350, 500],
          backgroundColor: ['#4CAF50', '#34495e', '#ff6b6b', '#3498db']
      }]
  },
  options: chartOptions
});





document.addEventListener('DOMContentLoaded', () => {
  const tableBody = document.getElementById('table-body');

  // Handle Add/Edit Form Submission
  document.querySelector('form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const action = formData.get('storageId') ? 'edit' : 'add';  // Check for Storage ID for editing
    formData.append('action', action);

    const response = await fetch('', {
      method: 'POST',
      body: formData,
    });

    const result = await response.json();
    alert(result.message);

    if (result.success) {
      location.reload(); // Reload to update table
    }
  });

  // Handle Edit Button Click
  tableBody.addEventListener('click', (e) => {
    if (e.target.classList.contains('edit-btn')) {
      const row = e.target.closest('tr');
      const storageId = row.cells[0].textContent.trim();  // Grab the Storage ID (first column)
      const type = row.cells[1].textContent.trim();
      const duration = row.cells[2].textContent.trim();
      const location = row.cells[3].textContent.trim();

      // Populate form fields with the row's data
      document.getElementById('type').value = type;
      document.getElementById('duration').value = duration;
      document.getElementById('location').value = location;

      // Add Storage ID to the form as a hidden field for editing
      const storageIdInput = document.createElement('input');
      storageIdInput.type = 'hidden';
      storageIdInput.name = 'storageId';
      storageIdInput.value = storageId;
      document.querySelector('form').appendChild(storageIdInput);
    }
  });

  



  // Handle Delete Button Click
  tableBody.addEventListener('click', async (e) => {
    if (e.target.classList.contains('delete-btn')) {
      console.log('Delete button clicked'); // Add this
      const row = e.target.closest('tr');
  
      const type = row.cells[1].textContent.trim();
      const duration = row.cells[2].textContent.trim();
      const location = row.cells[3].textContent.trim();

      if (confirm('Are you sure you want to delete this record?')) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('type', type);
        formData.append('duration', duration);
        formData.append('location', location);
  
        const response = await fetch('', {
          method: 'POST',
          body: formData,
        });
  
        const result = await response.json();
        alert(result.message);
    
        if (result.success) {
          row.remove();
      }
    }
  }
  });
  

});

