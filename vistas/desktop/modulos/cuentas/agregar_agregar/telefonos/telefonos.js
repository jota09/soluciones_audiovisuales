function agregarTelefono() {
    var html = '<div class="form-group col-lg-12"> ' +
            '<input type="hidden" class="id" name="telefono_id[]" value="">' +
            '<input type="hidden" class="eliminado" name="telefono_eliminado[]" value="0">' +
            '<div class="col-lg-1"></div> ' +
            '<div class="col-lg-3"> ' +
            '<input type="text" class="form-control validate[required]" value=""  id="num_telefono" name="num_telefono[]" > ' +
            '</div> ' +
            '<div class="col-lg-3"> ' +
            '<select class="form-control validate[required]"  name="tipo_telefono[]"> ' +
            '<option value="-1"></option> ' +
            '<option value="celular">Celular</option> ' +
            '<option value="fijo">Fijo</option> ' +
            '</select> ' +
            '</div> ' +
            '<div class="col-lg-1"> ' +
            '<button type="button"  class="btn btn_eliminar_reg_telefono btn-primary"><i class="fa fa-minus"></i></button> ' +
            '</div> ' +
            '</div>';

    $('#div_agregar_telefono').append(html);
    triggersTelefono();
}

function eliminarCampoRegistroTelefono(div) {
    if ($(div).find('.id').val() > 0 && $(div).find('.id').val() != "" && $(div).find('.id').val() != "0") {
        $(div).find('.eliminado').val(1);
        $(div).addClass('hidden');
    } else {
        $(div).remove();
    }
}


function triggersTelefono() {
    $('.btn_eliminar_reg_telefono').click(function () {
        eliminarCampoRegistroTelefono($(this).parent().parent());
    });
    selects_dos();

}

$(document).ready(function () {
    $('#btn_agregar_telefono').click(function () {
        agregarTelefono();
    });
    triggersTelefono();
});
