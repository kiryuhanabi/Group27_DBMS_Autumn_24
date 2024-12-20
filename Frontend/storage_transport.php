<?php
// Database connection details
$host = 'localhost'; // Change if your database host is different
$username = 'root'; // Database username
$password = ''; // Database password
$dbname = 'crud'; // Database name

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data
$sql = "SELECT `stTransport ID`, `Storage ID`, `Storage Type`, `Date`, `Transport Type`, `Temperature Range`, `Load Weight` FROM `tblstoragetransport`";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Dashboard</title>
    <link rel="stylesheet" href="storage_transport.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

</head>
<body>
    <div class="sidebar">
        <h2><img src="logo.png" alt="Agro Logo" class="logo-img"> Agro Storage</h2>
        <ul>
          <li><a href="storage.php" class="active"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="#"><i class="fas fa-warehouse"></i> Storage Transport</a></li>
          <li><a href="shipment_Creat.php"><i class="fas fa-truck"></i> Create Shipment</a></li>
          <li><a href="setting.html"><i class="fa fa-cog"></i> Settings</a></li>
          <li><a href="login.html"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </div>
      <div class="content">
    <div class="dashboard">
        <header>
            <h1>Storage Transport Dashboard</h1>
            <div class="top-icons">
              <i class="fas fa-envelope" id="message-icon">
                <span class="badge" id="message-badge">4</span>
              </i>
              <div class="message-dropdown" id="message-dropdown">
                <h4>4 New Messages</h4>
                <ul>
                  <li><a href="#">Order #1234 Request</a> <span>3 mins</span></li>
                  <li><a href="#">Stock Update Required</a> <span>12 mins</span></li>
                  <li><a href="#">Delivery Confirmation</a> <span>2 hrs</span></li>
                  <li><a href="#">New Supplier Message</a> <span>4 hrs</span></li>
                </ul>
                <a href="#">See All Messages</a>
              </div>


              <i class="fas fa-bell" id="notification-icon">
                <span class="badge" id="notification-badge">3</span>
              </i>
              <div class="notification-dropdown" id="notification-dropdown">
                  <h4>3 New Notifications</h4>
                  <ul>
                    <li><a href="#">4 new Orders</a> <span>2 mins</span></li>
                    <li><a href="#">3 new Registrations</a> <span>2 hrs</span></li>
                    <li><a href="#">Weekly report ready</a> <span>1 day</span></li>
                  </ul>
                  <a href="#">See All Notifications</a>
                </div>
            
      
      
      
              
              <i class="fas fa-user-circle" id="user-icon"></i>
            
            <div class="user-dropdown" id="user-dropdown">
              <div class="dropdown-header">
                <div class="user-initial" id="user-initial">M</div>
                <div class="user-info">
                  <h4 id="user-name">Md. Abdur Gaffar Mia</h4>
                  <p id="user-email">gaffar932@gmail.com</p>
                </div>
              </div>
      
              <ul class="dropdown-options">
                <li><a href="#" id="customize-profile-btn">Customize Profile</a></li>
              </ul>
      
              <div class="sign-out">
                <button id="sign-out-btn">Sign Out</button>
              </div>
            </div>
            </div>


          </header>
          <div class="modal" id="customize-modal">
            <div class="modal-content">
              <h3>Customize Profile</h3>
              <label for="name-input">Name:</label>
              <input type="text" id="name-input" placeholder="Enter your name">
              <label for="email-input">Email:</label>
              <input type="email" id="email-input" placeholder="Enter your email">
              <div class="modal-actions">
                <button id="save-btn">Save</button>
                <button id="cancel-btn">Cancel</button>
              </div>
            </div>
          </div>

          
        <div class="transport-filters">
            
            <div class="input-row">
                <label for="searchInput">Search Transport:</label>
                <input type="text" id="searchInput" placeholder="Search by Storage Transport ID or Storage ID">
            </div>
        </div>

        <section class="table-section">
          <h2>Storage Transport Imported List</h2>
          <table>
              <thead>
                  <tr>
                      <th>Storage Transport ID</th>
                      <th>Storage ID</th>
                      <th>Storage Type</th>
                      <th>Date</th>
                      <th>Transport Type</th>
                      <th>Temperature Range</th>
                      <th>Load Weight</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['stTransport ID']}</td>
                <td>{$row['Storage ID']}</td>
                <td>{$row['Storage Type']}</td>
                <td>{$row['Date']}</td>
                <td>{$row['Transport Type']}</td>
                <td>{$row['Temperature Range']}</td>
                <td>{$row['Load Weight']}</td>
                <td class='actions'>
                    <button class='view-btn'>Download</button>
                    
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No records found</td></tr>";
    }
    ?>
</tbody>

          </table>
      </section>
    </main>

    <script src="storage_transport.js"></script>

</div>
</div>

<script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const filter = this.value.toLowerCase().trim(); // Convert search input to lowercase and trim spaces
            const rows = document.querySelectorAll('tbody tr'); // Select all table rows inside <tbody>

            rows.forEach(row => {
                // Retrieve cell text, trim spaces, and convert to lowercase
                const stTransportID = row.cells[0]?.textContent?.toLowerCase().trim() || '';
                const storageID = row.cells[1]?.textContent?.toLowerCase().trim() || '';

                // Check if the search query matches any of the columns
                if (stTransportID.includes(filter) || storageID.includes(filter)) {
                    row.style.display = ''; // Show the row if it matches
                } else {
                    row.style.display = 'none'; // Hide the row if it doesn't match
                }
            });
        });
    </script>
</body>
</html>
