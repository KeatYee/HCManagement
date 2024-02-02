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
	
	$sql = "SELECT name, age FROM Users
			WHERE ssn = '$ssn'";
	$result = mysqli_query($conn, $sql);
	
	if ($result) {
		if ($row = mysqli_fetch_assoc($result)) {
			$username = $row['name'];
			$age = $row['age'];
		} 
		else {
			// Handle case when no rows are found
			$username = "N/A";
			$age = "N/A";
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
<title>Food Help Centre</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Food Bank Website</title>
<link href="a-profile.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<!--Font Awesome link [for icon]-->
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
<!--import the font "Lato" from the Google Fonts service-->

</head>
<body>
<!--top nav bar-->
<div class="menu">
	<img src="Img/Logo header.png"alt="logo">
	<p id="logoTitle">Food Help Centre</p>
     <ul>
        <li><a href="a-homepage.php">Home</a></li>
		<li><a href="a-about.html">About</a></li>
        <li>
		<a href="#">Services</a>
		<div class="dropDown">
		<a href="a-foodbankInfo.php">Food Bank</a>
		<a href="a-request.php">Requests</a>
		</div>
		</li>	
        <li><a href="a-contact.php">Contact</a></li>
		<li style="margin-right:0;"><a href="a-login.php">Login</a></li>
		<li style="margin-right:0;"><a href="a-profile.php">
		<i class="fas fa-user-circle" style="font-size:23px;"></i></a>
		</li>

     </ul>
</div>
<div class="container">

<!-- Side Navigation Bar -->
    <div class="sidebar">
        <a href="?action=acc">My Profile</a>
        <a href="?action=req">Request History</a>
		<div class="btn">
		<button id='deleteButton'><i class='fas fa-trash-alt'>&nbsp </i>Delete Account</button>
		<button id='logoutButton'><i class='fas fa-sign-out-alt'>&nbsp </i>Logout</button>
		</div>
    </div>

<div class="content">	
<!--Pop-up Edit form--> 
<div id="editFormContainer" class="edit-form-container">
    <div class="edit-form-content">
		<h2>Update Personal Details</h2>
		<!--multiplication sign as close button-->
        <span class="close" id="closeEditForm">&times;</span>
        <form action="a-editAcc.php" method="post" id="editForm">
            <!-- Edit form fields -->
			<label for="name"><b>Name</b></label>
            <input type="text" name="newUsername" placeholder="Enter your name" value="<?=$username?>">
			<label for="age"><b>Age</b></label>
            <input type="number" name="newAge" placeholder="Enter your age" value="<?=$age?>" oninput="quantityZero(event)">
			<h2>Change your password</h2>
			<label for="password"><b>Password</b></label>
            <input type="text" name="newPw" placeholder="Enter your password" value="<?=$password?>">
			<div class="update">
            <button name="submit" id="updateBtn" type="submit"><strong>SAVE CHANGES</strong></button>
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
    echo "<label for='userid'><strong>User ID</strong></label><br> <input type='text' id='userid' value='$userid' readonly><br>";
    echo "<label for='email'><strong>Email</strong></label><br> <input type='email' id='email' value='$email' readonly><br>";
    echo "<label for='password'><strong>Password</strong></label><br> <input type='password' id='password' value='$password' readonly><br>";
    echo "<label for='username'><strong>Username</strong></label><br> <input type='text' id='username' value='$username' readonly>";
    echo "<label for='age'><strong>Age</strong></label><br> <input type='number' id='age' value='$age' readonly><br>";
    echo "</form>";
    echo "<button id='editButton'><i class='fas fa-edit'>&nbsp</i>Edit</button>";
    echo "</div>";
    break;


//for request history 
case 'req' : 
	
	echo "<h2>Request History</h2>";
    $userid = $_SESSION['userid'];
	
	// Fetch and display user's donation history from the database
    $sql = "SELECT * FROM foodDonation WHERE accountID = '$userid'";
    $result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
        echo "<table class='reqTable'>";
		 echo "<tr>
                <th>Date</th>
                <th>Time</th>
                <th>Contact Number</th>
                <th>Address</th>
                <th>Status</th>
				<th>View</th>
              </tr>";
		
		
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . date('g:i a',strtotime($row['time'])) . "</td>";
            echo "<td>" . $row['contactNum'] . "</td>";
            echo "<td>" . $row['address'] . ", " . $row['city'] . ", " . $row['postcode'] . ", " . $row['state'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
			echo "<td><a href='?action=viewfood&id=". $row['foodDonationID']."'>&nbsp;&nbsp;<i class='fas fa-info-circle' style='color:#252525'></i></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } 
	else {
        echo "No donation history found.";
    }
    
    break;

case 'viewfood':
    if(isset($_GET['id'])){
        $donationID=$_GET['id'];
    }
    $sql="SELECT b.name, a.quantity 
          FROM fooddonationitem a, fooditem b
          WHERE a.foodItemID=b.foodItemID
          AND foodDonationID='$donationID'";
    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
        echo "<div id='foodFormContainer' class='food-form-container'>";
        echo "    <div class='food-form-content'>";
        echo "        <h2>Food Donation Details</h2>";
        echo "        <!--multiplication sign as close button-->";
        echo "        <span class='close' id='closeEditForm'>&times;</span>";
        echo "        <table class='reqTable'>";
        echo "        <tr>
                          <th>Name</th>
                          <th>Quantity</th>
                      </tr>";
        while($row=mysqli_fetch_assoc($result)){
            echo "    <tr>";
            echo "        <td>" . $row['name'] . "</td>";
            echo "        <td>" . $row['quantity'] . "</td>";
            echo "    </tr>";
        }
        echo "        </table>";
        echo "        <button id='returnBtn' onclick='window.location.href= `?action=req`'>RETURN</button>";
        echo "    </div>";
        echo "</div>";

    }
    else{
        echo "No food item history";
    }
    
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

<script src="a-profile.js"></script>
</body>
</html>

