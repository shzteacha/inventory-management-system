<?php
include'../includes/connection.php';

			$emp_id = $_POST['employee_id'];
			$fname = $_POST['firstname'];
			$lname = $_POST['lastname'];
			$gen = $_POST['gender'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$costcenter_id = $_POST['costcenter_id'];
			$hdate = $_POST['hireddate'];
		
	 			$old_emp_id = $_POST['old_employee_id'];
$query = "UPDATE employee 
          SET EMPLOYEE_ID = '$emp_id',
              FIRST_NAME = '$fname',
              LAST_NAME = '$lname',
              GENDER = '$gen',
              EMAIL = '$email',
              PHONE_NUMBER = '$phone',
              COSTCENTER_ID = '$costcenter_id',
              HIRED_DATE = '$hdate'
          WHERE EMPLOYEE_ID = '$old_emp_id'";

					$result = mysqli_query($db, $query) or die(mysqli_error($db));

							
?>
<script type="text/javascript">
    alert("You've Update Employee Successfully.");
    window.location = "employee.php";
</script>