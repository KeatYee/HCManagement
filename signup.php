<?php
 session_start();// Start session 
 include 'DBconnect.php'; // Include database connection
 //initialization
 $email="";
 $pass="";
 
 
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
            $pass=$_POST['password'];
        }
        else{
            $passerror= "Password at least 8-12 with a uppercase, 
                  lowercase, number and special character!";//Alert message red
		}		  
    }
    else{
        $passerror= "Password is required";
	}
	
	if(!empty($email) && !empty($pass)){
		
        $sql="SELECT * FROM Users WHERE email='$email'";
        $result=mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);

        if($count > 0) {
            $errormsg="Email is already used";
            $email="";
        }
		else {
            $code=rand(1,9999);
            $ssn="U".$code;
            $sql="INSERT INTO Users(ssn,email,password)
			      VALUES('$ssn','$email','$pass')";
            $result=mysqli_query($conn,$sql);

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
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Food Bank Website</title>
<link href="signup.css" rel="stylesheet">
<!--Include the font "Lato" from the Google Fonts service-->
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
<!--Font Awesome link [for icon]-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>

<!--top nav bar-->
<div class="menu">
    <div class="logo_area">
        <a href="#"><img class="logo" src="Img/logo.png"></a>
    </div>

	<div class="inner_menu">
        <ul>
            <li><a href="calendar.php">Calendar</a></li>
            <li><a href="#">Account</a></li>
            <li><a href="#">Record</a></li>
            <li><a href="#">Report</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Feedback</a></li>
        </ul>
    </div>
    
</div>

<!--Sign up form-->
<div class="signUpForm">

    <h1 id="title">Create An Account</h1>
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
        
        <button type="submit" name="submit" id="signUpBtn">Sign Up</button>
		
		<?php if(!empty($errormsg)){?>
		<p class="error"><?php echo "$errormsg";}?></p>
		
			<hr>
			<div class="login">
				<p>Already have an account? <a href="login.php">Log In.</a></p>
		</div>
    </form>
</div>

</body>
</html>
