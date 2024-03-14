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

// Check if the required parameters are present in the POST request
if (!isset($_POST['title'], $_POST['start'], $_POST['end'], $_POST['id'], $_POST['eventType'])) {
    echo "Missing required parameters.";
    exit();
}
else{
	$title = $_POST['title'];
	$start_date = $_POST['start'];
	$end_date = $_POST['end'];
	$id = $_POST['id'];
	$eventType = $_POST['eventType'];

	$primaryKeyColumn = '';
    switch ($eventType) {
        case 'appointment':
            $primaryKeyColumn = 'apptID';
            break;
        case 'medicationReminder':
            $primaryKeyColumn = 'medRemID';
            break;
        case 'bsTestingAlert':
            $primaryKeyColumn = 'testingID';
            break;
        default:
            echo "Unknown event type";
            exit();
    }

    $sql="UPDATE $eventType 
		  SET title = '$title',sDate = '$start_date', eDate = '$end_date' 
		  WHERE $primaryKeyColumn = '$id' AND ssn = '$ssn'";

	$update_query = mysqli_query($conn,$sql );

}

mysqli_close($conn);
?>
