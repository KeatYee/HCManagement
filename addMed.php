<?php
session_start();// Start session
include 'DBconnect.php'; // Include database connection
  
// Retrieve user information from the session
   $ssn = $_SESSION['ssn'];
   $email = $_SESSION['email'];
   $password = $_SESSION['password']; 

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    

// Check if an image was uploaded
    if(!empty($_FILES['file']['name'])){
        $MY_FILE = $_FILES['file']['tmp_name'];
        // To open the file and store its contents in $file_contents
        $file = fopen($MY_FILE, 'r');
        $file_contents = fread($file, filesize($MY_FILE));
        fclose($file);
        // escape some stcharacters that might appear in  file_contents
    $file_contents = addslashes($file_contents);

    }
    else{

    }


    

    // Update the name in the database
    $sql = "INSERT INTO Medicine (name,description,image)
    VALUES('$name','$desc','$file_contents')";
    $result = mysqli_query($conn, $sql);

    // Handle the result of the update operation
    if ($result) {
        echo "<script>";
        echo "alert('Medicine added successfully!');";
        echo "window.location.href = 'profile.php';"; 
        echo "</script>";
    } else {
        echo "Error updating medicine: " . mysqli_error($conn);
    }


}



?>