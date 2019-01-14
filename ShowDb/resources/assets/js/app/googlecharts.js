$(document).ready(function() {

    // Set a callback to run when the Google Visualization API is loaded.
    if(typeof drawChartsLocal == 'function') {
	    //GoogleCharts.load(drawChartsLocal, {
        //    'packages': ['geochart'],
        //    'mapsApiKey': 'AIzaSyC94p4NDgSVwh34FPRCDvaUDnNMA1V-sSU'
        //});
        //GoogleCharts.load(drawChartsLocal, ['corechart']);
        google.charts.load('current', {
            'packages':['corechart','geochart','bar'],
            'mapsApiKey':mapsApiKey
        });
        google.charts.setOnLoadCallback(drawChartsLocal);
    }

});
