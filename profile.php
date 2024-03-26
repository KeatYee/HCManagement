
<?php
session_start();// Start session
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

  $sql = "SELECT name, birthdate, sex, diabetesType FROM users WHERE ssn = '$ssn'";
  $result = mysqli_query($conn, $sql);
  

  if ($result) {
      // Fetch the row
      if ($row = mysqli_fetch_assoc($result)) {
          $name = $row['name'];
          $birthdate = $row['birthdate'];
          $sex = $row['sex'];
          $diabetesType = $row['diabetesType'];
          if($sex=="M"){
            $sex="Male";

          }
          else if ($sex=="F"){
            $sex="Female";

          }
      } else {
          // Handle case when no row is found
          $name = "";
          $birthdate = "1970-01-01";
          $sex="";
          $diabetesType="";
      }
  } 
  else {
      // Handle case of query failure
      $name = "";
      $birthdate = "1970-01-01";
      $sex="";
      $diabetesType="";
  }  


?>

<!DOCTYPE html>
<html>
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="profile.css" rel="stylesheet">
  <!--Include Google Fonts - Quicksand-->
  <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
  <!--Font Awesome Icons-->
  <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
</head>
<body>
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
<div class="container">
  <!-- Side Navigation Bar -->
  <div class="sidebar">
        <a href="?action=acc">Profile</a>
        <a href="?action=today">Today</a>
        <a href="?action=med">Medicine</a>
		<div class="btn">
		    <button id='deleteButton'><i class='fas fa-trash-alt'>&nbsp </i>Delete Account</button>
		    <button id='logoutButton'><i class='fas fa-sign-out-alt'>&nbsp </i>Logout</button>
		</div>
  </div>

<div class="content">	
<!--Pop-up Edit form--> 

<div id="editNameForm" class="edit-form-container">
  <div class="edit-form-content">
	<h2>Update Personal Details</h2>
    <span class="close" onclick="closeEditForm('editNameForm')">&times;</span>
      <form action="editAcc.php" method="post" id="editForm">
			  <label for="name"><b>Name</b></label>
        <input type="text" name="newName" placeholder="Enter your name" value="<?=$name?>" id="name">
			  <div class="update">
          <button name="submitName" id="updateBtn" type="submit"><strong>SAVE CHANGES</strong></button>
			  </div>
      </form>
  </div>
</div>

<div id="editBirthdateForm" class="edit-form-container">
  <div class="edit-form-content">
	<h2>Update Personal Details</h2>
    <span class="close" onclick="closeEditForm('editBirthdateForm')">&times;</span>
      <form action="editAcc.php" method="post" id="editForm">
			  <label for="birthdate"><b>Birthdate</b></label>
        <input type="date" name="newBirthdate" value="<?=$birthdate?>" id="birthdate">
			  <div class="update">
          <button name="submitBd" id="updateBtn" type="submit"><strong>SAVE CHANGES</strong></button>
			  </div>
      </form>
  </div>
</div>

<div id="editSexForm" class="edit-form-container">
  <div class="edit-form-content">
	<h2>Update Personal Details</h2>
    <span class="close" onclick="closeEditForm('editSexForm')">&times;</span>
      <form action="editAcc.php" method="post" id="editForm">
			  <label for="sex"><b>Sex</b></label>
        <input type="radio" name="newSex" value="M" id="sex"><label for="sex">Male</label>
        <input type="radio" name="newSex" value="F" id="sex"><label for="sex">Female</label>
			  <div class="update">
          <button name="submitSex" id="updateBtn" type="submit"><strong>SAVE CHANGES</strong></button>
			  </div>
      </form>
  </div>
</div>

<div id="editDiabetesForm" class="edit-form-container">
  <div class="edit-form-content">
	<h2>Update Personal Details</h2>
    <span class="close" onclick="closeEditForm('editDiabetesForm')">&times;</span>
      <form action="editAcc.php" method="post" id="editForm">
			  <label for="diabetesType"><b>Diabetes Type</b></label>
        <input type="radio" name="newDiabetesType" value="Type 1" id="diabetesType"><label for="diabetesType">Type 1</label>
        <input type="radio" name="newDiabetesType" value="Type 2" id="diabetesType"><label for="diabetesType">Type 2</label>
        <input type="radio" name="newDiabetesType" value="GDM" id="diabetesType"><label for="diabetesType">GDM</label>
			  <div class="update">
          <button name="submitDT" id="updateBtn" type="submit"><strong>SAVE CHANGES</strong></button>
			  </div>
      </form>
  </div>
</div>

<div id="addMedForm" class="edit-form-container">
  <div class="edit-form-content">
	<h2>Add Your Medicine</h2>
    <span class="close" onclick="closeEditForm('addMedForm')">&times;</span>
      <form action="addMed.php" method="post" id="editForm" enctype="multipart/form-data">
			  <label for="medName"><b>Name</b></label>
        <input type="text" name="name" id="medName">
        <label for="medDesc"><b>Description</b></label>
        <input type="text" name="desc" id="medDesc">
        <label for="medPic"><b>Image</b></label>
        <input type="file" name="file" value="" id="medPic">
			  <div class="update">
          <button name="submit" id="updateBtn" type="submit"><strong>ADD</strong></button>
			  </div>
      </form>
  </div>
</div>

  
<!-- user profile -->
<?php

    // Handle actions based on selected link
if (isset($_GET['action'])) {

    $action = $_GET['action'];
	  switch ($action) {
		
		
//for account	
case 'acc':
  echo "<div class='acc'>";
    echo "<h2>Your Detail</h2>";
    echo "<form class='accForm'>";
    
   
    echo "<label for='username'><strong>Username</strong></label><br> 
    <input type='text' id='username' value='$name' readonly onclick=\"openEditForm('editNameForm')\">";

    echo "<label for='birthdate'><strong>Birthdate</strong></label><br> 
    <input type='text' id='birthdate' value='$birthdate' readonly onclick=\"openEditForm('editBirthdateForm')\">";

    echo "<label for='sex'><strong>Sex</strong></label><br> 
    <input type='text' id='sex' value='$sex' readonly onclick=\"openEditForm('editSexForm')\">";
    
    echo "<label for='diabetesType'><strong>Diabetes Type</strong></label><br> 
    <input type='text' id='diabetesType' value='$diabetesType' readonly onclick=\"openEditForm('editDiabetesForm')\">";
   
    echo "</form>";
    echo "</div>";

    break;

case 'today' : 
  echo "Today";
    
    break;

case 'med' : 

  echo "<h2>Medication</h2>";
  echo "<div class='addMedBtn'>";
  echo "<button id='addMedBtn' onclick=\"openEditForm('addMedForm')\">Add</button>";
  echo "</div>";

  echo "<div class='med-container'>";
// Fetch data from the database
$query = "SELECT * FROM Medicine"; // Modify this query according to your database structure
$result = mysqli_query($conn, $query);

// Check if there are any rows in the result
if(mysqli_num_rows($result) > 0) {
    // Loop through each row of data
    while($row = mysqli_fetch_assoc($result)) {
        // Output HTML dynamically using the fetched data
        echo "<div class='med' id='med-" . $row['medID'] . "'>";
        // Check if image data exists
        if(!empty($row['image'])) {
          echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' alt='Medicine Image' style='width: 600;>";
      } 
      else {
          // If no image data, display default image 'med.jpg'
          echo "<img src='Img/defaultMedicine.jpg' alt='Default Medicine Image' width='600' height='400'>";
      }
        echo "<div class='name'>" . $row['name'] . "</div>";
        echo "<div class='desc'>" . $row['description'] . "</div>";
        echo "<button class='deleteBtn' onclick='deleteMedicine(" . $row['medID'] . ")'>Delete</button>";
        echo "</div>";
    }
} else {
    // Output a message if no rows are found in the database
    echo "No data found";
}

  echo "</div>";


      break;

default:
// Display a message if the action is not recognized
       echo "Invalid action!";
       break;
		
	}
}

?>		
	
	
  </div>

</div>

<!--Hamburger-->
<script src="app.js"></script>

<script src="profile.js"></script>
</body>
</html>


