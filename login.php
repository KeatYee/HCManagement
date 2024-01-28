<?php
session_start();// Start session 
include 'DBconnect.php'; // Include database connection
//initialization
$email="";
$pass="";
$name="";

// Check if the user is already logged in
  if (isset($_SESSION['ssn'])) {
    echo '<script>';
    echo 'if (confirm("You are already logged in. Do you want to log out?")) {';
    echo '   window.location.replace("logout.php");'; // Redirect to logout page
    echo '} else {';
    echo '   window.location.replace("homepage.php");'; 
    echo '}';
    echo '</script>';
    exit();
  }

  if(isset($_POST['submit'])) {//Validate submit
	if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['username'])) {
    
        $email = $_POST['email']; 
        $pass = $_POST['password'];
        $name = $_POST['username'];

        $sql = "SELECT * FROM Users WHERE email='$email'";
        $result = mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);

        if ($count == 1) {
        
           $row = mysqli_fetch_assoc($result);

           if ($_POST['password'] == $row['password']){
			   
			   // Set a session variable to indicate successful login
				$_SESSION['loginSuccess'] = true;
			   
                  $_SESSION['ssn'] = $row['ssn']; 
                  $_SESSION['email'] = $row['email']; 
                  $_SESSION['password'] = $row['password']; 
                  $_SESSION['username'] = $row['name'];
  
                  header("Location:homepage.php");
                  exit();

           }
           else {
             $passerror = "Incorrect password";
           }
        }
        else {
             $errormsg = "Email not found";
        }

    }
    else 
    {
        if(!empty($_POST['email'])){

            if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {//Validate email
                $email=$_POST['email'];
                
            }        
            else{
                $emailerror= "Email format is incorrect!";//Alert message red
            }	
        }
        else   {
            $emailerror= "Email is required";
        }
    
    
    
        if(!empty($_POST['password'])){
            
            $pattern='/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#%$&])[0-9A-Za-z!@#$%&]{8,12}$/'; //(?=.*[A-Za-z]) means at least one A-Za-z, 
                                                                                       //!@#$%& as special character, {8,12} 8-12character
            if(preg_match($pattern,$_POST['password'])) {//Validate password    
                $pass=$_POST['password'];
            }
            else{
                $passerror= "Password at least 8-12 with a uppercase, 
                      lowercase, number and special character!";}//Alert message red
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
                $nameerror= "Username at least 5 characters long and alphanumeric";}//Alert message red
        }
        else{	
            $nameerror= "Username is required";
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
  <link href="login.css" rel="stylesheet">
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
    <div class="login">
        <form action="login.php" method="POST">
	    <h2>LOG IN</h2>
	
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

	    <div class="remember-forgot">
	        <label><input type="checkbox">Remember me</label>
		    <a href="forgotpass.php">Forgot password</a>
	    </div>
	
	    <button type="submit" class="btn" name="submit">Login</button>
	
	    <div class="register-link">
	        <p>Don't have an account? &nbsp <a href="signup.php">Register Now</a></p>
        </div>
	    </form>
    </div>
</div>

<!--Javascript Alert for signing up successful-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.all.min.js"></script>
<?php
if (isset($_SESSION['signupSuccess']) && $_SESSION['signupSuccess']) {
    // Display SweetAlert message using JavaScript
    echo '<script>';
    echo 'Swal.fire("Congrats!", "Your account is created!", "success");';
    echo '</script>';

    // Unset the session variable
    unset($_SESSION['signupSuccess']);
}
?>
			
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

