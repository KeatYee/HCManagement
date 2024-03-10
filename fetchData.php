<?php
session_start();
include('DBconnect.php');

// Retrieve user information from the session
$ssn = $_SESSION['ssn'];


if(isset($_POST['view'])){
    if($_POST["view"] != ''){
       $update_query = "UPDATE medicationReminder 
                        SET status = 1 
                        WHERE status=0 AND ssn = '$ssn'";
       mysqli_query($conn, $update_query);
    }
    $query = "SELECT * FROM medicationReminder 
              ORDER BY comment_id DESC LIMIT 5";
    $result = mysqli_query($conn, $query);
    $output = '';

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_array($result)){
        $output .= '
        <li>
        <a href="#">
        <strong>'.$row["title"].'</strong><br />
        <small><em>'.$row["dosage"].'</em></small>
        </a>
        </li>
      ';
      }
    }
    else{
        $output .= '<li><a href="#" class="text-bold text-italic">No Noti Found</a></li>';
    }
    $status_query = "SELECT * FROM medicationReminder 
                     WHERE status=0";
    $result_query = mysqli_query($conn, $status_query);
    $count = mysqli_num_rows($result_query);
    $data = array(
       'notification' => $output,
       'unseen_notification'  => $count
    );
    echo json_encode($data);
    }
?>