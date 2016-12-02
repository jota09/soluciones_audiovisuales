$(document).ready(function () {
   $("#filtro_general_5").click(function () {
      $('#modal_filtro_general_5').modal('show');
      crearSlider();
   }
   );
   $("#filtro_servicio_ingreso").click(function () {
      $('#modal_filtro_servicio_ingreso').modal('show');
      crearSlider2();
   }
   );
   $("#filtro_servicio_linea").click(function () {
      $('#modal_filtro_servicio_linea').modal('show');
      crearSlider3();
   }
   );
   $("#filtro_servicio_estado").click(function () {
      $('#modal_filtro_servicio_estado').modal('show');
      crearSlider4();
   }
   );
   $('a[id="redir_reporte_comercial"]').click(function () {
      location.href = 'index.php?modulo=reportes&accion=reporteComercial';
   });
   $('a[id="redir_reporte_general"]').click(function () {
      location.href = 'index.php?modulo=reportes&accion=reporteGeneral';
   });
      obtenerGrafica25();
      obtenerGrafica26();
      obtenerGrafica27();

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

function obtenerGrafica25(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.serviciosIngreso;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica25", {
      "type": "serial",
      "theme": "light",
      "marginRight": 40,
      "marginLeft": 80,
      "titles": [{
            "text": "Ingresos por Servicio",
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
               "color": "#c6ba0d"
            },
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "bulletBorderColor": "#c6ba0d",
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
            "balloonColor": "#c6ba0d"
         }],
      "chartCursor": {
         "pan": true,
         "valueLineEnabled": true,
         "valueLineBalloonEnabled": true,
         "cursorAlpha": 1,
         "cursorColor": "#c6ba0d",
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
function obtenerGrafica26(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.serviciosLinea;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica26", {
      "type": "pie",
      "theme": "light",
      "dataProvider": chartData,
      "titleField": "title",
      "titles": [{
            "text": "Participación por Líneas de Negocio",
            "size": 20
         }],
      "titleField": "linea",
              "valueField": "value",
      "numberFormatter": {
         "precision": 2,
         "decimalSeparator": ",",
         "thousandsSeparator": "."
      },
      "labelRadius": -20,
      "radius": "33%",
      "innerRadius": "40%",
      "labelText": "[[percents]]%",
      "export": {
         "enabled": true
      }
   });
}
function obtenerGrafica27(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.serviciosEstado;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica27", {
      "type": "serial",
      "theme": "none",
      "marginRight": 70,
      "titles": [{
            "text": "Servicio por Estados",
            "size": 15
         }],
      "dataProvider": chartData,
      "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "minimum": 0
         }],
      "numberFormatter": {
         "precision": 2,
         "decimalSeparator": ",",
         "thousandsSeparator": "."
      },
      "startDuration": 1,
      "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b>",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "balloonColor": "#DB597B",
            "type": "column",
            "valueField": "value"
         }],
      "chartCursor": {
         "categoryBalloonEnabled": false,
         "cursorAlpha": 0,
         "zoomable": false
      },
      "categoryField": "estado",
      "categoryAxis": {
         "gridPosition": "start",
         "labelRotation": 0
      },
      "export": {
         "enabled": true
      }

   });
}
function filtro_general_5() {

    var bandera = $('#form_filtro_general_5').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_general_5").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_servicio_ingreso',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_5').find('input').val('');
            $('#modal_filtro_general_5').modal('hide');
            obtenerGrafica25(result);
            
        });
        
        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_servicio_linea',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_5').find('input').val('');
            $('#modal_filtro_general_5').modal('hide');
            obtenerGrafica26(result);
            
        });
        
        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_servicio_estado',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_5').find('input').val('');
            $('#modal_filtro_general_5').modal('hide');
            obtenerGrafica27(result);
        });
        
    }
}
function filtro_servicio_ingreso() {

    var bandera = $('#form_filtro_servicio_ingreso').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_servicio_ingreso").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_servicio_ingreso',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_servicio_ingreso').find('input').val('');
            $('#modal_filtro_servicio_ingreso').modal('hide');
            obtenerGrafica25(result);
            
        });
        
    }
}
function filtro_servicio_linea() {

    var bandera = $('#form_filtro_servicio_linea').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_servicio_linea").serialize();

         $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_servicio_linea',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_servicio_linea').find('input').val('');
            $('#modal_filtro_servicio_linea').modal('hide');
            obtenerGrafica26(result);
            
        });
        
    }
}
function filtro_servicio_estado() {

    var bandera = $('#form_filtro_servicio_estado').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_servicio_estado").serialize();

         $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_servicio_estado',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_servicio_estado').find('input').val('');
            $('#modal_filtro_servicio_estado').modal('hide');
            obtenerGrafica27(result);
        });
        
    }
}
function limpiar_filtro_general_5() {
   obtenerGrafica25();
   obtenerGrafica26();
   obtenerGrafica27();
   $('#form_filtro_general_5').find('input').val('');
   $('#modal_filtro_general_5').modal('hide');
}
function limpiar_filtro_servicio_ingreso() {
   obtenerGrafica25();
   $('#form_filtro_servicio_ingreso').find('input').val('');
   $('#modal_filtro_servicio_ingreso').modal('hide');
}
function limpiar_filtro_servicio_linea() {
   obtenerGrafica26();
   $('#form_filtro_servicio_linea').find('input').val('');
   $('#modal_filtro_servicio_linea').modal('hide');
}
function limpiar_filtro_servicio_estado() {
   obtenerGrafica27();
   $('#form_filtro_servicio_estado').find('input').val('');
   $('#modal_filtro_servicio_estado').modal('hide');
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
function crearSlider2(){
   $('#sliderBootstrap2').html('');
   $('#sliderBootstrap2').html('<div class="form-group">' +
           '<label class="control-label col-sm-3" for="rango">Rango de Valores <small>(en miles)</small>:</label>' +
           '<div class="col-sm-7 no-padding">' +
           ' <b>$ 1</b> <input id="rango2" name="rango" type="text" class="span2" value="" data-slider-min="1" data-slider-max="100000" data-slider-step="10" data-slider-value="[1,100000]"/> <b>$ 100.000</b>' +
           '</div>' +
           ' <div class="col-sm-2 no-padding">' +
           ' <div class="col-sm-2 no-padding"><input class="form-control" id="rango2-enabled" name="conRango" type="checkbox"/></div><div class="col-sm-10"><p class="text-center"> Con Rango de Valores</p></div>' +
           ' </div>' +
           ' </div>');
   var slider2 = new Slider("#rango2");
   slider2.disable();
   $("#rango2-enabled").click(function () {
      if (this.checked) {
         slider2.enable();
      }
      else {
         slider2.disable();
      }
   });
}
function crearSlider3(){
   $('#sliderBootstrap3').html('');
   $('#sliderBootstrap3').html('<div class="form-group">' +
           '<label class="control-label col-sm-3" for="rango">Rango de Valores <small>(en miles)</small>:</label>' +
           '<div class="col-sm-7 no-padding">' +
           ' <b>$ 1</b> <input id="rango3" name="rango" type="text" class="span2" value="" data-slider-min="1" data-slider-max="100000" data-slider-step="10" data-slider-value="[1,100000]"/> <b>$ 100.000</b>' +
           '</div>' +
           ' <div class="col-sm-2 no-padding">' +
           ' <div class="col-sm-2 no-padding"><input class="form-control" id="rango3-enabled" name="conRango" type="checkbox"/></div><div class="col-sm-10"><p class="text-center"> Con Rango de Valores</p></div>' +
           ' </div>' +
           ' </div>');
   var slider3 = new Slider("#rango3");
   slider3.disable();
   $("#rango3-enabled").click(function () {
      if (this.checked) {
         slider3.enable();
      }
      else {
         slider3.disable();
      }
   });
}
function crearSlider4(){
   $('#sliderBootstrap4').html('');
   $('#sliderBootstrap4').html('<div class="form-group">' +
           '<label class="control-label col-sm-3" for="rango">Rango de Valores <small>(en miles)</small>:</label>' +
           '<div class="col-sm-7 no-padding">' +
           ' <b>$ 1</b> <input id="rango4" name="rango" type="text" class="span2" value="" data-slider-min="1" data-slider-max="100000" data-slider-step="10" data-slider-value="[1,100000]"/> <b>$ 100.000</b>' +
           '</div>' +
           ' <div class="col-sm-2 no-padding">' +
           ' <div class="col-sm-2 no-padding"><input class="form-control" id="rango4-enabled" name="conRango" type="checkbox"/></div><div class="col-sm-10"><p class="text-center"> Con Rango de Valores</p></div>' +
           ' </div>' +
           ' </div>');
   var slider4 = new Slider("#rango4");
   slider4.disable();
   $("#rango4-enabled").click(function () {
      if (this.checked) {
         slider4.enable();
      }
      else {
         slider4.disable();
      }
   });
}
