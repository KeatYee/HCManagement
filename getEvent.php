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

// Fetch appointments for the logged-in user
$sql = "SELECT ssn, name, sDate, eDate, location FROM appointment WHERE ssn = '$ssn'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(['error' => 'Error fetching events']);
    exit();
}

$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}

header('Content-Type: application/json');
echo json_encode($events);
?>
