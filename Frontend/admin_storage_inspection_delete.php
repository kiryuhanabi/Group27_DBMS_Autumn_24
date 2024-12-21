<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "crud";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tblstorageinspection WHERE `Storage ID` = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_storage_inspection.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
