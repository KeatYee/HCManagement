<?php
session_start(); 
 include 'DBconnect.php'; // Include database connection
 //initialization
 $email="";
 $pass="";
 $name="";
 
if(isset($_POST['submit'])){ //Validate submit
	if(!empty($_POST['email'])){
        if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){ //Validate email
            $email=$_POST['email'];
			
		}	
    else{
            $emailerror= "Email format is incorrect!";//Alert message red
		}
  }
  else{
        $emailerror= "Email is required";
	}
	
	if(!empty($_POST['password'])){
		
    $pattern='/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#%&])[0-9A-Za-z!@#$%&]{8,12}$/'; //(?=.*[A-Za-z]) means at least one A-Za-z, 
                                                                                   //!@#$%& as special character, {8,12} 8-12character
    if(preg_match($pattern,$_POST['password'])){ //Validate password
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);// Password hashing

    }
    else{
      $passerror= "Password at least 8-12 with a uppercase, 
                  lowercase, number and special character!";//Alert message red
		}		  
  }
  else{
    $passerror= "Password is required";
	}
	
    if(!empty($_POST['username'])){
            
        $pattern='/^[a-zA-Z0-9]{5,}$/'; // for english chars + numbers only
                                        // valid username, alphanumeric & longer than or equals 5 chars
                                                                                  
        if(preg_match($pattern,$_POST['username'])) {//Validate username    
            $name=$_POST['username'];
        }
        else{
            $nameerror= "Username at least 5 characters long and alphanumeric";//Alert message red
        }
    }
    else{	
        $nameerror= "Username is required";
    }

	if(!empty($email) && !empty($pass) && !empty($name)){
		
        $sql="SELECT * FROM Users WHERE email='$email'";
        $result=mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);

        if($count > 0) {
            $emailerror="Email is already used";
            $email="";
  }
	else {
            $code=rand(1,9999);
            $ssn="U".$code;
            $role = "user";
            $sql="INSERT INTO Users(ssn,name,email,password,role)
			      VALUES('$ssn','$name','$email','$pass','$role')";
            $result=mysqli_query($conn,$sql);
			
		     // Set a session variable to indicate successful signup
             $_SESSION['signupSuccess'] = true;

			// Redirect to the login page after showing the SweetAlert
			header("Location:login.php");
            exit();

        }
		
		
  }
	
    
}	
 
// Close the database connection
mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="signup.css" rel="stylesheet">
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

<div class="wrapper">
    <div class="register">
        <form action="signup.php" method="POST">
	    <h2>CREATE NEW ACCOUNT</h2>
	
	    <div class="input-box">
	        <input type="text" placeholder="Username" name="username" value="<?=$name?>">
		    <i class='bx bx-user'></i>
            <?php if(!empty($nameerror)){?>
            <p class="error"><?php echo "$nameerror";}?></p>
	    </div>

	    <div class="input-box">
		    <input type="email" placeholder="Email" name="email" value="<?=$email?>">
	        <i class='bx bx-envelope'></i>
            <?php if(!empty($emailerror)){?>
            <p class="error"><?php echo "$emailerror";}?></p>
	    </div>

	    <div class="input-box">
		    <input type="password" placeholder="Password" name="password" >
		    <i class='bx bx-lock' ></i>
            <?php if(!empty($passerror)){?>
            <p class="error"><?php echo "$passerror";}?></p>
	    </div>

	
	    <button type="submit" class="btn" name="submit">Sign Up</button>
	
	    <div class="login-link">
	        <p>Alraedy have an account? &nbsp <a href="login.php">Login</a></p>
        </div>
	    </form>
    </div>
</div>

  <!--Hamburger-->
  <script src="app.js"></script>
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
