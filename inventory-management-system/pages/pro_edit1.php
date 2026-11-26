<?php
include('../includes/connection.php');

// Fetch and sanitize POST data
$zz = $_POST['assetid'];
$hname = $_POST['hostname'];
$tag = $_POST['assetag'];
$snum = $_POST['serialnum'];
$model = $_POST['model'];
$cust = $_POST['custodian'];
$dept = $_POST['costcenter'];
$sup = $_POST['supplier'];
$cat = $_POST['category'];
$emp = $_POST['employee'];
$date = $_POST['datestock'];

// Prepare and execute the UPDATE query
$query = "UPDATE asset 
          SET HOSTNAME = ?, ASSET_TAG = ?, SERIAL_NUMBER = ?, 
              MODEL = ?, CUSTODIAN = ?, COSTCENTER_ID = ?, 
              SUPPLIER_ID = ?, CATEGORY_ID = ?, EMPLOYEE_ID = ?, 
              DATE_STOCK_IN = ? 
          WHERE ASSET_ID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('sssssssssss', $hname, $tag, $snum, $model, $cust, $dept, $sup, $cat, $emp, $date, $zz);

if ($stmt->execute()) {
    echo '<script>alert("Asset updated successfully."); window.location = "product.php";</script>';
} else {
    die("Error updating asset: " . $stmt->error);
}

$stmt->close();
?>
