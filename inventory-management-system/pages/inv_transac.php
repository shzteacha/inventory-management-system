<?php
include '../includes/connection.php';

// Retrieve form data
$zz = $_POST['stockid'];
$ast = $_POST['assetid'];
$qty = $_POST['quantity'];
$mov = $_POST['movetype'];
$stda = $_POST['startdate'];
$endd = $_POST['enddate'];
$emp = $_POST['employee'];
$loc = $_POST['location'];
$remk = $_POST['remarks'];

// Calculate the timestamp based on START_DATE and END_DATE
$startTimestamp = strtotime($stda);
$endTimestamp = strtotime($endd);
$averageTimestamp = ($startTimestamp + $endTimestamp) / 2;
$time = date('Y-m-d H:i:s', $averageTimestamp);

// Insert data into stock_movement table using retrieved IDs
$insertStockMovement = "INSERT INTO stock_movement
    (STOCK_ID, ASSET_ID, QUANTITY, MOVE_ID, START_DATE, END_DATE, EMPLOYEE_ID, LOCATION, REMARKS, TIMESTAMP) 
    VALUES ('$zz', '$ast', '$qty', '$mov', '$stda', '$endd', '$emp', '$loc', '$remk', '$time')";

if (mysqli_query($db, $insertStockMovement)) {
    // Redirect if insertion is successful
    header('Location: inventory.php');
} else {
    // Error handling for stock_movement insertion
    echo "Error inserting into stock movement table: " . mysqli_error($db);
}
?>