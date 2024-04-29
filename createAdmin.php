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

if(isset($_POST['submit'])){ //Validate submit
	if(!empty($_POST['adminEmail'])){
        if(filter_var($_POST['adminEmail'],FILTER_VALIDATE_EMAIL)){ //Validate email
            $adminEmail=$_POST['adminEmail'];
			
		}	
        else{
            $emailerror= "Email format is incorrect!";//Alert message red
		}
    }
    else{
        $emailerror= "Email is required";
    }
	
	if(!empty($_POST['adminPassword'])){
		
    $pattern='/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#%&])[0-9A-Za-z!@#$%&]{8,12}$/'; //(?=.*[A-Za-z]) means at least one A-Za-z, 
                                                                                   //!@#$%& as special character, {8,12} 8-12character
    if(preg_match($pattern,$_POST['adminPassword'])){ //Validate password
        $adminPassword = password_hash($_POST['adminPassword'], PASSWORD_DEFAULT);// Password hashing

    }
    else{
      $passerror= "Password at least 8-12 with a uppercase, 
                  lowercase, number and special character!";//Alert message red
		}		  
  }
  else{
    $passerror= "Password is required";
	}
	
    if(!empty($_POST['adminName'])){
            
        $pattern='/^[a-zA-Z0-9]{5,}$/'; // for english chars + numbers only
                                        // valid username, alphanumeric & longer than or equals 5 chars
                                                                                  
        if(preg_match($pattern,$_POST['adminName'])) {//Validate username    
            $adminName=$_POST['adminName'];
        }
        else{
            $nameerror= "Username at least 5 characters long and alphanumeric";//Alert message red
        }
    }
    else{	
        $nameerror= "Username is required";
    }

	if(!empty($adminEmail) && !empty($adminPassword) && !empty($adminName)){
		
        $sql="SELECT * FROM Users WHERE email='$adminEmail'";
        $result=mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);

        if($count > 0) {
            $emailerror="Email is already used";
            $adminEmail="";
        }
	    else {
            $code=rand(1,9999);
            $ssn="A".$code;
            $role = "admin";
            $sql="INSERT INTO Users(ssn,name,email,password,role)
			      VALUES('$ssn','$adminName','$adminEmail','$adminPassword','$role')";
            $result=mysqli_query($conn,$sql);

            if($result){
                echo "<script>";
                echo "alert('New admin has created!');";
                echo "window.location.href = 'superuser.php';"; 
                echo "</script>";
            }

        }
		
  }
	
    
}	

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="createAdmin.css" rel="stylesheet">
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

<div class="createAdminForm">
    <form action="createAdmin.php" method="post">
        <input type="text" name="adminName" placeholder="Admin Name">
        <?php if(!empty($nameerror)){?>
            <p class="error"><?php echo "$nameerror";}?></p>

        <input type="email" name="adminEmail" placeholder="Admin Email">
        <?php if(!empty($emailerror)){?>
            <p class="error"><?php echo "$emailerror";}?></p>

        <input type="password" name="adminPassword" placeholder="Password">
        <?php if(!empty($passerror)){?>
            <p class="error"><?php echo "$passerror";}?></p>

        <button type="submit" name="submit">Create</button>
    </form>
</div>


<!--Hamburger-->
<script src="app.js"></script>


</body>
</html>