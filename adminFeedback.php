<?php
session_start();// Start session 
include('DBconnect.php'); // Include database connection

// Retrieve admin information from the session
$admin = $_SESSION['admin'];
$role =  $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="admin.css" rel="stylesheet">
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
      <li><a href="adminFeedback.php">Feedback</a></li>
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

<!--Search-->
<?php
// Check if the form 'search' button was clicked
if(isset($_POST['search'])){
    $valueSearch = $_POST['valueSearch'];
    $sql = "SELECT * FROM Feedback 
            WHERE (`ssn` LIKE '%$valueSearch%'
                OR `date` LIKE '%$valueSearch%'
                OR `time` LIKE '%$valueSearch%'
                OR `comment` LIKE '%$valueSearch%'
                OR `email` LIKE '%$valueSearch%')";

    $search_result = filterTable($conn,$sql); // Call the function to filter the database table based on the query
}
 else{ // If the search button wasn't clicked, select all records from the table
    $sql = "SELECT * FROM Feedback";
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
<form action="adminFeedback.php" method="post">
<input type="text" name="valueSearch" placeholder="Search">
<button type="submit" name ="search" id="searchBtn"><i class="fa fa-search"></i></button>
</div>

<!--User Details Table-->
<div class="UserDetails">
<table class="viewTable">
    <tr>
        <th>Feedback ID</th> 
        <th>User ID</th> 
        <th>Date</th> 
        <th>Time</th> 
        <th>Comment</th>
        <th>Email</th>
    </tr>

<?php 
while($row = mysqli_fetch_array($search_result)):
    $feedbackID=$row['feedbackID'];
    $ssn=$row['ssn'];
    $date=$row['date'];
    $time=$row['time'];
    $comment=$row['comment'];
    $email=$row['email'];

?>
    <tr>
        <td><?php echo $feedbackID?></td> 
        <td><?php echo $ssn?></td>
        <td><?php echo $date?></td>
        <td><?php echo $time?></td>
        <td><?php echo $comment?></td>
        <td><?php echo $email?></td> 
      
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