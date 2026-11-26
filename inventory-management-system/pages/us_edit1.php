<?php
// include('../includes/connection.php');

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Fetch and sanitize inputs
//     $id = intval($_POST['id']);
//     $empid = mysqli_real_escape_string($db, $_POST['empid']);
//     $username = mysqli_real_escape_string($db, $_POST['username']);

//     if(isset($_POST['password']) && !empty($_POST['password'])){
//         $password = mysqli_real_escape_string($db, $_POST['password']);
//         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
//     }
    

//     // Hash the new password
    

//     // Update user
//     $query = "UPDATE users 
//               SET EMPLOYEE_ID = ?, USERNAME = ?, PASSWORD = ? 
//               WHERE ID = ?";
//     $stmt = $db->prepare($query);
//     $stmt->bind_param("sssi", $empid, $username, $hashed_password, $id);

//     if ($stmt->execute()) {
//         echo '<script type="text/javascript">
//                 alert("You\'ve updated your account successfully.");
//                 window.location = "user.php";
//               </script>';
//     } else {
//         die("Error updating record: " . $stmt->error);
//     }

//     $stmt->close();
// }
?>


<?php
include('../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch and sanitize inputs
    $id = intval($_POST['id']);
    $empid = mysqli_real_escape_string($db, $_POST['empid']);
    $username = mysqli_real_escape_string($db, $_POST['username']);

    // Check if password is provided
    $password = isset($_POST['password']) && !empty($_POST['password']) 
                ? mysqli_real_escape_string($db, $_POST['password']) 
                : null;

    // Prepare the base update query
    $query = "UPDATE users SET EMPLOYEE_ID = ?, USERNAME = ?";
    $params = [$empid, $username];

    // If a new password is provided, include it in the query
    if ($password) {
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query .= ", PASSWORD = ?";
        $params[] = $password;
    }

    // Add the WHERE clause
    $query .= " WHERE ID = ?";
    $params[] = $id;

    // Prepare and bind the query
    $stmt = $db->prepare($query);

    // Dynamically bind parameters based on the query
    $types = str_repeat("s", count($params) - 1) . "i"; // "s" for strings, "i" for the ID
    $stmt->bind_param($types, ...$params);

    // Execute the query
    if ($stmt->execute()) {
        echo '<script type="text/javascript">
                alert("You\'ve updated your account successfully.");
                window.location = "user.php";
              </script>';
    } else {
        die("Error updating record: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();
}
?>
