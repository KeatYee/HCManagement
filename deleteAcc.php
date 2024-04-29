<?php
session_start();
include 'DBconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['ssn'])) {
    echo "<script> alert('You need to log in to access this page.');";
	  echo "window.location.replace('login.php');</script>";
    exit(); //redirect user to login page
}

   // Retrieve user information from the session
	$ssn = $_SESSION['ssn'];
	$email = $_SESSION['email'];
	$password = $_SESSION['password'];
        
        // Delete the account
        $deleteAccountQuery = "DELETE FROM Users WHERE ssn='$ssn'";
        $result = mysqli_query($conn, $deleteAccountQuery);
        
        // Destroy the session and redirect to the login page
        if($result){
            session_destroy();
            header("Location: homepage.php");
            exit();
        }
        else{
            echo "Error delete user: " . mysqli_error($conn);
        }
        

?>