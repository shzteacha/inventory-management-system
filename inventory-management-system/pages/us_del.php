<?php
include '../includes/connection.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Validate required parameters
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid or missing ID.");
}

// Optional: Check for 'do' parameter (remove if unnecessary)
if (!isset($_GET['do']) || $_GET['do'] != 1) {
    die("Unauthorized action.");
}

// Switch case for handling different types
switch ($_GET['type']) {
    case 'user':
        $id = intval($_GET['id']);
        // print_r($id);
        // print_r($_SESSION['MEMBER_ID']);
        // die();
        if($id == intval($_SESSION['MEMBER_ID'])){
            echo'<script type="text/javascript">
                alert("Logged in user unable to delete.");
                window.location = "user.php";
            </script>';
        }else{
            $query = 'DELETE FROM users WHERE ID = ' . $id;
            $result = mysqli_query($db, $query) or die(mysqli_error($db));
                echo '<script type="text/javascript">
                alert("User Successfully Deleted.");
                window.location = "user.php";
            </script>';
        }

        break;

    default:
        die("Invalid type specified.");
}
?>
