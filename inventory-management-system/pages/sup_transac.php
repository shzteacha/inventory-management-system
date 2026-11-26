<?php
include'../includes/connection.php';
?>

 <!-- Page Content -->
 <div class="col-lg-12">
     <?php
    include('../includes/connection.php');

    $name = $_POST['companyname'];
    $address = $_POST['address']; // Use address directly
    $phone = $_POST['phonenumber'];

    switch ($_GET['action']) {
        case 'add':     
            // Insert directly into the supplier table with the address
            $query = "INSERT INTO supplier
                      (SUPPLIER_ID, COMPANY_NAME, ADDRESS, PHONE_NUMBER)
                      VALUES (Null, '{$name}', '{$address}', '{$phone}')";
            mysqli_query($db, $query) or die('Error in inserting supplier in Database');
            break;
    }
    ?>
     <script type="text/javascript">
         window.location = "supplier.php";
     </script>
 </div>


<?php
include'../includes/footer.php';
?>