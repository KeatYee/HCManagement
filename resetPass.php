<?php
session_start();
include 'DBconnect.php';
//initialization
 $newPass = "";
 $conPass = "";
 $passerror = "";
 $errormsg = "";
 $email = "";

if(isset($_SESSION['email'])){
	   $email = $_SESSION['email'];
 
}

if(isset($_SESSION['admin'])){
	$email = $_SESSION['admin'];
 
}

if(isset($_SESSION['superuser'])){
	$email = $_SESSION['superuser'];
 
}


if(isset($_POST['submit'])){ 
	if(!empty($_POST['newPass'])){
        $pattern='/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#%&])[0-9A-Za-z!@#$%&]{8,12}$/'; 
		
		if(preg_match($pattern,$_POST['newPass'])) {

			if(!empty($_POST['conPass'])){
				$newPass = $_POST['newPass'];
                $conPass = $_POST['conPass'];
		
					if($newPass != $conPass) {
						$errormsg="Passwords do not match.";
			
					}
					else{
						$sql_check = "SELECT password FROM Users WHERE email='$email'";
                    	$result_check = mysqli_query($conn, $sql_check);

						if($result_check && mysqli_num_rows($result_check) > 0) {
							$row = mysqli_fetch_assoc($result_check);
                        	$currentPassword = $row['password'];

							// Verify if the new password is different from the current password
							if(!password_verify($newPass, $currentPassword)) {
								//password update
								$hashedNewPass = password_hash($_POST['newPass'], PASSWORD_DEFAULT); //password hashing

                            	$sql_update = "UPDATE Users SET password='$hashedNewPass' WHERE email='$email'";
                            	$result_update = mysqli_query($conn, $sql_update);
								if($result_update) {
									// Unset all session variables
									session_unset();

									// Destroy the session
									session_destroy();

									echo "<script>";
									echo "alert('Password reset successfully. You can now log in with your new password.');";
									echo "window.location.href = 'login.php';"; 
									echo "</script>";
									exit(); // Redirect user to login page
								}
								else {
									// Error updating password in the database
									$errormsg = "Error updating password. Please try again later.";
								}
							}
							else{
								$passerror = "Please enter a new password different from your current one.";

							}
						}
						else{
							$errormsg = "Error retrieving current password. Please try again later.";
						}
					}
			}
			else{
				 $errormsg= "Comfirm password cannot be empty"; //Alert message red
			}
        }
        else{
			
            $passerror= "Password at least 8-12 with a uppercase, 
			lowercase, number and special character!";//Alert message red
		}
	  }
	  else{
        $passerror= "New password is required"; //Alert message red
		
	  }
	  

}


?>

<!DOCTYPE html>
<html>
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="resetPass.css" rel="stylesheet">
  <!--Include Google Fonts - Quicksand-->
  <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
  <!--Font Awesome Icons-->
  <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="wrapper">
	<div class="resetPwForm">
    	<form action="resetPass.php" method="POST">   
		<h2 id="title">Reset Password</h2>
    	<p id="subtitle">Enter your new password here</p>
    	
		<div class="input-box">
		    <input type="password" placeholder="New Password" name="newPass" id="newPass">
		    <i class='bx bx-lock' ></i>
            <?php if(!empty($passerror)){?>
            <p class="error"><?php echo "$passerror";}?></p>
	    </div>

        <div class="input-box">
		    <input type="password" placeholder="Confirm Password" name="conPass" id="conPass">
		    <i class='bx bx-lock' ></i>
            <?php if(!empty($errormsg)){?>
            <p class="error"><?php echo "$errormsg";}?></p>
	    </div>

        <button type="submit" class="btn" name="submit" id="sendBtn">Confirm</button>
        
		<div class="link">
			<a href="login.php">Back to Login Page</a>
		</div>

		</form>
	</div>
</div>
    
</body>
</html>