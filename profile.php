
<!DOCTYPE html>
<html>
<script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
<link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<head>
   
    <title>User Profile</title>
    <style>
  *{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family: 'Open Sans', sans-serif;
  }
  
  body{
  
  background-color:#F5F5F5;
  /*background-image: url("1261630.jpg");*/
  background-size:cover;
  margin:0;
  margin-top:90px;
  
  }
  
  li{
    list-style:none;
    
  }
  
  li a{
    text-decoration:none;
    color:#7A7A7A;
    font-size:23px;
    font-weight:550;
    font-family: 'Open Sans', sans-serif;
  
  }
  
  a:hover{
    color:#0C479D;
  }
  /*HEADER*/
	header{
    position: fixed;
    z-index: 1000;
	  width:100%;
	  top:0;
	}
	
	.logopic{
	  width:auto;
	  height:auto;
	  margin-left:125px;
	}
	.logopic img{
	  width:75px;
	  height:75px;
	
	}
	
	.navbar{
	  padding:0;
	  height:90px;
	  margin:0;
	  display:flex;
	  align-items:center;
	  justify-content:space-between;
	  background-color:#ffffff;
  }
	.navbar .logo a {
	  margin-right: 855px;
	  font-size:2.0rem;
	  font-weight:800;
    color:#0C479D;
	}
	
	.navbar .content {
	  align-items: center;
	  width:100%;
		display: flex;
		gap: 3rem;
	}
	.loginbtn i{
	margin-left:50px;
	margin-right:100px;
	font-size:35px;
	
	}
	/*Dropdown Menu*/
	.dropbtn {
	  color: black;
	  padding: 16px;
	  font-size: 25px;
	  
	}
	
	.menu-dropdown {
	  position: relative;
	  display: inline-block;
	  z-index: 1000;
    
	}
	
	.dropdown-content {
	  display:none;
	  position:absolute;
	  background-color:#ffcccc 0.8;
	  border:1px dotted black;
    
	 
	
	}
	
	.menu-dropdown:hover .dropdown-content{
		display: block;
	}
	.dropdown-content a {
	  color: black;
	  display:block;
	  padding:20px 10px;
	
	}
	.dropdown-content a:hover{
	color:#a373fb;
	box-shadow: 0px 8px 20px black;}
	
		/*Footer*/
    footer {
      color: #0C479D;
      background-color:#0C479D;
      width: 100%;
      background-color: rgba(0, 0, 0, 0.3);
      text-align: center;
      bottom: 0;
      font-family: "Raleway", sans-serif;
      font-size:23px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 50px;
    }
    
    .footer-content {
      display: flex; 
      flex-wrap: wrap; 
      width: 100%; 
    }
    
    .about,
    .contact,
    .social-media {
      flex:1;
      text-align: left; 
    }
    .about{
    margin-left:50px;
    }	
    .contact{
      margin-left:175px;  
      margin-right:100px;
    }
    .social-media{
    
      margin-left:50px;
      text-align:center;
    }
    .social-icons{
    font-size:30px;	
    text-align:center;
    }	
    footer a {
      text-decoration: none;
      font-family: "Raleway", sans-serif;
      color: #444444;
    }
    
    footer a:hover {
      background-color: white;
      background: transparent;
      color: white;
    }
   

        .profile-container {
            display: flex;
            max-width: 800px;
            margin: 20px auto;
        }

        .profile-picture {
            flex: 1;
            padding: 20px;
            text-align: center;
        }

        .profile-picture img {
            max-width: 100%;
            border-radius: 50%;
        }

        .profile-details {
            flex: 1;
            padding: 20px;
        }

        .profile-details h2 {
            color: #0C479D;
        }

        .profile-details form {
            display: flex;
            flex-direction: column;
        }

        .profile-details label {
            margin-bottom: 8px;
        }

        .profile-details input,
        .profile-details select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .profile-details button {
            padding: 10px;
            background-color: #0C479D;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
 <div class="navbar">
  <div class="logopic"><img src="logo.png";>
  </div>
<div class="logo"><a>DiaCare</a></div>

    <ul class="content">       
		<li><a href="homepage.php">Home</a></li>
    <li><a href="calender.php">Calender</a></li>

		</li>
        <li><a href="Location.php">Record</a></li>
        <li><a href="aboutus.php">Report</a></li>
        <li><a href="feedback.php">Feedback</a></li>
   	</ul>
    <ul class="loginbtn">
      <li><a href="accounttype.php"><i class='bx bx-user'></i></a></li>
    </ul>
	</div>
</header>

    <div class="profile-container">
        <div class="profile-picture">
            <!-- User can upload their picture -->
            <img src="default-profile-image.jpg" alt="Profile Picture">
            <p>User ID: <strong>UserID123</strong></p>
        </div>

        <div class="profile-details">
            <h2>Edit Profile</h2>
            <form action="#" method="post" id="profileForm">
                <label for="diabetesType">Diabetes Type:</label>
                <select name="diabetesType" id="diabetesType">
                    <option value="type1">Type 1</option>
                    <option value="type2">Type 2</option>
                    <option value="gestational">Gestational</option>
                </select>

                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="sex">Sex:</label>
                <input type="text" id="sex" name="sex" required>

                <label for="birthdate">Birthdate:</label>
                <input type="date" id="birthdate" name="birthdate" required>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

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
