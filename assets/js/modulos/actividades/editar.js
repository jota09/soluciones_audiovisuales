window.onload = function() {
  campos_tipo();
}
$(document).ready(function() {
  $("#tipo").change(function() {
    campos_tipo();
  });
  $(".llamada").hide();
  $(".reunion").hide();
  $(".tarea").hide();
  $('#s2id_estado_llamada').css("display", "none");
  $('#s2id_estado_tarea').css("display", "none");
  $('#s2id_estado').css("display", "block");

  $("#fecha_inicio").on('changeDate', function() {
    var value = $(this).val();
    $("#fecha_fin").val(value);
  });
});

function campos_tipo() {
  op = $("#tipo").val();
  console.log(op);
  if (op == 38) {
    $('#s2id_estado').css("display", "none");
    $('#s2id_estado_llamada').css("display", "none");
    $('#s2id_estado_tarea').css("display", "block");
    $(".tarea").show();
    $(".tarea").find('input,select').removeAttr('disabled');
    $(".tarea").find('.addreq').addClass('required');
    $(".llamada").find('.addreq').removeClass('required');
    $(".reunion").find('.addreq').removeClass('required');
    $(".llamada").find('input').val('');
    $(".reunion").find('input').val('');

    $(".llamada").find('.addreq').each(function() {
      $(this).select2("val", "-1");
    });
    $(".reunion").find('.addreq').each(function() {
      $(this).select2("val", "-1");
    });

    $(".llamada").hide();
    $(".reunion").hide();
    $(".llamada").find('input,select').attr('disabled', 'disabled');
    $(".reunion").find('input,select').attr('disabled', 'disabled');
  }
  if (op == 39) {
    $('#s2id_estado').css("display", "none");
    $('#s2id_estado_tarea').css("display", "none");
    $('#s2id_estado_llamada').css("display", "block");
    $(".llamada").show();
    $(".llamada").find('input,select').removeAttr('disabled');
    $(".llamada").find('.addreq').addClass('required');
    $(".tarea").find('.addreq').removeClass('required');
    $(".reunion").find('.addreq').removeClass('required');
    $(".tarea").find('input').val('');
    $(".reunion").find('input').val('');
    $(".tarea").find('.addreq').each(function() {
      $(this).select2("val", "-1");
    });
    $(".reunion").find('.addreq').each(function() {
      $(this).select2("val", "-1");
    });
    $(".tarea").hide();
    $(".reunion").hide();
    $(".tarea").find('input,select').attr('disabled', 'disabled');
    $(".reunion").find('input,select').attr('disabled', 'disabled');
  }
  if (op == 40) {
    $('#s2id_estado').css("display", "none");
    $('#s2id_estado_tarea').css("display", "none");
    $('#s2id_estado_llamada').css("display", "block");
    $(".reunion").show();
    $(".reunion").find('input,select').removeAttr('disabled');
    $(".reunion").find('.addreq').addClass('required');
    $(".llamada").find('.addreq').removeClass('required');
    $(".tarea").find('.addreq').removeClass('required');
    $(".tarea").find('input').val('');
    $(".llamada").find('input').val('');
    $(".llamada").find('.addreq').each(function() {
      $(this).select2("val", "-1");
    });
    $(".tarea").find('.addreq').each(function() {
      $(this).select2("val", "-1");
    });
    $(".llamada").hide();
    $(".tarea").hide();
    $(".llamada").find('input,select').attr('disabled', 'disabled');
    $(".tarea").find('input,select').attr('disabled', 'disabled');

    var x = $('input[id^=email_actividad]').length;
    if (x < 0) {
      agregarInvitado();
    }

  }
}


function validarFormulario() {

  if (validarUbicacion() && validar_datos('#form_editar')) {


    var x = $('input[id^=email_actividad]').length;

    if ($("#tipo").val() != '222') {
      return true;
    }
    if ($("#tipo").val() == '222') {
      if (x > 0) {
        return true;
      } else {
        alert('Debe Haber almenos un Invitado');
        return false;
      }


    }

  } else {
    alert('Algunos datos no son validos, por favor verifique he intente nuevamente.');
    return false;
  }
}

function obtenerFormularioActividad(data) {

  var horas_fin = '',
    horas_inicio = '',
    minutos_fin = '',
    minutos_inicio = '',
    fecha_inicio_am = '',
    fecha_fin_am = '';
  $.each(s3vars.horas, function(k, v) {
    var selectedhf = '';
    if (v.hora.toString() === data.fecha_fin_hora.toString()) {
      selectedhf = 'selected';
    }

    var selectedhi = '';

    if (v.hora.toString() === data.fecha_inicio_hora.toString()) {
      selectedhi = 'selected';
    }
    horas_fin += '<option value="' + v.hora + '" ' + selectedhf + '>' + v.hora + '</option>';
    horas_inicio += '<option value="' + v.hora + '" ' + selectedhi + ' >' + v.hora + '</option>';
  });
  $.each(s3vars.minutos, function(k, v) {
    var selectedmf = '';
    if (v.minutos.toString() === data.fecha_fin_minutos.toString()) {
      selectedmf = 'selected';
    }
    var selectedmi = '';
    if (v.minutos.toString() === data.fecha_inicio_minutos.toString()) {
      selectedmi = 'selected';
    }
    minutos_fin += '<option value="' + v.minutos + '"  ' + selectedmf + '>' + v.minutos + '</option>';
    minutos_inicio += '<option value="' + v.minutos + '"  ' + selectedmi + '>' + v.minutos + '</option>';
  });
  //  console.log(data);
  if (data.fecha_inicio_am) {
    var am = '',
      pm = '';
    if (data.fecha_inicio_am == "AM") {
      am = 'selected';
    } else if (data.fecha_inicio_am == "PM") {
      pm = 'selected';

    }
    fecha_inicio_am = '<option value="AM" ' + am + '>AM</option><option value="PM" ' + pm + '>PM</option>';
  }
  if (data.fecha_fin_am) {
    var am = '',
      pm = '';
    if (data.fecha_fin_am == "AM") {
      am = 'selected';
    } else if (data.fecha_fin_am == "PM") {
      pm = 'selected';

    }
    fecha_fin_am = '<option value="AM" ' + am + '>AM</option><option value="PM" ' + pm + '>PM</option>';
  }

  op_act = '';
  op_mod_rel = '';
  op_mod_estado = '';
  op_aviso = '<option value="-1">Seleccionar</option>';
  for (key in s3vars.listas_actividades['aviso']) {
    op_aviso += "<option value='" + s3vars.listas_actividades['aviso'][key]['id'] + "'";
    if (data.aviso == s3vars.listas_actividades['aviso'][key]['id']) {
      op_aviso += "selected";
    }
    op_aviso += ">" + s3vars.listas_actividades['aviso'][key]['nombre'] + "</option>";
  }
  for (key in s3vars.listas_actividades['tipo']) {
    op_act += "<option value='" + s3vars.listas_actividades['tipo'][key]['id'] + "'";
    if (data.tipo == s3vars.listas_actividades['tipo'][key]['id']) {
      op_act += "selected";
    }
    op_act += ">" + s3vars.listas_actividades['tipo'][key]['nombre'] + "</option>";
  }
  console.log(data.tipo);
  if (data.tipo == '38') {
    for (key in s3vars.listas_actividades['estado_tarea']) {
      op_mod_estado += "<option value='" + s3vars.listas_actividades['estado_tarea'][key]['id'] + "'";
      if (data.estado == s3vars.listas_actividades['estado_tarea'][key]['id']) {
        op_mod_estado += "selected";
      }
      op_mod_estado += ">" + s3vars.listas_actividades['estado_tarea'][key]['nombre'] + "</option>";
    }
  }
  if (data.tipo == '39') {
    for (key in s3vars.listas_actividades['estado_llamada']) {
      op_mod_estado += "<option value='" + s3vars.listas_actividades['estado_llamada'][key]['id'] + "'";
      if (data.estado == s3vars.listas_actividades['estado_llamada'][key]['id']) {
        op_mod_estado += "selected";

      }
      op_mod_estado += ">" + s3vars.listas_actividades['estado_llamada'][key]['nombre'] + "</option>";
    }
  }
  if (data.tipo == '40') {
    for (key in s3vars.listas_actividades['estado_reunion']) {
      op_mod_estado += "<option value='" + s3vars.listas_actividades['estado_reunion'][key]['id'] + "'";
      if (data.estado == s3vars.listas_actividades['estado_reunion'][key]['id']) {
        op_mod_estado += "selected";

      }
      op_mod_estado += ">" + s3vars.listas_actividades['estado_reunion'][key]['nombre'] + "</option>";
    }
  }

  op_prioridad = '';
  op_cliente = '<option value="-1">Seleccionar</option>';
  op_tipo_llamada = '<option value="-1">Seleccionar</option>';

  for (key in s3vars.listas_actividades['prioridad']) {
    op_prioridad += "<option value='" + s3vars.listas_actividades['prioridad'][key]['id'] + "'";
    if (data.prioridad == s3vars.listas_actividades['prioridad'][key]['id']) {
      op_prioridad += "selected";
    }
    op_prioridad += ">" + s3vars.listas_actividades['prioridad'][key]['nombre'] + "</option>";
  }

  for (key in s3vars.listas_actividades['tipo_llamada']) {
    op_tipo_llamada += "<option value='" + s3vars.listas_actividades['tipo_llamada'][key]['id'] + "'";
    if (data.tipo_llamada == s3vars.listas_actividades['tipo_llamada'][key]['id']) {
      op_tipo_llamada += "selected";
    }
    op_tipo_llamada += ">" + s3vars.listas_actividades['tipo_llamada'][key]['nombre'] + "</option>";
  }



  for (key in s3vars.clientes_calendario) {
    op_cliente += "<option value='" + s3vars.clientes_calendario[key]['id'] + "'";
    if (data.contacto == s3vars.clientes_calendario[key]['id']) {
      op_cliente += "selected";
    }
    op_cliente += ">" + s3vars.clientes_calendario[key]['nombre'] + "</option>";
  }






  op_mod = '';
  tabla = '';
  modulo = '';

  for (key in s3vars.modulos_actividades) {
    op_mod += "<option value='" + s3vars.modulos_actividades[key]['id'] + "'";
    if (data.relacionado == s3vars.modulos_actividades[key]['id']) {
      op_mod += "selected";
      tabla = s3vars.modulos_actividades[key]['tabla'];
      modulo = s3vars.campos[key];
    }
    op_mod += ">" + key + "</option>";
  }



  $.ajax({
    type: "POST",
    url: 'index.php?modulo=actividades&accion=obtener_registrosxmodulo',
    //        data: 'tabla=' + tabla
    data: {
      tabla: tabla,
      campos: modulo
    },
    cache: false,
    dataType: "json",
    async: false,
  }).done(function(result) {
    for (key in result) {
      op_mod_rel += "<option value='" + result[key]['id'] + "'";
      if (data.relacionado_id == result[key]['id']) {
        op_mod_rel += "selected";
      }
      op_mod_rel += ">" + result[key]['nombre_general'] + "</option>";
    }

  });


  var invitados = '';
  invitados = cargar_invitados_cal(data.id);


  //trululu
  var form_test =
    '' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_MOD.lbl_nombre_actividad + '</label>' +
    '<div class="col-sm-9">' +
    '<input type="text" class="form-control  validate[required]" value="' + data.title + '" id="nombre" name="nombre" >' +
    '<input type="hidden" class="form-control" value="' + data.id + '" id="registroId" name="registroId" >' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="tipo">' + s3vars.L_APP.lbl_actividad_tipo + '</label>' +
    '<div class="col-sm-9">' +
    '<select class="form-control validate[required] " id="tipo" onchange="set_estado_calendario(this);" name="tipo" >' +
    '<option value="-1">Seleccionar</option>' +
    op_act +
    '</select>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="clearfix"></div>' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group ">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_MOD.lbl_fecha_inicio + '</label>' +
    '<div class="col-sm-9 pbt">' +
    '<input type="text" class="form-control validate[required] fecha" value="' + data.start + '" id="fecha_inicio" name="fecha_inicio" >' +
    '</div>' +
    '</div>' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre"></label>' +
    '<div class="col-sm-3">' +
    '<select class="form-control " id="fecha_fin_hora" name="fecha_inicio_hora">' +
    horas_inicio +
    '</select>' +
    '</div>' +
    '<div class="col-sm-3">' +
    '<select class="form-control" id="fecha_incio_minutos" name="fecha_inicio_minutos">' +
    minutos_inicio +
    '</select>' +
    '</div>' +
    '<div class="col-sm-3">' +
    '<select class="form-control" id="fecha_incio_minutos" name="fecha_inicio_am" >' +
    fecha_inicio_am +
    '</select>' +
    '<input type="hidden" name="id"  value="' + data.id + '">' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="tipo">' + s3vars.L_MOD.lbl_fecha_fin + '</label>' +
    '<div class="col-sm-9 pbt">' +
    '<input type="text" class="form-control validate[required] fecha" value="' + data.end + '" id="fecha_fin" name="fecha_fin" >' +
    '</div>' +
    '</div>' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre"></label>' +
    '<div class="col-sm-3">' +
    '<select class="form-control" id="fecha_fin_hora" name="fecha_fin_hora">' +
    horas_fin +
    '</select>' +
    '</div>' +
    '<div class="col-sm-3">' +
    '<select class="form-control" id="fecha_incio_minutos" name="fecha_fin_minutos">' +
    minutos_fin +
    '</select>' +
    '</div>' +
    '<div class="col-sm-3">' +
    '<select class="form-control" id="fecha_incio_minutos" name="fecha_fin_am" >' +
    fecha_fin_am +
    '</select>' +
    '<input type="hidden" name="id"  value="' + data.id + '">' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="clearfix"></div>' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_APP.lbl_actividad_relacionado + '</label>' +
    '<div class="col-sm-9">' +
    '<select class="form-control validate[required]" onchange="set_relacionado(this);" id="relacionado" name="relacionado">' +
    '<option value="-1">Seleccionar</option>' +
    op_mod +
    '</select>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_APP.lbl_actividad_relacionado_con + '</label>' +
    '<div class="col-sm-8">' +
    '<select class="form-control validate[required]"  id="relacionado_id" name="relacionado_id">' +
    '<option value="-1">Seleccionar</option>' +
    op_mod_rel +
    '</select>' +
    '</div>' +
    '<div class="col-sm-1 no-padding"> ' +
    '<div id="load-buscar-relacionado" class="hidden" >' +
    '<i class="fa fa-circle-o-notch fa-spin " style="color: #002a80; "></i>' +
    '</div> ' +
    '</div> ' +
    '</div>' +
    '</div>' +
    '<div class="clearfix"></div>' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_APP.lbl_actividad_estado + '</label>' +
    '<div class="col-sm-9">' +
    '<select class="form-control validate[required]"  id="estado" name="estado">' +
    '<option value="-1">Seleccionar</option>' +
    op_mod_estado +
    '</select>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_APP.lbl_actividad_aviso + '</label>' +
    '<div class="col-sm-9">' +
    '<select class="form-control validate[required]"  id="aviso" name="aviso">' +
    op_aviso +
    '</select>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="clearfix"></div>' +
    '<div class="panel-tarea ">' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_APP.lbl_actividad_prioridad + '</label>' +
    '<div class="col-sm-9">' +
    '<select class="form-control validate[required]"  id="prioridad" name="prioridad">' +
    '<option value="-1">Seleccionar</option>' +
    op_prioridad +
    '</select>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_APP.lbl_actividad_contacto + '</label>' +
    '<div class="col-sm-9">' +
    '<select class="form-control "  id="contacto" name="contacto">' +
    op_cliente +
    '</select>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="clearfix"></div>' +
    '<div class="panel-llamada  ">' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_APP.lbl_actividad_duracion + '</label>' +
    '<div class="col-sm-9">' +
    '<input type="text" class="form-control validate[required]"  id="duracion" name="duracion"  value="' + data.duracion + '">' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_APP.lbl_actividad_tipo_llamada + '</label>' +
    '<div class="col-sm-9">' +
    '<select class="form-control validate[required]"  id="tipo_llamada" name="tipo_llamada">' +
    op_tipo_llamada +
    '</select>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="clearfix"></div>' +
    '<div class="panel-reunion ">' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_APP.lbl_actividad_duracion + '</label>' +
    '<div class="col-sm-9">' +
    '<input type="text" class="form-control validate[required]"  id="duracion" name="duracion"  value="' + data.duracion + '">' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="col-sm-6 pbt">' +
    '<div class="from-group">' +
    '<label class="control-label col-sm-3" for="nombre">' + s3vars.L_APP.lbl_actividad_lugar + '</label>' +
    '<div class="col-sm-9">' +
    '<input type="text" class="form-control validate[required]"  id="lugar" name="lugar"  value="' + data.lugar + '">' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="clearfix"></div>' +
    '<div class="panel-reunion ">' +
    '<div class="col-sm-12">' +
    '<div class="form-group">' +
    '<label class="control-label col-sm-2">Agregar Invitado</label>' +
    '<div class="col-sm-9 no-padding-left">' +
    '<button type="button" id="btn_agregar_invitado" onclick="agregarInvitado_act();" class="btn btn-primary "><i class="fa fa-plus"></i></button>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div class="col-sm-12">' +
    '<label class="col-sm-2 control-label">Modulo Invitado</label>' +
    '<label class="col-sm-5 control-label">Nombre Invitado</label>' +
    '<label class="col-sm-4 control-label">Email Invitado</label>' +
    '</div>' +
    '<div class="clearfix"></div>' +
    '<div id="invitados">' +
    invitados +
    '</div>' +
    '<div class="clearfix"></div>' +
    '</div>' +
    '</div>' +
    '';

  var form = '<form id="form_actividades" action="index.php" class="form-horizontal" enctype="multipart/form-data" onsubmit="return validarFormulario_calendario();return false;"> ' +
    '<div class="row">  ' +
    '<div class="col-md-12"> ' +
    form_test +
    '</div>' +
    '</form> <script>cargaDatePicker(); selects_dos("form_actividades");</script>';
  return form;
}
