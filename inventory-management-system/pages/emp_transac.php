<?php
include '../includes/connection.php';

$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['email'];
$phone = $_POST['phonenumber'];
$costcenter_id = $_POST['costcenter_id']; // Updated to match the select field
$emp_id = $_POST['employee_id']; // Updated to match the field name in emp_add.php
$hdate = $_POST['hireddate'];

// Check if costcenter_id and employee_id are set
if (!isset($costcenter_id) || !isset($emp_id)) {
    echo "Error: Cost Center or Employee ID is missing in the form submission.";
    exit;
}

// Insert employee record using the provided costcenter_id
$insertEmployee = "INSERT INTO employee
                   (EMPLOYEE_ID, FIRST_NAME, LAST_NAME, EMAIL, PHONE_NUMBER, COSTCENTER_ID, HIRED_DATE)
                   VALUES ('$emp_id', '$fname', '$lname', '$email', '$phone', '$costcenter_id', '$hdate')";

if (mysqli_query($db, $insertEmployee)) {
    // Redirect if insertion is successful
    header('Location: employee.php');
} else {
    echo "Error inserting into employee table: " . mysqli_error($db);
}
?>


 