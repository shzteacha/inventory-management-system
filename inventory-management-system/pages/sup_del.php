<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

$query = 'SELECT ID, t.TYPE
          FROM users u
          JOIN type t ON t.TYPE_ID = u.TYPE_ID 
          WHERE ID = ' . $_SESSION['MEMBER_ID'];
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $Aa = $row['TYPE'];

    if ($Aa == 'User') {
        echo '<script type="text/javascript">
                alert("Restricted Page! You will be redirected to POS");
                window.location = "pos.php";
              </script>';
        exit();
    }
}

if (!isset($_GET['do']) || $_GET['do'] != 1) {
    switch ($_GET['type']) {
        case 'supplier':
            // Convert the ID to an integer for safety
            $supplier_id = intval($_GET['id']);

            // Directly delete the supplier
            $deleteSupplierQuery = "DELETE FROM supplier WHERE SUPPLIER_ID = $supplier_id";
            mysqli_query($db, $deleteSupplierQuery) or die(mysqli_error($db));

            echo '<script type="text/javascript">
                    alert("Supplier Successfully Deleted.");
                    window.location = "supplier.php";
                  </script>';
            break;
    }
}
?>
