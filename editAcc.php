<?php
session_start();// Start session
include 'DBconnect.php'; // Include database connection
  
// Retrieve user information from the session
   $ssn = $_SESSION['ssn'];
   $email = $_SESSION['email'];
   $password = $_SESSION['password']; 


if (isset($_POST['submitName'])) {
    $newName = $_POST['newName'];

    // Update the name in the database
    $sql = "UPDATE users SET name = '$newName' WHERE ssn = '$ssn'";
    $result = mysqli_query($conn, $sql);

    // Handle the result of the update operation
    if ($result) {
        echo "<script>";
        echo "alert('Name updated successfully!');";
        echo "window.location.href = 'profile.php';"; 
        echo "</script>";
    } else {
        echo "Error updating name: " . mysqli_error($conn);
    }
}

if (isset($_POST['submitBd'])) {
    $newBirthdate = $_POST['newBirthdate'];

    // Update the name in the database
    $sql = "UPDATE users SET birthdate = '$newBirthdate' WHERE ssn = '$ssn'";
    $result = mysqli_query($conn, $sql);

    // Handle the result of the update operation
    if ($result) {
        echo "<script>";
        echo "alert('Birthdate updated successfully!');";
        echo "window.location.href = 'profile.php';"; 
        echo "</script>";
    } else {
        echo "Error updating birthdate: " . mysqli_error($conn);
    }
}

if (isset($_POST['submitSex'])) {
    $newSex = $_POST['newSex'];

    // Update the name in the database
    $sql = "UPDATE users SET sex = '$newSex' WHERE ssn = '$ssn'";
    $result = mysqli_query($conn, $sql);

    // Handle the result of the update operation
    if ($result) {
        echo "<script>";
        echo "alert('Sex updated successfully!');";
        echo "window.location.href = 'profile.php';"; 
        echo "</script>";
    } else {
        echo "Error updating sex: " . mysqli_error($conn);
    }
}

if (isset($_POST['submitDT'])) {
    $newDiabetesType = $_POST['newDiabetesType'];

    // Update the name in the database
    $sql = "UPDATE users SET diabetesType = '$newDiabetesType' WHERE ssn = '$ssn'";
    $result = mysqli_query($conn, $sql);

    // Handle the result of the update operation
    if ($result) {
        echo "<script>";
        echo "alert('Diabetes type updated successfully!');";
        echo "window.location.href = 'profile.php';"; 
        echo "</script>";
    } else {
        echo "Error updating diabetes type: " . mysqli_error($conn);
    }
}

if (isset($_POST['submitPic'])) {
    // Check if a file was uploaded
    if (!empty($_FILES['file']['name'])) {
        $MY_FILE = $_FILES['file']['tmp_name'];
        // To open the file and store its contents in $file_contents
        $file = fopen($MY_FILE, 'r');
        $file_contents = fread($file, filesize($MY_FILE));
        fclose($file);
    
        // escape some stcharacters that might appear in  file_contents
        $file_contents = addslashes($file_contents);
    
        // Update the name in the database
        $sql = "UPDATE users SET profilePic = '$file_contents' 
                WHERE ssn = '$ssn'";
        $result = mysqli_query($conn, $sql);
    
        // Handle the result of the update operation
        if ($result) {
            echo "<script>";
            echo "alert('Profile added successfully!');";
            echo "window.location.href = 'profile.php';"; 
            echo "</script>";
        } 
        else {
            echo "Error updating profile picture: " . mysqli_error($conn);
        }

      
    }
    else{
        $error = "Please upload a picture for profile";
    }
    
}

if (isset($_POST['deletePic'])) {

    // Update the name in the database
    $sql = "UPDATE Users SET profilePic = NULL WHERE ssn = '$ssn'";
    $result = mysqli_query($conn, $sql);

    // Handle the result of the update operation
    if ($result) {
        echo "<script>";
        echo "alert('Profile removed successfully!');";
        echo "window.location.href = 'profile.php';"; 
        echo "</script>";
    } else {
        echo "Error removing profile type: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>