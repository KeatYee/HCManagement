<?php
session_start();
include('DBconnect.php');


// Check if the user is logged in
if (!isset($_SESSION['ssn'])) {
    echo "<script> alert('You need to log in to access calendar');";
	echo "window.location.replace('login.php');</script>";
    exit(); //redirect user to login page
}

// Retrieve user information from the session
$ssn = $_SESSION['ssn'];

if(isset($_POST['id']))
{
	$title = $_POST['title'];
	$start_date = $_POST['start'];
	$end_date = $_POST['end'];
	$id = $_POST['id'];

    $sql="update tbl_event set title='$title', 
    start_date='$start_date', end_date='$end_date' where id='$id'";

	$update_query = mysqli_query($conn,$sql );
}
?>
