$(document).ready(function() {
    aux = 0;

    cargar_invitados_act();
    if (s3vars.invitados.length > 0) {
        aux = s3vars.invitados.length;
    }
    $("#btn_agregar_invitado").click(function() {
        agregarInvitado_act();
    });
//    cargar_invitados();
    triggersInvitado_act();
});
/*
function agregarInvitado_act() {


    option_cuenta = '';

//var html = '<div class="form-group col-sm-12">' +
//            '<input type="hidden" class="id" name="item_meta_id[]" value="">' +
//            '<input type="hidden" class="eliminado" name="meta_eliminado[]" value="0">' +

    var html = '<div  class="col-sm-12 form-group">' +
            '<input type="hidden" class="eliminado" name="invitado_eliminado[]" value="0">' +
            '<input class="id" type="hidden" id="id_invitado_' + aux + '" name="id_invitado[]" >' +
            '<div class=" col-sm-2">' +
            '<label class=" control-label">Modulo Invitado</label>' +
            '<select class="form-control required" id="modulo_actividad" name="modulo_actividad[]" onchange="t_modulo_actividad_act(this)">' +
            '<option value="-1">Seleccionar</option>' +
            '<option value="1">Clientes</option>' +
            '<option value="2">Contactos</option>' +
            '</select>' +
            '</div>' +
            '<div class=" col-sm-5">' +
            '<label class=" control-label">Nombre</label>' +
            '<select class="form-control required" id="nombre_actividad" name="nombre_actividad[]" onchange="obtener_email_actividad(this)">' +
            '<option value="-1">Seleccionar</option>' +
            '</select>' +
            '</div>' +
            '<div class="col-sm-4 ">' +
            '<label  control-label">E-mail Invitado</label>' +
            '<input class="form-control required" type="email" id="email_actividad"  name="email_actividad[]">' +
            '</div>' +
            '<div class="col-sm-1 ">' +
//            '<button type="button"  onclick="del_invitado(this);" class="btn btn_eliminar_reg_invitado_act btn-primary  btn-md"><i class="fa fa-minus"></i></button> ' +
            '<button type="button"  class="btn btn_eliminar_reg_invitado_act btn-primary  btn-md"><i class="fa fa-minus"></i></button> ' +
            '</div>' +
            '</div>';
    aux++;
    $('#invitados').append(html);
    triggersInvitado_act();
}

function triggersInvitado_act() {
    $('.btn_eliminar_reg_invitado_act').on('click', function() {
        eliminarCampoRegistroInvitado_act($(this).parent().parent());
    });

}


function eliminarCampoRegistroInvitado_act(div) {
    if ($(div).find('.id').val() > 0 && $(div).find('.id').val() != "" && $(div).find('.id').val() != "0") {
        $(div).find('.eliminado').val(1);
        $(div).addClass('hidden');
    } else {
        $(div).remove();
    }
}*/
function del_invitado(obj) {
    eliminarCampoRegistroInvitado_act($(obj).parent().parent());
}


function t_modulo_actividad_act(obj) {
//define la lista de cliente o de usuarios

    option = '';
    option = '<option value="-1">Seleccionar</option>';
    if ($(obj).val() == '1') {
        for (i = 0; i < s3vars.clientes.length; i++) {
            option += '<option value="' + s3vars.clientes[i]['id'] + '">' + s3vars.clientes[i]['nombre'] + '</option>';
        }
    }
    if ($(obj).val() == '2') {
        for (i = 0; i < s3vars.usuarios.length; i++) {
            option += '<option value="' + s3vars.usuarios[i]['id'] + '">' + s3vars.usuarios[i]['nombre'] + '</option>';
        }
    }
//    console.log($($(obj).parent().parent()[0]));
//    console.log($($(obj).parent().parent()[0]['children'][3]));
    $($($(obj).parent().parent()[0]['children'][3]).children()[1]).empty();
    $($($(obj).parent().parent()[0]['children'][3]).children()[1]).append(option);
//    $($($(obj).parent().parent()[0]['children'][3]).children()).append(option);
}

function obtener_email_actividad(obj) {
    id = $(obj).val();
}



function cargar_invitados_act() {
    registro = $("#registro_actividad").val();
    for (i = 0; i < s3vars.invitados.length; i++) {
        op_m = '';
        op = '';
        if (s3vars.invitados[i]['modulo_actividad'] == 1) {
            op_m = '<option value="1" selected>clientes</option><option value="2">usuarios</option>';
            for (key in s3vars.clientes) {
                op += "<option value='" + s3vars.clientes[key]['id'] + "'";
                if (s3vars.invitados[i]['nombre_actividad'] == s3vars.clientes[key]['id']) {
                    op += "selected";
                }
                op += ">" + s3vars.clientes[key]['nombre'] + "</option>";
            }

        }
        if (s3vars.invitados[i]['modulo_actividad'] == 2) {
            op_m = '<option value="1">clientes</option><option value="2" selected>usuarios</option>';

            for (key in s3vars.usuarios) {
                op += "<option value='" + s3vars.usuarios[key]['id'] + "'";
//                op += "<option value='" + key + "'";
                if (s3vars.invitados[i]['nombre_actividad'] == s3vars.usuarios[key]['id']) {
                    op += "selected";
                }
                op += ">" + s3vars.usuarios[key]['nombre'] + "</option>";
            }
        }
        div = '<div  class="col-sm-12 form-group">' +
                '<input type="hidden" class="eliminado" name="invitado_eliminado[]" value="0">' +
                '<input class="id" type="hidden" id="id_invitado_' + aux + '" name="id_invitado[]" value="' + s3vars.invitados[i]['id'] + '">' +
                '<div class=" col-sm-2">' +
                '<select class="form-control required" id="modulo_actividad" name="modulo_actividad[]" onchange="t_modulo_actividad_act(this)">' +
                '<option value="-1">Seleccionar</option>' +
                op_m +
                '</select>' +
                '</div>' +
                '<div class=" col-sm-5">' +
                '<select class="form-control required" id="nombre_actividad" name="nombre_actividad[]" onchange="obtener_email_actividad(this)">' +
                '<option value="-1">Seleccionar</option>' +
                op +
                '</select>' +
                '</div>' +
                '<div class="col-sm-4 ">' +
                '<input class="form-control required" type="email" id="email_actividad"  name="email_actividad[]" value="' + s3vars.invitados[i]['email_actividad'] + '">' +
                '</div>' +
                '<div class="col-sm-1 ">' +
//                '<button type="button" onclick="del_invitado(this);" class="btn btn_eliminar_reg_invitado_act btn-primary btn-md"><i class="fa fa-minus"></i></button> ' +
                '<button type="button"  class="btn btn_eliminar_reg_invitado_act btn-primary btn-md"><i class="fa fa-minus"></i></button> ' +
                '</div>' +
                '</div>';
        $("#invitados").append(div);

    }
}