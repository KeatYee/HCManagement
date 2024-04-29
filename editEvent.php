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
// Update the events
$errors = array();

if(isset($_POST['submitAppt'])) {
    //Check if start date is earlier than end date
    if (!empty($_POST['sDate']) && !empty($_POST['eDate'])) {
        $sDate = strtotime($_POST['sDate']);
        $eDate = strtotime($_POST['eDate']);
        if ($sDate >= $eDate) {
            $errors[] = "End date must be later than start date.";
            $hasErrors = true;
        }
    }

    $title = $_POST['title'];
    $location = $_POST['location'];
    $id = $_POST['id'];

    if(empty($errors)){
        $sql = "UPDATE Appointment 
            SET title = '$title', sDate = '$sDate', eDate = '$eDate', location = '$location'
            WHERE apptID = '$id'";
        $result = mysqli_query($conn, $sql);

        if($result){
            echo "<script>";
            echo "alert('Event updated successfully!');";
            echo "window.location.href = 'profile.php';"; 
            echo "</script>";
        }
        else{
            echo "Error updating event: " . mysqli_error($conn);
        }

    }

    
}


if(isset($_POST['submitMed'])) {
    //Check if start date is earlier than end date
    if (!empty($_POST['sDate']) && !empty($_POST['eDate'])) {
        $sDate = strtotime($_POST['sDate']);
        $eDate = strtotime($_POST['eDate']);
        if ($sDate >= $eDate) {
            $errors[] = "End date must be later than start date.";
            $hasErrors = true;
        }
    }

    // Check if dosage amount and unit are entered for each selected medication
    foreach ($medIDs as $key => $medID) {
        // Check if the corresponding dosage amount and unit are empty
        if (empty($dosage_amounts[$key]) || empty($dosage_units[$key])) {
            $errors[] = "Dosage amount and unit are required for all selected medications.";
            break; 
        }
    }

    if(empty($errors)){
        $sql = "UPDATE MedicationReminder 
            SET title = '$title', sDate = '$sDate', eDate = '$eDate', location = '$location'
            WHERE apptID = '$id'";
        $result = mysqli_query($conn, $sql);

        if($result){
            echo "<script>";
            echo "alert('Event updated successfully!');";
            echo "window.location.href = 'profile.php';"; 
            echo "</script>";
        }
        else{
            echo "Error updating event: " . mysqli_error($conn);
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
    <link href="editEvent.css" rel="stylesheet">
  <!--Include Google Fonts - Quicksand-->
  <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
  <!--Font Awesome Icons-->
  <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<h2>Edit Event</h2>
<p><?php echo $error;?></p>
        <form action="editEvent.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="eventType" value="<?php echo $eventType; ?>">
            <!-- Display input fields to edit event details based on event type -->
            <?php
            switch ($eventType) {
                case 'Appointment':
                    ?>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>
                    <label for="sDate">Start date and time:</label>
                    <input type="datetime-local" id="sDate" name="sDate" value="<?php echo $sDate; ?>" required>
                    <label for="eDate">End date and time:</label>
                    <input type="datetime-local" id="eDate" name="eDate" value="<?php echo $eDate; ?>" required>
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" value="<?php echo $location; ?>" required>
                    
                    <input type="submit" name="submitAppt" value="Update" class="submit-btn">
                    </form>
                    <?php
                    break;
                case 'medicationReminder':
                    ?>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>">
                    <label for="sDate">Start date and time:</label>
                    <input type="datetime-local" id="sDate" name="sDate" value="<?php echo $sDate; ?>">
                    <label for="eDate">End date and time:</label>
                    <input type="datetime-local" id="eDate" name="eDate" value="<?php echo $eDate; ?>">
                     <!--PHP code to retrieve medicine options-->
	                <?php
                    $medOptionsQuery = "SELECT medID, name FROM Medicine WHERE ssn ='$ssn'";
                    $medOptionsResult = mysqli_query($conn, $medOptionsQuery);

                    $medOptions = array();

                    while ($row = mysqli_fetch_assoc($medOptionsResult)) {
                        $medOptions[$row['medID']] = $row['name'];
                    }
    

                    foreach ($medOptions as $medID => $name) { 
                     // Check if the current medicine ID matches the retrieved medicine ID
                     $checked = ($medID == $medID) ? "checked" : ""; ?>

                    <input type="checkbox" id="medicine<?php echo $medID; ?>" name="medID[]" value="<?php echo $medID; ?>" <?php $checked?>>
                    <?php echo $name; ?> <br>
        
                    <label for="dosage<?php echo $medID; ?>">Dosage:</label>
                    <div class="flexMed">
                    <input type="text" id="dosage_amount<?php echo $medID; ?>" name="dosage_amount[]" placeholder="2"><br>
                    <input type="text" id="dosage_unit<?php echo $medID; ?>" name="dosage_unit[]" placeholder="pills"><br>
                    </div>

                    <?php } ?>

                    <input type="submit" name="submitMed" value="Update" class="submit-btn">
                    <?php
                    break;
                case 'bsTestingAlert':
                    ?>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>">
                    <label for="sDate">Start date and time:</label>
                    <input type="datetime-local" id="sDate" name="sDate" value="<?php echo $sDate; ?>">
                    <label for="eDate">End date and time:</label>
                    <input type="datetime-local" id="eDate" name="eDate" value="<?php echo $eDate; ?>">

                    <input type="submit" name="submitBs" value="Update" class="submit-btn">
                    <?php
                    break;
                default:
                    echo "Unknown event type";
                    exit();
            }
            ?>


</body>
</html>
