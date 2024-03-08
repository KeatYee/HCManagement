<?php
$con = mysqli_connect("localhost", "root", "", "notif");

 //check connection
 if (!$con){
    die("Connection failed:".mysqli_connect_error());
}
?>