$(document).ready(function () {
   $("#filtro_general_2").click(function () {
      $('#modal_filtro_general_2').modal('show');
      crearSlider();
   }
   );
   $("#filtro_comercial_venta").click(function () {
      $('#modal_filtro_comercial_venta').modal('show');
      crearSlider2();
   }
   );
   $("#filtro_comercial_cotizacion").click(function () {
      $('#modal_filtro_comercial_cotizacion').modal('show');
      crearSlider3();
   }
   );
   $("#filtro_comercial_servicio").click(function () {
      $('#modal_filtro_comercial_servicio').modal('show');
      crearSlider4();
   }
   );
   $("#grafica4").dblclick(function () {
      tableroVenta();
   });
   $("#grafica8").dblclick(function () {
      tableroCotizacion();
   });
   $("#grafica21").dblclick(function () {
      tableroServicio();
   });
   $('a[id="redir_reporte_general"]').click(function () {
      location.href = 'index.php?modulo=reportes&accion=reporteGeneral';
   });
   obtenerGrafica4();
   obtenerGrafica7();
   obtenerGrafica8();
   obtenerGrafica11();
   obtenerGrafica21();
   obtenerGrafica24();
   
   
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
function tableroVenta() {
   location.href = 'index.php?modulo=reportes&accion=reporteVenta';
}
function tableroCotizacion() {
   location.href = 'index.php?modulo=reportes&accion=reporteCotizacion';
}
function tableroServicio() {
   location.href = 'index.php?modulo=reportes&accion=reporteServicio';
}
function obtenerGrafica4(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
      var chartData = s3vars.ventas;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica4", {
      "type": "serial",
      "theme": "none",
      "marginRight": 70,
      "titles": [{
            "text": "Ventas por Asesor",
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
            "type": "column",
            "valueField": "value",
            "balloonColor": "#DB597B"

         }],
      "chartCursor": {
         "pan": true,
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
function obtenerGrafica8(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.cotizaciones;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica8", {
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
            "lineAlpha": 0.2,
            "balloonColor": "#DB597B",
            "type": "column",
            "valueField": "value"
         }],
      "chartCursor": {
         "pan": true,
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
function obtenerGrafica7(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.ventasLinea;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica7", {
      "type": "pie",
      "theme": "light",
      "dataProvider": chartData,
      "titleField": "title",
      "valueField": "value",
      "labelRadius": -20,
      "colorField": "color",
      //"labelsEnabled": false,
//  "autoMargins": false,
//  "marginTop": 20,
//  "marginBottom": 20,
//  "marginLeft": 20,
//  "marginRight": 20,
//  "pullOutRadius": 20,

      "numberFormatter": {
         "precision": 2,
         "decimalSeparator": ",",
         "thousandsSeparator": "."
      },
      "radius": "33%",
      "innerRadius": "40%",
      "labelText": "[[percents]]%",
      "export": {
         "enabled": true
      }
   });
}
function obtenerGrafica11(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.cotizacionesLinea;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica11", {
      "type": "pie",
      "theme": "light",
      "dataProvider": chartData,
      "titleField": "title",
      "valueField": "value",
      "colorField": "color",
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
function obtenerGrafica21(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
      var chartData = s3vars.servicios;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica21", {
      "type": "serial",
      "theme": "none",
      "marginRight": 70,
      "titles": [{
            "text": "Cannon por Servicio",
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
         "pan": true,
         "categoryBalloonEnabled": false,
         "cursorAlpha": 0,
         "zoomable": false
      },
      "categoryField": "servicio",
      "categoryAxis": {
         "gridPosition": "start",
         "labelRotation": 0
      },
      "export": {
         "enabled": true
      }

   });
}
function obtenerGrafica24(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
   var chartData = s3vars.serviciosLinea;
   }
//   console.log(chartData);
   var chart = AmCharts.makeChart("grafica24", {
      "type": "pie",
      "theme": "light",
      "dataProvider": chartData,
      "titleField": "linea",
      "valueField": "value",
      "colorField": "color",
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
function filtro_general_2() {

    var bandera = $('#form_filtro_general_2').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_general_2").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_venta',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_2').find('input').val('');
            $('#modal_filtro_general_2').modal('hide');
            obtenerGrafica4(result);
            
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
            $('#form_filtro_general_2').find('input').val('');
            $('#modal_filtro_general_2').modal('hide');
            obtenerGrafica8(result);
            
        });
        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_servicio',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_2').find('input').val('');
            $('#modal_filtro_general_2').modal('hide');
            obtenerGrafica21(result);
            
        });
        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_venta_linea',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_general_2').find('input').val('');
            $('#modal_filtro_general_2').modal('hide');
            obtenerGrafica7(result);
            tabla_cuerpo_venta_linea(result);
            
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
            $('#form_filtro_general_2').find('input').val('');
            $('#modal_filtro_general_2').modal('hide');
            obtenerGrafica11(result);
            tabla_cuerpo_cotizacion_linea(result);
            
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
            $('#form_filtro_general_2').find('input').val('');
            $('#modal_filtro_general_2').modal('hide');
            obtenerGrafica24(result);
            tabla_cuerpo_servicio_linea(result);
            
        });

    }
}
function filtro_comercial_cotizacion() {

    var bandera = $('#form_filtro_comercial_cotizacion').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_comercial_cotizacion").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_cotizacion',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_comercial_cotizacion').find('input').val('');
            $('#modal_filtro_comercial_cotizacion').modal('hide');
            obtenerGrafica8(result);
            
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
            $('#form_filtro_comercial_cotizacion').find('input').val('');
            $('#modal_filtro_comercial_cotizacion').modal('hide');
            obtenerGrafica11(result);
            tabla_cuerpo_cotizacion_linea(result);
            
        });
    }
}
function filtro_comercial_venta() {

    var bandera = $('#form_filtro_comercial_venta').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_comercial_venta").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_venta',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_comercial_venta').find('input').val('');
            $('#modal_filtro_comercial_venta').modal('hide');
            obtenerGrafica4(result);
            
        });
        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_venta_linea',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_comercial_venta').find('input').val('');
            $('#modal_filtro_comercial_venta').modal('hide');
            obtenerGrafica7(result);
            tabla_cuerpo_venta_linea(result);
            
        });
   }
}
function filtro_comercial_servicio() {

    var bandera = $('#form_filtro_comercial_servicio').validationEngine('validate');

    if (bandera) {
        var formData = $("#form_filtro_comercial_servicio").serialize();

        $.ajax({
            url: 'index.php?modulo=reportes&accion=filtro_general_2_servicio',
            type: "GET",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#form_filtro_comercial_servicio').find('input').val('');
            $('#modal_filtro_comercial_servicio').modal('hide');
            obtenerGrafica21(result);
            
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
            $('#form_filtro_comercial_servicio').find('input').val('');
            $('#modal_filtro_comercial_servicio').modal('hide');
            obtenerGrafica24(result);
            tabla_cuerpo_servicio_linea(result);
            
        });

    }
}
function limpiar_filtro_general_2() {
   obtenerGrafica4();
   obtenerGrafica7();
   obtenerGrafica8();
   obtenerGrafica21();
   obtenerGrafica24();
   tabla_cuerpo_venta_linea();
   tabla_cuerpo_cotizacion_linea();
   tabla_cuerpo_servicio_linea();
   $('#form_filtro_general_2').find('input').val('');
   $('#modal_filtro_general_2').modal('hide');
}
function limpiar_filtro_comercial_venta() {
   obtenerGrafica4();
   obtenerGrafica7();
   tabla_cuerpo_venta_linea();
   $('#form_filtro_comercial_venta').find('input').val('');
   $('#modal_filtro_comercial_venta').modal('hide');
}
function limpiar_filtro_comercial_cotizacion() {
   obtenerGrafica8();
   obtenerGrafica11();
   tabla_cuerpo_cotizacion_linea();
   $('#form_filtro_comercial_cotizacion').find('input').val('');
   $('#modal_filtro_comercial_cotizacion').modal('hide');
}
function limpiar_filtro_comercial_servicio() {
   obtenerGrafica21();
   obtenerGrafica24();
   tabla_cuerpo_servicio_linea();
   $('#form_filtro_comercial_servicio').find('input').val('');
   $('#modal_filtro_comercial_servicio').modal('hide');
}
function tabla_cuerpo_venta_linea(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
      var chartData = s3vars.ventasLinea;
   }
   var tabla_linea_venta = '';
   $.each(chartData, function (k, v) {
            tabla_linea_venta += '<tr>' +
                    '<td><p class="text-center">' + v.title + '</p></td>' +
                    '<td><p class="text-center">' + v.cantidad + '</p></td>' +
                    '<td><p class="text-center">$' + v.value + '</p></td>' +
                    '</tr>';
         });
        $("#cuerpo_venta_linea").html(tabla_linea_venta);
}
function tabla_cuerpo_cotizacion_linea(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
      var chartData = s3vars.cotizacionesLinea;
   }
   var tabla_linea_cotizacion = '';
   $.each(chartData, function (k, v) {
            tabla_linea_cotizacion += '<tr>' +
                    '<td><p class="text-center">' + v.title + '</p></td>' +
                    '<td><p class="text-center">' + v.cantidad + '</p></td>' +
                    '<td><p class="text-center">$' + v.value + '</p></td>' +
                    '</tr>';
         });
        $("#cuerpo_cotizacion_linea").html(tabla_linea_cotizacion);
}
function tabla_cuerpo_servicio_linea(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   }
   else{
      var chartData = s3vars.serviciosLinea;
   }
   var tabla_linea_servicio = '';
   $.each(chartData, function (k, v) {
            tabla_linea_servicio += '<tr>' +
                    '<td><p class="text-center">' + v.linea + '</p></td>' +
                    '<td><p class="text-center">$' + v.value + '</p></td>' +
                    '</tr>';
         });
        $("#cuerpo_servicio_linea").html(tabla_linea_servicio);
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
