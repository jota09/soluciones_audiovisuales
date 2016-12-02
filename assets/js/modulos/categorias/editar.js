$(document).ready(function () {

  $('#btn_agregar_detalle_cotizacion').click(function() {
    
        agregarDetalle_cotizacion();
    });
    triggersDetalle_cotizacion();

});

function agregarDetalle_cotizacion() {
    var html = '<div class="form-group col-sm-12 no-padding-right"> '+
        '<input type="hidden" class="id" name="detalle_cotizacion_id[]" value="">'+
        '<input type="hidden" class="eliminado" name="detalle_cotizacion_eliminado[]" value="0">'+
        '<div class="col-sm-1 no-padding-right">'+
          '<input type="text" class="form-control validate[required]" value="" name="detalle_cantidad[]"  onkeypress="return soloNumeros(event);" > </div> '+
        '<div class="col-sm-2 no-padding-right"> '+
          '<input type="text" class="form-control " value="" name="detalle_categoriaa[]" readonly="readonly" ></div> '+

        '<div class="col-sm-2 no-padding-right"> '+
          '<input type="text" class="form-control " value="" name="detalle_referencia[]" onkeyup="buscarProducto(this);"  ></div> '+

        '<div class="col-sm-2 no-padding-right"> '+
          '<textarea class="form-control" name="detalle_descripcion[]" rows="2" readonly="readonly"></textarea></div> '+

        '<div class="col-sm-2 no-padding-right"> '+
          '<input type="text" class="form-control validate[required]" value="" name="detalle_valor_unitario[]"  onkeypress="return soloNumeros(event);" ></div> '+

        '<div class="col-sm-2 no-padding-right"> '+
          '<input type="text" class="form-control validate[required]" value="" name="detalle_total[]"  onkeypress="return soloNumeros(event);" ></div> '+

        '<div class="col-sm-1 no-padding-right"> '+
          '<button type="button" class="btn btn_eliminar_reg_detalle_cotizacion btn-default center-block btn-sm"><i class="fa fa-minus"></i></button> </div> '+
      '</div>';

    $('#detalle_cotizacion').append(html);
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
    $('.btn_eliminar_reg_detalle_cotizacion').click(function() {
        eliminarCampoRegistroDetalleCotizacion($(this).parent().parent());
    });
    
}


