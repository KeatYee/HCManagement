<?php
session_start();
include 'DBconnect.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['ssn'])) {
  echo "<script> alert('You need to log in to access the feedback page.');";
  echo "window.location.replace('login.php');</script>";
  exit(); //redirect user to login page
}

// Retrieve user information from the session
$ssn = $_SESSION['ssn'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = trim($_POST["name"]);
    $email = ($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $message = ($_POST["message"]);
    $date = date("Y-m-d");
    $time = date("H:i:s");


    // **Name Validation:**
    $allowedChars = '/^[a-zA-Z \-\']+$/'; // Allow letters, spaces, hyphens, and apostrophes
    if (!preg_match($allowedChars, $name)) {
      echo "<script>alert('Name can only contain letters, spaces, hyphens, and apostrophes.'); window.location.href='feedback.php';</script>";
    exit();
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Show alert message
        echo "<script>alert('Invalid email format');</script>";
    }

    $allowedChars = '/^[0-9+\-()]+$/'; // Allow digits, +, -, and ()
    if (!preg_match($allowedChars, $phone)) {
      echo "<script>alert('Invalid phone number format. Allowed characters: 0-9, +, -, and ().'); window.location.href='feedback.php';</script>";
      exit();
    }
    
  
        // SQL query to insert data into the database
        $sql = "INSERT INTO feedback (ssn, date, time, comment, email) 
        VALUES ('$ssn', '$date', '$time', '$message', '$email')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Show success message
            echo "<script>";
            echo "alert('We have received your feedback!');";
            echo "window.location.href = 'feedback.php';"; 
            echo "</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    // Close the database connection
    mysqli_close($conn);

}
?>

<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>diaCare</title>  
<link href="feedback.css" rel="stylesheet">
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

    <div class="dropdown-form">
        <div class="contact-info">
            <h2>Contact Us</h2><hr>
            
            <h4>Customer Service Hotline</h4>
            <p>03-90928888</p>
            <h4><b>Email</h4>
            <p>diacare8888@email.com</p>
            <h4>Facebook</h4>
            <p>facebook.com/Diacare</p>
            <h4>Instagram</h4> 
            <p>@Diacare___</p>
            <h4>Twitter</h4> 
            <p>@diacare</p>
        </div>

        <form class="user-input" action="feedback.php" method="post">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>

	
		

  <!--Hamburger-->
  <script src="app.js"></script>		
</body>
<footer>
  <div class="footer-content">

    <div class="about">
      <h3>About diaCare</h3>
      <p style="color:white;">diaCare is a comprehensive web application for people with diabetes or pre-diabetes </p>
    </div>

    <div class="contact">
      <h3>Contact Us</h3>
      <p style="color:white;">Email: diacare888@gmail.com</p>
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