<?php 

$servername = "localhost";
$username = "root";
$password = ""; // Update if necessary
$dbname = "crud"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding rows
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        // Add new rowa
        $type = $_POST['type'];
        $duration = $_POST['duration'];
        $location = $_POST['location'];

        // Fetch StorageID from tblsignup where User='storage'
        $sql_storageID = "SELECT ID FROM tblsignup WHERE User = 'storage' LIMIT 1";
        $result_storageID = $conn->query($sql_storageID);

        if ($result_storageID->num_rows > 0) {
            $row = $result_storageID->fetch_assoc();
            $storageID = $row['ID'];

            // Insert into tblstorage
            $sql = "INSERT INTO tblstorage (`Storage ID`, `Storage Type`, `Storage Duration`, `Location`) 
                    VALUES ('$storageID', '$type', '$duration', '$location')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Record added successfully']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
                exit;
            }
        }
    }
}


// Handle delete row
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
  $type = $_POST['type'] ?? '';
  $duration = $_POST['duration'] ?? '';
  $location = $_POST['location'] ?? '';

  // Debugging output
  error_log("Delete request received: Type: $type, Duration: $duration, Location: $location");

  if (!empty($type) && !empty($duration) && !empty($location)) {
      $sql = "DELETE FROM tblstorage 
              WHERE `Storage Type` = '$type' 
              AND `Storage Duration` = '$duration' 
              AND `Location` = '$location'";

      if ($conn->query($sql) === TRUE) {
          echo json_encode(['success' => true, 'message' => 'Record deleted successfully']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
      }
  } else {
      echo json_encode(['success' => false, 'message' => 'Invalid data provided']);
  }
  exit;
}



// Fetch data for display
$sql = "SELECT `Storage ID`, `Storage Type`, `Storage Duration`, `Location` FROM tblstorage";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="storage.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script defer src="storage.js"></script>

<body>
  <div class="sidebar">
    <h2><img src="logo.png" alt="Agro Logo" class="logo-img"> Agro Storage</h2>
    <ul>
      <li><a href="#" class="active"><i class="fa fa-home"></i> Home</a></li>
      <li><a href="storage_transport.php"><i class="fas fa-warehouse"></i> Storage Transport</a></li>
      <li><a href="shipment_Creat.php"><i class="fas fa-truck"></i> Create Shipment</a></li>
      <li><a href="setting.html"><i class="fa fa-cog"></i> Settings</a></li>
      <li><a href="starting_page.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>
  <div class="content">
    <header>
      <h1>Home</h1>
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
    



        <section class="dashboard">
            
            <div class="summary-cards">
                <div class="card total-products">
                    <h2 id="t_products">Loading...</h2>
                    <p>Total Products</p>
                </div>
                <div class="card storage-capacity">
                    <h2 id="s_Capacity">Loading...</h2>
                    <p>Storage Capacity</p>
                </div>
                <div class="card temperature">
                    <h2 id="temperature">Loading...</h2>
                    <p>Temperature</p>
                </div>
                <div class="card humidity">
                    <h2 id="humidity">Loading...</h2>
                    <p>Humidity</p>
                </div>
            </div>
        </section>

      <section class="container">
        <div class="table-container">
          <h2>Storage Overview</h2>

          <!-- Form to Add New Entry -->
          <form method="POST" action="">
                    <label for="type">Storage Type:</label>
                    <input type="text" id="type" name="type" required>

                    <label for="duration">Duration:</label>
                    <input type="text" id="duration" name="duration" required>

                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" required>

                    <button type="submit" name="add">Add</button>
                </form>
  
          <!-- Display Data in Table -->
          <table>
          <thead>
  <tr>
    <th>Storage ID</th>
    <th>Storage Type</th>
    <th>Duration</th>
    <th>Storage Location</th>
    <th>Action</th> <!-- New column -->
  </tr>
</thead>
<tbody id="table-body">

  <?php foreach ($data as $row): ?>
  <tr>
    <td><?= htmlspecialchars($row['Storage ID']); ?></td>
    <td><?= htmlspecialchars($row['Storage Type']); ?></td>
    <td><?= htmlspecialchars($row['Storage Duration']); ?></td>
    <td><?= htmlspecialchars($row['Location']); ?></td>
    <td class="actions">
      
      <button class="delete-btn">Delete</button>
    </td>
  </tr>
  <?php endforeach; ?>
</tbody>


                </table>
        </div>
    </section>

    <section class="charts-container">
      <h2>Analytics</h2>
      <div class="charts-wrapper">
<div class="chart" data-scroll="animate">
  <h3>Storage Transport Overview</h3>
  <canvas id="storageTransportChart"></canvas>
</div>

<div class="chart" data-scroll="animate">
  <h3>Create Shipment Overview</h3>
  <canvas id="shipmentTransportChart"></canvas>
</div>

<div class="chart pie-animate" data-scroll="animate">
  <h3>Revenue from Storage</h3>
  <canvas id="revenueChart"></canvas>
</div>

<div class="chart pie-animate" data-scroll="animate">
  <h3>Cost Analysis</h3>
  <canvas id="costChart"></canvas>
</div>
</div>
  </section>
  </div>
</body>
</html>

<?php
$conn->close();
?>
