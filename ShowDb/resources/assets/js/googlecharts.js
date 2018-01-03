$(document).ready(function() {
// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
if(typeof drawChartsLocal == 'function') {
  google.charts.setOnLoadCallback(drawChartsLocal);
}

});
