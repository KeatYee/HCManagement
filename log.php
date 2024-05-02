<?php
session_start(); // Start the session
include 'DBconnect.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['ssn'])) {
    echo "<script> alert('You need to log in to access the report page.');";
    echo "window.location.replace('login.php');</script>";
    exit(); //redirect user to login page
}

// Retrieve user information from the session
$ssn = $_SESSION['ssn'];
$email = $_SESSION['email'];
$password = $_SESSION['password']; 


// Fetch Blood Pressure data
$sqlBS =  "SELECT * FROM Records r 
    INNER JOIN BloodSugar s ON r.recordID = s.recordID
    WHERE ssn = '$ssn'";
$resultBS = mysqli_query($conn, $sqlBS);

// Fetch Blood Pressure data
$sqlBP =  "SELECT * FROM Records r 
    INNER JOIN BloodPressure p ON r.recordID = p.recordID
    WHERE ssn = '$ssn'";
$resultBP = mysqli_query($conn, $sqlBP);

// Fetch Body Weight data
$sqlWeight = "SELECT * FROM Records r 
              INNER JOIN BodyWeight w ON r.recordID = w.recordID
              WHERE ssn = '$ssn'";
$resultWeight = mysqli_query($conn, $sqlWeight);

// Fetch Meal data
$sqlMeal = "SELECT * FROM Records r 
            INNER JOIN Meal m ON r.recordID = m.recordID
            WHERE ssn = '$ssn'";
$resultMeal = mysqli_query($conn, $sqlMeal);

// Fetch Insulin Dose data
$sqlInsulin =  "SELECT * FROM Records r 
                INNER JOIN InsulinDose d ON r.recordID = d.recordID
                WHERE ssn = '$ssn'";
$resultInsulin = mysqli_query($conn, $sqlInsulin);

// Fetch medication intake data
$sqlMed =  "SELECT * FROM Records r 
            INNER JOIN MedicationIntake m ON r.recordID = m.recordID
            INNER JOIN Medicine med ON m.medID = med.medID
            WHERE r.ssn = '$ssn'";
$resultMed = mysqli_query($conn, $sqlMed);
?>
<!DOCTYPE html>
<html>
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="log.css" rel="stylesheet">
  <!--Include Google Fonts - Quicksand-->
  <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
  <!--Font Awesome Icons-->
  <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <!--jsPDF Library-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
</head>
<body>
<div class="close-icon">
    <a href="report.php"><i class='bx bx-arrow-back'></i></a>
</div>
<div id="makepdf">    

<h2>Blood Sugar</h2>
<?php if (mysqli_num_rows($resultBP) > 0): ?>
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>    
            <th>Value</th>
            <th>Timing</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultBS)): ?>
        <tr>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['value']; ?></td>
            <td><?php echo $row['timing']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No blood sugar data available.</p>
<?php endif; ?>

<h2>Blood Pressure</h2>
<?php if (mysqli_num_rows($resultBP) > 0): ?>
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>    
            <th>Systolic</th>
            <th>Diastolic</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultBP)): ?>
        <tr>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['systolic']; ?></td>
            <td><?php echo $row['diastolic']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No blood pressure data available.</p>
<?php endif; ?>

<h2>Body Weight</h2>
<?php if (mysqli_num_rows($resultWeight) > 0): ?>
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>      
            <th>Weight Value</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultWeight)): ?>
        <tr>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['weightValue']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No body weight data available.</p>
<?php endif; ?>

<h2>Meal</h2>
<?php if (mysqli_num_rows($resultMeal) > 0): ?>
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th> 
            <th>Meal Type</th>
            <th>Food Item</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultMeal)): ?>
        <tr>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['mealType']; ?></td>
            <td><?php echo $row['foodItem']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No meal data available.</p>
<?php endif; ?>

<h2>Insulin Dose</h2>
<?php if (mysqli_num_rows($resultInsulin) > 0): ?>
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th> 
            <th>Dosage</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultInsulin)): ?>
        <tr>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['dosage']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No insulin dose data available.</p>
<?php endif; ?>

<h2>Medication Intake</h2>
<?php if (mysqli_num_rows($resultMed) > 0): ?>
    <table class="viewTable">
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Medicine</th>
            <th>Dosage</th>
            <th>Unit</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultMed)): ?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['time']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['dosage']; ?></td>
                <td><?php echo $row['unit']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No medication intake data available.</p>
<?php endif; ?>


</div>

<div class="btnContainer">
  <button class=btnPdf id="generate-pdf">Generate PDF</button>
</div>
<script>
    
  let button = document.getElementById("generate-pdf");
    button.addEventListener("click", function () {
        let doc = new jsPDF("p", "mm", [300, 300]);
        let makePDF = document.querySelector("#makepdf");
 
        // Calculate vertical offset based on font size and number of lines
        let size = 12; // Adjust as needed
        let lines = makePDF.innerText.split('\n');
        let verticalOffset = size / 72; // Initial offset
        verticalOffset += (lines.length + 2.5) * size / 72; // Adjusted offset

        // fromHTML Method
        doc.fromHTML(makePDF, 15, verticalOffset);
        doc.save("diacare_historical_data.pdf");
    });

</script>
</body> 
</html>