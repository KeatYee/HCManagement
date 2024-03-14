<?php
session_start(); // Start the session
include 'DBconnect.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['ssn'])) {
    echo "<script> alert('You need to log in to access the profile page.');";
	  echo "window.location.replace('login.php');</script>";
    exit(); //redirect user to login page
}

// Retrieve user information from the session
	$ssn = $_SESSION['ssn'];
	$email = $_SESSION['email'];
	$password = $_SESSION['password']; 

// Fetch blood sugar data from MySQL
$sql = "SELECT r.date, bs.timing, AVG(bs.value) AS average_value 
        FROM Records r
        INNER JOIN BloodSugar bs ON r.recordID = bs.recordID
        WHERE r.recordType = 'Blood Sugar'
        GROUP BY r.date, bs.timing"; //**put the date range, use today's date
$result = $conn->query($sql);

// Initialize an array to store the formatted data
$chartData = [];

// Process fetched data and format it for Google Charts
while ($row = $result->fetch_assoc()) {
    $date = $row['date'];
    $timing = $row['timing'];
    $value = $row['average_value'];

    // Add data to the formatted array
    if (!isset($chartData[$date])) {
        $chartData[$date] = ['date' => $date];
    }

    // Assign blood sugar value to the appropriate timing column
    $chartData[$date][$timing] = $value;
}





?>
<!DOCTYPE html>
<html>
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="report.css" rel="stylesheet">
  <!--Include Google Fonts - Quicksand-->
  <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
  <!--Font Awesome Icons-->
  <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!--Google Chart-->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="chart1.js">
    google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawVisualization);

function drawVisualization() {
      // Create a DataTable and add columns
      var data = new google.visualization.DataTable();
            data.addColumn('string', 'Date');
            data.addColumn('number', 'Fasting');
            data.addColumn('number', 'Before Meal');
            data.addColumn('number', 'After Meal');
            data.addColumn('number', 'Bedtime');

    // Add rows from the PHP data
    <?php foreach ($chartData as $row): ?>
        data.addRow([<?= "'" . $row['date'] . "'" ?>,
            <?= isset($row['Fasting']) ? $row['Fasting'] : 'null' ?>,
            <?= isset($row['Before Meal']) ? $row['Before Meal'] : 'null' ?>,
            <?= isset($row['After Meal']) ? $row['After Meal'] : 'null' ?>,
            <?= isset($row['Bedtime']) ? $row['Bedtime'] : 'null' ?>]);
    <?php endforeach; ?>    

 // Define chart options
    var options = {
        title: 'Blood Sugar Readings by Date and Timing',
        vAxis: {title: 'Average Blood Sugar'},
        hAxis: {title: 'Date'},
        seriesType: 'bars',
        series: {3: {type: 'line'}} // Display a line for average blood sugar
    };

  var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}
  </script>
     
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
<div id="chart_div" style="width: 900px; height: 500px;"></div>
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
