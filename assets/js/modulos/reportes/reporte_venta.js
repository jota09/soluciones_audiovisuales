$(document).ready(function () {
   $("#filtro_general_3").click(function () {
      $('#modal_filtro_general_3').modal('show');
      crearSlider();
   });
   $("#filtro_ventas_mensuales").click(function () {
      $('#modal_filtro_ventas_mensuales').modal('show');
      crearSlider2();
   });
   $("#filtro_ventas_negocio").click(function () {
      $('#modal_filtro_ventas_negocio').modal('show');
      crearSlider3();
   });
   $("#filtro_ventas_asesor").click(function () {
      $('#modal_filtro_ventas_asesor').modal('show');
      crearSlider4();
   });
   $("#filtro_ventas_cliente").click(function () {
      $('#modal_filtro_ventas_cliente').modal('show');
      crearSlider5();
   });
   $("#filtro_ventas_sector").click(function () {
      $('#modal_filtro_ventas_sector').modal('show');
      crearSlider6();
   });
   $("#filtro_ventas_producto").click(function () {
      $('#modal_filtro_ventas_producto').modal('show');
      crearSlider7();
   });
   $('a[id="redir_reporte_comercial"]').click(function () {
      location.href = 'index.php?modulo=reportes&accion=reporteComercial';
   });
   $('a[id="redir_reporte_general"]').click(function () {
      location.href = 'index.php?modulo=reportes&accion=reporteGeneral';
   });

   powerTipLinea();
   powerTipMensuales();
   powerTipAsesor();
   powerTipSector();
   powerTipProducto();

   obtenerGrafica12();
   obtenerGrafica13();
   obtenerGrafica14();
   obtenerGrafica16();
   obtenerGrafica29();

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

function obtenerGrafica12(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventas;
   }
   //   console.log(chartData);
   var chart = AmCharts.makeChart("grafica12", {
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
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventas;
   }
   var tabla_linea_venta = '' +
           '<div class="col-sm-12 fondoBlanco">' +
           '<h5 class="negrita letraRosa">Ventas Mensuales<h5>' +
           '<table class="table tablaLinea">' +
           '<thead>' +
           ' <tr>' +
           '<th><p class="text-center">Mes</p></th>' +
           '<th><p class="text-center">Valor</p></th>' +
           '</tr>' +
           '</thead>' +
           '<tbody id="cuerpo_venta_linea">';


   $.each(chartData, function (k, v) {
      tabla_linea_venta += '<tr>' +
              '<td><p class="text-center">' + v.mes + '</p></td>' +
              '<td><p class="text-center">$' + v.value + '</p></td>' +
              '</tr>';
   });
   tabla_linea_venta += '</tbody>' +
           '</table>' +
           '</div>' +
           '<div class="col-sm-12 no-padding"><p class="expresadaMilesPowerTip">*Cifra expresada en miles</p></div>';
   $('#grafica12').data('powertip', tabla_linea_venta);
}

function obtenerGrafica13(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventasLinea;
   }
   //   console.log(chartData);
   var chart = AmCharts.makeChart("grafica13", {
      "type": "pie",
      "theme": "light",
      "dataProvider": chartData,
      "titleField": "title",
      "valueField": "value",
      "labelRadius": -20,
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
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventasLinea;
   }
   var tabla_linea_venta = '' +
           '<div class="col-sm-12 fondoBlanco">' +
           '<h5 class="negrita letraRosa">Ventas por Linea de Negocio<h5>' +
           '<table class="table tablaLinea">' +
           '<thead>' +
           ' <tr>' +
           '<th><p class="text-center">Linea de Negocio</p></th>' +
           '<th><p class="text-center">Ventas</p></th>' +
           '<th><p class="text-center">Valor</p></th>' +
           '</tr>' +
           '</thead>' +
           '<tbody id="cuerpo_venta_linea">';


   $.each(chartData, function (k, v) {
      tabla_linea_venta += '<tr>' +
              '<td><p class="text-center">' + v.title + '</p></td>' +
              '<td><p class="text-center">' + v.cantidad + '</p></td>' +
              '<td><p class="text-center">$' + v.value + '</p></td>' +
              '</tr>';
   });
   tabla_linea_venta += '</tbody>' +
           '</table>' +
           '</div>' +
           '<div class="col-sm-12 no-padding"><p class="expresadaMilesPowerTip">*Cifra expresada en miles</p></div>';
   $('#grafica13').data('powertip', tabla_linea_venta);
}

function obtenerGrafica14(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventasAsesor;
   }
   //   console.log(chartData);
   var chart = AmCharts.makeChart("grafica14", {
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
            "balloonColor": "#DB597B",
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
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventasAsesor;
   }
   var tabla_linea_venta = '' +
           '<div class="col-sm-12 fondoBlanco">' +
           '<h5 class="negrita letraRosa">Ventas Mensuales<h5>' +
           '<table class="table tablaLinea">' +
           '<thead>' +
           ' <tr>' +
           '<th><p class="text-center">Asesor</p></th>' +
           '<th><p class="text-center">Valor</p></th>' +
           '</tr>' +
           '</thead>' +
           '<tbody id="cuerpo_venta_linea">';


   $.each(chartData, function (k, v) {
      tabla_linea_venta += '<tr>' +
              '<td><p class="text-center">' + v.nombres + '</p></td>' +
              '<td><p class="text-center">$' + v.value + '</p></td>' +
              '</tr>';
   });
   tabla_linea_venta += '</tbody>' +
           '</table>' +
           '</div>' +
           '<div class="col-sm-12 no-padding"><p class="expresadaMilesPowerTip">*Cifra expresada en miles</p></div>';
   $('#grafica14').data('powertip', tabla_linea_venta);
}

function obtenerGrafica16(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventasSector;
   }
   //   console.log(chartData);
   var chart = AmCharts.makeChart("grafica16", {
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
      "colorField": "color",
              "labelRadius": -20,
      "radius": "33%",
      "innerRadius": "60%",
      "labelText": "[[percents]]%",
      "export": {
         "enabled": true
      }
   });
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventasSector;
   }
   var tabla_linea_venta = '' +
           '<div class="col-sm-12 fondoBlanco">' +
           '<h5 class="negrita letraRosa">Ventas Mensuales<h5>' +
           '<table class="table tablaLinea">' +
           '<thead>' +
           ' <tr>' +
           '<th><p class="text-center">Sector</p></th>' +
           '<th><p class="text-center">Valor</p></th>' +
           '</tr>' +
           '</thead>' +
           '<tbody id="cuerpo_venta_linea">';


   $.each(chartData, function (k, v) {
      tabla_linea_venta += '<tr>' +
              '<td><p class="text-center">' + v.title + '</p></td>' +
              '<td><p class="text-center">$' + v.value + '</p></td>' +
              '</tr>';
   });
   tabla_linea_venta += '</tbody>' +
           '</table>' +
           '</div>' +
           '<div class="col-sm-12 no-padding"><p class="expresadaMilesPowerTip">*Cifra expresada en miles</p></div>';
   $('#grafica16').data('powertip', tabla_linea_venta);
}

function obtenerGrafica29(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventasPorProducto;
   }
   //   console.log(chartData);
   var chart = AmCharts.makeChart("grafica29", {
      "type": "serial",
      "theme": "none",
      "marginRight": 70,
      "titles": [{
            "text": "Cotización de Servicios Operativos",
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
            "valueField": "total"
         }],
      "chartCursor": {
         "categoryBalloonEnabled": false,
         "cursorAlpha": 0,
         "zoomable": false
      },
      "categoryField": "mes",
      "categoryAxis": {
         "gridPosition": "start",
         "labelRotation": 0
      },
      "export": {
         "enabled": true
      }

   });
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventasPorProducto;
   }
   var tabla_linea_venta = '' +
           '<div class="col-sm-12 fondoBlanco">' +
           '<h5 class="negrita letraRosa">Ventas Mensuales<h5>' +
           '<table class="table tablaLinea">' +
           '<thead>' +
           ' <tr>' +
           '<th><p class="text-center">Mes</p></th>' +
           '<th><p class="text-center">Valor</p></th>' +
           '</tr>' +
           '</thead>' +
           '<tbody id="cuerpo_venta_linea">';


   $.each(chartData, function (k, v) {
      tabla_linea_venta += '<tr>' +
              '<td><p class="text-center">' + v.mes + '</p></td>' +
              '<td><p class="text-center">$' + v.value + '</p></td>' +
              '</tr>';
   });
   tabla_linea_venta += '</tbody>' +
           '</table>' +
           '</div>' +
           '<div class="col-sm-12 no-padding"><p class="expresadaMilesPowerTip">*Cifra expresada en miles</p></div>';
   $('#grafica29').data('powertip', tabla_linea_venta);
}

function filtro_general_3() {

   var bandera = $('#form_filtro_general_3').validationEngine('validate');

   if (bandera) {
      var formData = $("#form_filtro_general_3").serialize();

      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_1',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_general_3').find('input').val('');
         $('#modal_filtro_general_3').modal('hide');
         obtenerGrafica12(result);

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
         $('#form_filtro_general_3').find('input').val('');
         $('#modal_filtro_general_3').modal('hide');
         obtenerGrafica13(result);

      });
      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_2_venta',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_general_3').find('input').val('');
         $('#modal_filtro_general_3').modal('hide');
         obtenerGrafica14(result);

      });
      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_2_venta_top',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_general_3').find('input').val('');
         $('#modal_filtro_general_3').modal('hide');
         tabla_cuerpo_venta_top(result);

      });
      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_2_venta_sector',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_general_3').find('input').val('');
         $('#modal_filtro_general_3').modal('hide');
         obtenerGrafica16(result);

      });
      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_2_venta_producto',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_general_3').find('input').val('');
         $('#modal_filtro_general_3').modal('hide');
         obtenerGrafica29(result);

      });
   }
}

function filtro_ventas_mensuales() {

   var bandera = $('#form_filtro_ventas_mensuales').validationEngine('validate');

   if (bandera) {
      var formData = $("#form_filtro_ventas_mensuales").serialize();

      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_1',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_ventas_mensuales').find('input').val('');
         $('#modal_filtro_ventas_mensuales').modal('hide');
         obtenerGrafica12(result);

      });
   }
}

function filtro_ventas_negocio() {

   var bandera = $('#form_filtro_ventas_negocio').validationEngine('validate');

   if (bandera) {
      var formData = $("#form_filtro_ventas_negocio").serialize();

      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_2_venta_linea',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_ventas_negocio').find('input').val('');
         $('#modal_filtro_ventas_negocio').modal('hide');
         obtenerGrafica13(result);

      });
   }
}

function filtro_ventas_asesor() {

   var bandera = $('#form_filtro_ventas_asesor').validationEngine('validate');

   if (bandera) {
      var formData = $("#form_filtro_ventas_asesor").serialize();

      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_2_venta',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_ventas_asesor').find('input').val('');
         $('#modal_filtro_ventas_asesor').modal('hide');
         obtenerGrafica14(result);

      });
   }
}

function filtro_ventas_cliente() {

   var bandera = $('#form_filtro_ventas_cliente').validationEngine('validate');

   if (bandera) {
      var formData = $("#form_filtro_ventas_cliente").serialize();

      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_2_venta_top',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_ventas_cliente').find('input').val('');
         $('#modal_filtro_ventas_cliente').modal('hide');
         tabla_cuerpo_venta_top(result);

      });
   }
}

function filtro_ventas_sector() {

   var bandera = $('#form_filtro_ventas_sector').validationEngine('validate');

   if (bandera) {
      var formData = $("#form_filtro_ventas_sector").serialize();

      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_2_venta_sector',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_ventas_sector').find('input').val('');
         $('#modal_filtro_ventas_sector').modal('hide');
         obtenerGrafica16(result);
      });
   }
}

function filtro_ventas_producto() {

   var bandera = $('#form_filtro_ventas_producto').validationEngine('validate');

   if (bandera) {
      var formData = $("#form_filtro_ventas_producto").serialize();

      $.ajax({
         url: 'index.php?modulo=reportes&accion=filtro_general_2_venta_producto',
         type: "GET",
         dataType: "json",
         data: formData,
         cache: false,
         contentType: false,
         processData: false

      }).done(function (result) {
         $('#form_filtro_ventas_producto').find('input').val('');
         $('#modal_filtro_ventas_producto').modal('hide');
         obtenerGrafica29(result);

      });
   }
}

function limpiar_filtro_general_3() {
   obtenerGrafica12();
   obtenerGrafica13();
   obtenerGrafica14();
   tabla_cuerpo_venta_top();
   obtenerGrafica16();
   obtenerGrafica29();
   $('#form_filtro_general_3').find('input').val('');
   $('#modal_filtro_general_3').modal('hide');
}

function limpiar_filtro_ventas_mensuales() {
   obtenerGrafica12();
   $('#form_filtro_ventas_mensuales').find('input').val('');
   $('#modal_filtro_ventas_mensuales').modal('hide');
}

function limpiar_filtro_ventas_negocio() {
   obtenerGrafica13();
   $('#form_filtro_ventas_negocio').find('input').val('');
   $('#modal_filtro_ventas_negocio').modal('hide');
}

function limpiar_filtro_ventas_asesor() {
   obtenerGrafica14();
   $('#form_filtro_ventas_asesor').find('input').val('');
   $('#modal_filtro_ventas_asesor').modal('hide');
}

function limpiar_filtro_ventas_cliente() {
   tabla_cuerpo_venta_top();
   $('#form_filtro_ventas_cliente').find('input').val('');
   $('#modal_filtro_ventas_cliente').modal('hide');
}

function limpiar_filtro_ventas_sector() {
   obtenerGrafica16();
   $('#form_filtro_ventas_sector').find('input').val('');
   $('#modal_filtro_ventas_sector').modal('hide');
}

function limpiar_filtro_ventas_producto() {
   obtenerGrafica29();
   $('#form_filtro_ventas_producto').find('input').val('');
   $('#modal_filtro_ventas_producto').modal('hide');
}

function tabla_cuerpo_venta_top(data) {
   if (typeof data != "undefined") {
      var chartData = data;
   } else {
      var chartData = s3vars.ventasTop;
   }
   var tabla_cuerpo_venta_top = '';
   $.each(chartData, function (k, v) {

      tabla_cuerpo_venta_top += '<div class="col-sm-12 no-padding fondoGris marginTopCliente">' +
              '<div class="col-sm-12 no-padding fondoBlanco filaTopCliente">' +
              '<div class="col-sm-2 no-padding fondoAzul"><p class="posicionTopCliente">' + (k + 1) + '</p></div>' +
              '<div class="col-sm-3 no-padding"><p class="cuentaTopCliente">' + v.nombre + '</p></div>' +
              '<div class="col-sm-5 no-padding"><p class="valorTopCliente">$' + v.total + '</p></div>';
      if (v.imagen !== null) {
         tabla_cuerpo_venta_top += '<div class="col-sm-2 no-padding"><img class="col-sm-12 no-padding img-rounded" src="uploads/img_cuenta/' + v.imagen + '" style="position: absolute;"></div>';
      } else {
         tabla_cuerpo_venta_top += '<div class="col-sm-2 no-padding"><img class="col-sm-12 no-padding img-rounded" src="uploads/img_cuenta/sin_avatar.jpg" style="position: absolute;"></div>';
      }
      tabla_cuerpo_venta_top += '</div>' +
              '</div>';

   });
   $("#cuerpo_venta_top").html(tabla_cuerpo_venta_top);
}

//{if condition="!empty($ventasTop.imagen)"}
//                         <div class="col-sm-2 no-padding"><img class="col-sm-12 no-padding img-rounded" src="uploads/img_cuenta/{$ventasTop.imagen}" style="position: absolute;"></div>
//          {else}
//                         <div class="col-sm-2 no-padding"><img class="col-sm-12 no-padding img-rounded" src="uploads/img_cuenta/sin_avatar.jpg" style="position: absolute;"></div>
//          {/if}



function crearSlider() {
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
      } else {
         slider.disable();
      }
   });
}

function crearSlider2() {
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
      } else {
         slider2.disable();
      }
   });
}

function crearSlider3() {
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
      } else {
         slider3.disable();
      }
   });
}

function crearSlider4() {
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
      } else {
         slider4.disable();
      }
   });
}

function crearSlider5() {
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
      } else {
         slider5.disable();
      }
   });
}

function crearSlider6() {
   $('#sliderBootstrap6').html('');
   $('#sliderBootstrap6').html('<div class="form-group">' +
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
      } else {
         slider6.disable();
      }
   });
}

function crearSlider7() {
   $('#sliderBootstrap7').html('');
   $('#sliderBootstrap7').html('<div class="form-group">' +
           '<label class="control-label col-sm-3" for="rango">Rango de Valores <small>(en miles)</small>:</label>' +
           '<div class="col-sm-7 no-padding">' +
           ' <b>$ 1</b> <input id="rango7" name="rango" type="text" class="span2" value="" data-slider-min="1" data-slider-max="100000" data-slider-step="10" data-slider-value="[1,100000]"/> <b>$ 100.000</b>' +
           '</div>' +
           ' <div class="col-sm-2 no-padding">' +
           ' <div class="col-sm-2 no-padding"><input class="form-control" id="rango7-enabled" name="conRango" type="checkbox"/></div><div class="col-sm-10"><p class="text-center"> Con Rango de Valores</p></div>' +
           ' </div>' +
           ' </div>');
   var slider7 = new Slider("#rango7");
   slider7.disable();
   $("#rango7-enabled").click(function () {
      if (this.checked) {
         slider7.enable();
      } else {
         slider7.disable();
      }
   });
}
function powerTipLinea() {
   // mouse follow
   $("#grafica13")
           .mouseenter(function () {
              $('#grafica13').on('click', function () {
                 $('#grafica13').powerTip({
                    followMouse: true,
                    mouseOnToPopup: true
                 });
                 $('#grafica13').powerTip('show');
              });
           })
           .mouseleave(function () {

           });

   $('#grafica13').powerTip({manual: true});

// hook custom mouse events
   $('#grafica13').on({
      mouseenter: function (event) {
         $('#grafica13').on('click', function () {
            $('#grafica13').powerTip({
               followMouse: true
            });
         });
      },
      mouseleave: function () {
         $('#grafica13').powerTip({
            followMouse: true
         });

         try {
            $.powerTip.destroy(this);
         } catch (e) {

         }
      }
   });
}
function powerTipMensuales() {
   // mouse follow
   $("#grafica12")
           .mouseenter(function () {
              $('#grafica12').on('click', function () {
                 $('#grafica12').powerTip({
                    followMouse: true,
                    mouseOnToPopup: true
                 });
                 $('#grafica12').powerTip('show');
              });
           })
           .mouseleave(function () {

           });

   $('#grafica12').powerTip({manual: true});

// hook custom mouse events
   $('#grafica12').on({
      mouseenter: function (event) {
         $('#grafica12').on('click', function () {
            $('#grafica12').powerTip({
               followMouse: true
            });
         });
      },
      mouseleave: function () {
         $('#grafica12').powerTip({
            followMouse: true
         });
         $.powerTip.destroy(this);
      }
   });
}
function powerTipAsesor() {
   // mouse follow
   $("#grafica14")
           .mouseenter(function () {
              $('#grafica14').on('click', function () {
                 $('#grafica14').powerTip({
                    followMouse: true,
                    mouseOnToPopup: true
                 });
                 $('#grafica14').powerTip('show');
              });
           })
           .mouseleave(function () {

           });

   $('#grafica14').powerTip({manual: true});

// hook custom mouse events
   $('#grafica14').on({
      mouseenter: function (event) {
         $('#grafica14').on('click', function () {
            $('#grafica14').powerTip({
               followMouse: true
            });
         });
      },
      mouseleave: function () {
         $('#grafica14').powerTip({
            followMouse: true
         });
         $.powerTip.destroy(this);
      }
   });
}
function powerTipSector() {
   // mouse follow
   $("#grafica16")
           .mouseenter(function () {
              $('#grafica16').on('click', function () {
                 $('#grafica16').powerTip({
                    followMouse: true,
                    mouseOnToPopup: true
                 });
                 $('#grafica16').powerTip('show');
              });
           })
           .mouseleave(function () {

           });

   $('#grafica16').powerTip({manual: true});

// hook custom mouse events
   $('#grafica16').on({
      mouseenter: function (event) {
         $('#grafica16').on('click', function () {
            $('#grafica16').powerTip({
               followMouse: true
            });
         });
      },
      mouseleave: function () {
         $('#grafica16').powerTip({
            followMouse: true
         });
         $.powerTip.destroy(this);
      }
   });
}
function powerTipProducto() {
   // mouse follow
   $("#grafica29")
           .mouseenter(function () {
              $('#grafica29').on('click', function () {
                 $('#grafica29').powerTip({
                    followMouse: true,
                    mouseOnToPopup: true
                 });
                 $('#grafica29').powerTip('show');
              });
           })
           .mouseleave(function () {

           });

   $('#grafica29').powerTip({manual: true});

// hook custom mouse events
   $('#grafica29').on({
      mouseenter: function (event) {
         $('#grafica29').on('click', function () {
            $('#grafica29').powerTip({
               followMouse: true
            });
         });
      },
      mouseleave: function () {
         $('#grafica29').powerTip({
            followMouse: true
         });
         $.powerTip.destroy(this);
      }
   });
}
