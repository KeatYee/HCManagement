<?php
session_start();// Start session 
include('DBconnect.php'); // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['superuser'])) {
    echo "<script> alert('You don't have access to this page');";
	echo "window.location.replace('login.php');</script>";
    exit(); //redirect user to login page
}

// Retrieve admin information from the session
$superuser = $_SESSION['superuser'];
$role =  $_SESSION['role'];
$Superssn = $_SESSION['Superssn'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="superuser.css" rel="stylesheet">
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

<!--Search-->
<?php
// Check if the form 'search' button was clicked
if(isset($_POST['search'])){
    $valueSearch = $_POST['valueSearch'];
    $sql = "SELECT * FROM Users 
            WHERE role='admin'
            AND (`ssn` LIKE '%$valueSearch%'
                OR `name` LIKE '%$valueSearch%'
                OR `birthdate` LIKE '%$valueSearch%'
                OR `diabetesType` LIKE '%$valueSearch%'
                OR `sex` LIKE '%$valueSearch%'
                OR `email` LIKE '%$valueSearch%')";

    $search_result = filterTable($conn,$sql); // Call the function to filter the database table based on the query
}
 else{ // If the search button wasn't clicked, select all records from the table
    $sql = "SELECT * FROM Users
            WHERE role='admin'";
    $search_result = filterTable($conn,$sql);
}

function filterTable($conn,$sql){
	
    // Execute the SQL query and store the results in $filter_Result
    $filter_Result = mysqli_query($conn,$sql);
    
    // Return the results of the query
    return $filter_Result;
}

?>

<div class="search">
<form action="superuser.php" method="post">
<input type="text" name="valueSearch" placeholder="Search">
<button type="submit" name ="search" id="searchBtn"><i class="fa fa-search"></i></button>
<a href="createAdmin.php">Create Admin</a>
</div>

<!--User Details Table-->
<div class="UserDetails">
<table class="viewTable">
    <tr>
        <th>User ID</th> 
        <th>Name</th> 
        <th>Email</th> 
        <th>Birthdate</th> 
        <th>Password</th>
        <th>Gender</th>
        <th>Edit</th> 
        <th>Delete</th>
    </tr>

<?php 
while($row = mysqli_fetch_array($search_result)):
    $ssn=$row['ssn'];
    $name=$row['name'];
    $email=$row['email'];
    $birthdate=$row['birthdate'];
    $diabetesType=$row['diabetesType'];
    $sex=$row['sex'];

?>
    <tr>
        <td><?php echo $ssn?></td> 
        <td><?php echo $name?></td>
        <td><?php echo $email?></td>
        <td><?php echo $birthdate?></td>
        <td><?php echo $diabetesType?></td>
        <td><?php echo $sex?></td> 
        <td><a href="editAdmin.php?ssn=<?=$ssn?>">EDIT</a></td>
        <td><a href="deleteAdmin.php?ssn=<?=$ssn?>">DELETE</a></td>
    </tr>
<?php 

	endwhile;

?>
  </table>
</form>
</div>

<!--Hamburger-->
<script src="app.js"></script>
</body>
</html>