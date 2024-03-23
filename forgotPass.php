<?php

// Start session (required for accessing session data)
session_start();
include 'DBconnect.php'; // Include database connection

//initialization
 $email="";
 
 if(isset($_POST['submit'])){ //Validate submit
 
	if(!empty($_POST['email'])){
		
        if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){ //Validate email
            $email=$_POST['email'];
			
			$sql="SELECT * FROM Users WHERE email='$email'";
			$result=mysqli_query($conn,$sql);
			$count=mysqli_num_rows($result);
			
			//check if user is already signed up
			if($count == 0) {
				$emailerror="Email not found. 
				Please check your input or sign up for a new account.";
				$email="";

			}
			else{
				$_SESSION['email'] = $email;
				header("Location:resetPass.php");
				exit();
			}
			
		}	
        else{
            $emailerror= "Email format is incorrect!";//Alert message red
		}
    }
    else{
        $emailerror= "Email is required";
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
  <link href="forgotPass.css" rel="stylesheet">
  <!--Include Google Fonts - Quicksand-->
  <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
  <!--Font Awesome Icons-->
  <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="wrapper">
    <div class="forgotPwForm">
        <form action="forgotPass.php" method="POST">
	    <h2>Forgot your password ?</h2>
		<p id="subtitle">Enter your email address to receive your password reset instructions</p>

	    <div class="input-box">
		    <input type="email" placeholder="Email" name="email" value="<?=$email?>">
	        <i class='bx bx-envelope'></i>
            <?php if(!empty($emailerror)){?>
            <p class="error"><?php echo "$emailerror";}?></p>
	    </div>

	    <button type="submit" class="btn" name="submit">Send</button>
		
		<div class="link">
			<a href="login.php">Back to Login Page</a>
		</div>

	    </form>
    </div>
</div>

</body>
</html>