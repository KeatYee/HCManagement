google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawVisualization);

function drawVisualization() {
  // Some raw data (not necessarily accurate)
  var data = google.visualization.arrayToDataTable([
    ['Date', 'Fasting', 'Before Meal', 'After Meal', 'Bedtime'],
    ['2024-03-01', 120.5, null, null, null],
    ['2024-03-01', null, 110.8, null, null],
    ['2024-03-01', null, null, 130.3, null],
    ['2024-03-01', null, null, null, 140.6],
    ['2024-03-02', 125.2, null, null, null],
    ['2024-03-02', null, 115.7, null, null],
    ['2024-03-02', null, null, 128.9, null],
    ['2024-03-02', null, null, null, 135.4],
    // Add more rows for other dates and their corresponding readings
  ]);

  var options = {
    title: 'Blood Sugar Readings by Date and Timing',
    vAxis: {title: 'Average Blood Sugar'},
    hAxis: {title: 'Date'},
    seriesType: 'bars',
    series: {3: {type: 'line'}} // Display a line for average blood sugar
  };

  var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}