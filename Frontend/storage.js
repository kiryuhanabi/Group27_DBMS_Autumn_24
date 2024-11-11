// Function to display real-time date and time
function updateDateTime() {
    const now = new Date();
    document.getElementById('datetime').textContent = now.toLocaleString();
}

// Update date and time every second
setInterval(updateDateTime, 1000);

// Function to simulate temperature
function updateTemperature() {
    const simulatedTemp = (Math.random() * 5 + 18).toFixed(1); // Simulates temperature between 18-23°C
    document.getElementById('temperature').textContent = `Temperature: ${simulatedTemp}°C`;
}

// Update temperature every 5 seconds
setInterval(updateTemperature, 5000);

// Scroll animation for the real-time info section
window.addEventListener('scroll', function() {
    const infoSection = document.querySelector('.realtime-info');
    const sectionPosition = infoSection.getBoundingClientRect().top;
    const screenPosition = window.innerHeight / 1.5;

    if (sectionPosition < screenPosition) {
        infoSection.classList.add('appear');
    }
});
