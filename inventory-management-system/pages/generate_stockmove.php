<?php
include '../includes/connection.php';

// Define headers for Excel file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=stocks_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Query to retrieve data
$query = "SELECT m.STOCK_ID, a.ASSET_ID, m.QUANTITY, o.MOVE_ID, m.START_DATE, m.END_DATE, e.EMPLOYEE_ID, m.LOCATION, 
                 m.REMARKS, m.TIMESTAMP
          FROM stock_movement m
          JOIN asset a ON m.ASSET_ID = a.ASSET_ID
          JOIN employee e ON m.EMPLOYEE_ID = e.EMPLOYEE_ID
          JOIN move_type o ON m.MOVE_ID = o.MOVE_ID
          ORDER BY m.STOCK_ID ASC";     
$result = mysqli_query($db, $query) or die(mysqli_error($db));


// Print table header
echo "<table border='1'>";
echo "<tr>
        <th>Stock ID</th>
        <th>Asset ID</th>
        <th>Quantity</th>
        <th>Move</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Employee ID</th>
        <th>Location</th>
        <th>Remarks</th>
        <th>Timestamp</th>
      </tr>";

// Print table rows with data
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['STOCK_ID'] . "</td>";
    echo "<td>" . $row['ASSET_ID'] . "</td>";
    echo "<td>" . $row['QUANTITY'] . "</td>";
    echo "<td>" . $row['MOVE_ID'] . "</td>";
    echo "<td>" . $row['START_DATE'] . "</td>";
    echo "<td>" . $row['END_DATE'] . "</td>";
    echo "<td>" . $row['EMPLOYEE_ID'] . "</td>";
    echo "<td>" . $row['LOCATION'] . "</td>";
    echo "<td>" . $row['REMARKS'] . "</td>";
    echo "<td>" . $row['TIMESTAMP'] . "</td>";
    echo "</tr>";
}

// Close the table
echo "</table>";
?>
