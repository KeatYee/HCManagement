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

// Get today's date
$today = date("Y-m-d");

//all------------------------------------------------
  $bloodSugarQuery1 = "SELECT r.date, b.value, b.timing 
                    FROM Records r 
                    INNER JOIN BloodSugar b ON r.recordID = b.recordID
                    WHERE r.ssn = '$ssn'";
  $result1 = mysqli_query($conn, $bloodSugarQuery1);

  $afterMealData = array();
  $beforeMealData = array();
  $fastingData = array();

  if($result1){
        // Loop through the fetched data and organize it by timing category
    while ($row = mysqli_fetch_assoc($result1)) {
      $date = $row['date'];
      $value = $row['value'];
      $timing = $row['timing'];

      // Depending on the timing category, add the data to the appropriate array
      if ($timing == 'after_meal') {
        $afterMealData[$date] = $value;
      } elseif ($timing == 'before_meal') {
        $beforeMealData[$date] = $value;
      } elseif ($timing == 'fasting') {
        $fastingData[$date] = $value;
      }
    }
  }

  

//week--------------------------------------------------
  $bloodSugarQuery2 = "SELECT r.date, b.value, b.timing 
                    FROM Records r 
                    INNER JOIN BloodSugar b ON r.recordID = b.recordID
                    WHERE r.date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
  $result2 = mysqli_query($conn, $bloodSugarQuery2);

  $afterMealWeekData = array();
  $beforeMealWeekData = array();
  $fastingWeekData = array();

  if($result2){
    while ($row = mysqli_fetch_assoc($result2)) {
      $date = $row['date'];
      $value = $row['value'];
      $timing = $row['timing'];

      // Depending on the timing category, add the data to the appropriate array
      if ($timing == 'after_meal') {
        $afterMealWeekData[$date] = $value;
      } elseif ($timing == 'before_meal') {
        $beforeMealWeekData[$date] = $value;
      } elseif ($timing == 'fasting') {
        $fastingWeekData[$date] = $value;
      }
    }
  }
//month--------------------------------------------------
// Array of month names
$months = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

// Retrieve the month index from the query parameter or default to the current month
$currentMonthIndex = isset($_GET['month']) ? intval($_GET['month']) : date('n')- 1;
// If the adjusted month index is negative, set it to 11 (December)
if ($currentMonthIndex < 0) {
  $currentMonthIndex = 11;
}
// Get the month name based on the current month index
$currentMonthName = $months[$currentMonthIndex];

function fetchMonthData($currentMonthIndex, $conn, $ssn) {

  $sql = "SELECT r.date, b.value, b.timing 
        FROM Records r 
        LEFT JOIN BloodSugar b ON r.recordID = b.recordID
        WHERE r.ssn = '$ssn' 
        AND MONTH(r.date) = " . ($currentMonthIndex + 1) . "
        AND YEAR(r.date) = YEAR(CURDATE())";


 
  $result = mysqli_query($conn, $sql);
  $monthData = [
      'afterMeal' => [],
      'beforeMeal' => [],
      'fasting' => []
  ];

  if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
          $date = $row['date'];
          $value = $row['value'];
          $timing = $row['timing'];

          // Add the data to the appropriate array
          if ($timing == 'after_meal') {
              $monthData['afterMeal'][$date] = $value;
          } elseif ($timing == 'before_meal') {
              $monthData['beforeMeal'][$date] = $value;
          } elseif ($timing == 'fasting') {
              $monthData['fasting'][$date] = $value;
          }
      }
  }

  // Fill in missing data with null values
  foreach (['afterMeal', 'beforeMeal', 'fasting'] as $category) {
      if (empty($monthData[$category])) {
          $monthData[$category] = [];
      }
  }

  return $monthData;
}


// Call the function passing required parameters
$monthData = fetchMonthData($currentMonthIndex, $conn, $ssn);

//day--------------------------------------------------
  $sql="SELECT r.date, b.value, b.timing 
      FROM Records r 
      INNER JOIN BloodSugar b ON r.recordID = b.recordID
      WHERE r.ssn = '$ssn' 
      AND DATE(r.date) = CURDATE()";
  $result = mysqli_query($conn, $sql);

  $afterMealDayData = array();
  $beforeMealDayData = array();
  $fastingDayData = array();

if($result){
  while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['date'];
    $value = $row['value'];
    $timing = $row['timing'];

    
    if ($timing == 'after_meal') {
      $afterMealDayData[$date] = $value;
    } elseif ($timing == 'before_meal') {
      $beforeMealDayData[$date] = $value;
    } elseif ($timing == 'fasting') {
      $fastingDayData[$date] = $value;
    }
  }
}


//count
$bloodSugarQuery4 = "SELECT r.date, b.value, b.timing 
                    FROM Records r 
                    INNER JOIN BloodSugar b ON r.recordID = b.recordID
                    WHERE r.ssn = '$ssn'";
$result4 = mysqli_query($conn, $bloodSugarQuery4);                    
// Initialize counters for categories
$normalCount = 0;
$lowCount = 0;
$highCount = 0;

// Loop through fetched records and categorize them
while ($row = mysqli_fetch_assoc($result4)) {
  $value = $row['value'];

  if ($value >= 72 && $value <= 99) {
      $normalCount++;
  } elseif ($value < 72) {
      $lowCount++;
  } else {
      $highCount++;
  }
}
//data array for donut 
$dataArray = [
  ['Category', 'Count'],
  ['Normal', $normalCount],
  ['Low', $lowCount],
  ['High', $highCount]
];

//highest n lowest n average
$highestQuery = "SELECT MAX(bs.value) AS highest_value
FROM BloodSugar bs
INNER JOIN Records r ON bs.recordID = r.recordID
WHERE r.ssn = '$ssn'";
$highestResult = mysqli_query($conn, $highestQuery);
$highestRow = mysqli_fetch_assoc($highestResult);
$highestValue = $highestRow['highest_value'];

$lowestQuery = "SELECT MIN(bs.value) AS lowest_value
FROM BloodSugar bs
INNER JOIN Records r ON bs.recordID = r.recordID
WHERE r.ssn = '$ssn'";
$lowestResult = mysqli_query($conn, $lowestQuery);
$lowestRow = mysqli_fetch_assoc($lowestResult);
$lowestValue = $lowestRow['lowest_value'];

$avgQuery = "SELECT AVG(bs.value) AS avg_value
FROM BloodSugar bs
INNER JOIN Records r ON bs.recordID = r.recordID
WHERE r.ssn = '$ssn'";
$avgResult = mysqli_query($conn, $avgQuery);
$avgRow = mysqli_fetch_assoc($avgResult);
$avgValue = number_format($avgRow['avg_value'], 2);

?>
<!DOCTYPE html>
<html>
<head>
<title>diaCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="report.css" rel="stylesheet">
  <!--Include Google Fonts - Quicksand-->
  <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
  <!--Font Awesome Icons-->
  <script src="https://kit.fontawesome.com/410ff7000d.js" crossorigin="anonymous"></script>
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!--jsPDF Library-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
  <!--Google Chart-->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  
  <!--Graph to retrieve month data-->
<script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(function() {
        drawMonthChart(<?php echo json_encode($monthData); ?>);
    });

    function drawMonthChart(monthData) {
     
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'After Meal');
      data.addColumn('number', 'Before Meal');
      data.addColumn('number', 'Fasting');
      data.addColumn('number', 'Target'); // target line

        // Loop through the fetched month data and add it to the chart data
        <?php foreach ($monthData['afterMeal'] as $date => $value) { ?>
            data.addRow([new Date('<?php echo $date ?>'), <?php echo $value ?>, null, null, 90]);
        <?php } ?>
        <?php foreach ($monthData['beforeMeal'] as $date => $value) { ?>
            data.addRow([new Date('<?php echo $date ?>'), null, <?php echo $value ?>, null, 90]);
        <?php } ?>
        <?php foreach ($monthData['fasting'] as $date => $value) { ?>
            data.addRow([new Date('<?php echo $date ?>'), null, null, <?php echo $value ?>, 90]);
        <?php } ?>


      // Set chart options
      var options = {
        title: 'Month',
        curveType: 'function',
        pointSize: 5, // Size of the dots
        legend: { position: 'bottom' },
        series: {
            0: { color: 'red' },    // After Meal
            1: { color: 'green' },  // Before Meal
            2: { color: 'blue' },   // Fasting
            3: { color: 'green',
              lineDashStyle: [4, 4],
              pointSize: 0 }  //target line
        },
        tooltip: { 
          trigger: 'selection' // Only show tooltip on selection, not hover
        }
       
      };
      

      // Instantiate and draw the chart
      var chart = new google.visualization.LineChart(document.getElementById('chart_div1'));
      chart.draw(data, options);
    }

  </script> 
<!--Graph to retrieve all data-->
<script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});
        
     // Set a callback to run when the Google Visualization API is loaded.
   google.charts.setOnLoadCallback(drawAllChart);

    function drawAllChart() {
      // Define the data format
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'After Meal');
      data.addColumn('number', 'Before Meal');
      data.addColumn('number', 'Fasting');
      data.addColumn('number', 'Target'); // target line

       // PHP arrays to hold the data fetched from the database for each timing category
       var bloodSugarData = [
            <?php
            // Output the data in the required format
            foreach ($afterMealData as $date => $value) {
                echo "[new Date('$date'), $value, null, null, 90], ";
            }
            foreach ($beforeMealData as $date => $value) {
                echo "[new Date('$date'), null, $value, null, 90], ";
            }
            foreach ($fastingData as $date => $value) {
                echo "[new Date('$date'), null, null, $value, 90], ";
            }
            ?>
        ];

      // Add data to the DataTable
      data.addRows(bloodSugarData);

      // Set chart options
      var options = {
        title: 'All',
        curveType: 'function',
        pointSize: 5, // Size of the dots
        legend: { position: 'bottom' },
        series: {
            0: { color: 'red' },    // After Meal
            1: { color: 'green' },  // Before Meal
            2: { color: 'blue' },   // Fasting
            3: { color: 'green',
              lineDashStyle: [4, 4],
              pointSize: 0 }  //target line
        },
        tooltip: { 
          trigger: 'selection' // Only show tooltip on selection, not hover
        }
       
      };

      // Instantiate and draw the chart
      var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
      chart.draw(data, options);
    }

  
  </script>
 <!--Graph to retrieve week data-->
 <script type="text/javascript">
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});
        
        // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawWeekChart);
   
       function drawWeekChart() {
         // Define the data format
         var data = new google.visualization.DataTable();
         data.addColumn('date', 'Date');
         data.addColumn('number', 'After Meal');
         data.addColumn('number', 'Before Meal');
         data.addColumn('number', 'Fasting');
         data.addColumn('number', 'Target'); // target line
   
          // PHP arrays to hold the data fetched from the database for each timing category
          var bloodSugarData = [
               <?php
               // Output the data in the required format
               foreach ($afterMealWeekData as $date => $value) {
                   echo "[new Date('$date'), $value, null, null, 90], ";
               }
               foreach ($beforeMealWeekData as $date => $value) {
                   echo "[new Date('$date'), null, $value, null, 90], ";
               }
               foreach ($fastingWeekData as $date => $value) {
                   echo "[new Date('$date'), null, null, $value, 90], ";
               }
               ?>
           ];
   
         // Add data to the DataTable
         data.addRows(bloodSugarData);
   
         // Set chart options
         var options = {
           title: 'Week',
           curveType: 'function',
           pointSize: 5, // Size of the dots
           legend: { position: 'bottom' },
           series: {
               0: { color: 'red' },    // After Meal
               1: { color: 'green' },  // Before Meal
               2: { color: 'blue' },   // Fasting
               3: { color: 'green',
                 lineDashStyle: [4, 4],
                 pointSize: 0 }  //target line
           },
           tooltip: { 
             trigger: 'selection' // Only show tooltip on selection, not hover
           }
          
         };
   
         // Instantiate and draw the chart
         var chart = new google.visualization.LineChart(document.getElementById('chart_div3'));
         chart.draw(data, options);
       }
   
  </script>

<!--Graph to retrieve Day data-->
<script type="text/javascript">
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});
        
        // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawDayChart);
   
       function drawDayChart() {
         // Define the data format
         var data = new google.visualization.DataTable();
         data.addColumn('date', 'Date');
         data.addColumn('number', 'After Meal');
         data.addColumn('number', 'Before Meal');
         data.addColumn('number', 'Fasting');
         data.addColumn('number', 'Target'); // target line
   
          // PHP arrays to hold the data fetched from the database for each timing category
          var bloodSugarData = [
               <?php
               // Output the data in the required format
               foreach ($afterMealDayData as $date => $value) {
                   echo "[new Date('$date'), $value, null, null, 90], ";
               }
               foreach ($beforeMealDayData as $date => $value) {
                   echo "[new Date('$date'), null, $value, null, 90], ";
               }
               foreach ($fastingDayData as $date => $value) {
                   echo "[new Date('$date'), null, null, $value, 90], ";
               }
               ?>
           ];
   
         // Add data to the DataTable
         data.addRows(bloodSugarData);
   
         // Set chart options
         var options = {
           title: 'Day',
           curveType: 'function',
           pointSize: 5, // Size of the dots
           legend: { position: 'bottom' },
           series: {
               0: { color: 'red' },    // After Meal
               1: { color: 'green' },  // Before Meal
               2: { color: 'blue' },   // Fasting
               3: { color: 'green',
                 lineDashStyle: [4, 4],
                 pointSize: 0 }  //target line
           },
           tooltip: { 
             trigger: 'selection' // Only show tooltip on selection, not hover
           }
          
         };
   
         // Instantiate and draw the chart
         var chart = new google.visualization.LineChart(document.getElementById('chart_div4'));
         chart.draw(data, options);
       }
   
  </script>
<!--Donut Graph-->
<script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
       var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataArray); ?>);
      
       var options = {
                pieHole: 0.4,
                legend: 'none',
                colors: ['#4CAF50', '#F44336', '#FFC107']
        };


      var chart = new google.visualization.PieChart(document.getElementById('chart_donut'));
      chart.draw(data, options);
      }

  </script>
     

</head>
<!--top nav bar-->
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
<body>
<div id="makepdf">
  <div class="tab">
    <button class="tablinks active" onclick="openTab(event, 'all')">All</button>
    <button class="tablinks" onclick="openTab(event, 'month')">Month</button>
    <button class="tablinks" onclick="openTab(event, 'week')">Week</button>
    <button class="tablinks" onclick="openTab(event, 'day')">Day</button>
  </div>

  <div id="month" class="tabcontent">
    <div class="monthBtn">
      <button class="previousBtn" onclick="navigateMonth(-1)">Previous Month</button>
      <h2><?php echo $currentMonthName?></h2>
      <button class="nextBtn" onclick="navigateMonth(1)">Next Month</button>
    </div>

    <div id="chart_div1" class="line_graph" ></div>
  </div>

  <div id="all" class="tabcontent">
    <div id="chart_div2" class="line_graph" ></div>
  </div>

  <div id="week" class="tabcontent">
    <div id="chart_div3" class="line_graph" ></div>
  </div>

  <div id="day" class="tabcontent">
    <div id="chart_div4" class="line_graph" ></div>
  </div>

  
  <div class="log">
    <a href="log.php">
      See others historical data
    </a>
  </div>

  <hr>
  <div class="countBS">
    <div id="chart_donut" style="width:500px; height: 500px;"></div>
    <div class="count">

      <h2> <?php echo ($normalCount+ $lowCount+ $highCount)?> Times Tested</h2>
      <div class="title" id="norTitle" data-message="Normal value is between 72 and 99 mg/dL">
        <h3>Normal</h3>
      </div>

      <div class="title" id="loTitle" data-message="Low value is less than 72 mg/dL">
        <h3>Low</h3>
      </div>

      <div class="title" id="hiTitle" data-message="High value is more than 99 mg/dL">
        <h3>High</h3>
      </div>
  
    </div>

    <div class="num">
      <p><?php echo $normalCount?> times</p>
      <p><?php echo $lowCount?> times</p>
      <p><?php echo $highCount?> times</p>
    </div>
  </div>
  <hr>

  <div class="container" id="container">
    <div class="box">
      <h3>Highest</h3>
      <p id="highest"><?php echo $highestValue; ?></p><p>mg/dL</p>
    </div>
    <div class="box">
      <h3>Lowest</h3>
      <p id="lowest"><?php echo $lowestValue; ?></p><p>mg/dL</p>
    </div>
    <div class="box">
      <h3>Average</h3>
      <p id="average"><?php echo $avgValue; ?></p><p>mg/dL</p>
    </div>
  </div>
  <hr>



</div>

<div class="btnContainer">
  <button class=btnPdf id="generate-pdf">Generate PDF</button>
</div>


<!--Hamburger-->
<script src="app.js"></script>
<script>
  let countingStarted = false; // Flag to track whether counting has started

  document.addEventListener('scroll', function() {
    // Get the position of the container element
    const container = document.getElementById('container');
    const containerPosition = container.getBoundingClientRect().top;

    // Check if the container is in the viewport and counting hasn't started yet
    const isInViewport = containerPosition < window.innerHeight && !countingStarted;

    if (isInViewport) {
      startCounting(); // Call your counting function when the container is in the viewport
      countingStarted = true; // Set the flag to indicate that counting has started
    }
  });

  function startCounting() {
    // Get the target values for counting
    const highestValue = <?php echo $highestValue; ?>;
    const lowestValue = <?php echo $lowestValue; ?>;
    const avgValue = <?php echo $avgValue; ?>;
  
   // Call the counting function for each number
    countToValue('highest', highestValue, 2000); 
    countToValue('lowest', lowestValue, 2000);
    countToValue('average', avgValue, 2000); 
  }

  function countToValue(id, targetValue, speed) {
    let currentValue = 0;
    const element = document.getElementById(id);
    const increment = targetValue / (speed / 10); // Calculate the increment based on speed

    const interval = setInterval(function() {
      if (currentValue >= targetValue) {
        clearInterval(interval); // Stop the interval when target value is reached
      }
      else {
        currentValue += increment; // Increment the current value
        element.textContent = currentValue.toFixed(2); // Update the displayed value
      }
    }, 10); // Update every 10 milliseconds
  } 

  function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }

    var tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].classList.remove("active"); // Remove the 'active' class from all tab buttons
    }

    document.getElementById(tabName).style.display = "block";

    // Add the 'active' class to the clicked tab button
    //evt.currentTarget.classList.add("active");

    // If the tab name corresponds to a graph, initialize the chart
    if (tabName === 'month') {
    <?php 
        // Retrieve the month index from the query parameter or default to the current month
        $currentMonthIndex = isset($_GET['month']) ? intval($_GET['month']) : date('n') - 1;
        $monthData = fetchMonthData($currentMonthIndex, $conn, $ssn);
    ?>
    drawMonthChart(<?php echo json_encode($monthData); ?>); 
    } else if (tabName === 'all') {
      drawAllChart(); 
    } else if (tabName === 'week') {
      drawWeekChart();
    } else if (tabName === 'day') {
      drawDayChart();
    }
    
  }


  document.addEventListener('DOMContentLoaded', function() {
    openTab(event, 'all'); // Select the "All" tab by default

  });

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
    doc.save("diacare_report.pdf");
});



  function navigateMonth(delta) {
      // Get the current URL and parse it
      var url = new URL(window.location.href);
      // Get the current month index from the URL query parameter or default to 0
      var currentMonthIndex = parseInt(url.searchParams.get("month")) || 0;
      // Update the month index based on the delta
      currentMonthIndex += delta;
      // Set the new month index as a query parameter in the URL
      url.searchParams.set("month", currentMonthIndex);
      // Reload the page with the updated URL
      window.location.href = url.toString();
  }
      
</script>
</body>
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

</html>
