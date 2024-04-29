<?php
session_start();// Start session 
include('DBconnect.php'); // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['superuser'])) {
    echo "<script> alert('You don't have access to this page');";
	echo "window.location.replace('login.php');</script>";
    exit(); //redirect user to login page
}
else{
    // Retrieve admin information from the session
    $superuser = $_SESSION['superuser'];
    $role =  $_SESSION['role'];
    $Superssn = $_SESSION['Superssn'];

    $sql = "SELECT * FROM Users WHERE ssn = '$Superssn'";
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

}


  
if (isset($_POST['submitName'])) {
  $newName = $_POST['newName'];

  // Update the name in the database
  $sql = "UPDATE users SET name = '$newName' WHERE ssn = '$Superssn'";
  $result = mysqli_query($conn, $sql);

  // Handle the result of the update operation
  if ($result) {
      echo "<script>";
      echo "alert('Name updated successfully!');";
      echo "window.location.href = 'superuserProfile.php';"; 
      echo "</script>";
  } else {
      echo "Error updating name: " . mysqli_error($conn);
  }
}

if (isset($_POST['submitBd'])) {
  $newBirthdate = $_POST['newBirthdate'];

  // Update the name in the database
  $sql = "UPDATE users SET birthdate = '$newBirthdate' WHERE ssn = '$Superssn'";
  $result = mysqli_query($conn, $sql);

  // Handle the result of the update operation
  if ($result) {
      echo "<script>";
      echo "alert('Birthdate updated successfully!');";
      echo "window.location.href = 'superuserProfile.php';"; 
      echo "</script>";
  } else {
      echo "Error updating birthdate: " . mysqli_error($conn);
  }
}

if (isset($_POST['submitSex'])) {
  $newSex = $_POST['newSex'];

  // Update the name in the database
  $sql = "UPDATE users SET sex = '$newSex' WHERE ssn = '$Superssn'";
  $result = mysqli_query($conn, $sql);

  // Handle the result of the update operation
  if ($result) {
      echo "<script>";
      echo "alert('Sex updated successfully!');";
      echo "window.location.href = 'superuserProfile.php';"; 
      echo "</script>";
  } else {
      echo "Error updating sex: " . mysqli_error($conn);
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="adminProfile.css" rel="stylesheet">
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
      <li><a href="superuser.php">Admins</a></li>
      <li><a href="logout.php">Quit</a></li>
      <li><a href="superuserProfile.php"><i class='bx bx-user' style="font-size:30px;"></i></a></li>
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
<div class='acc'>
    <h2>Admin Profile</h2>
    <div class='accContainer'>
        <form class='accForm'>
            <label for='email'><strong>Email</strong></label><br> 
            <input type='text' id='email' value='<?php echo $superuser; ?>' readonly onclick="openEditForm('editEmailForm')">
            
            <label for='username'><strong>Username</strong></label><br> 
            <input type='text' id='username' value='<?php echo $name; ?>' readonly onclick="openEditForm('editNameForm')">
            
            <label for='birthdate'><strong>Birthdate</strong></label><br> 
            <input type='text' id='birthdate' value='<?php echo $birthdate; ?>' readonly onclick="openEditForm('editBirthdateForm')">
            
            <label for='sex'><strong>Sex</strong></label><br> 
            <input type='text' id='sex' value='<?php echo $sex; ?>' readonly onclick="openEditForm('editSexForm')">
            
        </form>
    </div>

    <a href="resetPass.php">Reset Password</a>
</div>

<!--Pop-up Edit form--> 
<div id="editEmailForm" class="edit-form-container">
  <div class="edit-form-content">
	<h2>Update Personal Details</h2>
    <span class="close" onclick="closeEditForm('editEmailForm')">&times;</span>
          <p>Email cannot be reset !</p>
      </form>
  </div>
</div>


<div id="editNameForm" class="edit-form-container">
  <div class="edit-form-content">
	<h2>Update Personal Details</h2>
    <span class="close" onclick="closeEditForm('editNameForm')">&times;</span>
      <form action="superuserProfile.php" method="post" id="editForm">
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
      <form action="superuserProfile.php" method="post" id="editForm">
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
      <form action="superuserProfile.php" method="post" id="editForm">
			  <label for="sex"><b>Sex</b></label>
        <input type="radio" name="newSex" value="M" id="sex"><label for="sex">Male</label>
        <input type="radio" name="newSex" value="F" id="sex"><label for="sex">Female</label>
			  <div class="update">
          <button name="submitSex" id="updateBtn" type="submit"><strong>SAVE CHANGES</strong></button>
			  </div>
      </form>
  </div>
</div>

<!--Hamburger-->
<script src="app.js"></script>
<script>
  // Show the edit form pop-up according input
function openEditForm(formId) {
    var editFormContainer = document.getElementById(formId);
    editFormContainer.style.display = "block";
}

// Close button click event listener
function closeEditForm(formId) {
    var editFormContainer = document.getElementById(formId);
    editFormContainer.style.display = "none";
}
</script>
</body>
</html>