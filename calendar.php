<?php 
session_start();
include('DBconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['ssn'])) {
    echo "<script> alert('You need to log in to access calendar');";
	echo "window.location.replace('login.php');</script>";
    exit(); //redirect user to login page
}

// Retrieve user information from the session
$ssn = $_SESSION['ssn'];

$fetch_event1 = mysqli_query($conn, "SELECT * FROM Appointment");
$fetch_event2 = mysqli_query($conn, "SELECT * FROM medicationReminder");
$fetch_event3 = mysqli_query($conn, "SELECT * FROM bsTestingAlert");

// Combine the results of all queries
$combined_events = array();

while ($result = mysqli_fetch_array($fetch_event1)) {
  $combined_events[] = array(
      'title' => $result['title'],
      'start' => date('c', strtotime($result['sDate'])),
      'end' => date('c', strtotime($result['eDate'])),
      'color' => '#f1ffc4',
      'textColor' => 'black',
  );
}

while ($result = mysqli_fetch_array($fetch_event2)) {
  $combined_events[] = array(
      'title' => $result['title'],
      'start' => date('c', strtotime($result['sDate'])),
      'end' => date('c', strtotime($result['eDate'])),
      'color' => '#a7bed3', 
      'textColor' => 'black', 
  );
}

while ($result = mysqli_fetch_array($fetch_event3)) {
  $combined_events[] = array(
      'title' => $result['title'],
      'start' => date('c', strtotime($result['sDate'])),
      'end' => date('c', strtotime($result['eDate'])),
      'color' => '#ffcaaf', 
      'textColor' => 'black', 
  );    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>diaCare</title>
    
    <!--Include Google Fonts - Quicksand-->
    <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
    <!--Boxicons-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="calendar.css" rel="stylesheet">

    <!--Font Awesome Icons-->
    <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> 
</head>
<!--top nav bar-->
<header>
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
</header>
<body>
<div class="container">
   <div id="calendar"></div>
</div>
<div class="buttons">
<a href="addEvent.php">
    <button id="addBtn">Add</button>
</a>
</div>

<script>
$(document).ready(function() {

   $('#calendar').fullCalendar({
      header:
      {
           left: 'month, agendaWeek, agendaDay, list',
           center: 'title',
           right: 'prev, today, next'
      },
      buttonText:
      {
           today: 'Today',
           month: 'Month',
           week: 'Week',
           day: 'Day',
           list: 'List'
      },
      events: <?php echo json_encode($combined_events); ?>,
      editable: true, // Enables dragging and resizing events
      eventDrop: function(event) {
    // This function is called when an event is dropped

    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
    var title = event.title;
    var id = event.id;

    // Send AJAX request to update.php with event details
    $.ajax({
        url: "updateEvent.php",
        type: "POST",
        data: { title: title, start: start, end: end, id: id },
        success: function() {
            alert("Event Updated Successfully");
        }
    });
}

    });
});
</script> 


<!--Javascript Alert for adding event successful-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.all.min.js"></script>
<?php
if (isset($_SESSION['addSuccess']) && $_SESSION['addSuccess']) {
    // Display SweetAlert message using JavaScript
    echo '<script>';
    echo 'Swal.fire("Congrats!", "Your event is added!", "success");';
    echo '</script>';

    // Unset the session variable
    unset($_SESSION['addSuccess']);
}
?>

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
  <!--Hamburger-->
  <script src="app.js"></script> 
</body>
</html>