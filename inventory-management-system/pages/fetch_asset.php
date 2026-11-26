<?php
include '../includes/connection.php';

// Check if asset tag is provided
if (isset($_POST['asset_tag'])) {
    $assetTag = mysqli_real_escape_string($db, $_POST['asset_tag']);
    
    // Query to fetch asset details based on the asset tag
    $query = "SELECT * FROM asset WHERE ASSET_TAG = '$assetTag'";
    $result = mysqli_query($db, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $asset = mysqli_fetch_assoc($result);
        
        // Return asset details as JSON
        echo json_encode([
            'success' => true,
            'asset' => $asset
        ]);
    } else {
        // No asset found
        echo json_encode([
            'success' => false
        ]);
    }
} else {
    echo json_encode([
        'success' => false
    ]);
}
?>
