<?php
session_start();// Start session 
include('DBconnect.php'); // Include database connection


if(!empty($_GET['ssn'])){
    $ssn=$_GET['ssn'];

  $sql="SELECT * FROM Users WHERE ssn='$ssn'";
  $result=mysqli_query($conn,$sql);

  if($row=mysqli_fetch_assoc($result)){
    $ssn=$row['ssn'];
    $name=$row['name'];
    $email=$row['email'];
    $birthdate=$row['birthdate'];
    $sex=$row['sex'];
  }
  else{
    echo "User not found!";
  }
    
}

 /* superuser edit admin */
if(isset($_POST['submit'])){ 
    $ssn = $_POST['ssn'];
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newBirthdate = $_POST['birthdate'];
    $newSex = $_POST['sex'];


    // Update the name in the database
    $sql = "UPDATE Users SET name = '$newName', email = '$newEmail',
            birthdate = '$newBirthdate', sex = '$newSex'
            WHERE ssn = '$ssn'";
    $result = mysqli_query($conn, $sql);

    // Handle the result of the update operation
    if ($result) {
        echo "<script>";
        echo "alert('Admin details updated successfully!');";
        echo "window.location.href = 'superuser.php';"; 
        echo "</script>";
    } else {
        echo "Error editing admin: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="editAdmin.css" rel="stylesheet">
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
      <li><a href="adminProfile.php"><i class='bx bx-user' style="font-size:30px;"></i></a></li>
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
        <h1>Edit Admin</h1>
        <form action="editAdmin.php" method="POST">
            <label for="ssn">User ID:</label>
            <input type="text" id="ssn" name="ssn" value="<?php echo $ssn; ?>" readonly>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br>
            <label for="birthdate">Birthdate:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>"><br>
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