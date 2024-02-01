<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>diaCare</title>  
<link href="feedback.css" rel="stylesheet">
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