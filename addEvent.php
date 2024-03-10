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

// Retrieve selected date range from URL parameters
if (isset($_GET['start']) && isset($_GET['end'])) {
    $start = $_GET['start'];
    $end = $_GET['end'];

}

//Appointment-------------------
if(isset($_POST['submitAppt'])) {

    if (!empty($_POST['eventTitle']) && !empty($_POST['eventStartDate']) 
    && !empty($_POST['eventEndDate']) && !empty($_POST['location']) && !empty($_POST['reminderType'])) {

        // Perform database insertion for appointment
        $title = $_POST['eventTitle'];
        $startDate = date("Y-m-d\TH:i:s", strtotime($_POST['eventStartDate']));
        $endDate = date("Y-m-d\TH:i:s", strtotime($_POST['eventEndDate']));
        $location = $_POST['location'];
        $remType = $_POST['reminderType'];

        $sql = "INSERT INTO Appointment(ssn, title, sDate, eDate, location, remType)
                VALUES('$ssn', '$title', '$startDate', '$endDate', '$location', '$remType')";
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

    }
    else {
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
        if (empty($_POST['location'])) {
            $locError = "Please enter location.";
        }
        if (empty($_POST['reminderType'])) {
            $remError = "Please choose a reminder type.";
        }

    }
}


//Medication Reminder-------------------
if(isset($_POST['submitMed'])) {

    if (!empty($_POST['eventTitle']) && !empty($_POST['eventStartDate']) && !empty($_POST['eventEndDate'])
     && !empty($_POST['medicine']) && !empty($_POST['dosage']) && !empty($_POST['reminderType'])) {

        // Perform database insertion for appointment
        $title = $_POST['eventTitle'];
        $startDate = date("Y-m-d\TH:i:s", strtotime($_POST['eventStartDate']));
        $endDate = date("Y-m-d\TH:i:s", strtotime($_POST['eventEndDate']));
        $medicine = $_POST['medicine'];
        $dosage = $_POST['dosage'];
        $remType = $_POST['reminderType'];

        $sql = "INSERT INTO MedicationReminder(medID, ssn, title, dosage, sDate, eDate, remType)
                VALUES('$medicine', '$ssn', '$title', '$dosage', '$startDate', '$endDate', '$remType')";
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

    }
    else {
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
        if (empty($_POST['medicine'])) {
            $locError = "Please choose your medicine.";
        }
        if (empty($_POST['dosage'])) {
            $locError = "Please enter medicine dosage.";
        }
        if (empty($_POST['reminderType'])) {
            $remError = "Please choose a reminder type.";
        }

    }
}

//Blood Sugar Testing Alert-------------------
if(isset($_POST['submitBS'])) {

    if (!empty($_POST['eventTitle']) && !empty($_POST['eventStartDate']) && !empty($_POST['eventEndDate'])
     && !empty($_POST['reminderType'])) {

        // Perform database insertion for appointment
        $title = $_POST['eventTitle'];
        $startDate = date("Y-m-d\TH:i:s", strtotime($_POST['eventStartDate']));
        $endDate = date("Y-m-d\TH:i:s", strtotime($_POST['eventEndDate']));
        $remType = $_POST['reminderType'];

        $sql = "INSERT INTO BSTestingAlert(ssn, title, sDate, eDate, alertType)
                VALUES('$ssn', '$title', '$startDate', '$endDate', '$remType')";
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

    }
    else {
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
        if (empty($_POST['reminderType'])) {
            $remError = "Please choose a reminder type.";
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
    <link href="addEvent.css" rel="stylesheet">
  <!--Include Google Fonts - Quicksand-->
  <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
  <!--Font Awesome Icons-->
  <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<div class="tabs-container">
<div class="tabs">
    <div class="tab" onclick="showForm(0)">Tab 1</div>
    <div class="tab" onclick="showForm(1)">Tab 2</div>
    <div class="tab" onclick="showForm(2)">Tab 3</div>
</div>

<div class="forms">
    <div class="form" id="form1">
        <!-- Healthcare Appointment -->
        <h2>Appointment</h2>
        <form id="eventForm" action="addEvent.php" method="POST">

        <label for="eventTitle">Event Title:</label>
        <input type="text" id="eventTitle" name="eventTitle" required>

        <label for="eventStartDate">Start Date and Time:</label>
        <input type="datetime-local" id="eventStartDate" name="eventStartDate" required>

        <label for="eventEndDate">End Date and Time:</label>
        <input type="datetime-local" id="eventEndDate" name="eventEndDate" required>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>

        <label for="reminderType">Reminder Type:</label>
        <select id="reminderType" name="reminderType">
            <option value="email">Email</option>
            <option value="popup">Popup</option>
        </select>

        <input type="submit" name="submitAppt" value="CREATE" class="submit-btn"/>
        </form>
    </div>

    <div class="form" id="form2">
        <!-- Mediction Reminder -->
        <h2>Medication Reminder</h2>
        <form id="eventForm" action="addEvent.php" method="POST">

        <label for="eventTitle">Event Title:</label>
        <input type="text" id="eventTitle" name="eventTitle" required>

        <label for="eventStartDate">Start Date and Time:</label>
        <input type="datetime-local" id="eventStartDate" name="eventStartDate" required>

        <label for="eventEndDate">End Date and Time:</label>
        <input type="datetime-local" id="eventEndDate" name="eventEndDate" required>

        <!--PHP code to retrieve medicine options-->
	    <?php
	        $medOptionsQuery = "SELECT medID, name FROM Medicine";
	        $medOptionsResult = mysqli_query($conn, $medOptionsQuery);

	        $medOptions = array();

	        while ($row = mysqli_fetch_assoc($medOptionsResult)) {
		            $medOptions[$row['medID']] = $row['name'];
            	}
	    ?>
        <label for="medicine">Medicine:</label>
        <?php foreach ($medOptions as $medID => $name) { ?>
        <input type="radio" id="medicine" name="medicine" value="<?php echo $medID; ?>">
        <?php echo json_encode($name); ?>
        <?php } ?>

        <label for="dosage">Dosage:</label>
        <input type="number" id="dosage" name="dosage" required>

        <label for="reminderType">Reminder Type:</label>
        <select id="reminderType" name="reminderType">
            <option value="email">Email</option>
            <option value="popup">Popup</option>
        </select>

        <input type="submit" name="submitMed" value="CREATE" class="submit-btn"/>
        </form>
    </div>

    <div class="form" id="form3">
        <!-- Blood Sugar Testing Reminder -->
        <h2>Blood Sugar Testing</h2>
        <form id="eventForm" action="addEvent.php" method="POST">

        <label for="eventTitle">Event Title:</label>
        <input type="text" id="eventTitle" name="eventTitle" required>

        <label for="eventStartDate">Start Date and Time:</label>
        <input type="datetime-local" id="eventStartDate" name="eventStartDate" required>

        <label for="eventEndDate">End Date and Time:</label>
        <input type="datetime-local" id="eventEndDate" name="eventEndDate" required>

        <label for="reminderType">Reminder Type:</label>
        <select id="reminderType" name="reminderType">
            <option value="email">Email</option>
            <option value="popup">Popup</option>
        </select>

        <input type="submit" name="submitBS" value="CREATE" class="submit-btn"/>
        </form>
    </div>

</div>

</div>

<script>
// Function to switch between forms
function showForm(index) {
    var forms = document.querySelectorAll('.form');
    var tabs = document.querySelectorAll('.tab');

    // Hide all forms and reset tab colors
    forms.forEach(function(form) {
        form.style.display = 'none';
    });
    tabs.forEach(function(tab) {
        tab.style.backgroundColor = '#f0f0f0';
    });

    // Show the selected form and set tab color
    forms[index].style.display = 'block';
    tabs[index].style.backgroundColor = '#ddd';
}
    
// Call showForm with index 0 to display the default form on page load
document.addEventListener('DOMContentLoaded', function() {
    showForm(0);
});

</script>


</body>
</html>