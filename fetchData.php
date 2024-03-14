<?php
session_start();
include('DBconnect.php');

// Retrieve user information from the session
$ssn = $_SESSION['ssn'];


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

    //fetch event
    $query_med = "SELECT * FROM medicationReminder 
              ORDER BY medRemID DESC LIMIT 5";
    $result_med = mysqli_query($conn, $query_med);

    $query_appt = "SELECT * FROM Appointment 
              ORDER BY apptID DESC LIMIT 5";
    $result_appt = mysqli_query($conn, $query_appt);

    $query_bs = "SELECT * FROM BSTestingAlert 
              ORDER BY testingID DESC LIMIT 5";
    $result_bs = mysqli_query($conn, $query_bs);


    $output = '';

    if(mysqli_num_rows($result_med) > 0 || mysqli_num_rows($result_appt) > 0 
    || mysqli_num_rows($result_bs) > 0){
      while($row = mysqli_fetch_array($result_med)){
        $output .= '
        <li>
        <a href="#">
        <strong>'.$row["title"].'</strong><br />
        <small><em>'.$row["dosage"].'</em></small>
        </a>
        </li>
      ';
      }

      while($row = mysqli_fetch_array($result_appt)){
        $output .= '
        <li>
        <a href="#">
        <strong>'.$row["title"].'</strong><br />
        <small><em>'.$row["location"].'</em></small>
        </a>
        </li>
      ';
      }

      while($row = mysqli_fetch_array($result_bs)){
        $output .= '
        <li>
        <a href="#">
        <strong>'.$row["title"].'</strong><br />
        <small><em>'.$row["sDate"].'</em></small>
        </a>
        </li>
      ';
      }
    }
    else{
        $output .= '<li><a href="#" class="text-bold text-italic">No Noti Found</a></li>';
    }


    $status_query1 = "SELECT * FROM medicationReminder 
                     WHERE status=0";
    $result_query1 = mysqli_query($conn, $status_query1);
    $count1 = mysqli_num_rows($result_query1);

    $status_query2 = "SELECT * FROM Appointment 
                     WHERE status=0";
    $result_query2 = mysqli_query($conn, $status_query2);
    $count2 = mysqli_num_rows($result_query2);

    $status_query3 = "SELECT * FROM BSTestingAlert 
                     WHERE status=0";
    $result_query3 = mysqli_query($conn, $status_query3);
    $count3 = mysqli_num_rows($result_query3);

    $count = $count1 + $count2 + $count3;

    $data = array(
       'notification' => $output,
       'unseen_notification'  => $count
    );
    echo json_encode($data);
}
?>