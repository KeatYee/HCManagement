google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = new google.visualization.DataTable();
  data.addColumn('timeofday', 'Time of Day');
  data.addColumn('number', 'Blood Sugar Level');
  data.addColumn('number', 'Target'); // Add a new column for the target line

// Replace this with your actual blood sugar level data
    var bloodSugarData = [
      [[2, 0, 0], 160, 90],     // Example: 2:00 AM, 160 mg/dL
      [[8, 0, 0], 90, 90],     // Example: 8:00 AM, 90 mg/dL
      [[10, 30, 0], 120, 90],  // Example: 10:30 AM, 120 mg/dL
      [[12, 0, 0], 110, 90],   // Example: 12:00 PM, 110 mg/dL
      // Add more data points as needed
    ];

    data.addRows(bloodSugarData);

    var options = {
      title: 'Blood Sugar Level Throughout the Day',
      curveType: 'function',
      legend: { position: 'bottom' },
      pointSize: 5, // Size of the dots
      pointShape: 'circle', // Shape of the dots
      series: {
        0: { // Blood Sugar Level series
          lineWidth: 2 // Adjust the line width as needed
        },
        1: { // Target Line series
          color: 'green', // Color of the line
          lineWidth: 2, // Adjust the line width as needed
          lineDashStyle: [4, 4], // Dashed line style
          pointSize: 0, // Set point size to zero to hide dots
          visibleInLegend: false // Don't show this series in the legend
        }
      },
      vAxis: {
        viewWindow: {
          min: 0,  // Minimum y-axis value
          max: 200 // Maximum y-axis value
        }
      }
    };
    

  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

  chart.draw(data, options);
}