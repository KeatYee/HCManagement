<?php

  session_start();// Start session
  include 'DBconnect.php'; // Include database connection

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

 
    
      //records
      date_default_timezone_set('Asia/Kuala_Lumpur');
      $date = date("Y-m-d");
      $time = date("H:i:s");
      $recordType = "record"; // Change this to the appropriate record type
      $sql_record = "INSERT INTO records (ssn, time, date, recordType) VALUES ('$ssn', '$time', '$date', '$recordType')";
      mysqli_query($conn, $sql_record);

      // Blood Sugar
      $bs_value = $_POST['bs_value'];
      $bs_timing = $_POST['bs_timing'];
      $sql_bs = "INSERT INTO BloodSugar (value, timing) VALUES ('$bs_value', '$bs_timing')";
      mysqli_query($conn, $sql_bs);

      // Blood Pressure
      $bp_systolic = $_POST['bp_systolic'];
      $bp_diastolic = $_POST['bp_diastolic'];
      $sql_bp = "INSERT INTO BloodPressure (systolic, diastolic) VALUES ('$bp_systolic', '$bp_diastolic')";
      mysqli_query($conn, $sql_bp);

      // Meal
      $meal_type = $_POST['meal_type'];
      $food_item = $_POST['food_item'];
      $sql_meal = "INSERT INTO Meal (mealType, foodItem) VALUES ('$meal_type', '$food_item')";
      mysqli_query($conn, $sql_meal);

      // Body Weight
      $weight_value = $_POST['weight_value'];
      $sql_weight = "INSERT INTO BodyWeight (weightValue) VALUES ('$weight_value')";
      mysqli_query($conn, $sql_weight);

      // Insulin Dose
      $insulin_dose = $_POST['insulin_dose'];
      $sql_insulin = "INSERT INTO InsulinDose (dosage) VALUES ('$insulin_dose')";
      mysqli_query($conn, $sql_insulin);

      // Medication Intake
      $med_name = $_POST['med_name'];
      $med_description = $_POST['med_description'];
      $sql_med = "INSERT INTO Medicine (name, description) VALUES ('$med_name', '$med_description')";
      mysqli_query($conn, $sql_med);

      // Close the database connection
      mysqli_close($conn);

      // Redirect to the record page to prevent duplicate submissions
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
          <label for="bs_value">Blood Sugar Value:</label>
          <input type="number" id="bs_value" name="bs_value" step="0.01" min="0"><br>
          <label for="bs_timing">Timing:</label><br>
          <input type="radio" id="fasting" name="bs_timing" value="fasting">
          <label for="fasting">Fasting</label><br>
          <input type="radio" id="before_meal" name="bs_timing" value="before_meal">
          <label for="before_meal">Before Meal</label><br>
          <input type="radio" id="after_meal" name="bs_timing" value="after_meal">
          <label for="after_meal">After Meal</label><br>
          <input type="radio" id="bedtime" name="bs_timing" value="bedtime">
          <label for="bedtime">Bedtime</label><br>


          <h2>Blood Pressure</h2>
          <label for="bp_systolic">Systolic:</label>
          <input type="number" id="bp_systolic" name="bp_systolic" min="0"><br>
          <label for="bp_diastolic">Diastolic:</label>
          <input type="number" id="bp_diastolic" name="bp_diastolic" min="0"><br>

          <h2>Meal</h2>
          <label for="meal_type">Meal Type:</label><br>
          <input type="radio" id="breakfast" name="meal_type" value="Breakfast">
          <label for="breakfast">Breakfast</label><br>
          <input type="radio" id="lunch" name="meal_type" value="Lunch">
          <label for="lunch">Lunch</label><br>
          <input type="radio" id="dinner" name="meal_type" value="Dinner">
          <label for="dinner">Dinner</label><br>
          <input type="radio" id="snack" name="meal_type" value="Snack">
          <label for="snack">Snack</label><br>
          <label for="food_item">Food Item:</label>
          <input type="text" id="food_item" name="food_item"><br>

          <h2>Body Weight</h2>
          <label for="weight_value">Weight Value:</label>
          <input type="number" id="weight_value" name="weight_value" step="0.01" min="0"><br>

          <h2>Insulin Dose</h2>
          <label for="insulin_dose">Insulin Dose:</label>
          <input type="number" id="insulin_dose" name="insulin_dose" step="0.01" min="0"><br>

          <h2>Medication Intake</h2>
          <label for="med_name">Medication Name:</label>
          <input type="text" id="med_name" name="med_name"><br>
          <label for="med_description">Description:</label>
          <input type="text" id="med_description" name="med_description"><br>

          <input type="submit" value="Submit">
      </form>
  </div>
  </body>
  </html>
    
      

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