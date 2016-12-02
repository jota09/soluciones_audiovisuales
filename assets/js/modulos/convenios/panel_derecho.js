$(document).ready(function () {

   cargar_actividades();
   cargar_documentos();
   cargar_oportunidades();

   cargardatosGrafico();

   $("#annio").change(function () {
      cargardatosGrafico();
   });
$('#form_actividad #fecha_inicio_actividad').datepicker().on('changeDate', function (ev) {
          return $('#form_actividad #fecha_inicio_actividad').validationEngine('validate');
   });
   $('#form_actividad #fecha_fin_actividad').datepicker().on('changeDate', function (ev) {
          return $('#form_actividad #fecha_fin_actividad').validationEngine('validate');
   });
});

function cargardatosGrafico() {

   $.ajax({
      url: 'index.php?modulo=oportunidades&accion=obtenerOportunidadesXConvenio',
      data: {
         id: s3vars.registro.id,
         annio: $("#annio").val()
      },
      type: 'POST',
      dataType: 'json',
      beforeSend: function () {
         if (s3vars.registro.id > 0) {
            $('#chart_panel_derecho').html('<i class="fa fa-refresh fa-spin " style="color: rgb(0, 42, 128); font-size: 60px; left: 25%; position: relative; top: 25%; "></i>');
         }
      },
      success: function (data) {
         console.log(data);
         $('#pnl-der-mes').text($("#pnl-mes option:selected").text());
         if (data.length == 0) {
            $('#chart_panel_derecho').html('<small>Sin datos</small>');
         } else {
            obtenerGrafica(data);
         }
      }
   });
}



function obtenerGrafica(chartData) {
   var chart;
   var graph;
   
   // SERIAL CHART
   chart = new AmCharts.AmSerialChart();
//        chart.pathToImages = "../amcharts/images/";
   chart.language = "es";
   chart.marginTop = 0;
   chart.marginRight = 0;
   chart.dataProvider = chartData;
   chart.categoryField = "fecha";
   //chart.dataDateFormat = "YYYY-MM-DD";
   chart.balloon.cornerRadius = 6;

   // AXES
   // category
   var categoryAxis = chart.categoryAxis;
  // categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
  // categoryAxis.minPeriod = "MM"; // our data is daily, so we set minPeriod to DD
   categoryAxis.dashLength = 1;
   categoryAxis.minorGridEnabled = false;
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
   graph.balloonText = "<span style='font-size:14px;'><b>[[category]]</b></span><br /><span style='font-size:12px;'><b>[[value]]</b> Oportunidades</span>";
   chart.addGraph(graph);

   // CURSOR
   var chartCursor = new AmCharts.ChartCursor();
   chartCursor.cursorAlpha = 0;
   chartCursor.cursorPosition = "mouse";
  // chartCursor.categoryBalloonDateFormat = "M";
   chartCursor.graphBulletSize = 2;
   chart.addChartCursor(chartCursor);

   chart.creditsPosition = "bottom-right";

   // WRITE
   chart.write("chart_panel_derecho");
}
