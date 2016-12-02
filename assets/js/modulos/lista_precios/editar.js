var fila = 1;
var myVar = 0;
$(document).ready(function () {
   $('#cuenta_id').select2('readonly', false);

   triggersprecio_lista();

   $("#tipo_id").change(function () {
      if ($(this).val() == 16) { // Clasificacion
         $("#clasificacion_id").addClass("validate[required]").parent().parent().parent().removeClass('hidden');
         $("#cuenta_id").removeClass("validate[required]").parent().parent().parent().addClass('hidden');
      } else {
         $("#cuenta_id").addClass("validate[required]").parent().parent().parent().removeClass('hidden');
         $("#clasificacion_id").removeClass("validate[required]").parent().parent().parent().addClass('hidden');
      }
   });

   if (s3vars.registro.id > 0) {
      $.each(s3vars.registroPrecios, function (index, val) {
         agregarprecio_lista_editar(val);
      });

      if ($("#tipo_id").val() == 16) { // Clasificacion
         $("#clasificacion_id").addClass("validate[required]").parent().parent().parent().removeClass('hidden');
         $("#cuenta_id").removeClass("validate[required]").parent().parent().parent().addClass('hidden');
      } else {
         $("#cuenta_id").addClass("validate[required]").parent().parent().parent().removeClass('hidden');
         $("#clasificacion_id").removeClass("validate[required]").parent().parent().parent().addClass('hidden');
      }
   }

});

function agregarprecio_lista_editar(data) {
   
   fila++;
   var html = '<div class="form-group col-sm-12 no-padding-right"> ' +
           '<input type="hidden" class="id" name="precio_id[]" value="' + data.precio_id + '">' +
           '<input type="hidden" class="eliminado" name="precio_eliminado[]" value="0">' +
           '<div class="col-sm-1"> <label> </label> </div>' +
           '<div class="col-sm-2 no-padding-right editar_js">' +
           '<input type="text" class="form-control" value="' + data.codigo + '" id="codigo_' + fila + '" readonly="readonly" > </div> ' +
           '<label class="control-label col-sm-2 ver_js" >' + data.codigo + '</label>' +
           '<div class="col-sm-2 no-padding-right editar_js"> ' +
           '<input type="hidden" value="' + data.producto_id + '" id="producto_id_' + fila + '" name="producto_id[]" >' +
           '<textarea class="form-control categoria_prod" value="" id="categoria_' + fila + '" readonly="readonly" >' + data.categoria + '</textarea></div> ' +
           '<label class="control-label col-sm-2 ver_js" >' + data.categoria + '</label>' +
           '<div class="col-sm-2 no-padding-right editar_js"> ' +
           '<input type="text" class="form-control product-id validate[required,funcCall[verificarProduct]]" id="referencia_' + fila + '" data-product-id="' + data.producto_id + '" value="' + data.referencia + '" onkeyup="buscarProducto(this);"  ></div> ' +
           '<label class="control-label col-sm-2 ver_js" >' + data.referencia + '</label>' +
           '<div class="col-sm-2 no-padding-right editar_js"> ' +
           '<input type="text" class="form-control validate[required] number" id="precio_' + fila + '" value="' + data.precio + '" name="precio[]"  onkeypress="return soloNumeros(event);" ></div> ' +
           '<label class="control-label col-sm-2 ver_js" >' + data.precio + '</label>' +
           '<div class="col-sm-1 no-padding-right editar_js"> ' +
           '<i id="load-buscar-general_' + fila + '" class="fa fa-circle-o-notch fa-spin hidden" style="color: #002a80; "></i>';
   if (fila > 2) {
      html += '<button type="button" class="btn btn_eliminar_reg_precio_lista btn-default center-block btn-sm pull-right"><i class="fa fa-minus"></i></button>';
   }
   html += ' </div> ' +
           '</div>';

   $('#precio_lista').append(html);
   $(".editar_js").css({display: "none"});
   $('.number').number(true, 0, '.', ',');
   triggersprecio_lista();
}

function agregarprecio_lista() {
   fila++;
   var html = '<div class="form-group col-sm-12 no-padding-right"> ' +
           '<input type="hidden" class="id" name="precio_id[]" value="">' +
           '<input type="hidden" class="eliminado" name="precio_eliminado[]" value="0">' +
           '<div class="col-sm-1"> <label> </label> </div>' +
           '<div class="col-sm-2 no-padding-right">' +
           '<input type="text" class="form-control" value="" id="codigo_' + fila + '" readonly="readonly" > </div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="hidden" value="" id="producto_id_' + fila + '" name="producto_id[]" >' +
           '<textarea class="form-control categoria_prod" id="categoria_' + fila + '" readonly="readonly" ></textarea></div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="text" class="form-control product-id validate[required,funcCall[verificarProduct]]"  id="referencia_' + fila + '" value="" onkeyup="buscarProducto(this);"  ></div> ' +
           '<div class="col-sm-2 no-padding-right"> ' +
           '<input type="text" class="form-control validate[required] number" id="precio_' + fila + '" value="" name="precio[]"  onkeypress="return soloNumeros(event);" ></div> ' +
           '<div class="col-sm-1 no-padding-right"> ' +
           '<i id="load-buscar-general_' + fila + '" class="fa fa-circle-o-notch fa-spin hidden" style="color: #002a80; "></i>' +
           '<button type="button" class="btn btn_eliminar_reg_precio_lista btn-default center-block btn-sm pull-right"><i class="fa fa-minus"></i></button> </div> ' +
           '</div>';

   $('#precio_lista').append(html);
   $('.number').number(true, 0, '.', ',');
   triggersprecio_lista();
//  alert(fila);
//   console.log(fila);
}

function eliminarCampoRegistroDetalleCotizacion(div) {

   bootbox.confirm({
      message: "Esta seguro que desea eliminar realmente este producto?",
      buttons: {
         confirm: {
            label: 'SI',
            className: 'btn-success'
         },
         cancel: {
            label: 'NO',
            className: 'btn-danger'
         }
      },
      callback: function (result) {
         if (result == true) {
            if ($(div).find('.id').val() > 0 && $(div).find('.id').val() != "" && $(div).find('.id').val() != "0") {
               $(div).find('.eliminado').val(1);
               $(div).find('.product-id').removeAttr("data-product-id");
               $(div).addClass('hidden');
            } else {
               $(div).remove();
            }
         }
      }
   });
}

function triggersprecio_lista() {
   $(".btn_eliminar_reg_precio_lista").unbind("click");
   $('.btn_eliminar_reg_precio_lista').click(function () {
      eliminarCampoRegistroDetalleCotizacion($(this).parent().parent());
   });

}

function buscarProducto(obj) {
   console.log($(obj).val());
   var aux = $(obj).attr('id').split("_");

   $(obj).autocomplete({
      minLength: 3,
      source: function (request, response) {
         $.ajax({
            url: "index.php",
            dataType: "json",
            async: true,
            method: 'GET',
            data: {
               'modulo': 'productos',
               'accion': 'ObtenerProductosXNombre',
               'nombre': request.term
            },
            beforeSend: function () {
               $('#load-buscar-general_' + aux[1]).removeClass('hidden');
               $('#btn_agregar').attr('disabled', 'disabled');
            },
            success: function (data) {

               $('#load-buscar-general_' + aux[1]).addClass('hidden');

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
            cargarProductoSeleccionado(ui.item, aux);
         }, 500);
         

         //location.href = 'index.php?modulo=' + ui.item.modulo + '&accion=' + ui.item.accion + '&' + ui.item.variable_nombre + '=' + ui.item.variable_valor;
      }
   }).data("ui-autocomplete")._renderItem = function (ul, item) {

      //$('#load-buscar-general').addClass('hidden');
      return $("<li>").append("<a >" + item.referencia + "</a>").appendTo(ul);

   };

}

function cargarProductoSeleccionado(reg, aux) {

   $("#codigo_" + aux[1]).val(reg.codigo);
   $("#categoria_" + aux[1]).val(reg.categoria);
   $("#producto_id_" + aux[1]).val(reg.id);
   $("#referencia_" + aux[1]).val(reg.referencia);
   $("#referencia_" + aux[1]).attr('data-product-id',reg.id);

   clearInterval(myVar);

}