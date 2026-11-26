<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get asset tag from query
$asset_tag = $_GET['asset_tag'] ?? '';

if ($asset_tag) {
    $stmt = $conn->prepare("SELECT * FROM asset WHERE ASSET_TAG = ?");
    $stmt->bind_param("s", $asset_tag);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $asset = $result->fetch_assoc();
        echo json_encode(['success' => true, 'asset' => $asset]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Asset not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid asset tag']);
}

$conn->close();
?>
