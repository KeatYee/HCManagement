<!DOCTYPE html>
<html>
<head>
  <link href="homepage.css" rel="stylesheet">
  <!--Include Google Fonts - Quicksand-->
  <<link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
  <!--Font Awesome Icons-->
  <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<!--top nav bar-->
<header>
<div class="navbar">
  <div class="logopic"><img src="Img/logo.png"></div>
  <div class="logo"><a>DiaCare</a></div>

    <ul class="content">       
		<li><a href="homepage.php">Home</a></li>
    <li><a href="calendar.php">Calendar</a></li>
    <li><a href="record.php">Record</a></li>
    <li><a href="report.php">Report</a></li>
    <li><a href="feedback.php">Feedback</a></li>
   	</ul>
    <ul class="loginbtn">
      <li><a href="login.php"><i class='bx bx-user'></i></a></li>
    </ul>
</div>
</header>

<body>
<div class="container">

  <div class="container-con1">
      <h1>Welcome to DiaCare</h1>
      <p>Your Diabetic Journey, Our Priority</p>
	    <form action="userView.php" >
        <button>START RECORD NOW</button>
      </form>
  </div>

  <div class="container-con3">
    <h2>Types of Diabetes</h2>
  </div>

  <div class="container-con2">
    <div class="con1">
        <h2>TYPE 1</h2>
          <p>
          <br>Autoimmune response destroys insulin-producing cells in the pancreas.
          <br><br>Often develops in childhood or adolescence.
          <br><br>Requires insulin injections for survival.
          <br><br>Excessive thirst, frequent urination, unexplained weight loss.
          </p>
    </div>

    <div class="con2">
        <h2>TYPE 2</h2>
          <p>
          <br>Insulin resistance and insufficient insulin production.
          <br><br>Commonly occurs in adulthood, but increasingly seen in youth.
          <br><br>Controlled through diet, exercise, oral medications, and sometimes insulin.
          <br><br>Fatigue, increased thirst, blurred vision, slow wound healing.
          </p>
    </div>

    <div class="con3">
        <h2>Gestational Diabetes</h2>
          <p>
          <br>Develops during pregnancy.
          <br><br>Overweight, family history, older age during pregnancy.
          <br><br>Diet, exercise, and, in some cases, medication.
          <br><br>Increases the risk of type 2 diabetes later in life.
          </p>
    </div>
  </div>


  <div class="container-con4">
    <div class="con1">
        <h2>ABOUT US</h2>
          <p>
          At <b>DiaCare</b>, we believe that managing your health should be a seamless and empowering journey. 
          We've designed a comprehensive health management platform that goes beyond the ordinary. 
          Whether you're navigating diabetes or simply striving for a healthier lifestyle, 
          our user-friendly system puts you in control of your well-being.
          </p>
    </div>

    <div class="con2">
        <img src="Img/bglogin.jpg" alt="about us image">
    </div>
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