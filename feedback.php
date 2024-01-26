
<!DOCTYPE html>
<html>
<script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
<link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<head>
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
  margin-top:20px;
  
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
	text-decoration:none;
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
	  text-decoration:none;
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
	.navbar .content a{
	 text-decoration:none;
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
   
/*Body*/


        .dropdown-form {
            background-color: #F5F5F5;
            margin-left:23%;
            margin-right:20%;
            margin-top:6%;
            margin-bottom:5%;
            padding: 100px;
            border-radius: 10px;
            box-shadow: 0 0 13px rgba(0, 0, 0, 0.1);
            width:1100px;
            justify-content: center;
            align-items: center;
           
        }

        /* Additional styles for contact info and input fields */
        /* You can customize these styles according to your design */

        .contact-info {
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            text-transform: uppercase;
             font-size: 40px;
            font-family: 'Montserrat', sans-serif;
            text-align: center;
	        margin-top: 40px;
            margin-bottom:1px;
            color: #333333;
        }

        h4 {
            text-transform: uppercase;
             font-size: 25px;
            font-family: 'Montserrat', sans-serif;
            text-align: center;
	        margin-top: 40px;
            margin-bottom:30px;
            color: #333333;
        }
        .contact-info p {
            display: flex;
    font-size:20px;
    font-family: 'Montserrat', sans-serif;
    text-align: center;
    color: #7A7A7A;
    letter-spacing: 0.5em;
    margin-top: 50px;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    padding: 0;
    height: 55px;

        }

        .user-input {
            display: flex;
            flex-direction: column;
        }

        .user-input input,
        .user-input textarea {
            margin-top: 20px;
            margin-bottom: 30px;
            padding:30px 45px 40px 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }



        .btn{
            margin-top:50px;
	border: none;
	width:90%;
	color:#ffffff;
	height:55px;
	background:rgba(255,255,255,0.3);
	border:1px solid rgba(0,0,0,0.5);
	outline:none;
	margin: auto;
	margin-top: 10px;
	border-radius:20px;
	display: flex;
 	align-items: center;
  	justify-content: center;
  	padding: 0;
	box-shadow:0 0 10px rgba(0,0,0,0.1);
	cursor:pointer;
	font-size:20px;
	background-color:#0C479D;
	font-weight:500;
	transition: all 1s;
        }

    .btn:hover{
	border:2px solid 	#125AC2;
	background-color:	#125AC2;
  	color:black;
	
}
	</style>
 </head>
 
 <header>
 <div class="navbar">
  <div class="logopic"><img src="logo.png";>
  </div>
<div class="logo"><a>DiaCare</a></div>

    <ul class="content">       
		<li><a href="homepage.php">Home</a></li>
    <li><a href="calender.php">Calender</a></li>
		    <div class="dropdown-content">
		     <a href="userView.php">View</a>   
		    <a href="userHistory.php">History</a>  
		</div>
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
<body>

    <div class="dropdown-form">
        <div class="contact-info">
            <h2>Contact Us</h2><hr>
            
            <h4>Customer Service Hotline</h4>
            <p>03-90928888</p>
            <h4><b>Email</h4>
            <p>diacare8888@email.com</p>
            <h4>Facebook</h4>
            <p>facebook.com/Diacare</p>
            <h4>Instagram</h4> 
            <p>@Diacare___</p>
            <h4>Twitter</h4> 
            <p>@diacare</p>
        </div>

        <form class="user-input" action="submit_form.php" method="post">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="user_id" placeholder="User ID">
            <input type="email" name="email" placeholder="Email">
            <input type="tel" name="phone" placeholder="Phone Number">
            <textarea name="message" placeholder="Your Message"></textarea>
            <button type="submit" class="btn">Submit</button>
        </form>
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