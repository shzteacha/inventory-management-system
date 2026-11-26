<?php
include '../includes/connection.php';

// Retrieve form data

$emp = $_POST['empid'];
$name = $_POST['username'];
$pass = $_POST['password'];
$cost = $_POST['costid'];
// $opt = $_POST['type'];


$insertUsers = "INSERT INTO users
    (EMPLOYEE_ID, USERNAME, PASSWORD, COSTCENTER_ID, TYPE_ID)
    VALUES ('$emp', '$name', '$pass', '$cost', '1')";

var_dump($insertUsers);

if (mysqli_query($db, $insertUsers)) {
   
    header('Location: user.php');
} else {
  
    echo "Error inserting into user table: " . mysqli_error($db);
} 
?>