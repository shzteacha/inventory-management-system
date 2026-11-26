<?php 
include '../includes/connection.php';
// Check if the import button is clicked
if (isset($_POST['import_asset'])) {
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
        $filename = $_FILES['file']['tmp_name'];
        
        // Open the CSV file
        $file = fopen($filename, 'r');

        // Skip the first row (column names)
        fgetcsv($file, 10000, ",");

        // Loop through the remaining rows
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Convert the date format from DD/MM/YYYY to YYYY-MM-DD
            $dateStockIn = date('Y-m-d', strtotime(str_replace('/', '-', $column[7])));

            // Construct the INSERT query
            $sqlInsert = "INSERT INTO asset (CATEGORY_ID, ASSET_TAG, HOSTNAME, SERIAL_NUMBER, MODEL, CUSTODIAN, COSTCENTER_ID, DATE_STOCK_IN, SUPPLIER_ID, EMPLOYEE_ID) 
                          VALUES (
                            '".mysqli_real_escape_string($db, $column[0])."', 
                            '".mysqli_real_escape_string($db, $column[1])."', 
                            '".mysqli_real_escape_string($db, $column[2])."', 
                            '".mysqli_real_escape_string($db, $column[3])."', 
                            '".mysqli_real_escape_string($db, $column[4])."', 
                            '".mysqli_real_escape_string($db, $column[5])."', 
                            '".mysqli_real_escape_string($db, $column[6])."', 
                            '".mysqli_real_escape_string($db, $dateStockIn)."', 
                            '".mysqli_real_escape_string($db, $column[8])."', 
                            '".mysqli_real_escape_string($db, $column[9])."'
                          )";

            // Execute the query
            $result = mysqli_query($db, $sqlInsert);

            // Check for errors
            if (!$result) {
                echo "Error: " . mysqli_error($db);
            }
        }
        // Close the file
        fclose($file);
        echo "<script>
                alert('File successfully imported.');
                window.location.href='product.php';
              </script>";
        exit; // Stop execution after redirection
    } else {
        echo "<script>
                alert('Please upload a valid CSV file.');
                window.location.href='product.php';
              </script>";
        exit;
    }
}

?>
