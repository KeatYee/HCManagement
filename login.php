<?php
session_start();// Start session 
include 'DBconnect.php'; // Include database connection
//initialization
$email="";
$pass="";

// Check if the user is already logged in
  if (isset($_SESSION['ssn'])) {
    echo '<script>';
    echo 'if (confirm("You are already logged in. Do you want to log out?")) {';
    echo '   window.location.replace("logout.php");'; // Redirect to logout page
    echo '} else {';
    echo '   window.location.replace("calendar.php");'; 
    echo '}';
    echo '</script>';
    exit();
  }

  if(isset($_POST['submit'])) {//Validate submit
	if(!empty($_POST['email']) && !empty($_POST['password'])) {
    
        $email = $_POST['email']; 
        $pass = $_POST['password'];

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
                  $_SESSION['accountType'] = $row['accountType'];
  
                  header("Location:calendar.php");
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

    }
  }

// Close the database connection
mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>diaCare</title>
</head>
<body>

<!--top nav bar-->
<div class="menu">
	<img src="Img/Logo header.png"alt="logo">
	<p id="logoTitle">diaCare</p>
     <ul>
        <li><a href="calendar.php">Calendar</a></li>
     </ul>
</div>

<!--Login Form-->
<div class="loginForm">

    <h1 id="title">Login to Your Account</h1>
    <p id="subtitle">Join Us in the Fight Against Hunger</p>
    <form action="" method="POST" >
        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Enter your email"
		value="<?=$email?>">
		
		<?php if(!empty($emailerror)){?>
        <p class="error"><?php echo "$emailerror";}?></p>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password"><br>
        
		<?php if(!empty($passerror)){?>
        <p class="error"><?php echo "$passerror";}?></p>
        
        <button type="submit" name="submit" id="logInBtn">Log In</button>
        <a id="forgotPw" href="a-forgotPassword.php">Forgot password?</a><br>
		<?php if(!empty($errormsg)){?>
        <p class="error" style="text-align:center;"><?php echo "$errormsg";}?></p>
			<hr>
			<div class="signUp">
				<p>Don't have an account? <a href="signUp.php">Sign Up.</a></p>
		</div>
    </form>
</div>


</body>
</html>


