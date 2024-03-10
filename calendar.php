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

<div class="sidebar bar-block" style="display:none" id="mySidebar">
  <button class="bar-item btnClose" onclick="closeNav()">Close &times;</button>
  <a href="?action=calendar" class="bar-item">Calendar</a>
  <a href="?action=today" class="bar-item">Today's</a>
  <a href="?action=all" class="bar-item">All Events</a>
</div>
 
<div class="openNav-notif">
  <button id="openNav" class="button btnOpen" onclick="openNav()">
  <i class='bx bxs-right-arrow'></i>
  </button>

  <ul class="nav navbar-nav navbar-right">
     <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="label label-pill label-danger count" style="border-radius:10px;"></span> 
        <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span>
      </a>
      <ul class="dropdown-menu"></ul>
     </li>
  </ul>

</div>

</div>

<div id="main">
<?php

// Handle actions based on selected link
if (isset($_GET['action'])) {
$action = $_GET['action'];
switch ($action) {
  case 'calendar':
  echo"<div class='container'>";
    echo"<div id='calendar'></div>";
  echo"</div>";
  echo"<div class='btn-container'>";
    echo"<a href='addEvent.php'>+</a>";
  echo"</div>";
    break;

  case 'today':
    echo"<h2 style='padding-left: 30px;'>Today's Reminder</h2>";
    $sql = "SELECT mr.*, m.name AS medicine_name, m.description AS medicine_description, m.image AS medicine_image 
    FROM MedicationReminder mr
    JOIN Medicine m ON mr.medID = m.medID
    WHERE DATE(mr.sDate) <= CURDATE() AND DATE(mr.eDate) >= CURDATE() AND ssn = '$ssn'";

$result = mysqli_query($conn, $sql);

if ($result) {
if (mysqli_num_rows($result) > 0) {
    echo '<div style="display: flex; flex-wrap: wrap;">'; // Start flexbox container

    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">'; // Start individual reminder box
        echo "<p><strong>Medication Reminder ID:</strong> " . $row["medRemID"] . "</p>";
        echo "<p><strong>Medication Name:</strong> " . $row["medicine_name"] . "</p>";
        echo "<p><strong>Description:</strong> " . $row["medicine_description"] . "</p>";
        echo "<p><strong>Dosage:</strong> " . $row["dosage"] . "</p>";
        echo "<p><strong>Start Date:</strong> " . $row["sDate"] . "</p>";
        echo "<p><strong>End Date:</strong> " . $row["eDate"] . "</p>";
        echo "<p><strong>Reminder Type:</strong> " . $row["remType"] . "</p>";
        echo '</div>'; // End individual reminder box
    }

    echo '</div>'; // End flexbox container
} else {
    echo "No reminders for today.";
}
} else {
echo "Error: " . mysqli_error($conn);
}

    break;

  case 'all':
    break;

  default:
  // Display a message if the action is not recognized
    echo "Invalid action!";
    break;
}
}
?>

</div>
<script>
function openNav() {
  document.getElementById("main").style.marginLeft = "25%";
  document.getElementById("mySidebar").style.width = "25%";
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("openNav").style.display = 'none';
}
function closeNav() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("openNav").style.display = "inline-block";
}
</script>

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

  <!--Calendar javascript-->
  <script src="calendar.js"></script>

<!--Push Notification-->
<script>

$(document).ready(function(){

// updating the view with notifications using ajax

function load_unseen_notification(view = ''){

 $.ajax({

  url:"fetchData.php",
  method:"POST",
  data:{view:view},
  dataType:"json",
  success:function(data){

   $('.dropdown-menu').html(data.notification);

   if(data.unseen_notification > 0){
    $('.count').html(data.unseen_notification);
   }

  }

 });

}

load_unseen_notification();
// load new notifications

$(document).on('click', '.dropdown-toggle', function(){

$('.count').html('');
load_unseen_notification('yes');

});

setInterval(function(){
  load_unseen_notification();;
}, 5000);

});

</script>
</body>
</html>

