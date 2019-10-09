/**
 * @file
 * Calendar Charts JavaScript file.
 */

(function($, Drupal) {
  Drupal.behaviors.calendarCharts = {
    attach: function(context, settings) {

        const reducer = function(obj, b) {
            obj[b] = ++obj[b] || 1;
            console.log(obj);
            return obj;
          };

      $("#calendar_basic")
        .once()
        .each(function(index) {
            google.charts.load("current", { packages: ["calendar"] });
            google.charts.setOnLoadCallback(drawChart);

            //pulls in the data from the view rows
            let data = settings.calendarCharts[index].data;
            //converts each of the data items into JS Dates//
            let dates = data.map(item => new Date(item));
            let dateCounts = dates.reduce(reducer, {});
            let chartData = Object.entries(dateCounts).map(([key, value]) => [new Date(key), value]);
            function drawChart() { 
            let dataTable = new google.visualization.DataTable();
            dataTable.addColumn({ type: "date", id: "Date" });
            dataTable.addColumn({ type: "number", id: "Won/Loss" });
            dataTable.addRows(chartData);

            var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));
            var options = {
              title: "Red Sox Attendance",
              height: 350
            };

            chart.draw(dataTable, options);
          }
    
        });
    
    }
  };
})(jQuery, Drupal);
