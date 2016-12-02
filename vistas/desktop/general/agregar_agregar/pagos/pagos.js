function agregarPago() {
    var html = '<div class="form-group col-sm-12 div_pago"> ' +
            '<input type="hidden" class="id" name="pago_id[]" value="">' +
            '<input type="hidden" class="eliminado" name="pago_eliminado[]" value="0">' +
            '<div class="col-sm-1"></div> ' +
            '<div class="col-sm-3"> ' +
            '<input type="text" class="form-control validate[required] fecha"  name="fecha_pago[]"> ' +
            '</div> ' +
            '<div class="col-sm-3"> ' +
            '<input type="text" class="form-control validate[required] number"  name="valor[]"  onkeypress="return soloNumeros(event);" > ' +
            '</div> ' +
            '<div class="col-sm-2"> ' +
            '<select class="form-control validate[required] tipo_pago" name="pagado[]"> ' +
            '<option value="1">Si</option> ' +
            '<option value="0">No</option> ' +
            '</select> ' +
            '</div> ' +
            '<div class="col-sm-1"> ' +
           
            '<button type="button"  class="btn btn_eliminar_reg_pago btn-default center-block btn-sm"><i class="fa fa-minus"></i></button> ' +
            '</div> ' +
            '</div>';

    $('#div_agregar_pago').append(html);
    $('.number').number(true, 0, '.', ',');
    triggersPago();
}

function eliminarCampoRegistroPago(div) {
    if ($(div).find('.id').val() > 0 && $(div).find('.id').val() != "" && $(div).find('.id').val() != "0") {
        $(div).find('.eliminado').val(1);
        $(div).addClass('hidden');
    } else {
        $(div).remove();
    }
}


function triggersPago() {
    $('.btn_eliminar_reg_pago').click(function() {
        eliminarCampoRegistroPago($(this).parent().parent());
    });
    selects_dos();
    cargaDatePicker();

}

$(document).ready(function() {
    $('#btn_agregar_pago').click(function() {
        agregarPago();
    });
    triggersPago();
});
