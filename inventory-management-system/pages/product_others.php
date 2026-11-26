<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

// Redirect if user type is "User"
$query = 'SELECT ID, t.TYPE FROM users u JOIN type t ON t.TYPE_ID = u.TYPE_ID WHERE ID = ' . $_SESSION['MEMBER_ID'];
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $Aa = $row['TYPE'];

    if ($Aa == 'User') {
        echo '<script type="text/javascript">
                alert("Restricted Page! You will be redirected to POS");
                window.location = "pos.php";
              </script>';
        exit;
    }
}

?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Filtered Assets</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Asset ID</th>
                        <th>Category Name</th>
                        <th>Asset Tag</th>
                        <th>Hostname</th>
                        <th>Serial Number</th>
                        <th>Custodian</th>
                        <th>Cost Center</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
<?php
// Query to filter by CATEGORY_ID = 3
$query = "SELECT a.ASSET_ID, t.CNAME, a.ASSET_TAG, a.HOSTNAME, a.SERIAL_NUMBER, a.MODEL, 
                 a.CUSTODIAN, c.DEPARTMENT, a.DATE_STOCK_IN, s.COMPANY_NAME, e.EMPLOYEE_ID
          FROM asset a
          JOIN category t ON a.CATEGORY_ID = t.CATEGORY_ID
          JOIN cost_center c ON a.COSTCENTER_ID = c.COSTCENTER_ID
          JOIN supplier s ON a.SUPPLIER_ID = s.SUPPLIER_ID
          JOIN employee e ON a.EMPLOYEE_ID = e.EMPLOYEE_ID
          WHERE a.CATEGORY_ID = 9
          GROUP BY a.ASSET_ID";

$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['ASSET_ID'] . '</td>';
    echo '<td>' . $row['CNAME'] . '</td>';
    echo '<td>' . $row['ASSET_TAG'] . '</td>';
    echo '<td>' . $row['HOSTNAME'] . '</td>';
    echo '<td>' . $row['SERIAL_NUMBER'] . '</td>';
    echo '<td>' . $row['CUSTODIAN'] . '</td>';
    echo '<td>' . $row['DEPARTMENT'] . '</td>';
    echo '<td align="right">
            <div class="btn-group">
                <a type="button" class="btn btn-primary bg-gradient-primary" href="pro_searchfrm.php?action=edit&id=' . $row['ASSET_ID'] . '">
                    <i class="fas fa-fw fa-list-alt"></i> Details
                </a>
            </div>
          </td>';
    echo '</tr>';
}
?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
