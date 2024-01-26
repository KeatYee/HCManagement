<?php 
session_start();
include('DBconnect.php');
$fetch_event = mysqli_query($conn, "SELECT * FROM appointment");

// Retrieve user information from the session
$ssn = $_SESSION['ssn'];

//Validate submit create event form
if(isset($_POST['createBtn'])) {
    $eventType = $_POST['eventType'];
    switch ($eventType) {
        case 'appointment':
            // Validation for appointment
            if (!empty($_POST['title']) && !empty($_POST['eventStartDate']) && !empty($_POST['eventEndDate']) && !empty($_POST['location'])) {
                // Perform database insertion for appointment
                $title = $_POST['title'];
                $startDate = date("Y-m-d\TH:i:s", strtotime($_POST['eventStartDate']));
                $endDate = date("Y-m-d\TH:i:s", strtotime($_POST['eventEndDate']));
                $location = $_POST['location'];

                $sql = "INSERT INTO Appointment(ssn, name, sDate, eDate, location, remType)
                    VALUES('$ssn', '$title', '$startDate', '$endDate', '$location', 'email')";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die('Error: ' . mysqli_error($conn));
                }
                else{
                    // Show success message and redirect
                    echo "<script>alert('Appointment added successfully.');";
                    echo " window.location.replace('calendar.php');</script>";
                    exit(); 
                }

                

            } else {
                // Handle validation error for appointment
                echo "<script>";
                if (empty($_POST['title'])) {
                    echo "alert('Please enter a title.');";
                }
                if (empty($_POST['eventStartDate'])) {
                    echo "alert('Please select a start date.');";
                }
                if (empty($_POST['eventEndDate'])) {
                    echo "alert('Please select an end date.');";
                }
                if (empty($_POST['location'])) {
                    echo "alert('Please enter a location.');";
                }
    echo "</script>";
            }
            break;

        case 'bloodSugarTestingAlert':
            // Validation for blood sugar testing alert
            if (!empty($_POST['date']) && !empty($_POST['time'])) {
                // Perform database insertion for blood sugar testing alert
                $date = $_POST['date'];
                $time = $_POST['time'];

                $sql = "INSERT INTO BSTestingAlert(ssn, date, time, alertType)
                        VALUES('$ssn', '$date', '$time', 'email')";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die('Error: ' . mysqli_error($conn));
                }
                else{
                    // Show success message and redirect
                    echo "<script>alert('Alert added successfully.');";
                    echo " window.location.replace('calendar.php');</script>";
                    exit(); 
                }

            } else {
                // Handle validation error for blood sugar testing alert
                echo "Please fill in all required fields.";
            }
            break;

        case 'medicationReminder':
            // Validation for medication reminder
            if (!empty($_POST['dosage']) && !empty($_POST['date']) && !empty($_POST['time']) && !empty($_POST['medicine'])) {
                // Perform database insertion for medication reminder
                $dosage = $_POST['dosage'];
                $date = $_POST['date'];
                $time = $_POST['time'];
                $medicine = $_POST['medicine'];

                //fetch corresponding medID from Medicine table
				$medQuery = "SELECT medID FROM Medicine 
                             WHERE name = '$medicine'";
                $medResult = mysqli_query($conn,$medQuery);
                $medRow = mysqli_fetch_assoc($medResult);
                $medID = $medRow['medID'];

                $sql = "INSERT INTO MedicationReminder(medID, ssn, dosage, date, time, remType)
                        VALUES('$medID', '$ssn', '$dosage', '$date', '$time', 'email')";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die('Error: ' . mysqli_error($conn));
                }
                else{
                    // Show success message and redirect
                    echo "<script>alert('Reminder added successfully.');";
                    echo " window.location.replace('calendar.php');</script>";
                    exit(); 
                }

                
            } else {
                // Handle validation error for medication reminder
                echo "Please fill in all required fields.";
            }
            break;

        default:
            // Handle unknown event type
            echo "Unknown event type.";
            break;
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>diaCare</title>
    <link href="calendar.css" rel="stylesheet">
    <!--Include Google Fonts - Quicksand-->
    <<link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
    <!--Font Awesome Icons-->
    <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
    <!--Boxicons-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/> 
    <!-- Include FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <!-- Include jQuery, Moment.js, FullCalendar, and Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<!--top nav bar-->
<header>
<div class="navbar">
  <div class="logopic"><img src="Img/logo.png"></div>
  <div class="logo"><a>DiaCare</a></div>

    <ul class="content">       
		<li><a href="homepage.php">Home</a></li>
    <li><a href="calender.php">Calender</a></li>
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
    <h2>Javascript Fullcalendar</h2>
  <div class="container">
   <div id="calendar"></div>
  </div>
  <br>
    
</body>

<script>
 // Function to show JavaScript pop-up form for event creation
 function showPopup() {
        var eventType = $('input[name="eventType"]:checked').val();
        var formHtml = '';
        switch (eventType) {
            case 'appointment':
                formHtml = `
                    <div class="form-group">
                         <input type="hidden" name="eventType" value="appointment">
                    </div>
                    <div class="form-group">
                        <label for="eventTitle">Title:</label>
                        <input type="text" class="form-control" id="eventTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="eventStartDate">Start Date and Time:</label>
                        <input type="datetime-local" name="eventStartDate" required>
                    </div>
                    <div class="form-group">
                        <label for="eventEndDate">End Date and Time:</label>
                        <input type="datetime-local" name="eventEndDate" required>
                    </div>
                    <div class="form-group">
                        <label for="eventLocation">Location:</label>
                        <input type="text" class="form-control" id="eventLocation" name="location" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Create Event" name="createBtn">`;
                break;
            case 'bloodSugarTestingAlert':
                formHtml = `
                     <div class="form-group">
                         <input type="hidden" name="eventType" value="bloodSugarTestingAlert">
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Date:</label>
                        <input type="date" class="form-control" id="eventDate" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="eventTime">Time:</label>
                        <input type="time" class="form-control" id="eventTime" name="time" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Create Event" name="createBtn">`;
                break;
            case 'medicationReminder':
                //PHP code to retrieve medicine options
	            <?php
	            $medOptionsQuery = "SELECT medID, name FROM Medicine";
	            $medOptionsResult = mysqli_query($conn, $medOptionsQuery);

	            $medOptions = array();

	            while ($row = mysqli_fetch_assoc($medOptionsResult)) {
		            $medOptions[$row['medID']] = $row['name'];
            	}
	            ?>
                formHtml = `
                     <div class="form-group">
                         <input type="hidden" name="eventType" value="medicationReminder">
                    </div>
                    <div class="form-group">
                        <label for="eventMed">Medicine:</label>
                        <?php foreach ($medOptions as $medID => $name) { ?>
                        <input type="radio" class="form-control" id="eventMed" name="medicine" value="<?php echo $medID; ?>">
                        <?php echo json_encode($name); ?>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="dosage">Dosage:</label>
                        <input type="number" class="form-control" id="dosage" name="dosage"  min="0.1" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Date:</label>
                        <input type="date" class="form-control" id="eventDate" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="eventTime">Time:</label>
                        <input type="time" class="form-control" id="eventTime" name="time" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Create Event" name="createBtn">`;
                break;
            default:
                break;
        }

        // Create a Bootstrap modal and inject the form HTML
        var modal = $('<div class="modal fade" id="eventModal" role="dialog">\
            <div class="modal-dialog">\
                <div class="modal-content">\
                    <div class="modal-header">\
                        <button type="button" class="close" data-dismiss="modal">&times;</button>\
                        <h4 class="modal-title">Create Event :'+ eventType +'\</h4>\
                    </div>\
                    <div class="modal-body">\
                        <form id="eventForm" method="POST" action="calendar.php">\
                            '+ formHtml +'\
                        </form>\
                    </div>\
                </div>\
            </div>\
        </div>');

        // Show the modal
        modal.modal('show');
    }


    // Document ready function using jQuery
    $(document).ready(function() {
    $('#calendar').fullCalendar({
      selectable: true,
           selectHelper: true,
      select: function(){
                  // Show a Bootstrap modal with radio buttons for event types
                  var eventTypeModal = `
                  <div class="modal fade" id="eventTypeModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Select Event Type</h4>
                                </div>
                                <div class="modal-body">
                                    <label class="radio-inline">
                                        <input type="radio" name="eventType" value="appointment">Appointment
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="eventType" value="bloodSugarTestingAlert">Blood Sugar Testing Alert
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="eventType" value="medicationReminder">Medication Reminder
                                    </label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="showPopup()">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    
                    // Append the event type modal to the body
                    $('body').append(eventTypeModal);

                    // Show the event type modal
                    $('#eventTypeModal').modal('show');
           },
      // Calendar header settings     
      header:{
           left: 'month, agendaWeek, agendaDay, list',
           center: 'title',
           right: 'prev, today, next'
           },
      buttonText:{
           today: 'Today',
           month: 'Month',
           week: 'Week',
           day: 'Day',
           list: 'List'
           },
      // Customize the appearance of the current day     
      dayRender: function(date, cell){
           var today = $.fullCalendar.moment();
              if(date.get('date')==today.get('date')){
                 cell.css("background","#ebced4");
              }
           }, 
      // Events to be displayed on the calendar     
      events:[
        <?php
        while($result = mysqli_fetch_array($fetch_event))
        { ?>
       {
           title: '<?php echo $result['name']; ?>',
           start: '<?php echo $result['date']; ?>',
           end: '<?php echo $result['date']; ?>',
           color: 'yellow',
           textColor: 'black'
        },
     <?php } ?>
            ]
            
 });
 });
 </script>
</html>