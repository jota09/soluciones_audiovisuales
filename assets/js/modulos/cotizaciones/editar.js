window.onload = function () {
   $('input[name^="detalle_total"]').attr('readonly', 'readonly');
   if (s3vars.registro == '') {
      var d = new Date();
      var caducidad = sumarDias(d, 30);
      var dd = caducidad.getDate(), mm = caducidad.getMonth() + 1, yyyy = caducidad.getFullYear();
      var fecha = yyyy + '-' + mm + '-' + dd;
      $("#fecha_caducidad").val(fecha);
   }
   $('input[id^="detalle_valor_unitario_"]').attr('readonly', 'readonly');
   
}

var fila = 1;
var editor = "";
var bandera_modal = 0;
$(document).ready(function () {
   $('#cuenta_id').select2('readonly', false);

   triggersDetalle_cotizacion();

   $("#cuenta_id").change(function () {
      buscaOportunidadesXCuenta($("#cuenta_id").val());
   });

   $(".modal-transparent").on('show.bs.modal', function () {
      setTimeout(function () {
         $(".modal-backdrop").addClass("modal-backdrop-transparent");
      }, 0);
   });
   $(".modal-transparent").on('hidden.bs.modal', function () {
      $(".modal-backdrop").addClass("modal-backdrop-transparent");
   });

   $("#iva").change(function (k, v) {
      calcularTotal();
   });

   if (s3vars.registro.id > 0) {
      agregarDetalleCotizacion();
   } else {
      $("#descuento").val(0);
      $("#subtotal").val(0);
      $("#subtotal_descuento").val(0);
      $("#valor_iva").val(0);
      $("#total").val(0);

   }

   $("#btn_enviar_correo").unbind('click').click(function () {
      enviarCotizacionCorreo();
   });

   cargarEditor();
   $('#btn_agregar_detalle_cotizacion2').click(function () {     
      if ($('#cuenta_id').validationEngine('validate') && $('#fecha_cierre').validationEngine('validate')){
         cargar_productos();         
      }
      else{
         bootbox.alert("Verifique que la Fecha de Cierre y/o Cuenta sean validos");
      }
   });

});

function cargar_productos() {
   $.ajax({
      type: "POST",
      url: 'index.php?modulo=productos&accion=obtenerProductos',
      data: 'modulo_name=' + s3vars.modulo + '&fecha_cierre=' + $("#fecha_cierre").val() + '&cuenta_id=' + $("#cuenta_id").val(),
      dataType: "json",
      beforeSend: function () {
               $('#btn_agregar_detalle_cotizacion2').attr('disabled', 'disabled');
            },
   }).done(function (result) {
      $('#lista_productos').modal('show');
      productos = '';
      productos = result;
      crearTablaListaProductos();
      $('#btn_agregar_detalle_cotizacion2').removeAttr('disabled');

   });
}


function crearTablaListaProductos() {

   var tabla = $('#tabla_listar_productos').DataTable();
   tabla.destroy();
    $('#tabla_listar_productos tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input name="'+title+'" type="text" placeholder="Buscar '+title+'" />' );
    } );
   
   var tablaPopups = $('#tabla_listar_productos').DataTable({
      "ordering": false,
      data: productos['pro'],
      "columns": productos['campos'],
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
         $.each($(nRow).find('td'), function (a, b) {
            if (a == 2) {
               $(b).html('<a class="">' + $(b).text() + '</a>');
               $(b).unbind('click').click(function () {
                  agregarNuevoDetalleCotizacion2(aData);
                  $('#lista_productos').modal("hide");
               });
            }
         });
      }
   });
   tablaPopups.column( 4 ).visible( false );
   // Apply the search
   tablaPopups.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

}


function sumarDias(fecha, dias) {
   fecha.setDate(fecha.getDate() + dias);
   return fecha;
}

function agregarNuevoDetalleCotizacion() {
   fila++;
   var html = '<div class="form-group col-sm-12 no-padding-right"> ' +
           '<input type="hidden" class="id" name="detalle_cotizacion_id[]" value="">' +
           '<input type="hidden" name="detalle_producto_id[]" id="detalle_producto_id_' + fila + '" value="">' +
           '<input type="hidden" class="eliminado" name="detalle_cotizacion_eliminado[]" value="0">' +
           '<div class="col-sm-1 no-padding-right">' +
           '<input type="text" class="form-control validate[required]" value="1" id="detalle_cantidad_' + fila + '" name="detalle_cantidad[]" onkeyup="calcularTotal(); return soloNumeros(event); " > </div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="text" class="form-control " value="" id="detalle_categoria_' + fila + '" name="detalle_categoria[]" readonly="readonly" ></div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="text" class="form-control " value="" id="detalle_referencia_' + fila + '" name="detalle_referencia[]" onkeyup="buscarProducto(this);"  ></div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<textarea class="form-control" name="detalle_descripcion[]" id="detalle_descripcion_' + fila + '" rows="2" readonly="readonly"></textarea></div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="text" class="form-control validate[required] text-right number" value="" id="detalle_valor_unitario_' + fila + '" readonly="readonly" name="detalle_valor_unitario[]" onkeyup="calcularTotal(); return soloNumeros(event); " ></div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="text" class="form-control validate[required] text-right number" id="detalle_total_' + fila + '"  readonly="readonly" value="" name="detalle_total[]"  ></div> ' +
           '<div class="col-sm-1 no-padding-right"> ' +
           '<button type="button" class="btn btn_eliminar_reg_detalle_cotizacion btn-default center-block btn-sm"><i class="fa fa-minus"></i></button> </div> ' +
           '</div>';

   $('#detalle_cotizacion').append(html);
   $('.number').number(true, 0, '.', ',');
   triggersDetalle_cotizacion();
}

function agregarNuevoDetalleCotizacion2(aData) {
   fila++;
   var html = '<div class="form-group col-sm-12 no-padding-right"> ' +
           '<input type="hidden" class="id" name="detalle_cotizacion_id[]" value="">' +
           '<input type="hidden" name="detalle_producto_id[]" id="detalle_producto_id_' + fila + '" value="' + aData.id + '">' +
           '<input type="hidden" class="eliminado" name="detalle_cotizacion_eliminado[]" value="0">' +
           '<div class="col-sm-1 no-padding-right">' +
           '<input type="text" class="form-control validate[required]" value="1" id="detalle_cantidad_' + fila + '" name="detalle_cantidad[]" onkeyup="calcularTotal(); return soloNumeros(event); " > </div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="text" class="form-control " value="' + aData.categoria + '" id="detalle_categoria_' + fila + '" name="detalle_categoria[]" readonly="readonly" ></div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="text" class="form-control " value="' + aData.referencia + '" id="detalle_referencia_' + fila + '" name="detalle_referencia[]" onkeyup=""  ></div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<textarea class="form-control" name="detalle_descripcion[]" id="detalle_descripcion_' + fila + '" rows="2" readonly="readonly">' + aData.descripcion + '</textarea></div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="text" class="form-control validate[required] text-right number" value="' + aData.precio + '" id="detalle_valor_unitario_' + fila + '" readonly="readonly" name="detalle_valor_unitario[]" onkeyup="calcularTotal(); return soloNumeros(event); " ></div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="text" class="form-control validate[required] text-right number" id="detalle_total_' + fila + '"  readonly="readonly" value="' + aData.precio + '" name="detalle_total[]"  ></div> ' +
           '<div class="col-sm-1 no-padding-right"> ' +
           '<button type="button" class="btn btn_eliminar_reg_detalle_cotizacion btn-default center-block btn-sm"><i class="fa fa-minus"></i></button> </div> ' +
           '</div>';

   $('#detalle_cotizacion').append(html);
   $('.number').number(true, 0, '.', ',');
   triggersDetalle_cotizacion();
}

function eliminarCampoRegistroDetalleCotizacion(div) {
   if ($(div).find('.id').val() > 0 && $(div).find('.id').val() != "" && $(div).find('.id').val() != "0") {
      $(div).find('.eliminado').val(1);
      $(div).addClass('hidden');
   } else {
      $(div).remove();
   }
}


function triggersDetalle_cotizacion() {
   $('.btn_eliminar_reg_detalle_cotizacion').click(function () {
      eliminarCampoRegistroDetalleCotizacion($(this).parent().parent());
   });
   $('input[id^="detalle_valor"]').removeAttr('readonly');

}

function buscaOportunidadesXCuenta(cuenta) {
   $("#load-buscar-general").removeClass('hidden');
   $.ajax({
      type: "POST",
      url: 'index.php?modulo=oportunidades&accion=OportunidadXCuenta',
      data: {modulo_id: cuenta, modulo_name: 'cuentas'},
      dataType: "json",
   }).done(function (result) {
      console.log(result);
      $("#oportunidad_id option").remove();
      var html = '';
      $.each(result, function (k, v) {
         html += '<option value="' + v.id + '" > ' + v.referencia + ' </option>';

      });

      $("#oportunidad_id").append(html);
      $("#load-buscar-general").addClass('hidden');

   });
}


function buscarProducto(obj) {
   //  console.log($(obj).val());

   $(obj).autocomplete({
      minLength: 1,
      source: function (request, response) {
         $.ajax({
            url: "index.php",
            dataType: "json",
            async: true,
            method: 'GET',
            data: {
               'modulo': 'productos',
               'accion': 'ObtenerProductosXNombre',
               'nombre': request.term,
               'cotizacion': true,
               'fecha_cotizacion': $("#fecha_cierre").val(),
               'cuenta': $("#cuenta_id").val()
            },
            beforeSend: function () {
               $('#load-buscar-general').removeClass('hidden');
               $('#btn_agregar').attr('disabled', 'disabled');
            },
            success: function (data) {

               $('#load-buscar-general').addClass('hidden');

               response(data);
            },
            error: function (err) {
               console.log('err' + err);
            }
         }).done(function (done) {

            if (done.length == 0) {
               $('#btn_agregar').removeAttr('disabled');
            }
            if (done.length == 0 && s3vars.accion == "editar" && s3vars.registro == "") {

            } else if (done.length == 0 && s3vars.accion == "editar" && s3vars.registro != "") {
               console.log("NO nuevo");
            }

         }).fail(function (fail) {
            console.log('fail' + fail);
         });
      },
      select: function (event, ui) {


         myVar = setInterval(function () {
            cargarProductoSeleccionado(ui.item, $(obj));
         }, 500);
         //location.href = 'index.php?modulo=' + ui.item.modulo + '&accion=' + ui.item.accion + '&' + ui.item.variable_nombre + '=' + ui.item.variable_valor;
      }
   }).data("ui-autocomplete")._renderItem = function (ul, item) {

      //$('#load-buscar-general').addClass('hidden');
      return $("<li>").append("<a >" + item.referencia + "</a>").appendTo(ul);

   };

}

function cargarProductoSeleccionado(reg, obj) {

   var aux = obj.attr('id').split("_");
   console.log(reg);

   $("#detalle_codigo_" + aux[2]).val(reg.codigo);
   $("#detalle_producto_id_" + aux[2]).val(reg.producto_id);
   $("#detalle_categoria_" + aux[2]).val(reg.categoria);
   $("#" + obj.attr('id')).val(reg.referencia);
   $("#detalle_descripcion_" + aux[2]).val(reg.descripcion);
   $("#detalle_valor_unitario_" + aux[2]).val(reg.precio);

   calcularTotal();

   clearInterval(myVar);

}

function calcularTotal() {
   var porcentaje_id = $("#iva").val();
   if (s3vars.modulo != 'cotizaciones') {
      $.each(s3vars.listasM3.iva, function (k, v) {
         if (v.id == porcentaje_id) {
            porcentaje_iva = parseInt(v.nombre);
         }
      });
   }
   if (s3vars.modulo == 'cotizaciones') {
      $.each(s3vars.listasM.iva, function (k, v) {
         if (v.id == porcentaje_id) {
            porcentaje_iva = parseInt(v.nombre);
         }
      });
   }
   var subtotal = 0;
   for (var i = 1; i <= fila; i++) {

      if ($("#detalle_cantidad_" + i).val() !== undefined) {
         var total = parseInt($("#detalle_cantidad_" + i).val() * $("#detalle_valor_unitario_" + i).val());
         $("#detalle_total_" + i).val(total);
         subtotal += total;
      }
   }

   var descuento = parseInt($("#descuento").val());
   var subtotal_descuento = subtotal - descuento;
   var iva = subtotal_descuento * (parseInt(porcentaje_iva) / 100);
   var total_total = subtotal_descuento + iva;

   $("#subtotal").val(subtotal);
   $("#subtotal_descuento").val(subtotal_descuento);
   $("#valor_iva").val(iva);
   $("#total").val(total_total);

   s3vars.cuenta_cotizacion.forEach(function (item, index, array) {
      if (item.id === $("#cuenta_id").val()) {
         if ((parseInt(item.disponible) - parseInt($("#total").val())) < 0 && bandera_modal == 0) {
            bandera_modal++;
            $('#modal-transparent').modal('toggle');
            setTimeout(function () {
               $('#modal-transparent').modal('toggle');
            }, 2000);
         }
      }
   });




   return true;
}

function agregarDetalleCotizacion() {

   $.each(s3vars.detalles, function (kk, vv) {
      console.log(vv);

      var html = '<div class="form-group col-sm-12 no-padding-right"> ' +
              '<input type="hidden" class="id" name="detalle_cotizacion_id[]" value="' + vv.id + '">' +
              '<input type="hidden" name="detalle_producto_id[]" id="detalle_producto_id_' + fila + '"  value="' + vv.producto_id + '">' +
              '<input type="hidden" class="eliminado" name="detalle_cotizacion_eliminado[]" value="0">' +
              '<div class="col-sm-1 no-padding-right editar_js">' +
              '<input type="text" class="form-control validate[required]"  value="' + vv.cantidad + '" id="detalle_cantidad_' + fila + '" name="detalle_cantidad[]"  onkeyup="calcularTotal(); return soloNumeros(event); " > </div> ' +
              '<label class="control-label col-sm-1 ver_js" >' + vv.cantidad + '</label>' +
              '<div class="col-sm-2 no-padding-right editar_js"> ' +
              '<input type="text" class="form-control "  value="' + vv.categoria + '" id="detalle_categoria_' + fila + '" name="detalle_categoria[]" readonly="readonly" ></div> ' +
              '<label class="control-label col-sm-2 ver_js" >' + vv.categoria + '</label>' +
              '<div class="col-sm-2 no-padding-right editar_js"> ' +
              '<input type="text" class="form-control "  value="' + vv.referencia + '" id="detalle_referencia_' + fila + '" name="detalle_referencia[]" onkeyup="buscarProducto(this);"  ></div> ' +
              '<label class="control-label col-sm-2 ver_js" >' + vv.referencia + '</label>' +
              '<div class="col-sm-2 no-padding-right editar_js"> ' +
              '<textarea class="form-control" name="detalle_descripcion[]" id="detalle_descripcion_' + fila + '" rows="2" readonly="readonly">' + vv.descripcion + '</textarea></div> ' +
              '<label class="control-label col-sm-2 ver_js" >' + vv.descripcion + '</label>' +
              '<div class="col-sm-2 no-padding-right editar_js"> ' +
              '<input type="text" class="form-control validate[required] text-right number"  value="' + vv.valor_unitario + '" id="detalle_valor_unitario_' + fila + '" readonly="readonly" name="detalle_valor_unitario[]"  onkeypress="calcularTotal(); return soloNumeros(event);" ></div> ' +
              '<label class="control-label col-sm-2 ver_js" >' + vv.valor_unitario + '</label>' +
              '<div class="col-sm-2 no-padding-right editar_js"> ' +
              '<input type="text" class="form-control validate[required] text-right number" id="detalle_total_' + fila + '" readonly="readonly"  value="' + vv.valor_unitario * vv.cantidad + '" name="detalle_total[]" readonly="readonly"  onkeypress="return soloNumeros(event);" ></div> ' +
              '<label class="control-label col-sm-2 ver_js" style="text-align:right;">' + vv.detalle_total + '</label>' +
              '<div class="col-sm-1 no-padding-right editar_js"> ' +
              '<button type="button" class="btn btn_eliminar_reg_detalle_cotizacion btn-default center-block btn-sm"><i class="fa fa-minus"></i></button> </div> ' +
              '</div>';

      $('#detalle_cotizacion').append(html);
      triggersDetalle_cotizacion();

      $(".editar_js").css({display: "none"});
      $('.number').number(true, 0, '.', ',');
      fila++;
   });

   calcularTotal();
}

function enviarCotizacionCorreo() {
   $("#add_msg").html("").html("Enviando correo");
   $('#Esperar').modal('show');
   $.ajax({
      type: "POST",
      url: 'index.php?modulo=cotizaciones&accion=enviarCotizacion',
      data: {registro_id: s3vars.registro.id, cuenta_id: $("#cuenta_id").val(), detalle_correo: editor.getData(), remitentes: $('#remitentes').val().join(',')},
      dataType: "json",
   }).done(function (result) {
      $('#remitentes').select2('val', '');
      editor.setData("");
      $('#Esperar').modal('hide');
      $('#enviar_correo').modal('hide');

      if (result != '') {
         bootbox.alert("El correo ha sido envio corectamente a los siguientes direcciones de correo: <b>" + result + "</b>");
      }

   });
}

function cargarEditor() {
   editor = CKEDITOR.replace('enviar_detalle_correo', {
      toolbar: [
         //['Source','-','Save','NewPage','Preview','-','Templates'],
         //['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
         //['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
         //['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
         //'/',
         ['Bold', 'Italic', 'Underline', 'Strike'], //,'-','Subscript','Superscript'
         ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote'],
         ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
         //['Link','Unlink','Anchor'],
         ['Image'], //,'PageBreak','HorizontalRule','Flash', 'Table', 'Smiley', 'SpecialChar'
         //'/',
         ['Styles', 'Format', 'Font', 'FontSize'],
         ['TextColor', 'BGColor'],
                 //['Maximize', 'ShowBlocks','-','About','EqnEditor']
      ]
              //'Basic',
              //filebrowserBrowseUrl: 'librerias/php/kcfinder//filemanager/index.php',
              //filebrowserUploadUrl: 'uploader/upload.php',
              /*filebrowserBrowseUrl: 'librerias/php/kcfinder/browse.php?opener=ckeditor&type=files',
               filebrowserImageBrowseUrl: 'librerias/php/kcfinder/browse.php?opener=ckeditor&type=images',
               filebrowserFlashBrowseUrl: 'librerias/php/kcfinder/browse.php?opener=ckeditor&type=flash',
               filebrowserUploadUrl: 'librerias/php/kcfinder/upload.php?opener=ckeditor&type=files',
               filebrowserImageUploadUrl: 'librerias/php/kcfinder/upload.php?opener=ckeditor&type=images',
               filebrowserFlashUploadUrl: 'librerias/php/kcfinder/upload.php?opener=ckeditor&type=flash',*/
   });
}
