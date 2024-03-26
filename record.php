<?php
session_start(); // Start session
include 'DBconnect.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate and sanitize inputs
    function sanitizeInput($input) {
        return htmlspecialchars(trim($input));
    }

    // Validate Systolic Blood Pressure
    $bp_systolic = sanitizeInput($_POST['bp_systolic']);
    if (!is_numeric($bp_systolic) || $bp_systolic <= 0) {
        die("Invalid Systolic Blood Pressure value.");
    }

    // Validate Diastolic Blood Pressure
    $bp_diastolic = sanitizeInput($_POST['bp_diastolic']);
    if (!is_numeric($bp_diastolic) || $bp_diastolic <= 0) {
        die("Invalid Diastolic Blood Pressure value.");
    }

    // Validate Blood Sugar Value
    $bs_value = sanitizeInput($_POST['bs_value']);
    if (!is_numeric($bs_value) || $bs_value <= 0) {
        die("Invalid Blood Sugar Value.");
    }

    // Validate Weight Value
    $weight_value = sanitizeInput($_POST['weight_value']);
    if (!is_numeric($weight_value) || $weight_value <= 0) {
        die("Invalid Weight Value.");
    }

    // Validate Insulin Dose
    $insulin_dose = sanitizeInput($_POST['insulin_dose']);
    if (!is_numeric($insulin_dose) || $insulin_dose <= 0) {
        die("Invalid Insulin Dose.");
    }

    // Sanitize and prepare other inputs
    $bs_timing = sanitizeInput($_POST['bs_timing']);
    $meal_type = sanitizeInput($_POST['meal_type']);
    $food_item = sanitizeInput($_POST['food_item']);
    $medID = sanitizeInput($_POST['medID']);

    // Insert data into records table
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $recordType = "record"; // Change this to the appropriate record type
    $sql_record = "INSERT INTO records (ssn, time, date, recordType) VALUES ('$ssn', '$time', '$date', '$recordType')";
    mysqli_query($conn, $sql_record);

    // Insert data into BloodSugar table
    $sql_bs = "INSERT INTO BloodSugar (value, timing) VALUES ('$bs_value', '$bs_timing')";
    mysqli_query($conn, $sql_bs);

    // Insert data into BloodPressure table
    $sql_bp = "INSERT INTO BloodPressure (systolic, diastolic) VALUES ('$bp_systolic', '$bp_diastolic')";
    mysqli_query($conn, $sql_bp);

    // Insert data into Meal table
    $sql_meal = "INSERT INTO Meal (mealType, foodItem) VALUES ('$meal_type', '$food_item')";
    mysqli_query($conn, $sql_meal);

    // Insert data into BodyWeight table
    $sql_weight = "INSERT INTO BodyWeight (weightValue) VALUES ('$weight_value')";
    mysqli_query($conn, $sql_weight);

    // Insert data into InsulinDose table
    $sql_insulin = "INSERT INTO InsulinDose (dosage) VALUES ('$insulin_dose')";
    mysqli_query($conn, $sql_insulin);

    // Insert data into MedicationIntake table
    $sql_medication = "INSERT INTO MedicationIntake (medID) VALUES ('$medID')";
    mysqli_query($conn, $sql_medication);

    mysqli_close($conn);

    header("Location: record.php");
    exit();
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

    <head>
        <title>Record Page</title>
        <br>
    </head>
    <body>
    <div class="record-container">
        <h1>Record Page</h1>
        <form action="record.php" method="post">
            <h2>Blood Sugar</h2>
            <label for="bs_value">Blood Sugar Value (mmol/L):</label>
            <input type="number" id="bs_value" name="bs_value" step="0.01" min="0" required><br>
            <label for="bs_timing">Timing:</label><br>
            <input type="radio" id="fasting" name="bs_timing" value="fasting" required>
            <label for="fasting">Fasting</label><br>
            <input type="radio" id="before_meal" name="bs_timing" value="before_meal" required>
            <label for="before_meal">Before Meal</label><br>
            <input type="radio" id="after_meal" name="bs_timing" value="after_meal" required>
            <label for="after_meal">After Meal</label><br>
            <input type="radio" id="bedtime" name="bs_timing" value="bedtime" required>
            <label for="bedtime">Bedtime</label><br>


            <h2>Blood Pressure</h2>
            <label for="bp_systolic">Systolic (mm/Hg):</label>
            <input type="number" id="bp_systolic" name="bp_systolic" min="0" required><br>
            <label for="bp_diastolic">Diastolic (mm/Hg):</label>
            <input type="number" id="bp_diastolic" name="bp_diastolic" min="0" required><br>

            <h2>Meal</h2>
            <label for="meal_type">Meal Type:</label><br>
            <input type="radio" id="breakfast" name="meal_type" value="Breakfast" required>
            <label for="breakfast">Breakfast</label><br>
            <input type="radio" id="lunch" name="meal_type" value="Lunch" required>
            <label for="lunch">Lunch</label><br>
            <input type="radio" id="dinner" name="meal_type" value="Dinner" required>
            <label for="dinner">Dinner</label><br>
            <input type="radio" id="snack" name="meal_type" value="Snack" required>
            <label for="snack">Snack</label><br>
            
            <label for="food_item">Food Item:</label>
            <input type="text" id="food_item" name="food_item" required><br>

            <h2>Body Weight</h2>
            <label for="weight_value">Weight Value (KG):</label>
            <input type="number" id="weight_value" name="weight_value" step="0.01" min="0" required><br>

            <h2>Insulin Dose</h2>
            <label for="insulin_dose">Insulin Dose (mg/dl):</label>
            <input type="number" id="insulin_dose" name="insulin_dose" step="0.01" min="0" required><br>

            <h2>Medication Intake</h2>
        <label for="medication">Select Medication:</label>

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


        <input type="submit" value="Submit">
    </form>
    </div>
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
    </footer>
    </html>