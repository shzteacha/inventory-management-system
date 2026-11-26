<?php
include('../includes/connection.php');

// Retrieve and sanitize inputs
$stockid = $_POST['stockid'];
$assetid = $_POST['assetid'];
$quantity = $_POST['quantity'];
$moveid = $_POST['movetype'];
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];
$employee = $_POST['employee'];
$location = $_POST['location'];
$remarks = $_POST['remarks'];

// Calculate the timestamp based on startdate and enddate
$startTimestamp = strtotime($startdate);
$endTimestamp = strtotime($enddate);
$averageTimestamp = ($startTimestamp + $endTimestamp) / 2;
$timestamp = date('Y-m-d H:i:s', $averageTimestamp);

// Prepare the SQL query
$query = "UPDATE stock_movement 
          SET ASSET_ID = ?, QUANTITY = ?, MOVE_ID = ?, START_DATE = ?, 
              END_DATE = ?, EMPLOYEE_ID = ?, LOCATION = ?, REMARKS = ?, TIMESTAMP = ?
          WHERE STOCK_ID = ?";
$stmt = $db->prepare($query);

// Bind parameters
$stmt->bind_param("sssssssssi", $assetid, $quantity, $moveid, $startdate, $enddate, $employee, $location, $remarks, $timestamp, $stockid);

// Execute the query and check for errors
if ($stmt->execute()) {
    echo '<script type="text/javascript">
            alert("You\'ve updated the stock movement successfully.");
            window.location = "inventory.php";
          </script>';
} else {
    die("Error updating record: " . $stmt->error);
}

// Close the statement and connection
$stmt->close();
$db->close();
?>