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

if (isset($_SESSION['addSuccess']) && $_SESSION['addSuccess']) {
    // Display SweetAlert message using JavaScript
    echo '<script>';
    echo 'Swal.fire("Congrats!", "Your event is added!", "success");';
    echo '</script>';

    // Unset the session variable
    unset($_SESSION['addSuccess']);
}


$fetch_event1 = mysqli_query($conn, "SELECT * FROM Appointment WHERE ssn = '$ssn'");
$fetch_event2 = mysqli_query($conn, "SELECT * FROM medicationReminder WHERE ssn = '$ssn'");
$fetch_event3 = mysqli_query($conn, "SELECT * FROM bsTestingAlert WHERE ssn = '$ssn'");

// Combine the results of all queries
$combined_events = array();

while ($result = mysqli_fetch_array($fetch_event1)) {
  $combined_events[] = array(
      'id' => $result['apptID'], 
      'title' => $result['title'],
      'start' => date('c', strtotime($result['sDate'])),
      'end' => date('c', strtotime($result['eDate'])),
      'color' => '#f1ffc4',
      'textColor' => 'black',
      'eventType' => 'Appointment',
  );
}

while ($result = mysqli_fetch_array($fetch_event2)) {
  $combined_events[] = array(
      'id' => $result['medRemID'], 
      'title' => $result['title'],
      'start' => date('c', strtotime($result['sDate'])),
      'end' => date('c', strtotime($result['eDate'])),
      'color' => '#a7bed3', 
      'textColor' => 'black', 
      'eventType' => 'medicationReminder', 
  );
}

while ($result = mysqli_fetch_array($fetch_event3)) {
  $combined_events[] = array(
      'id' => $result['testingID'],   
      'title' => $result['title'],
      'start' => date('c', strtotime($result['sDate'])),
      'end' => date('c', strtotime($result['eDate'])),
      'color' => '#ffcaaf', 
      'textColor' => 'black', 
      'eventType' => 'bsTestingAlert',
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> 
    
<!--Javascript Alert for adding event successful-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.all.min.js"></script>

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

<div class="sidebar-notif">

  <!--sidebar link-->
  <div class="sidebar bar-block" style="display:none" id="mySidebar">
    <button class="bar-item-close btnClose" onclick="closeNav()">Close &times;</button>
    <a href="#" class="bar-item bar-item-1"><i class='bx bx-calendar-check'></i>&nbsp Healthcare Appointment</a>
    <a href="#" class="bar-item bar-item-2"><i class='bx bx-injection'></i>&nbsp Blood Sugar Testing</a>
    <a href="#" class="bar-item bar-item-3"><i class='bx bxs-capsule'></i>&nbsp Medication Reminder</a>
  </div>

  <!--sidebar icon-->
  <div class="openNav-notif">
      <button id="openNav" class="button btnOpen" onclick="openNav()">
        <i class='bx bxs-right-arrow'></i>
      </button>

      <!--notification icon-->
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <span class="label label-pill label-danger count" style="border-radius:10px;"></span> 
          <span class="glyphicon glyphicon-bell"></span>
          </a>
          <ul class="dropdown-menu"></ul>
        </li>
      </ul>

  </div>

</div>

<div id="main">
  <div class='container'>
      <div id='calendar'></div>
  </div>
  <div class='addEvent-btn'>
      <a href='addEvent.php'>+</a>
  </div>
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
    selectable: true, // Allows selecting a date/time range
    selectHelper: true, // Renders a placeholder event while dragging
    select: function(start, end, allDay) {
      // Format the selected date range
      var formattedStart = moment(start).format("YYYY-MM-DD HH:mm:ss");
      var formattedEnd = moment(end).format("YYYY-MM-DD HH:mm:ss");

      // Redirect to add event page
      window.location.href = "addEvent.php?start=" + formattedStart + "&end=" + formattedEnd;
    },
    editable: true, // Enables dragging and resizing events
    eventDrop: function(event, delta, revertFunc) {
    // This function is called when an event is dropped

      alert(event.title + " was dropped on " + event.start.format());
        if (!confirm("Are you sure about this change?")) {
          revertFunc();
        }
        else {
          var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
          var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
          var title = event.title;
          var id = event.id;
          var eventType = event.eventType;

          // Send AJAX request to updateEvent.php with event details
          $.ajax({
          url: "updateEvent.php",
          type: "POST",
          data: { title: title, start: start, end: end, id: id, eventType: eventType },
            success: function() {
              alert("Event Updated Successfully");
            }
          });
        }

    },
    eventOverlap: true,
    eventResize: function(event, delta, revertFunc) {
    // This function is called when an event is resized
      alert(event.title + " end is now " + event.end.format());
      if (!confirm("Are you sure about this change?")) {
        revertFunc();
      }
      else {
        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        var title = event.title;
        var id = event.id;
        var eventType = event.eventType;

        // Send AJAX request to updateEvent.php with event details
        $.ajax({
        url: "updateEvent.php",
        type: "POST",
        data: { title: title, start: start, end: end, id: id, eventType: eventType },
          success: function() {
            alert("Event Updated Successfully");
          }
        });

      }
    },
    eventClick: function(event) {
      // This function is called when an event is clicked

      if (confirm("Are you sure you want to remove it?")) {
        var id = event.id;
        var eventType = event.eventType;

        // Send AJAX request to deleteEvent.php with event details
        $.ajax({
          url: "deleteEvent.php",
          type: "POST",
          data: { id: id, eventType: eventType },
          success: function() {
            alert("Event removed successfully");
            window.location.reload();
          }
        });
      }
    }


  });
});
</script> 
<footer>
  <div class="footer-content">

    <div class="about">
      <h3>About diaCare</h3>
      <p style="color:white;">diaCare is a comprehensive web application for people with diabetes or pre-diabetes </p>
    </div>

    <div class="contact">
      <h3>Contact Us</h3>
      <p style="color:white;">Email: diacare888@gmail.com</p>
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

  <!--Calendar javascript-->
  <script src="calendar.js"></script>

  <!--Push Notification-->
  <script src="pushNotif.js"></script>

</body>
</html>

