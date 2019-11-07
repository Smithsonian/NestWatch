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
            let chartOptions = settings.calendarCharts[index].options;
            let dateCounts = data.reduce(reducer, {});
            let chartData = Object.entries(dateCounts).map(([key, value]) => [new Date(key), value]);
            function drawChart() { 
            let dataTable = new google.visualization.DataTable();
            dataTable.addColumn({ type: "date", id: "Date" });
            dataTable.addColumn({ type: "number", id: "Count" });
            dataTable.addRows(chartData);
            console.log(chartOptions);

            var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));
            var options = {
              height: chartOptions.canvasHeight,
              noDataPattern: {
                backgroundColor: '#efefef',
                color: '#efefef'
              },
            //   calendar: {
            //     cellSize: chartOptions.cellSize,
            //     cellColor: {
            //         stroke: chartOptions.cellColor,
            //         strokeOpacity: chartOptions.strokeOpacity,
            //         strokeWidth: chartOptions.cellStroke,
            //     }
            // }
            };

            chart.draw(dataTable, options);
          }
    
        });
    
    }
  };
})(jQuery, Drupal);
