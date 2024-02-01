<!DOCTYPE html>
<html>
<script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
<link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<head>
   
    <title>User Profile</title>
 
</head>
<body>

<header>
 <div class="navbar">
  <div class="logopic"><img src="logo.png";>
  </div>
<div class="logo"><a>DiaCare</a></div>

    <ul class="content">       
		<li><a href="homepage.php">Home</a></li>
    <li><a href="calender.php">Calender</a></li>

		</li>
        <li><a href="Location.php">Record</a></li>
        <li><a href="aboutus.php">Report</a></li>
        <li><a href="feedback.php">Feedback</a></li>
   	</ul>
    <ul class="loginbtn">
      <li><a href="accounttype.php"><i class='bx bx-user'></i></a></li>
    </ul>
	</div>
</header>


        <div class="profile-details">
            <h2>Edit Profile</h2>
            <form action="#" method="post" id="profileForm">
                <label for="diabetesType">Diabetes Type:</label>
                <select name="diabetesType" id="diabetesType">
                    <option value="type1">Type 1</option>
                    <option value="type2">Type 2</option>
                    <option value="gestational">Gestational</option>
                </select>

                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="sex">Sex:</label>
                <input type="text" id="sex" name="sex" required>

                <label for="birthdate">Birthdate:</label>
                <input type="date" id="birthdate" name="birthdate" required>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

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


<?php
session_start(); // Start session
include 'a-DBconnect.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    echo "<script> alert('You need to log in to access the profile page.');";
    echo "window.location.replace('individuallogin.php');</script>";
    exit(); // Redirect user to the login page
}

// Retrieve user information from the session
$userid = $_SESSION['userid'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];

$sql = "SELECT name, age, diabetesType, firstName, lastName, sex, birthdate FROM Account
        WHERE accountID = '$userid'";
$result = mysqli_query($conn, $sql);

if ($result) {
    if ($row = mysqli_fetch_assoc($result)) {
        $username = $row['name'];
        $age = $row['age'];
        $diabetesType = $row['diabetesType'];
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $sex = $row['sex'];
        $birthdate = $row['birthdate'];
    } else {
        // Handle case when no rows are found
        $username = "N/A";
        $age = "N/A";
        $diabetesType = "N/A";
        $firstName = "N/A";
        $lastName = "N/A";
        $sex = "N/A";
        $birthdate = "N/A";
    }
}
?>
<script src="a-profile.js"></script>
    <script>
        function enableEdit() {
            document.getElementById("diabetesType").removeAttribute("disabled");
            document.getElementById("firstName").readOnly = false;
            document.getElementById("lastName").readOnly = false;
            document.getElementById("sex").readOnly = false;
            document.getElementById("birthdate").readOnly = false;
            document.getElementById("updateBtn").style.display = "block";
        }
    </script>
</body>
</html>
