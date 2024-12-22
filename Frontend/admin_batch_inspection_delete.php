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
    $sql = "DELETE FROM tblbatchinspection WHERE `Batch Barcode` = $id";
    $sql_cer = "DELETE FROM tblbatchcertification WHERE `Batch Barcode` = $id";
    if ($conn->query($sql) === TRUE && $conn->query($sql_cer) === True) {
        header("Location: admin_batch_inspection.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
