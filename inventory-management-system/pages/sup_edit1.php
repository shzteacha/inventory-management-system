<?php
include('../includes/connection.php');
			$zz = $_POST['id'];
            $address = $_POST['address'];
			$name = $_POST['name'];
            $phone = $_POST['phone'];
		
	 			$query = 'UPDATE supplier
          SET COMPANY_NAME = "' . $name . '", 
              ADDRESS = "' . $address . '", 
              PHONE_NUMBER = "' . $phone . '" 
          WHERE SUPPLIER_ID = "' . $zz . '"';
					$result = mysqli_query($db, $query) or die(mysqli_error($db));

							
?>
<script type="text/javascript">
    alert("You've Update Supplier Successfully.");
    window.location = "supplier.php";
</script>