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

    // Validation for appointment
    $titleError = $startError = $endError = $locError = $remError = "";
    $hasErrors = false;

    if (empty($_POST['eventTitle'])) {
        $titleError = "Please enter a title.";
        $hasErrors = true;
    }
    if (empty($_POST['eventStartDate'])) {
        $startError = "Please select a start date.";
        $hasErrors = true;
    }
    if (empty($_POST['eventEndDate'])) {
        $endError = "Please select an end date.";
        $hasErrors = true;
    }
    if (empty($_POST['location'])) {
        $locError = "Please enter location.";
        $hasErrors = true;
    }
    if (empty($_POST['reminderType'])) {
        $remError = "Please choose a reminder type.";
        $hasErrors = true;
    }
    //Check if start date is earlier than end date
    if (!empty($_POST['eventStartDate']) && !empty($_POST['eventEndDate'])) {
        $startDate = strtotime($_POST['eventStartDate']);
        $endDate = strtotime($_POST['eventEndDate']);
        if ($startDate >= $endDate) {
            $endError = "End date must be later than start date.";
            $hasErrors = true;
        }
    }

    if (!$hasErrors) {

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
}


//Medication Reminder-------------------
if(isset($_POST['submitMed'])) {

    // Validation for appointment
    $titleError = $startError = $endError = $medError = $dsgError = $remError = "";
    $hasErrors = false;

    // Handle validation error for appointment
    if (empty($_POST['eventTitle'])) {
        $titleError = "Please enter a title.";
        $hasErrors = true;
    }
    if (empty($_POST['eventStartDate'])) {
        $startError = "Please select a start date.";
        $hasErrors = true;
    }
    if (empty($_POST['eventEndDate'])) {
        $endError = "Please select an end date.";
        $hasErrors = true;
    }
    if (empty($_POST['medicine'])) {
        $medError = "Please choose your medicine.";
        $hasErrors = true;
    }
    if (empty($_POST['dosage'])) {
        $dsgError = "Please enter medicine dosage.";
        $hasErrors = true;
    }
    if (empty($_POST['reminderType'])) {
        $remError = "Please choose a reminder type.";
        $hasErrors = true;
    }
    //Check if start date is earlier than end date
    if (!empty($_POST['eventStartDate']) && !empty($_POST['eventEndDate'])) {
        $startDate = strtotime($_POST['eventStartDate']);
        $endDate = strtotime($_POST['eventEndDate']);
        if ($startDate >= $endDate) {
            $endError = "End date must be later than start date.";
            $hasErrors = true;
        }
    }

    if (!$hasError) {

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
}

//Blood Sugar Testing Alert-------------------
if(isset($_POST['submitBS'])) {
      // Validation for appointment
      $titleError = $startError = $endError = $remError = "";
      $hasErrors = false;  

    if (empty($_POST['eventTitle'])) {
        $titleError = "Please enter a title.";
        $hasErrors = true;  
    }
    if (empty($_POST['eventStartDate'])) {
        $startError = "Please select a start date.";
        $hasErrors = true;  
    }
    if (empty($_POST['eventEndDate'])) {
        $endError = "Please select an end date.";
        $hasErrors = true;  
    }
    if (empty($_POST['reminderType'])) {
        $remError = "Please choose a reminder type.";
        $hasErrors = true;  
    }
    //Check if start date is earlier than end date
    if (!empty($_POST['eventStartDate']) && !empty($_POST['eventEndDate'])) {
        $startDate = strtotime($_POST['eventStartDate']);
        $endDate = strtotime($_POST['eventEndDate']);
        if ($startDate >= $endDate) {
            $endError = "End date must be later than start date.";
            $hasErrors = true;  
        }
    }

    if (!$hasError) {

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
    <div class="tab" onclick="showForm(0)">Healthcare Appointment</div>
    <div class="tab" onclick="showForm(1)">Medication Reminder</div>
    <div class="tab" onclick="showForm(2)">Blood Sugar Testing Alert</div>
</div>

<div class="forms">
    <div class="form" id="form1">
        <!-- Healthcare Appointment -->
        <form id="eventForm" action="addEvent.php" method="POST">

        <label for="eventTitle">Event Title</label><br>
        <input type="text" id="eventTitle" name="eventTitle" required>
        <span class="error"><?php if(isset($titleError)) echo $titleError; ?></span>
        <br>

        <label for="eventStartDate">Start Date and Time</label><br>
        <input type="datetime-local" id="eventStartDate" name="eventStartDate" required>
        <span class="error"><?php if(isset($startError)) echo $startError; ?></span>
        <br>

        <label for="eventEndDate">End Date and Time</label><br>
        <input type="datetime-local" id="eventEndDate" name="eventEndDate" required>
        <span class="error"><?php if(isset($endError)) echo $endError; ?></span>
        <br>

        <label for="location">Location</label><br>
        <input type="text" id="location" name="location" required>
        <span class="error"><?php if(isset($loctError)) echo $locError; ?></span>
        <br>

        <label for="reminderType">Reminder Type</label><br>
        <select id="reminderType" name="reminderType">
            <option value="email">Email</option>
            <option value="popup">Popup</option>
        </select>
        <span class="error"><?php if(isset($remError)) echo $remError; ?></span>
        <br>

        <input type="submit" name="submitAppt" value="CREATE" class="submit-btn"/>
        </form>
    </div>

    <div class="form" id="form2">
        <!-- Mediction Reminder -->
        <form id="eventForm" action="addEvent.php" method="POST">

        <label for="eventTitle">Event Title:</label><br>
        <input type="text" id="eventTitle" name="eventTitle" required>
        <span class="error"><?php if(isset($titleError)) echo $titleError; ?></span>
        <br>

        <label for="eventStartDate">Start Date and Time:</label><br>
        <input type="datetime-local" id="eventStartDate" name="eventStartDate" required>
        <span class="error"><?php if(isset($startError)) echo $startError; ?></span>
        <br>

        <label for="eventEndDate">End Date and Time:</label><br>
        <input type="datetime-local" id="eventEndDate" name="eventEndDate" required>
        <span class="error"><?php if(isset($endError)) echo $endError; ?></span>
        <br>

        <!--PHP code to retrieve medicine options-->
	    <?php
	        $medOptionsQuery = "SELECT medID, name FROM Medicine WHERE ssn ='$ssn'";
	        $medOptionsResult = mysqli_query($conn, $medOptionsQuery);

	        $medOptions = array();

	        while ($row = mysqli_fetch_assoc($medOptionsResult)) {
		            $medOptions[$row['medID']] = $row['name'];
            	}
	    ?>
        <label for="medicine">Medicine:</label><br>
        <?php foreach ($medOptions as $medID => $name) { ?>
            <input type="radio" id="medicine_<?php echo $medID; ?>" name="medicine" value="<?php echo $medID; ?>">
            <label for="medicine_<?php echo $medID; ?>"><?php echo htmlspecialchars($name); ?></label><br>
        <?php } ?>

        <span class="error"><?php if(isset($medError)) echo $medError; ?></span>
        <br>

        <label for="dosage">Dosage:</label><br>
        <input type="number" id="dosage" name="dosage" required>
        <span class="error"><?php if(isset($dsgError)) echo $dsgError; ?></span>
        <br>

        <label for="reminderType">Reminder Type:</label><br>
        <select id="reminderType" name="reminderType">
            <option value="email">Email</option>
            <option value="popup">Popup</option>
        </select>
        <span class="error"><?php if(isset($remError)) echo $remError; ?></span>
        <br>

        <input type="submit" name="submitMed" value="CREATE" class="submit-btn"/>
        </form>
    </div>

    <div class="form" id="form3">
        <!-- Blood Sugar Testing Reminder -->
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