function toggleContent(sectionId) {

    document.querySelectorAll(".content").forEach((section) => {
      section.style.display = "none";
    });
  
    const content = document.getElementById(sectionId);
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  }
  
  
  function saveProfile() {
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
  
    if (name && email) {
      localStorage.setItem("profileName", name);
      localStorage.setItem("profileEmail", email);
      alert("Profile updated successfully!");
    } else {
      alert("Please fill out all fields!");
    }
  }

  document.addEventListener("DOMContentLoaded", () => {
    const savedName = localStorage.getItem("profileName");
    const savedEmail = localStorage.getItem("profileEmail");
  
    if (savedName) document.getElementById("name").value = savedName;
    if (savedEmail) document.getElementById("email").value = savedEmail;
  });
  
  
  function logout() {
    window.location.href = "login.html";
  }
  
  
  
  
  
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
      window.location.href = "login.php";
    });
    
    
    document.addEventListener("DOMContentLoaded", loadFromLocalStorage);




