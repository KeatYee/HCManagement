<?php
session_start();// Start session 
include('DBconnect.php'); // Include database connection

// Retrieve admin information from the session
$superuser = $_SESSION['superuser'];
$role =  $_SESSION['role'];
$Superssn = $_SESSION['Superssn'];

if (!empty($_GET['ssn'])) {
    $ssn = $_GET['ssn'];

    // Check if user confirmed deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        // Delete the account
        $deleteAccountQuery = "DELETE FROM Users WHERE ssn='$ssn'";
        $result = mysqli_query($conn, $deleteAccountQuery);

        // Handle the result of the deletion operation
        if ($result) {
            echo "<script>";
            echo "alert('Admin deleted successfully!');";
            echo "window.location.href = 'superuser.php';"; 
            echo "</script>";
        } else {
            echo "<script>alert('Error deleting admin: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        // Display confirmation dialog
        echo "<script>";
        echo "var confirmDelete = confirm('Are you sure you want to delete this admin?');";
        echo "if (confirmDelete) {";
        echo "  window.location.href = 'deleteAdmin.php?ssn=$ssn&confirm=true';"; // Add confirm=true parameter
        echo "} else {";
        echo "  window.location.href = 'superuser.php';"; // Redirect to admin.php if canceled
        echo "}";
        echo "</script>";
    }
}

?>