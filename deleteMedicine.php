<?php
session_start();// Start session
include 'DBconnect.php'; // Include database connection

   // Retrieve user information from the session
   $ssn = $_SESSION['ssn'];
   $email = $_SESSION['email'];
   $password = $_SESSION['password']; 

   // Check if the medicine ID is set and not empty
if(isset($_POST['id']) && !empty($_POST['id'])) {
    $medID = $_POST['id'];
    $query = "DELETE FROM Medicine 
              WHERE medID = '$medID'";
    $result = mysqli_query($conn, $query);

    // Handle the result of the update operation
    if($result) {
        echo "<script>";
        echo "alert('Medicine deleted successfully.');";
        echo "window.location.href = 'profile.php';"; 
        echo "</script>";
    } else {
        echo "Error deleting medicine: " . mysqli_error($conn);
    }
}
?>