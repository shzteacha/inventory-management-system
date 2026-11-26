<?php
include '../includes/connection.php';

// Define headers for Excel file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=assets_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Query to retrieve data
$query = "SELECT a.ASSET_ID, t.CNAME AS CATEGORY_NAME, a.ASSET_TAG, a.HOSTNAME, a.SERIAL_NUMBER, 
                 a.MODEL, a.CUSTODIAN, c.DEPARTMENT AS COST_CENTER, a.DATE_STOCK_IN, s.COMPANY_NAME AS SUPPLIER, 
                 CONCAT(e.FIRST_NAME, ' ', e.LAST_NAME) AS EMPLOYEE_NAME
          FROM asset a
          JOIN category t ON a.CATEGORY_ID = t.CATEGORY_ID
          JOIN cost_center c ON a.COSTCENTER_ID = c.COSTCENTER_ID
          JOIN supplier s ON a.SUPPLIER_ID = s.SUPPLIER_ID
          JOIN employee e ON a.EMPLOYEE_ID = e.EMPLOYEE_ID
          ORDER BY a.ASSET_ID ASC";
$result = mysqli_query($db, $query) or die(mysqli_error($db));

// Print table header
echo "<table border='1'>";
echo "<tr>
        <th>Asset ID</th>
        <th>Category Name</th>
        <th>Asset Tag</th>
        <th>Hostname</th>
        <th>Serial Number</th>
        <th>Model</th>
        <th>Custodian</th>
        <th>Cost Center</th>
        <th>Date Stock In</th>
        <th>Supplier</th>
        <th>Employee Name</th>
      </tr>";

// Print table rows with data
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['ASSET_ID'] . "</td>";
    echo "<td>" . $row['CATEGORY_NAME'] . "</td>";
    echo "<td>" . $row['ASSET_TAG'] . "</td>";
    echo "<td>" . $row['HOSTNAME'] . "</td>";
    echo "<td>" . $row['SERIAL_NUMBER'] . "</td>";
    echo "<td>" . $row['MODEL'] . "</td>";
    echo "<td>" . $row['CUSTODIAN'] . "</td>";
    echo "<td>" . $row['COST_CENTER'] . "</td>";
    echo "<td>" . $row['DATE_STOCK_IN'] . "</td>";
    echo "<td>" . $row['SUPPLIER'] . "</td>";
    echo "<td>" . $row['EMPLOYEE_NAME'] . "</td>";
    echo "</tr>";
}

// Close the table
echo "</table>";
?>
