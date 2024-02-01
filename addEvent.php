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

//Validate submit create event form
if(isset($_POST['submit'])) {
    if (!empty($_POST['eventTitle']) && !empty($_POST['eventStartDate']) && !empty($_POST['eventEndDate'])) {
        // Perform database insertion for appointment
        $title = $_POST['eventTitle'];
        $startDate = date("Y-m-d\TH:i:s", strtotime($_POST['eventStartDate']));
        $endDate = date("Y-m-d\TH:i:s", strtotime($_POST['eventEndDate']));

        $sql = "INSERT INTO Appointment(ssn, name, sDate, eDate, location, remType)
                VALUES('$ssn', '$title', '$startDate', '$endDate', 'Ampang', 'email')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die('Error: ' . mysqli_error($conn));
        }
        else{
            // Set a session variable to indicate event added successful
				$_SESSION['addSuccess'] = true;

            header("Location:calendar.php");
            exit();
        }

        

    } else {
        // Handle validation error for appointment
        if (empty($_POST['eventTitle'])) {
            $titleError = "Please enter a title.";
        }
        if (empty($_POST['eventStartDate'])) {
            $startError = "Please select a start date.";
        }
        if (empty($_POST['eventEndDate'])) {
            $endError = "Please select an end date.";
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>diaCare</title>
</head>
<body>
<form id="eventForm" method="POST" action="addEvent.php">
            <label for="eventTitle">Event Title:</label>
            <input type="text" id="eventTitle" name="eventTitle" required>

            <label for="eventStartDate">Start Date and Time:</label>
            <input type="datetime-local" id="eventStartDate" name="eventStartDate" required>

            <label for="eventEndDate">End Date and Time:</label>
            <input type="datetime-local" id="eventEndDate" name="eventEndDate" required>

            <button type="submit" name="submit">Add Event</button>
        </form>
    </div>
</body>
</html>