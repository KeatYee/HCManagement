<?php
session_start();// Start session 
include('DBconnect.php'); // Include database connection

// Retrieve admin information from the session
$admin = $_SESSION['admin'];
$role =  $_SESSION['role'];

if(!empty($_GET['ssn'])){
    $ssn=$_GET['ssn'];

  $sql="SELECT * FROM Users WHERE ssn='$ssn'";
  $result=mysqli_query($conn,$sql);

  if($row=mysqli_fetch_assoc($result)){
    $ssn=$row['ssn'];
    $name=$row['name'];
    $email=$row['email'];
    $birthdate=$row['birthdate'];
    $diabetesType=$row['diabetesType'];
    $sex=$row['sex'];
  }
  else{
    echo "User not found!";
  }
    
}

 
if(isset($_POST['submit'])){ 
    $ssn = $_POST['ssn'];
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newBirthdate = $_POST['birthdate'];
    $newDT = $_POST['diabetesType'];
    $newSex = $_POST['sex'];


    // Update the name in the database
    $sql = "UPDATE Users SET name = '$newName', email = '$newEmail',
            birthdate = '$newBirthdate', diabetesType = '$newDT', sex = '$newSex'
            WHERE ssn = '$ssn'";
    $result = mysqli_query($conn, $sql);

    // Handle the result of the update operation
    if ($result) {
        echo "<script>";
        echo "alert('User details updated successfully!');";
        echo "window.location.href = 'admin.php';"; 
        echo "</script>";
    } else {
        echo "Error editing uer: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="adminEditUser.css" rel="stylesheet">
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
      <li><a href="admin.php">Users</a></li>
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
<div class="edit-user-container">
        <h1>Edit User</h1>
        <form action="adminEditUser.php" method="POST">
            <label for="ssn">User ID:</label>
            <input type="text" id="ssn" name="ssn" value="<?php echo $ssn; ?>" readonly>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br>
            <label for="birthdate">Birthdate:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>"><br>
            <label for="diabetesType">Diabetes Type:</label>
            <select id="diabetesType" name="diabetesType">
                <option value="Type 1" <?php if($diabetesType == 'Type 1') echo 'selected'; ?>>Type 1</option>
                <option value="Type 2" <?php if($diabetesType == 'Type 2') echo 'selected'; ?>>Type 2</option>
                <option value="GDM" <?php if($diabetesType == 'GDM') echo 'selected'; ?>>GDM</option>
            </select><br>
            
            <label for="sex">Sex:</label>
            <select id="sex" name="sex">
                <option value="M" <?php if($sex == 'M') echo 'selected'; ?>>Male</option>
                <option value="F" <?php if($sex == 'F') echo 'selected'; ?>>Female</option>
            </select><br>
            <button type="submit" name="submit">Update</button>
        </form>
    </div>

  <!--Hamburger-->
  <script src="app.js"></script>
</body>
</html>