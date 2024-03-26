<?php
session_start();
include('DBconnect.php');

// Retrieve user information from the session
$ssn = $_SESSION['ssn'];

//mark them as seen when user view notification
if(isset($_POST['view'])){
    if($_POST["view"] != ''){

      //update event
       $update_med = "UPDATE medicationReminder 
                        SET status = 1 
                        WHERE status=0 AND ssn = '$ssn'";
       mysqli_query($conn, $update_med);

       $update_appt = "UPDATE Appointment 
                        SET status = 1 
                        WHERE status=0 AND ssn = '$ssn'";
       mysqli_query($conn, $update_appt);

       $update_bs = "UPDATE BSTestingAlert 
                       SET status = 1 
                       WHERE status=0 AND ssn = '$ssn'";
       mysqli_query($conn, $update_bs);

    }

    // Get today's date and time
    $now = date("Y-m-d H:i:s");

   // Fetch today notifications from the combined table
   $query_combined = "
   (SELECT medRemID AS id, title, dosage AS description, 'Medication Reminder' AS type, sDate, eDate 
   FROM MedicationReminder WHERE eDate >= CURDATE())
   UNION
   (SELECT testingID AS id, title, sDate AS description, 'Blood Sugar Testing Alert' AS type, sDate, eDate 
   FROM BSTestingAlert WHERE eDate >= CURDATE())
   UNION
   (SELECT apptID AS id, title, location AS description, 'Appointment' AS type, sDate, eDate 
   FROM Appointment WHERE eDate >= CURDATE())
   ORDER BY sDate DESC";

   $result_combined = mysqli_query($conn, $query_combined);
  // echo $query_combined;


  $output = '';

  if(mysqli_num_rows($result_combined) > 0) {
      while($row = mysqli_fetch_array($result_combined)){
        
          $output .= '
          <li>
              <a href="#">
                  <strong>'.$row["title"].'</strong><br />
                  <small><em>'.$row["description"].'</em></small><br />
              </a>
          </li>
          ';
      }
  }
  else {

      $output .= '
      <li>
        <a href="#" class="text-bold text-italic">No Notifications</a>
       
      </li>';
  }

    // Count unseen notifications
    $query_count = "(SELECT COUNT(*) AS count 
                    FROM medicationReminder WHERE status = 0 AND ssn = '$ssn')
                    UNION
                    (SELECT COUNT(*) AS count 
                    FROM Appointment WHERE status = 0 AND ssn = '$ssn')
                    UNION
                    (SELECT COUNT(*) AS count 
                    FROM BSTestingAlert WHERE status = 0 AND ssn = '$ssn')";
    
    $result_count = mysqli_query($conn, $query_count);
    $count = 0;

    while ($row = mysqli_fetch_array($result_count)) {
        $count += $row['count'];
    }

    $data = array(
       'notification' => $output,
       'unseen_notification'  => $count
    );
    echo json_encode($data);
}
?>