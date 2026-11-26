<?php
include '../includes/connection.php';

// Retrieve form data
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


$insertAsset = "INSERT INTO asset
    (ASSET_ID, CATEGORY_ID, ASSET_TAG, HOSTNAME, SERIAL_NUMBER, MODEL, CUSTODIAN, COSTCENTER_ID, DATE_STOCK_IN, SUPPLIER_ID, EMPLOYEE_ID) 
    VALUES ('$zz', '$cat', '$tag', '$hname', '$snum', '$model', '$cust', '$dept', '$date', '$sup', '$emp')";

var_dump($insertAsset);

if (mysqli_query($db, $insertAsset)) {
   
    header('Location: product.php');
} else {
  
    echo "Error inserting into product table: " . mysqli_error($db);
} 
?>