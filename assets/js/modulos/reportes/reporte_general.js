$(document).ready(function () {
   $("#filtro_general_1").click(function () {
      $('#modal_filtro_general_1').modal('show');
      crearSlider();
   }
   );
   $("#grafica").dblclick(function () {
      tableroComercial();
   });
   obtenerGrafica();
   $(".modal-transparent").on('show.bs.modal', function () {
      setTimeout(function () {
         $(".modal-backdrop").addClass("modal-backdrop-transparent");
      }, 0);
   });
   $(".modal-transparent").on('hidden.bs.modal', function () {
      $(".modal-backdrop").addClass("modal-backdrop-transparent");
   });

   $('.number').number(true, 0, '.', ',');

});
function tableroComercial() {
   location.href = 'index.php?modulo=reportes&accion=reporteComercial';
}
function obtenerGrafica(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else {
      var chartData = s3vars.ventas;
   }
   var chart = AmCharts.makeChart("grafica", {
      "type": "serial",
      "theme": "light",
      "marginRight": 40,
      "marginLeft": 80,
      "titles": [{
            "text": "Ventas Mensuales",
            "size": 15
         }],
      "autoMarginOffset": 20,
      "dataDateFormat": "YYYY-MM",
      "valueAxes": [{
            "id": "v1",
            "axisAlpha": 0,
            "minimum": 0,
            "position": "left",
            "ignoreAxisWidth": true
         }],
      "balloon": {
         "borderThickness": 1,
         "shadowAlpha": 0
      },
      "numberFormatter": {
         "precision": 2,
         "decimalSeparator": ",",
         "thousandsSeparator": "."
      },
      "graphs": [{
            "id": "g1",
            "balloon": {
               "drop": true,
               "adjustBorderColor": true,
               "color": "#DB597B"
            },
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "bulletBorderColor": "#DB597B",
            "bulletSize": 7,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "fillColorsField": "lineColor",
            "legendValueText": "[[value]]",
            "lineColorField": "lineColor",
            "title": "red line",
            "useLineColorForBulletBorder": false,
            "valueField": "value",
            "balloonText": "<span style='font-size:18px;'>[[value]]</span>",
            "balloonColor": "#DB597B"
         }],
      "chartCursor": {
         "pan": true,
         "valueLineEnabled": true,
         "valueLineBalloonEnabled": true,
         "cursorAlpha": 1,
         "cursorColor": "#DB597B",
         "limitToGraph": "g1",
         "valueLineAlpha": 0.2,
         "valueZoomable": true
      },
      "valueScrollbar": {
         "oppositeAxis": false,
         "offset": 50,
         "scrollbarHeight": 10
      },
      "categoryField": "fecha",
      "categoryAxis": {
         "parseDates": true,
         "dashLength": 1,
         "minorGridEnabled": true
      },
      "export": {
         "enabled": true
      },
      "dataProvider": chartData
   });

}
function filtro_general_1() {

   var bandera = $('#form_filtro_general_1').validationEngine('validate');

   if (bandera) {
      var formData = $("#form_filtro_general_1").serialize()
      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_1',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_general_1').find('input').val('');
         $('#modal_filtro_general_1').modal('hide');
         obtenerGrafica(result);

      });

   }
}

function limpiar_filtro_general_1() {
   obtenerGrafica();
   $('#form_filtro_general_1').find('input').val('');
   $('#modal_filtro_general_1').modal('hide');
}
function crearSlider(){
   $('#sliderBootstrap').html('');
   $('#sliderBootstrap').html('<div class="form-group">' +
           '<label class="control-label col-sm-3" for="rango">Rango de Valores <small>(en miles)</small>:</label>' +
           '<div class="col-sm-7 no-padding">' +
           ' <b>$ 1</b> <input id="rango" name="rango" type="text" class="span2" value="" data-slider-min="1" data-slider-max="100000" data-slider-step="10" data-slider-value="[1,100000]"/> <b>$ 100.000</b>' +
           '</div>' +
           ' <div class="col-sm-2 no-padding">' +
           ' <div class="col-sm-2 no-padding"><input class="form-control" id="rango-enabled" name="conRango" type="checkbox"/></div><div class="col-sm-10"><p class="text-center"> Con Rango de Valores</p></div>' +
           ' </div>' +
           ' </div>');
   var slider = new Slider("#rango");
   slider.disable();
   $("#rango-enabled").click(function () {
      if (this.checked) {
         slider.enable();
      }
      else {
         slider.disable();
      }
   });
}
