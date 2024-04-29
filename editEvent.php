<?php 
session_start();
include('DBconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['ssn'])) {
    echo "<script> alert('You need to log in to access calendar');";
	echo "window.location.replace('login.php');</script>";
    exit(); // Redirect user to login page
}

// Retrieve user information from the session
$ssn = $_SESSION['ssn'];

// Check if the required parameters are present in the GET request
if (!isset($_GET['id'], $_GET['eventType'])) {
    echo "Missing required parameters.";
    exit();
} 
else {
    $id = $_GET['id'];
    $eventType = $_GET['eventType'];

    $primaryKeyColumn = '';
    switch ($eventType) {
        case 'Appointment':
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

    // Query to fetch event details based on ID and event type
    $sql = "SELECT * FROM $eventType 
            WHERE $primaryKeyColumn = '$id'";
    $result = mysqli_query($conn, $sql);

    if($row=mysqli_fetch_assoc($result)){
        $title = $row['title'];
        $sDate = $row['sDate'];
        $eDate = $row['eDate'];
        
        if($eventType == "Appointment"){
            $location = $row['location'];
        }
        if($eventType == "MedicationReminder"){
            $medID = $row['medID'];
            $dosage = $row['dosage'];
            $unit = $row['unit'];
        }
      }
      else{
        echo "Event not found!";
      }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>diaCare</title>
    <link href="addEvent.css" rel="stylesheet">
  <!--Include Google Fonts - Quicksand-->
  <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
  <!--Font Awesome Icons-->
  <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>


</body>
</html>
