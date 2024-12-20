<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "crud");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $temperatureRange = $_POST['temperatureRange'];
    $quantity = $_POST['quantity'];
    $shipmentID = $_POST['shipmentID']; // Hidden field for edit functionality

    if (!empty($shipmentID)) {
        // Update existing shipment
        $updateQuery = "UPDATE tblshipment 
                        SET `Shipment Quantity` = '$quantity', `Operating Temperature` = '$temperatureRange' 
                        WHERE `Shipment ID` = '$shipmentID'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "<script>alert('Shipment updated successfully!');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // Create new shipment
        $shipmentIDQuery = "SELECT MAX(`Shipment ID`) AS max_id FROM tblshipment";
        $shTransportIDQuery = "SELECT MAX(`shTransport ID`) AS max_id FROM tblshipment";
        $retailerIDQuery = "SELECT MAX(`Retailer ID`) AS max_id FROM tblshipment";
        
        $shipmentIDResult = $conn->query($shipmentIDQuery);
        $shTransportIDResult = $conn->query($shTransportIDQuery);
        $retailerIDResult = $conn->query($retailerIDQuery);
        
        $shipmentIDRow = $shipmentIDResult ? $shipmentIDResult->fetch_assoc() : null;
        $shTransportIDRow = $shTransportIDResult ? $shTransportIDResult->fetch_assoc() : null;
        $retailerIDRow = $retailerIDResult ? $retailerIDResult->fetch_assoc() : null;
        
        $shipmentID = isset($shipmentIDRow['max_id']) ? $shipmentIDRow['max_id'] + 1 : 2410001;
        $shTransportID = isset($shTransportIDRow['max_id']) ? $shTransportIDRow['max_id'] + 1 : 2420001;
        $retailerID = isset($retailerIDRow['max_id']) ? $retailerIDRow['max_id'] + 1 : 2430001;

        $shipmentDate = date("Y-m-d");

        $insertQuery = "INSERT INTO tblshipment (`Shipment ID`, `shTransport ID`, `Retailer ID`, `Shipment Date`, `Shipment Quantity`, `Operating Temperature`) 
                        VALUES ('$shipmentID', '$shTransportID', '$retailerID', '$shipmentDate', '$quantity', '$temperatureRange')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>alert('Shipment created successfully!');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $deleteID = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM tblshipment WHERE `Shipment ID` = '$deleteID'";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('Shipment deleted successfully!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch and display shipments
$fetchQuery = "SELECT `Shipment ID`, `shTransport ID`, `Retailer ID`, `Shipment Date`, `Shipment Quantity`, `Operating Temperature` FROM tblshipment";
$result = $conn->query($fetchQuery);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Dashboard</title>
    <link rel="stylesheet" href="shipment_Creat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
   

</head>
<body>
    <body>
        <div class="sidebar">
            <h2><img src="logo.png" alt="Agro Logo" class="logo-img"> Agro Storage</h2>
            <ul>
              <li><a href="storage.php" class="active"><i class="fa fa-home"></i> Home</a></li>
              <li><a href="storage_transport.php"><i class="fas fa-warehouse"></i> Storage Transport</a></li>
              <li><a href="#"><i class="fas fa-truck"></i> Create Shipment</a></li>
              <li><a href="setting.html"><i class="fa fa-cog"></i> Settings</a></li>
              <li><a href="login.html"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
          </div>
        
          <div class="content">
        <div class="dashboard">
            <header>
                <h1>Create Shipment Dashboard</h1>
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
            <h3>Create New Shipment</h3>
            <form method="POST">
            <input type="hidden" id="shipmentID" name="shipmentID"> <!-- Hidden field for edit -->
            <div class="form-group">
                <div class="input-row">
                    <label for="temperatureRange">Operating Temperature:</label>
                    <input type="text" id="temperatureRange" name="temperatureRange" required>
                </div>
                <div class="input-row">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" required>
                </div>
            </div>

            
            <button type="submit">Create Shipment</button>
            <div class="input-row">
            <label for="searchInput">Search Shipment:</label>
            <input type="text" id="searchInput" placeholder="Search by shipment ID or shTransport ID or Retailer ID">
            </div>
            </form>
        </div>

        <section class="table-section">
        <h2>Shipment List</h2>
        <table>
            <thead>
            <tr>
                <th>Shipment ID</th>
                <th>shTransport ID</th>
                <th>Retailer ID</th>
                <th>Shipment Date</th>
                <th>Shipment Quantity</th>
                <th>Operating Temperature</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Shipment ID'] ?></td>
                    <td><?= $row['shTransport ID'] ?></td>
                    <td><?= $row['Retailer ID'] ?></td>
                    <td><?= $row['Shipment Date'] ?></td>
                    <td><?= $row['Shipment Quantity'] ?></td>
                    <td><?= $row['Operating Temperature'] ?></td>
                    <td class="actions">
    <button class="btn edit-btn" onclick="editShipment('<?= $row['Shipment ID'] ?>', '<?= $row['Shipment Quantity'] ?>', '<?= $row['Operating Temperature'] ?>')">Edit</button>
    <button class="btn delete-btn" onclick="deleteShipment('<?= $row['Shipment ID'] ?>')">Delete</button>
    <button class="btn view-btn" onclick="generatePDF('<?= $row['Shipment ID'] ?>', '<?= $row['shTransport ID'] ?>', '<?= $row['Retailer ID'] ?>', '<?= $row['Shipment Date'] ?>', '<?= $row['Shipment Quantity'] ?>', '<?= $row['Operating Temperature'] ?>')">View</button>
</td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </section>


    
    </main>

    <script src="shipment_Creat.js"></script>
  </div>
</div>

<script>
    function editShipment(shipmentID, quantity, temperature) {
    document.getElementById("shipmentID").value = shipmentID;
    document.getElementById("quantity").value = quantity;
    document.getElementById("temperatureRange").value = temperature;
}

function deleteShipment(id) {
    if (confirm("Are you sure you want to delete this shipment?")) {
        window.location.href = `?delete_id=${id}`;
    }
}


    function clearForm() {
        document.getElementById("temperatureRange").value = "";
        document.getElementById("quantity").value = "";
      }
        
        document.getElementById('searchInput').addEventListener('input', function () {
    const filter = this.value.toLowerCase().trim(); // Convert search input to lowercase and trim spaces
    const rows = document.querySelectorAll('tbody tr'); // Select all table rows inside <tbody>

    rows.forEach(row => {
        // Retrieve cell text, trim spaces, and convert to lowercase
        const shipmentID = row.cells[0]?.textContent?.toLowerCase().trim() || '';
        const shTransportID = row.cells[1]?.textContent?.toLowerCase().trim() || '';
        const retailerID = row.cells[2]?.textContent?.toLowerCase().trim() || '';

        // Check if the search query matches any of the columns
        if (shipmentID.includes(filter) || shTransportID.includes(filter) || retailerID.includes(filter)) {
            row.style.display = ''; // Show the row if it matches
        } else {
            row.style.display = 'none'; // Hide the row if it doesn't match
        }
    });
});



    
</script>
</body>
</html>
