$(document).ready(function () {
   $("#filtro_general_4").click(function () {
      $('#modal_filtro_general_4').modal('show');
      crearSlider();
   }
   );
   $("#filtro_cotizacion_etapa").click(function () {
      $('#modal_filtro_cotizacion_etapa').modal('show');
      crearSlider2();
   }
   );
   $("#filtro_cotizacion_linea").click(function () {
      $('#modal_filtro_cotizacion_linea').modal('show');
      crearSlider3();
   }
   );
   $("#filtro_cotizacion_asesor").click(function () {
      $('#modal_filtro_cotizacion_asesor').modal('show');
      crearSlider4();
   }
   );
   $("#filtro_cotizacion_sector").click(function () {
      $('#modal_filtro_cotizacion_sector').modal('show');
      crearSlider5();
   }
   );
   $("#filtro_cotizacion_mes").click(function () {
      $('#modal_filtro_cotizacion_mes').modal('show');
      crearSlider6();
   }
   );
   $('a[id="redir_reporte_comercial"]').click(function () {
      location.href = 'index.php?modulo=reportes&accion=reporteComercial';
   });
   $('a[id="redir_reporte_general"]').click(function () {
      location.href = 'index.php?modulo=reportes&accion=reporteGeneral';
   });
      obtenerGrafica17();
      obtenerGrafica18();
      obtenerGrafica19();
      obtenerGrafica20();
      obtenerGrafica28();
      
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
function obtenerGrafica17(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.cotizacionesEtapa;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica17", {
      "type": "serial",
      "theme": "none",
      "marginRight": 70,
      "titles": [{
            "text": "Cotizacion por Etapas",
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
      "categoryField": "etapa",
      "categoryAxis": {
         "gridPosition": "start",
         "labelRotation": 0
      },
      "export": {
         "enabled": true
      }

   });
}
function obtenerGrafica18(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.cotizacionesLinea;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica18", {
      "type": "pie",
      "theme": "light",
      "dataProvider": chartData,
      "titleField": "title",
      "colorField": "color",
      "legend": {
         "position": "right",
//         "marginRight": 10,
         "autoMargins": false,
         "valueWidth": 0
      },
      "titles": [{
            "text": "Participación por Líneas de Negocio",
            "size": 15
         }],
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
function obtenerGrafica19(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.cotizaciones;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica19", {
      "type": "serial",
      "theme": "none",
      "marginRight": 70,
      "titles": [{
            "text": "Cotizaciones por Asesor",
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
            "balloonColor": "#DB597B",
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "value"
         }],
      "chartCursor": {
         "categoryBalloonEnabled": false,
         "cursorAlpha": 0,
         "zoomable": false
      },
      "categoryField": "nombres",
      "categoryAxis": {
         "gridPosition": "start",
         "labelRotation": 0
      },
      "export": {
         "enabled": true
      }

   });
}
function obtenerGrafica20(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.cotizacionesSector;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica20", {
      "type": "pie",
      "theme": "light",
      "colorField": "color",
      "legend": {
         "position": "right",
//         "marginRight": 10,
         "autoMargins": false,
         "valueWidth": 0
      },
      "titles": [{
            "text": "Participación por Sector",
            "size": 15
         }],
      "dataProvider": chartData,
      "numberFormatter": {
         "precision": 2,
         "decimalSeparator": ",",
         "thousandsSeparator": "."
      },
      "titleField": "title",
      "valueField": "value",
      "labelRadius": -20,
      "radius": "33%",
      "innerRadius": "60%",
      "labelText": "[[percents]]%",
      "export": {
         "enabled": true
      }
   });
}
function obtenerGrafica28(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.cotizacionesporMes;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica28", {
      "type": "serial",
      "theme": "light",
      "titles": [{
            "text": "Cotizacion por Mes",
            "size": 15
         }],
      "dataProvider": chartData,
      "valueAxes": [{
            "stackType": "regular",
            "axisAlpha": 0.3,
            "gridAlpha": 0
         }],
      "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "fillColorsField": "color",
            "title": "Nueva",
            "type": "column",
            "valueField": "Nueva"
         }, {
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "fillColorsField": "color",
            "title": "Borrador",
            "type": "column",
            "valueField": "Borrador"
         }, {
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "labelText": "[[value]]",
            "fillColorsField": "color",
            "lineAlpha": 0.3,
            "title": "Ganada",
            "type": "column",
            "valueField": "Ganada"
         }, {
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "fillColorsField": "color",
            "title": "Presentada",
            "type": "column",
            "valueField": "Presentada"
         }, {
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "labelText": "[[value]]",
            "fillColorsField": "color",
            "lineAlpha": 0.3,
            "title": "En Negociación",
            "type": "column",
            "valueField": "En Negociacion"
         }, {
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "fillColorsField": "color",
            "title": "Perdida",
            "type": "column",
            "valueField": "Perdida"
         }],
      "categoryField": "mes",
      "numberFormatter": {
         "precision": 2,
         "decimalSeparator": ",",
         "thousandsSeparator": "."
      },
      "categoryAxis": {
         "gridPosition": "start",
         "axisAlpha": 0,
         "gridAlpha": 0,
         "position": "left"
      },
      "exportConfig": {
         "menuTop": "20px",
         "menuRight": "20px",
         "menuItems": [{
               "icon": '/lib/3/images/export.png',
               "format": 'png'
            }]
      }
   });
}
function filtro_general_4() {

    var bandera = $('#form_filtro_general_4').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_general_4").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion_etapa',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_4').find('input').val('');
            $('#modal_filtro_general_4').modal('hide');
            obtenerGrafica17(result);
            
        });
        
        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion_linea',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_4').find('input').val('');
            $('#modal_filtro_general_4').modal('hide');
            obtenerGrafica18(result);
            
        });

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_4').find('input').val('');
            $('#modal_filtro_general_4').modal('hide');
            obtenerGrafica19(result);
            
        });

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion_sector',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_4').find('input').val('');
            $('#modal_filtro_general_4').modal('hide');
            obtenerGrafica20(result);
            
        });
        

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion_mes',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_4').find('input').val('');
            $('#modal_filtro_general_4').modal('hide');
            obtenerGrafica28(result);
            
        });
    }
}
function filtro_cotizacion_etapa() {

    var bandera = $('#form_filtro_cotizacion_etapa').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_cotizacion_etapa").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion_etapa',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_cotizacion_etapa').find('input').val('');
            $('#modal_filtro_cotizacion_etapa').modal('hide');
            obtenerGrafica17(result);
            
        });
     }
}
function filtro_cotizacion_linea() {

    var bandera = $('#form_filtro_cotizacion_linea').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_cotizacion_linea").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion_linea',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_cotizacion_linea').find('input').val('');
            $('#modal_filtro_cotizacion_linea').modal('hide');
            obtenerGrafica18(result);
        });
     }
}
function filtro_cotizacion_asesor() {

    var bandera = $('#form_filtro_cotizacion_asesor').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_cotizacion_asesor").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_cotizacion_asesor').find('input').val('');
            $('#modal_filtro_cotizacion_asesor').modal('hide');
            obtenerGrafica19(result);
            
        });
     }
}
function filtro_cotizacion_sector() {

    var bandera = $('#form_filtro_cotizacion_sector').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_cotizacion_sector").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion_sector',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_cotizacion_sector').find('input').val('');
            $('#modal_filtro_cotizacion_sector').modal('hide');
            obtenerGrafica20(result);
            
        });
     }
}
function filtro_cotizacion_mes() {

    var bandera = $('#form_filtro_cotizacion_mes').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_cotizacion_mes").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion_mes',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_cotizacion_mes').find('input').val('');
            $('#modal_filtro_cotizacion_mes').modal('hide');
            obtenerGrafica28(result);
            
        });
     }
}
function limpiar_filtro_general_4() {
   obtenerGrafica17();
   obtenerGrafica18();
   obtenerGrafica19();
   obtenerGrafica20();
   obtenerGrafica28();
   $('#form_filtro_general_4').find('input').val('');
   $('#modal_filtro_general_4').modal('hide');
}
function limpiar_filtro_cotizacion_etapa() {
   obtenerGrafica17();
   $('#form_filtro_cotizacion_etapa').find('input').val('');
   $('#modal_filtro_cotizacion_etapa').modal('hide');
}
function limpiar_filtro_cotizacion_linea() {
   obtenerGrafica18();
   $('#form_filtro_cotizacion_linea').find('input').val('');
   $('#modal_filtro_cotizacion_linea').modal('hide');
}
function limpiar_filtro_cotizacion_asesor() {
   obtenerGrafica19();
   $('#form_filtro_cotizacion_asesor').find('input').val('');
   $('#modal_filtro_cotizacion_asesor').modal('hide');
}
function limpiar_filtro_cotizacion_sector() {
   obtenerGrafica20();
   $('#form_filtro_cotizacion_sector').find('input').val('');
   $('#modal_filtro_cotizacion_sector').modal('hide');
}
function limpiar_filtro_cotizacion_mes() {
   obtenerGrafica28();
   $('#form_filtro_cotizacion_mes').find('input').val('');
   $('#modal_filtro_cotizacion_mes').modal('hide');
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
function crearSlider5(){
   $('#sliderBootstrap5').html('');
   $('#sliderBootstrap5').html('<div class="form-group">' +
           '<label class="control-label col-sm-3" for="rango">Rango de Valores <small>(en miles)</small>:</label>' +
           '<div class="col-sm-7 no-padding">' +
           ' <b>$ 1</b> <input id="rango5" name="rango" type="text" class="span2" value="" data-slider-min="1" data-slider-max="100000" data-slider-step="10" data-slider-value="[1,100000]"/> <b>$ 100.000</b>' +
           '</div>' +
           ' <div class="col-sm-2 no-padding">' +
           ' <div class="col-sm-2 no-padding"><input class="form-control" id="rango5-enabled" name="conRango" type="checkbox"/></div><div class="col-sm-10"><p class="text-center"> Con Rango de Valores</p></div>' +
           ' </div>' +
           ' </div>');
   var slider5 = new Slider("#rango5");
   slider5.disable();
   $("#rango5-enabled").click(function () {
      if (this.checked) {
         slider5.enable();
      }
      else {
         slider5.disable();
      }
   });
}
function crearSlider6(){
   $('#sliderBootstrap6').html('');
   $('#sliderBootstra6').html('<div class="form-group">' +
           '<label class="control-label col-sm-3" for="rango">Rango de Valores <small>(en miles)</small>:</label>' +
           '<div class="col-sm-7 no-padding">' +
           ' <b>$ 1</b> <input id="rango6" name="rango" type="text" class="span2" value="" data-slider-min="1" data-slider-max="100000" data-slider-step="10" data-slider-value="[1,100000]"/> <b>$ 100.000</b>' +
           '</div>' +
           ' <div class="col-sm-2 no-padding">' +
           ' <div class="col-sm-2 no-padding"><input class="form-control" id="rango6-enabled" name="conRango" type="checkbox"/></div><div class="col-sm-10"><p class="text-center"> Con Rango de Valores</p></div>' +
           ' </div>' +
           ' </div>');
   var slider6 = new Slider("#rango6");
   slider6.disable();
   $("#rango6-enabled").click(function () {
      if (this.checked) {
         slider6.enable();
      }
      else {
         slider6.disable();
      }
   });
}