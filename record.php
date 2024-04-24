<?php
session_start(); // Start session
include 'DBconnect.php'; // Include database connection

if (!isset($_SESSION['ssn'])) {
    echo "<script> alert('You need to log in to access record`');";
    echo "window.location.replace('login.php');</script>";
    exit(); //redirect user to login page
}

// Retrieve user information from the session
$ssn = $_SESSION['ssn'];
$email = $_SESSION['email'];
$password = $_SESSION['password']; 

$errors = array();
//flag for check any data inserted
$recordBoxSubmitted = false;
//flag for which data inserted
$bsRecord = false;
$bpRecord = false;
$mealRecord = false;
$insulinRecord = false;
$weightRecord = false;
$medRecord = false;
//flag for database insertion
$successful = false;

//Validate submit
if (isset($_POST['submit'])) {

    //date_default_timezone_set('Asia/Kuala_Lumpur');
    if(isset($_POST['date']) || isset($_POST['time'])){
        $date = $_POST['date'];
        $time = $_POST['time'];
    }
    else{
        $errors[]="Please enter the date and time";
    }

     // Insert Blood Sugar record
    if (!empty($_POST['bs_timing']) || !empty($_POST['bs_value'])) {
        // If timing or value is entered, both timing and value are required
        if (empty($_POST['bs_timing']) && !empty($_POST['bs_value'])) {
            $errors[] = "Blood sugar timing is required if blood sugar value is entered.";
        } 
        elseif (empty($_POST['bs_value']) && !empty($_POST['bs_timing'])) {
            $errors[] = "Blood sugar value is required if blood sugar timing is entered.";
        } 
        elseif (!empty($_POST['bs_timing']) && !empty($_POST['bs_value'])) {
            
            if ($_POST['bs_value'] < 54 || $_POST['bs_value'] > 144) {
                $errors[] = "Blood sugar value must be between 54 and 144 mg/dL.";
            }
            else{
                $recordBoxSubmitted = true;
                $bsRecord = true;
            }
        }
    }
    // Insert Blood Pressure record
    if (!empty($_POST['bp_systolic']) || !empty($_POST['bp_diastolic'])) {

        if (!empty($_POST['bp_systolic']) && empty($_POST['bp_diastolic'])) {
            $errors[] = "Diastolic value is required if Systolic value is entered.";
        } 
        elseif (!empty($_POST['bp_diastolic']) && empty($_POST['bp_systolic'])) {
            $errors[] = "Systolic value is required if Diastolic value is entered.";
        } 
        elseif (!empty($_POST['bp_systolic']) && !empty($_POST['bp_diastolic'])) {
            $recordBoxSubmitted = true;
            if ($_POST['bp_systolic'] < 100 || $_POST['bp_systolic'] > 250) {
                $errors[] = "Systolic value must be between 100 and 250 mmHg.";
            }else if ($_POST['bp_diastolic'] < 50 || $_POST['bp_diastolic'] > 250) {
                $errors[] = "Diastolic value must be between 50 and 250 mmHg.";
            }else{
                $recordBoxSubmitted = true;
                $bpRecord = true;
            }
        }
    }
    // Insert Meal record
    if (!empty($_POST['food_item']) || !empty($_POST['meal_type'])) {

        if (!empty($_POST['food_item']) && empty($_POST['meal_type'])) {
            $errors[] = "Meal type is required if food item is entered.";
        } 
        elseif (!empty($_POST['meal_type']) && empty($_POST['food_item'])) {
            $errors[] = "Food item is required if meal type is entered.";
        }
        elseif (!empty($_POST['food_item']) && !empty($_POST['meal_type'])) {
            $recordBoxSubmitted = true;
            $mealRecord = true;

        }
    }
  

  // Medication Intake validation
    if (!empty($_POST['medID'])) {
        $medIDs = $_POST['medID'];
        $dosage_amounts = $_POST['dosage_amount'];
        $dosage_units = $_POST['dosage_unit'];

        // Check if dosage amount and unit are entered for each selected medication
        foreach ($medIDs as $key => $medID) {
            // Check if the corresponding dosage amount and unit are empty
            if (empty($dosage_amounts[$key]) || empty($dosage_units[$key])) {
                $errors[] = "Dosage amount and unit are required for all selected medications.";
                break; // Stop checking if any medication is missing dosage information
            } else {
                $recordBoxSubmitted = true;
                $medRecord = true;
            }
        }
    }
    

    // Insert Body Weight record
    if (!empty($_POST['weight_value'])) {
        if ($_POST['weight_value'] < 1) {
            $errors[] = "Weight value must be greater than 0.";
        }
        else{
            $recordBoxSubmitted = true;
            $weightRecord = true;
        }
    }
     // Insert Insulin Dose record
     if (!empty($_POST['insulin_dose'])) {
        if ($_POST['insulin_dose'] < 1) {
            $errors[] = "Insulin dose must be greater than 0.";
        }
        else{
            $recordBoxSubmitted = true;
            $insulinRecord = true;
        }
     }


    if (!$recordBoxSubmitted) {
        $errors[] = "At least one record box must be submitted.";
    }

    if(empty($errors)){
        //proceed to database insertion
//blood sugar-----------
        if($bsRecord){
            $recordType = "Blood Sugar";
            $sql_records = "INSERT INTO records (ssn, time, date, recordType)
             VALUES ('$ssn', '$time', '$date', '$recordType')";
            $result = mysqli_query($conn, $sql_records);
            if($result){
                $recordID = $conn->insert_id;
                $bs_value = $_POST['bs_value'];
                $bs_timing = $_POST['bs_timing'];

                $sql_bs = "INSERT INTO BloodSugar (recordID, value, timing)
                 VALUES ('$recordID', '$bs_value', '$bs_timing')";
                 $result = mysqli_query($conn, $sql_bs);
                 if($result){
                    $successful = true;
                 }
            
            }
        }
//blood pressure----------
        if($bpRecord){
            $recordType = "Blood Pressure";
            $sql_records = "INSERT INTO records (ssn, time, date, recordType)
             VALUES ('$ssn', '$time', '$date', '$recordType')";
            $result = mysqli_query($conn, $sql_records);
            if($result){
                $recordID = $conn->insert_id;
                $bp_systolic = $_POST['bp_systolic'];
                $bp_diastolic = $_POST['bp_diastolic'];

                $sql_bp = "INSERT INTO BloodPressure (recordID, systolic, diastolic)
                 VALUES ('$recordID', '$bp_systolic', '$bp_diastolic')";
                 $result = mysqli_query($conn, $sql_bp);
                 if($result){
                    $successful = true;
                 }
            
            }
        }
//meal------------------
        if($mealRecord){
            $recordType = "Meal";
            $sql_records = "INSERT INTO records (ssn, time, date, recordType)
             VALUES ('$ssn', '$time', '$date', '$recordType')";
            $result = mysqli_query($conn, $sql_records);
            if($result){
                $recordID = $conn->insert_id;
                $food_item = $_POST['food_item'];
                $meal_type = $_POST['meal_type'];

                $sql_meal = "INSERT INTO Meal (recordID, fooditem , mealtype)
                 VALUES ('$recordID', '$meal_type', '$food_item')";
                 $result = mysqli_query($conn, $sql_meal);
                 if($result){
                    $successful = true;
                 }
            
            }
        }
//insulin dose-----------
        if($insulinRecord){
            $recordType = "Insulin Dose";
            $sql_records = "INSERT INTO records (ssn, time, date, recordType)
             VALUES ('$ssn', '$time', '$date', '$recordType')";
            $result = mysqli_query($conn, $sql_records);
            if($result){
                $recordID = $conn->insert_id;
                $insulin_dose = $_POST['insulin_dose'];

                $sql_insulin = "INSERT INTO InsulinDose (recordID, dosage)
                 VALUES ('$recordID', '$insulin_dose')";
                 $result = mysqli_query($conn, $sql_insulin);
                 if($result){
                    $successful = true;
                 }
            }
        }
//weight-----------------
        if($weightRecord){
            $recordType = "Body Weight";
            $sql_records = "INSERT INTO records (ssn, time, date, recordType)
             VALUES ('$ssn', '$time', '$date', '$recordType')";
            $result = mysqli_query($conn, $sql_records);
            if($result){
                $recordID = $conn->insert_id;
                $weight_value = $_POST['weight_value'];

                $sql_weight ="INSERT INTO bodyweight (recordID, weightValue)
                 VALUES ('$recordID', '$weight_value')";
                 $result = mysqli_query($conn, $sql_weight);
                 if($result){
                    $successful = true;
                 }
            }
        }
//medication------------        
        if($medRecord){
            $recordType = "Medication Intake";
            $sql_records = "INSERT INTO records (ssn, time, date, recordType)
             VALUES ('$ssn', '$time', '$date', '$recordType')";
            $result = mysqli_query($conn, $sql_records);
            if($result){
                $recordID = $conn->insert_id;

                foreach ($_POST['medID'] as $key => $medID) {
                    $dosage_amount = $_POST['dosage_amount'][$key];
                    $dosage_unit = $_POST['dosage_unit'][$key];
                    
                    $sql = "INSERT INTO MedicationIntake (recordID, medID, dosage, unit)
                     VALUES ('$recordID', '$medID', '$dosage_amount', '$dosage_unit')";
                    $result = mysqli_query($conn, $sql);
                }
                 if($result){
                    $successful = true;
                 }
            }
        }

    }

    if($successful){
        echo "<script>";
        echo "alert('Record added successfully!');";
        echo "window.location.href = 'record.php';"; 
        echo "</script>";
    }

}

?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>diaCare</title>
    <link href="record.css" rel="stylesheet">

    <!--Include Google Fonts - Quicksand-->
    <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
    <!--Font Awesome Icons-->
    <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
    <!--Boxicons-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<!--top nav bar-->
<nav>
    <div class="nav-left">
        <div class="logo"><img src="Img/logo.png" alt="logo"><p>DiaCare</p></div>
    </div>
    <div class="nav-right">
        <ul class="nav-links">
            <li><a href="homepage.php">Home</a></li>
            <li><a href="calendar.php">Calendar</a></li>
            <li><a href="record.php">Record</a></li>
            <li><a href="report.php">Report</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="profile.php"><i class='bx bx-user' style="font-size:30px;"></i></a></li>
        </ul>

        <div class="hamburger">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>

    </div>
</nav>

   

<body>
<div class="record-container">
<?php if(!empty($errors)){
        foreach ($errors as $error) {?>
            <div class="error">
            <p class="error"><i class='bx bx-error' style="font-size:5vh;"></i>&nbsp
            <?php echo "$error";?></p>
            </div>
    <?php }
    } ?>
    
<form id="recordForm" action="record.php" method="post">
<h1>Diacare</h1>
<div class="record-box time">    
    <h2>Date and Time</h2>
    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required><br>

    <label for="time">Time:</label>
    <input type="time" id="time" name="time" required><br>
</div>

<div class="record-box blood-sugar">
    <h2>Blood Sugar</h2>
    <label for="bs_value">Blood Sugar Value (mg/dL):</label>
    <input type="number" placeholder="Enter value 54 to 144" id="bs_value" name="bs_value" step="0.01" min="54" max="144"><br>

    <label for="bs_timing">Timing:</label><br>
    <input type="radio" id="fasting" name="bs_timing" value="fasting">
    <label for="fasting">Fasting</label>
    <input type="radio" id="before_meal" name="bs_timing" value="before_meal">
    <label for="before_meal">Before Meal</label>
    <input type="radio" id="after_meal" name="bs_timing" value="after_meal">
    <label for="after_meal">After Meal</label>

    <button class="clearButton" id="clearBsTimingButton">CLEAR</button>

</div>

<script>
    var bsTimingRadios = document.querySelectorAll('input[name="bs_timing"]');
    var clearBsTimingButton = document.getElementById('clearBsTimingButton');

    clearBsTimingButton.addEventListener('click', function() {
        bsTimingRadios.forEach(function(radio) {
            radio.checked = false;
        });
    });
</script>

<div class="record-box blood-pressure">
    <h2>Blood Pressure</h2>
    <label for="bp_systolic">Systolic (mm/Hg):</label>
    <input type="number" id="bp_systolic" name="bp_systolic" placeholder="Enter value 100 to 250" min="100" max="250"><br>

    <label for="bp_diastolic">Diastolic (mm/Hg):</label>
    <input type="number" id="bp_diastolic" name="bp_diastolic" placeholder="Enter value 50 to 250" min="50" max="250" ><br>
</div>

<div class="record-box meal">
    <h2>Meal</h2>
    <label for="food_item">Food Item:</label>
    <input type="text" id="food_item" name="food_item" placeholder="Salad,Egg mayo sandwich and milk"><br>

    <label for="meal_type">Meal Type:</label><br>
    <input type="radio" id="breakfast" name="meal_type" value="Breakfast">
    <label for="breakfast">Breakfast</label>
    <input type="radio" id="lunch" name="meal_type" value="Lunch">
    <label for="lunch">Lunch</label>
    <input type="radio" id="dinner" name="meal_type" value="Dinner">
    <label for="dinner">Dinner</label>
    <input type="radio" id="snack" name="meal_type" value="Snack">
    <label for="snack">Snack</label>
    <button class="clearButton" id="clearMealButton">CLEAR</button>
</div>

<script>
    // Get all radio buttons with name 'meal_type'
    var mealTypeRadios = document.querySelectorAll('input[name="meal_type"]');
    var clearButton = document.getElementById('clearMealButton');

    // Add event listener to the clear button
    clearButton.addEventListener('click', function() {
        // Loop through each radio button and set checked to false
        mealTypeRadios.forEach(function(radio) {
            radio.checked = false;
        });
    });
</script>

<div class="record-box body-weight">
    <h2>Body Weight</h2>
    <label for="weight_value">Weight Value (KG):</label>
    <input type="number" id="weight_value" name="weight_value" placeholder="Enter value 1 to 400" step="0.01" min="1" max="400"><br>
</div>

<div class="record-box insulin-dose">
    <h2>Insulin Dose</h2>
    <label for="insulin_dose">Insulin Dose (mg/dl):</label>
    <input type="number" id="insulin_dose" name="insulin_dose" placeholder="Enter value" step="0.01" min="0"><br>
</div>

<div class="record-box medication-intake">
    <h2>Medication Intake</h2>
    <h3>Select Medication:</h3><br>

    <?php
    $medOptionsQuery = "SELECT medID, name FROM Medicine WHERE ssn ='$ssn'";
    $medOptionsResult = mysqli_query($conn, $medOptionsQuery);

    $medOptions = array();

    while ($row = mysqli_fetch_assoc($medOptionsResult)) {
        $medOptions[$row['medID']] = $row['name'];
    }
    ?>

    <?php foreach ($medOptions as $medID => $name) { ?>

        <input type="checkbox" id="medicine<?php echo $medID; ?>" name="medID[]" value="<?php echo $medID; ?>">
        <?php echo $name; ?> <br>
        
        <label for="dosage<?php echo $medID; ?>">Dosage:</label>
        <div class="flexMed">
        <input type="text" id="dosage_amount<?php echo $medID; ?>" name="dosage_amount[]" placeholder="Enter the amount (exp:2)"><br>
        <input type="text" id="dosage_unit<?php echo $medID; ?>" name="dosage_unit[]" placeholder="Enter the unit (exp:mg)"><br>
        </div>

    <?php } ?>
</div>
    
<input type="submit" value="Submit" name="submit">
</div>
</form>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var now = new Date();
    var dateField = document.getElementById('date');
    var timeField = document.getElementById('time');

     // Set the date field to today
     dateField.value = now.toISOString().split('T')[0]; // Format: YYYY-MM-DD

    // Set the time field to the current time
    var currentTime = now.toTimeString().split('')[0]; // Format: HH:MM

});

</script>
</body>

<!--Hamburger-->
<script src="app.js"></script>
</body>
<footer>
    <div class="footer-content">
        <div class="about">
            <h3>About Foodbank</h3>
            <p style="color:white;">ØHungers is a Malaysian NGO food bank collecting <br>and distributing edible food to charities and families.</p>
        </div>
        <div class="contact">
            <h3>Contact Us</h3>
            <p style="color:white;">Email: ØHungers@gmail.com</p>
            <p style="color:white;">Phone: +601-2879819</p>
            <p style="color:white;">Address: 1495 Jalan Kong Kong Batu 26 Ladang Lim Lim 81750 Masai Johor Malaysia</p>
        </div>

        <div class="social-media">
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</footer>
</html>
