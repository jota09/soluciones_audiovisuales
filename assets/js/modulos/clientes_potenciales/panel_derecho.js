$(document).ready(function () {

  cargar_actividades();
  cargar_documentos();
  cargar_oportunidades();
        $(' #cuenta_id').select2('readonly', false);
$('#form_actividad #fecha_inicio_actividad').datepicker().on('changeDate', function (ev) {
          return $('#form_actividad #fecha_inicio_actividad').validationEngine('validate');
   });
   $('#form_actividad #fecha_fin_actividad').datepicker().on('changeDate', function (ev) {
          return $('#form_actividad #fecha_fin_actividad').validationEngine('validate');
   });

});


function obtenerGrafica(chartData) {
  var chart;
  var graph;
  var chartData = [
    {
      "fecha": "2012-01-07",
      "value": 10
    },
    {
      "fecha": "2012-02-08",
      "value": 12

    },
    {
      "fecha": "2012-03-09",
      "value": 3
    },
    {
      "fecha": "2012-04-10",
      "value": 14
    },
    {
      "fecha": "2012-05-11",
      "value": 5
    },
    {
      "fecha": "2012-06-12",
      "value": 16
    }
  ];

  // SERIAL CHART
  chart = new AmCharts.AmSerialChart();
//        chart.pathToImages = "../amcharts/images/";
  chart.language = "es";
  chart.marginTop = 0;
  chart.marginRight = 0;
  chart.dataProvider = chartData;
  chart.categoryField = "fecha";
  chart.dataDateFormat = "YYYY-MM-DD";
  chart.balloon.cornerRadius = 6;

  // AXES
  // category
  var categoryAxis = chart.categoryAxis;
  categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
  categoryAxis.minPeriod = "MM"; // our data is daily, so we set minPeriod to DD
  categoryAxis.dashLength = 1;
  categoryAxis.minorGridEnabled = true;
  categoryAxis.axisColor = "#DADADA";

  // value
  var valueAxis = new AmCharts.ValueAxis();
  valueAxis.axisAlpha = 0;
  valueAxis.dashLength = 1;
  valueAxis.inside = true;
  chart.addValueAxis(valueAxis);

  // GRAPH
  graph = new AmCharts.AmGraph();
  graph.lineColor = "#db597b";
  graph.negativeLineColor = "#db597b"; // this line makes the graph to change color when it drops below 0
  graph.bullet = "round";
  graph.bulletSize = 8;
  graph.bulletBorderColor = "#FFFFFF";

  graph.bulletBorderThickness = 2;
  graph.bulletBorderAlpha = 1;
  graph.connect = false; // this makes the graph not to connect data points if data is missing
  graph.lineThickness = 2;
  graph.valueField = "value";
  graph.balloonText = "Mes: [[category]]<br><b><span style='font-size:14px;'>[[value]] </span></b>";
  chart.addGraph(graph);

  // CURSOR
  var chartCursor = new AmCharts.ChartCursor();
  chartCursor.cursorAlpha = 0;
  chartCursor.cursorPosition = "mouse";
  chartCursor.categoryBalloonDateFormat = "DD";
  chartCursor.graphBulletSize = 2;
  chart.addChartCursor(chartCursor);

  chart.creditsPosition = "bottom-right";

  // WRITE
  chart.write("chart_panel_derecho");
}
