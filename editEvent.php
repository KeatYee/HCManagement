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
if (isset($_GET['id'], $_GET['eventType'])){
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
        if($eventType == "medicationReminder"){
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
    $id = $_POST['id'];
    $eventType = $_POST['eventType'];

    // Validate title
    if (empty($_POST["title"])) {
        $errors[] = "Title is required";
    } else {
        $title = $_POST["title"];
    }
    
    //Check if start date is earlier than end date
    if (!empty($_POST['sDate']) && !empty($_POST['eDate'])) {
        $sDate = strtotime($_POST['sDate']);
        $eDate = strtotime($_POST['eDate']);
        if ($sDate >= $eDate) {
            $errors[] = "End date must be later than start date.";
            $hasErrors = true;
        }
        else{
            $sDate = date("Y-m-d\TH:i:s", strtotime($_POST['sDate']));
            $eDate = date("Y-m-d\TH:i:s", strtotime($_POST['eDate']));
        }
    } else {
        if (empty($_POST["sDate"])) {
            $errors[] = "Start date and time is required";
        }
        if (empty($_POST["eDate"])) {
            $errors[] = "End date and time is required";
        }
    }

     // Validate location
     if (empty($_POST["location"])) {
        $errors[] = "Location is required";
    } else {
        $location = $_POST["location"];
    }


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

if(isset($_POST['submitBs'])) {
    $id = $_POST['id'];
    $eventType = $_POST['eventType'];

    // Validate title
    if (empty($_POST["title"])) {
        $errors[] = "Title is required";
    } else {
        $title = $_POST["title"];
    }
    
    //Check if start date is earlier than end date
    if (!empty($_POST['sDate']) && !empty($_POST['eDate'])) {
        $sDate = strtotime($_POST['sDate']);
        $eDate = strtotime($_POST['eDate']);
        if ($sDate >= $eDate) {
            $errors[] = "End date must be later than start date.";
            $hasErrors = true;
        }
        else{
            $sDate = date("Y-m-d\TH:i:s", strtotime($_POST['sDate']));
            $eDate = date("Y-m-d\TH:i:s", strtotime($_POST['eDate']));
        }
    } else {
        if (empty($_POST["sDate"])) {
            $errors[] = "Start date and time is required";
        }
        if (empty($_POST["eDate"])) {
            $errors[] = "End date and time is required";
        }
    }

    if(empty($errors)){
        $sql = "UPDATE BSTestingAlert 
            SET title = '$title', sDate = '$sDate', eDate = '$eDate'
            WHERE testingID = '$id'";
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
    $id = $_POST['id'];
    $eventType = $_POST['eventType'];

    // Validate title
    if (empty($_POST["title"])) {
        $errors[] = "Title is required";
    } else {
        $title = $_POST["title"];
    }

    //Check if start date is earlier than end date
    if (!empty($_POST['sDate']) && !empty($_POST['eDate'])) {
        $sDate = strtotime($_POST['sDate']);
        $eDate = strtotime($_POST['eDate']);
        if ($sDate >= $eDate) {
            $errors[] = "End date must be later than start date.";
            $hasErrors = true;
        }
        else{
            $sDate = date("Y-m-d\TH:i:s", strtotime($_POST['sDate']));
            $eDate = date("Y-m-d\TH:i:s", strtotime($_POST['eDate']));
        }
    } else {
        if (empty($_POST["sDate"])) {
            $errors[] = "Start date and time is required";
        }
        if (empty($_POST["eDate"])) {
            $errors[] = "End date and time is required";
        }
    }

   // Validate medicine selection
   if (empty($_POST["medID"])) {
        $errors[] = "Please select a medicine";
    } else {
        $medID = $_POST["medID"];
    }

    // Validate dosage amount
    if (empty($_POST["dosage_amount"])) {
        $errors[] = "Dosage amount is required";
    } else {
        $dosage = $_POST["dosage_amount"];
    }

    // Validate dosage unit
    if (empty($_POST["dosage_unit"])) {
        $errors[] = "Dosage unit is required";
    } else {
        $unit = $_POST["dosage_unit"];
    }

    if(empty($errors)){

        $sql = "UPDATE MedicationReminder 
            SET title = '$title', medID = '$medID', sDate = '$sDate', eDate = '$eDate', dosage = '$dosage',  unit = '$unit'
            WHERE medRemID = '$id'";
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

<?php if(!empty($errors)){
        foreach ($errors as $error) {?>
            <div class="error">
            <p class="error"><i class='bx bx-error' style="font-size:5vh;"></i>&nbsp
            <?php echo "$error";?></p>
            </div>
    <?php }
    } ?>
        <form action="editEvent.php" method="POST">
        
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="eventType" value="<?php echo $eventType; ?>">
            <div class="close-icon">
                    <a href="profile.php?action=today"><i class='bx bx-arrow-back'></i></a>
            </div>
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
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>
                    <label for="sDate">Start date and time:</label>
                    <input type="datetime-local" id="sDate" name="sDate" value="<?php echo $sDate; ?>" required>
                    <label for="eDate">End date and time:</label>
                    <input type="datetime-local" id="eDate" name="eDate" value="<?php echo $eDate; ?>" required>
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

                    <input type="radio" id="medicine<?php echo $medID; ?>" name="medID" value="<?php echo $medID; ?>" <?php echo $checked; ?>>

                    <?php echo $name; ?> <br>

                    <?php } ?>
                            
                    <label for="dosage">Dosage:</label>
                    
                    <div class="flexMed">
                    <input type="text" id="dosage_amount" name="dosage_amount" placeholder="amount" value="<?php echo $dosage; ?>" required>
                    <input type="text" id="dosage_unit" name="dosage_unit" placeholder="unit" value="<?php echo $unit; ?>" required><br>
                    </div>

                    <input type="submit" name="submitMed" value="Update" class="submit-btn">
                    <?php
                    break;
                case 'bsTestingAlert':
                    ?>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>
                    <label for="sDate">Start date and time:</label>
                    <input type="datetime-local" id="sDate" name="sDate" value="<?php echo $sDate; ?>" required>
                    <label for="eDate">End date and time:</label>
                    <input type="datetime-local" id="eDate" name="eDate" value="<?php echo $eDate; ?>" required>

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
